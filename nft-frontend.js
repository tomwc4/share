/*
* // NFT Actions
*/

//root NFT app constants
const contractAddress = '0x0000000000000000000000000000000000000000';

//fetch ABI json
var contractJSON = {};
jQuery.getJSON("/contracts/ABI.json", function(data){
  contractJSON = data;
}).fail(function(){
  console.log("An error has occurred.");
});

//register new keys for this website!!! 6/11
const ALCHEMY_KEY_DEV = "000000000000000000000000000000000";
const ALCHEMY_KEY_LIVE = "000000000000000000000000000000000";
const ALCHEMY_KEY = ALCHEMY_KEY_DEV; //switch for dev or live

//var chain = 'polygon'; //polygon
var chain = 'localhost'; //local
const defaultChain = "http://localhost:7545";

const web3 = new Web3(defaultChain);

let currentAccount = "0x0";
let balance;

async function updateConnectStatus() { 

	const onboarding = new MetaMaskOnboarding();
	const isInstalled = MetaMaskOnboarding.isMetaMaskInstalled();
	//const isInstalled = false;
	
	if (!isInstalled) {
		console.log('need to install metamask');

		jQuery('#wallet-connect-output').html('You need to <a id="mmInstall" href="#">install MetaMask wallet</a> in order to continue.');
		jQuery('#wallet-connect-output').fadeIn(500);

		jQuery('#mmInstall').click(function(){
			onboarding.startOnboarding();
		});

	} else {
		onboarding.stopOnboarding();
		//get account info or return error
        //const accounts = web3.eth.accounts;

        // window.ethereum
        const accounts = await ethereum
		.request({ method: 'eth_requestAccounts' })
		.then(handleAccountsChanged)
		.catch((err) => {
			if (err.code === -32002) {
                //user clicked the connect button again but dialog is already open
				console.log('Window is already open');
				jQuery('#wallet-connect-output').html('Request already open in MetaMask.');
				jQuery('#wallet-connect-output').fadeIn(500);
			} else if (err.code === 4001) {
				//user rejected the connection request
				console.log('User rejected connection request');
				jQuery('#wallet-connect-output').html('Request to connect was rejected in MetaMask. Please try again.');
				jQuery('#wallet-connect-output').fadeIn(500);
			} else {
				console.log(err);
			}
		});

	}
}

async function handleAccountsChanged(accounts) {
	if (accounts.length === 0) {
	// MetaMask is locked or the user has not connected any accounts
	console.log('Please connect MetaMask to one of your accounts on a chain we support.');
	jQuery('#wallet-connect-output').html('Please connect MetaMask to one of your accounts.');
	jQuery('#wallet-connect-output').fadeIn(500);
	  
	} else if (accounts[0] !== currentAccount) {
		
	  currentAccount = accounts[0];

      checkChain();

	  var output = '<input type="hidden" name="user-wallet-id" value="'+currentAccount+'"> <i class="fas fa-check-circle"></i> '+currentAccount;
		
	  jQuery('#form-connect-wallet #wallet-connect-output').html(output);		
	  jQuery('#form-connect-wallet #wallet-connect-output').fadeIn(500);
	 
	}
}

async function checkChain() {
    let chainId = 0;
    
    if(chain === 'rinkeby') {
      chainId = 4;
    }
    if(chain === 'polygon') {
      chainId = 137;
    }
    if(chain === 'localhost') {
        chainId = 1337;
    }

    //console.log(window.ethereum.networkVersion + " "+chainId);

    if (window.ethereum.networkVersion !== chainId) {
      try {
        await window.ethereum.request({
          method: 'wallet_switchEthereumChain',
          params: [{ chainId: web3.utils.toHex(chainId) }],
        });
        updateConnectStatus();
      } catch (err) {
        if (err.code === 4001) {
            //user rejected the connection request
            console.log('User rejected connection request');
            jQuery('#wallet-connect-output').html('Request to connect was rejected in MetaMask. Please try again.');
            jQuery('#wallet-connect-output').fadeIn(500);
        }
        if (err.code === -32002) {
            //user clicked the connect button again but dialog is already open
			console.log('Window is already open');
			jQuery('#wallet-connect-output').html('Request already open in MetaMask.');
			jQuery('#wallet-connect-output').fadeIn(500);
        }
        if (err.code === 4902) {
          try {
            if(chain === 'rinkeby') {
              await window.ethereum.request({
                method: 'wallet_addEthereumChain',
                params: [
                  {
                    chainName: 'Rinkeby Test Network',
                    chainId: web3.utils.toHex(chainId),
                    nativeCurrency: { name: 'ETH', decimals: 18, symbol: 'ETH' },
                    rpcUrls: [`https://eth-rinkeby.alchemyapi.io/v2/${ALCHEMY_KEY}`],
                  },
                ],
              });
            }
            else if(chain === 'mumbai') {
              await window.ethereum.request({
                method: 'wallet_addEthereumChain',
                params: [
                  {
                    chainName: 'Polygon TestNet',
                    chainId: web3.utils.toHex(chainId),
                    nativeCurrency: { name: 'MATIC', decimals: 18, symbol: 'MATIC' },
                    rpcUrls: [`https://polygon-mumbai.g.alchemy.com/v2/${ALCHEMY_KEY}`],
                  },
                ],
              });
            }
            else if(chain === 'polygon') {
              await window.ethereum.request({
                method: 'wallet_addEthereumChain',
                params: [
                  {
                    chainName: 'Polygon Mainnet',
                    chainId: web3.utils.toHex(chainId),
                    nativeCurrency: { name: 'MATIC', decimals: 18, symbol: 'MATIC' },
                    rpcUrls: [`https://polygon-mainnet.g.alchemy.com/v2/${ALCHEMY_KEY}`],
                  },
                ],
              });
            }
            updateConnectStatus();
          } catch (err) {
            console.log(err);
          }
        }
        }
      }
}

async function purchaseNFT(nftID,chain,price) {

    console.log("purchase nft: "+nftID+" on chain: "+chain+" for price: "+price);

    await updateConnectStatus().then(() =>{
        console.log(currentAccount);
     }
    ).catch((err) => {
        console.error(err);
    });

    await checkBalance(currentAccount).then(() =>{     
        
        console.log("account balance: "+balance);       
        
        if(parseInt(balance) >= parseInt(price)) {

            const contract = new web3.eth.Contract(contractJSON.abi, contractAddress);
            
            //console.log(contract.methods);

            contract.methods.count().call().then((count) => {
                console.log("count: "+count);
            });
            

        } else {
            console.log("not enough balance");
            jQuery('#wallet-connect-output').html('Not enough coin in wallet!');
			      jQuery('#wallet-connect-output').fadeIn(500);
        }        

    } ).catch((err) => {
        console.error(err);
    });   

}

async function checkBalance(address) {
    try {
        await web3.eth.getBalance(address).then((balanceInWei) => {
            balance = web3.utils.fromWei(balanceInWei);
        });
    } catch (error) {
        console.log(error);
    }
}

function enableNFTButtons(){

    //this call would come from inside unity instance and send nftDataID
    jQuery('#nft-toggle').click(function(){ 
        lity(jQuery('.nft-content'));					
        nftWindowActive = 1;
        //document.exitPointerLock();
        jQuery('.nft-content').find('.activity-entry').css('display','none'); //reset and hide all entries
        
        //var nftDataID = 628; //622 624 626 628
        var nftDataID = 517;
             
        var currentEntry = jQuery('.nft-content').find('.activity-entry[data-id="'+nftDataID+'"]');
        var nftChain =  currentEntry.attr('data-chain');
        var nftPrice = currentEntry.attr('data-price');
        
        currentEntry.css('display','flex');
        //document.addEventListener("mousemove", updatePosition, false);
        //unityInstance.SendMessage('JavascriptHook', 'TintGreen');}

        jQuery('.nft-content').find('#purchase-nft').click(function(){ 
            purchaseNFT(nftDataID,nftChain,nftPrice);
        });	

    });	


}
