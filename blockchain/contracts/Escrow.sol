// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;

contract Escrow {
    address public buyer;
    address payable public seller;
    uint public amount;
    bool public isConfirmed;

    constructor(address payable _seller) payable {
        buyer = msg.sender;
        seller = _seller;
        amount = msg.value;
        isConfirmed = false;
    }

    function confirmDelivery() external {
        require(msg.sender == buyer, "Only buyer can confirm");
        require(!isConfirmed, "Already confirmed");
        isConfirmed = true;
        seller.transfer(amount);
    }

    function refundBuyer() external {
        require(msg.sender == seller, "Only seller can refund");
        require(!isConfirmed, "Already confirmed");
        payable(buyer).transfer(amount);
    }
}
