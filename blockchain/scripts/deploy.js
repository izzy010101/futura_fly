// Import ethers directly from Hardhat
const { ethers } = require("hardhat");

async function main() {
    const [deployer] = await ethers.getSigners(); // Get the deployer's account

    console.log("Deploying contract with account:", deployer.address);

    // Get the balance of the deployer account and format it using ethers v6
    const balance = await deployer.provider.getBalance(deployer.address);
    console.log("Account balance:", ethers.formatEther(balance)); // Use ethers.formatEther directly here

    const Escrow = await ethers.getContractFactory("Escrow");
    const escrow = await Escrow.deploy(deployer.address); // Ensure the amount is correctly parsed


    await escrow.deployed(); // Wait for the deployment to complete

    console.log("Escrow contract deployed to:", escrow.address);
}

main().catch((error) => {
    console.error(error);
    process.exitCode = 1;
});
