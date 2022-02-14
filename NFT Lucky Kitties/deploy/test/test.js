const { task } = require("hardhat/config");
const { ethers } = require("@nomiclabs/hardhat-ethers");
const { expect } = require("chai");

require('dotenv').config();
const { NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS } = process.env;

task("test", "Runs a test of our NFT minting process").setAction(async function (taskArguments, hre) {
    //test values
    const recipient = '0x73Ece4f102960fD9703c9124672ecD89e22008f6';
    const metadataURI = 'ipfs://QmbVnXX6HQxvmrH3DhqDLtP3BkFtbRhedD3uh9xKBGDSLB/VDLC_0003.json';

    const contract = await hre.ethers.getContractAt(NFT_CONTRACT_NAME, NFT_CONTRACT_ADDRESS);

    let balance = await contract.balanceOf(recipient);
    let balanceNum = await balance.toNumber(); 
    //console.log(balanceNum); //get total number of receipient's contract transactions (choose an empty one)
    expect(balanceNum).to.equal(0);

    const isOwned = await contract.isContentOwned(metadataURI);
    //console.log(isOwned); // should return false  
    expect(isOwned).to.equal(false);

    const newlyMintedToken = await contract.safeMint(recipient, metadataURI);
    await newlyMintedToken.wait();

    let newBalance = await contract.balanceOf(recipient); 
    let newBalanceNum = await newBalance.toNumber();    
    //console.log(newBalanceNum); //should increment up
    expect(newBalanceNum).to.equal(1);

    const isOwnedNew = await contract.isContentOwned(metadataURI);
    //console.log(isOwnedNew); // should return true 
    expect(isOwnedNew).to.equal(true); 

    const tokenURI = await contract.tokenURI(0);
    //console.log(tokenURI); // should return true  
    expect(tokenURI).to.equal(true);
});