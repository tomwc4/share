// SPDX-License-Identifier: MIT
pragma solidity ^0.8.4;

import "@openzeppelin/contracts/token/ERC721/ERC721.sol";
import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/access/Ownable.sol";
import "@openzeppelin/contracts/security/PullPayment.sol";
import "@openzeppelin/contracts/utils/Counters.sol";

/// @custom:security-contact info@vectordefector.com
contract Lucky_Kittehz is ERC721, ERC721URIStorage, Ownable, PullPayment {

    //constants
    using Counters for Counters.Counter;
    Counters.Counter private _tokenIdCounter;
    uint256 public constant TOTAL_SUPPLY = 10_000;
    uint256 public constant MINT_PRICE = 0.015 ether;
    mapping(string => uint8) existingURIs; //add uri mapping to ensure uniques

    constructor() ERC721("Lucky_Kittehz", "VDLC") {}

    function _baseURI() internal pure override returns (string memory) {
        return "ipfs://";
    }

    function safeMint(address to, string memory uri) public onlyOwner {
        uint256 tokenId = _tokenIdCounter.current();
        require(tokenId < TOTAL_SUPPLY, "Max supply reached");
        _tokenIdCounter.increment();
        _safeMint(to, tokenId);
        _setTokenURI(tokenId, uri);
        existingURIs[uri] = 1;
    }
    
    function payToMint(address recipient,string memory uri) public payable returns (uint256) {
        uint256 tokenId = _tokenIdCounter.current();
        require(tokenId < TOTAL_SUPPLY, "Max supply reached");
        require(msg.value >= MINT_PRICE, 'Need to pay up!');
        _tokenIdCounter.increment();
        _mint(recipient, tokenId);
        _setTokenURI(tokenId, uri);
        existingURIs[uri] = 1;
        return tokenId;
    }

    function _burn(uint256 tokenId) internal override(ERC721, ERC721URIStorage) {
        super._burn(tokenId);
    }

    function tokenURI(uint256 tokenId)
        public
        view
        override(ERC721, ERC721URIStorage)
        returns (string memory){
        return super.tokenURI(tokenId);
    }

    function isContentOwned(string memory uri) public view returns (bool) {
        return existingURIs[uri] == 1;
    }
    
    function count() public view returns (uint256) {
        return _tokenIdCounter.current();
    }

    /// @dev Overridden in order to make it an onlyOwner function
    function withdrawPayments(address payable payee) public override onlyOwner virtual {
        super.withdrawPayments(payee);
    }

}