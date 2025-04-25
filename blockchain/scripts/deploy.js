// Explicitly import ethers from the package
const { ethers } = require("hardhat");

async function main() {
    const [deployer] = await ethers.getSigners(); // Get the deployer's account

    console.log("Deploying contract with account:", deployer.address);

    // Use ethers directly to get the balance and format it
    const balance = await deployer.provider.getBalance(deployer.address);
    console.log("Account balance:", ethers.utils.formatEther(balance)); // Use ethers.utils.formatEther instead of hre.ethers

    const Escrow = await ethers.getContractFactory("Escrow");
    const escrow = await Escrow.deploy(deployer.address, { value: ethers.utils.parseUnits("0.05", "ether") }); // Use parseUnits to send ETH or tAP3X value

    await escrow.deployed(); // Wait for the deployment to complete

    console.log("Escrow contract deployed to:", escrow.address);
}

main().catch((error) => {
    console.error(error);
    process.exitCode = 1;
});
