require('dotenv').config();
const { task } = require("hardhat/config");
const { ethers } = require("@nomiclabs/hardhat-ethers");
const { writeFileSync, readFileSync, existsSync, fs } = require('fs');
const MAX_ITEMS = 10;
const VERIFY_TIMEOUT = 3000;
const MINT_TIMEOUT = 1000;
const { NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS, NFT_IPFS_ADDRESS, WALLET_ADDRESS } = process.env;

//utils
function timer(ms) {
  return new Promise(res => setTimeout(res, ms));
}

function zeroPad(num, places = 4){
  return String(num).padStart(places, '0');
}

//check ETH balance of connected account
task("check-balance", "Prints out the balance of your account(s)").setAction(async function (taskArguments, hre) {
  const accounts = await hre.ethers.getSigners();
  for (const account of accounts) {
    console.log(`Account balance for ${account.address}: ${await account.getBalance()}`);
  }
});

//get mint count
task("count", "Prints out total number in collection").setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const counted = await contract.count();
  console.log(counted);
});

//return account list of attached wallet
task("accounts", "Prints the list of accounts", async (taskArgs, hre) => {
  const accounts = await hre.ethers.getSigners();
  for (const account of accounts) {
    console.log(account.address);
  }
});

//deploy the config'd contract
task("deploy", "Deploys the NFT.sol contract").setAction(async function (taskArguments, hre) {
  const [deployer] = await hre.ethers.getSigners(); //get the account to deploy the contract
  console.log("Deploying contracts with the account:", deployer.address); 

  const contract = await hre.ethers.getContractFactory(NFT_CONTRACT_NAME);
  const nft = await contract.deploy();
  await nft.deployed();
  console.log(`Contract deployed to address: ${nft.address}`); //save this address it returns!
});

task("get-mint-status", "Checks mint status of provided URI")
.addParam("uri", "The tokenID to fetch metadata for")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const result = await contract.getOwnedContent(taskArguments.uri);
  console.log(result);
});

/* //needs to be implmented public not internal
task("burn", "burns the passed tokenID")
.addParam("tokenId", "The tokenID to fetch metadata for")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const result = await contract._burn(taskArguments.tokenId);
  console.log(result);
});
*/ 

//runs the mint task from the contract
task("mint", "Mints from the NFT contract").setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);

  const mint_log = './_mint_data.json'; //path to data output

  var prevData = {}
  let counter = 0;
  let key = counter+1;
  let stopper = MAX_ITEMS;

  if(!existsSync(mint_log)){
      //skip and use defaults if log hasnt written yet
  } else {
    prevData = JSON.parse(readFileSync(mint_log, 'utf-8'));
    counter = Object.keys(prevData).length;
    key = counter+1;
    stopper = counter+MAX_ITEMS;
  }
  
  async function processBatchMints() {   

    console.log(`**  Counters@ cur:${counter} stop:${stopper} key:${key}  **`); //output current counts

    const NFTaddress = `${ NFT_IPFS_ADDRESS }/VDLC_${zeroPad(key)}.json`;

    console.log('Minting: '+NFTaddress);

    const mintProcess = await contract.safeMint(WALLET_ADDRESS, NFTaddress, {
      gasLimit: 600_000 //verify gas costs with a small batch mint first!
    });

    //wait for process to send transaction complete on wait() vs. getting initial txn data return
    try {
      const mintResponse = await mintProcess.wait();

      if(mintResponse) {
        console.log(`Transaction Hash #${counter}/${stopper}: ${mintResponse.events[0].transactionHash}`);
        prevData[counter] = mintResponse.transactionHash; 
        writeFileSync(`./_mint_data.json`, JSON.stringify(prevData)); //output to json receipt on each complete
      }
    } catch (mintError) {
      console.log(mintError);
      writeFileSync(`./_errors${counter}.json`, JSON.stringify(mintError)); 
      process.exit(1);
    }  

    await timer(VERIFY_TIMEOUT); //pause before verify to let network catch up

    const checkToken = await contract.tokenURI(counter) //check to make sure token exists after mint
    .then(function(checkResponse){
      console.log(`tokenId[${counter}] confirmed@: ${checkResponse}`);
    })
    .catch(function(tokenErr){
      console.log(tokenErr);
      writeFileSync(`./_errors${counter}.json`, JSON.stringify(tokenErr)); 
      process.exit(1);
    });

    await timer(MINT_TIMEOUT); //pause before next mint to let network catch up

    counter++;
    key++;

    if(counter < stopper) {      
      await processBatchMints();
    } else {
      console.log('**  TRANSACTION COMPLETE  **');
    }
  }

  await processBatchMints(); //fire await chains
  
}); 

task("token-uri", "Fetches the token metadata for the given token ID")
.addParam("tokenId", "The tokenID to fetch metadata for")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const response = await contract.tokenURI(taskArguments.tokenId);

  //console.log(NFT_IPFS_ADDRESS);
    
  const metadata_url = response;
  console.log(`Metadata URL: ${metadata_url}`);
});

task("update-token-uri", "Updates the token metadata URI for the given token ID")
.addParam("tokenId", "The tokenID to set metadata for")
.addParam("uri", "The URI to set")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const updateURI = await contract.updateTokenURI(taskArguments.tokenId, taskArguments.uri);
});

task("transfer", "Transfer NFTs to another address")
.addParam("tokenId", "The tokenID to fetch metadata for")
.addParam("address", "The address to transfer to")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);

  const seller = WALLET_ADDRESS;
 
  const response = await contract.transfer(seller, taskArguments.address, taskArguments.tokenId)
  .then(function(response){
    console.log(`Transaction Hash: ${response.hash}`);
  })
  .catch(function(error){
      console.log(error);
  }); 
});