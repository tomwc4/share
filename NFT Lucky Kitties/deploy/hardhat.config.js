require("@nomiclabs/hardhat-ethers");
require("@nomiclabs/hardhat-ganache");
require("@nomiclabs/hardhat-etherscan");
require('dotenv').config();
require("./scripts/deploy.js");
require("./test/test.js");

const { ALCHEMY_KEY, ACCOUNT_PRIVATE_KEY, ETHERSCAN_KEY } = process.env;

/**
 * @type import('hardhat/config').HardhatUserConfig
 */

module.exports = {
  solidity: "0.8.4",
  paths: {
    artifacts: './src/artifacts',
  },
  defaultNetwork: "ganache",
  networks: {
    ganache: {
      url: 'HTTP://127.0.0.1:7545',
      chainId: 1337,
      gasLimit: 6000000,
    },/*
    goerli: {
      url: `https://eth-goerli.alchemyapi.io/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`]
    },
    mumbai: {
      url: `https://polygon-mumbai.g.alchemy.com/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`]
    },
    ropsten: {
      url: `https://eth-ropsten.alchemyapi.io/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`]
    },
    rinkeby: {
      url: `https://eth-rinkeby.alchemyapi.io/v2/${ALCHEMY_KEY}`,
      accounts: [`0x${ACCOUNT_PRIVATE_KEY}`]
    },
    ethereum: {
      chainId: 1,
      url: `https://eth-mainnet.alchemyapi.io/v2/${ALCHEMY_KEY}`,
      accounts: [`0x${ACCOUNT_PRIVATE_KEY}`]
    },
    polgon: {
      url: `https://polygon-mainnet.g.alchemy.com/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`]
    },
  */},
  etherscan: {
    apiKey: ETHERSCAN_KEY,
  },
};
