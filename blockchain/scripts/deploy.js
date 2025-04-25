const hre = require("hardhat");

async function main() {
    const [deployer] = await hre.ethers.getSigners();

    console.log("Deploying contract with account:", deployer.address);
    const balance = await deployer.provider.getBalance(deployer.address);
    console.log("Account balance:", hre.ethers.utils.formatEther(balance));  // Correct way to call formatEther

    const Escrow = await hre.ethers.getContractFactory("Escrow");
    const escrow = await Escrow.deploy(deployer.address, {
        value: hre.ethers.utils.parseUnits("0.05", 18)  // Make sure you're using parseUnits to convert the value properly
    });

    await escrow.waitForDeployment();

    console.log("Escrow contract deployed to:", await escrow.getAddress());
}

main().catch((error) => {
    console.error(error);
    process.exitCode = 1;
});
