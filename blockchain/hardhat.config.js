require("@nomicfoundation/hardhat-toolbox");
require("dotenv").config();

module.exports = {
    solidity: "0.8.20",
    networks: {
        apex: {
            url: 'https://rpc.nexus.testnet.apexfusion.org',
            chainId: 9070,
            accounts: [`0x${process.env.APEX_PRIVATE_KEY}`],
        },
    },
};
