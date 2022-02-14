require('dotenv').config();
const { task } = require("hardhat/config");
const { ethers } = require("@nomiclabs/hardhat-ethers");
const { writeFileSync, fs } = require('fs');
const fetch = require('node-fetch');
const MAX_ITEMS = 500;
const { NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS, NFT_IPFS_ADDRESS } = process.env;

//utils
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
  }n
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

task("get-mint-status", "Checks mint status of provided URI").addParam("uri", "The address to check").setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const result = await contract.isContentOwned(taskArguments.uri);
  console.log(result);
});

//runs the mint task from the contract
task("mint", "Mints from the NFT contract").addParam("address", "The address to receive a token").setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const output = {};
  
  //do a loop for every item to mint
  for (var i = 1; i <= MAX_ITEMS; i++) {
    const transactionResponse = await contract.safeMint(taskArguments.address, `${ NFT_IPFS_ADDRESS }/VDLC_${zeroPad(i)}.json`);
    console.log(`Transaction Hash #${i}/${MAX_ITEMS}: ${transactionResponse.hash}`);
    output[i] = transactionResponse.hash;
  }  

  //output a json receipt on complete
  writeFileSync(`./_mint_data.json`, JSON.stringify(output));  

}); 

task("token-uri", "Fetches the token metadata for the given token ID")
.addParam("tokenId", "The tokenID to fetch metadata for")
.setAction(async function (taskArguments, hre) {
  const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);
  const response = await contract.tokenURI(taskArguments.tokenId);

   console.log(NFT_IPFS_ADDRESS);
    
    const metadata_url = response;
    console.log(`Metadata URL: ${metadata_url}`);

    const metadata = await fetch(metadata_url)
    .then(res => res.text())
    .then(text => console.log(`Metadata fetch response: ${text}`));    
});