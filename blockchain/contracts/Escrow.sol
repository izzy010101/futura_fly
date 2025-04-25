// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

// Interface to interact with ERC-20 token contracts
interface IERC20 {
    function transfer(address recipient, uint amount) external returns (bool);
    function balanceOf(address account) external view returns (uint);
}

contract Escrow {
    address public buyer;
    address payable public seller;
    uint public amount;
    bool public isConfirmed;
    IERC20 public token; // tAP3X token contract
    address public tokenAddress; // ERC20 Token contract address

    constructor(address payable _seller, address _tokenAddress) {
        buyer = msg.sender;
        seller = _seller;
        tokenAddress = _tokenAddress;
        token = IERC20(_tokenAddress); // Set the token contract
        amount = 100 * 10**18; // Assuming 100 tAP3X tokens for now (adjust accordingly)
        isConfirmed = false;
    }

    function confirmDelivery() external {
        require(msg.sender == buyer, "Only buyer can confirm");
        require(!isConfirmed, "Already confirmed");
        isConfirmed = true;

        // Transfer the tokens to the seller
        require(token.balanceOf(address(this)) >= amount, "Not enough tokens in escrow");
        token.transfer(seller, amount);
    }

    function refundBuyer() external {
        require(msg.sender == seller, "Only seller can refund");
        require(!isConfirmed, "Already confirmed");

        // Refund the tokens to the buyer
        require(token.balanceOf(address(this)) >= amount, "Not enough tokens in escrow");
        token.transfer(buyer, amount);
    }
}
