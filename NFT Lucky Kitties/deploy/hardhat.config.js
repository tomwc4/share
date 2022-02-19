require("@nomiclabs/hardhat-ethers");
require("@nomiclabs/hardhat-ganache");
require("@nomiclabs/hardhat-etherscan");
require('dotenv').config();
require("./scripts/deploy.js");
//require("./test/test.js");

const { ALCHEMY_KEY_LIVE, ALCHEMY_KEY_DEV, ACCOUNT_PRIVATE_KEY, ETHERSCAN_KEY } = process.env;

//const ALCHEMY_KEY = ALCHEMY_KEY_DEV;
const ALCHEMY_KEY = ALCHEMY_KEY_LIVE;

/**
 * @type import('hardhat/config').HardhatUserConfig
 */

module.exports = {
  solidity: "0.8.4",
  paths: {
    artifacts: './src/artifacts',
  },
  defaultNetwork: "polygon",
  networks: {
    ganache: {
      url: 'HTTP://127.0.0.1:7545',
      chainId: 1337,
      gasPrice: 50000000000 //set test gas to mimic live
    }, 
    goerli: {
      url: `https://eth-goerli.alchemyapi.io/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`]
    },
    mumbai: {
      url: `https://polygon-mumbai.g.alchemy.com/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`],
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
      accounts: [`0x${ACCOUNT_PRIVATE_KEY}`],
      gasPrice: 50000000000 //(in wei) = 50 gwei / changes frequently, check pricing!
    },
    polygon: {
      url: `https://polygon-mainnet.g.alchemy.com/v2/${ALCHEMY_KEY}`,
      accounts: [`${ACCOUNT_PRIVATE_KEY}`],
      gasPrice: 40000000000 //(in wei) = 40 gwei / changes frequently, check pricing!
    },
  },
  etherscan: {
    apiKey: ETHERSCAN_KEY,
  },
};
