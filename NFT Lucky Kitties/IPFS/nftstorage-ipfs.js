const fs = require('fs');
const { NFTStorage, File } = require('nft.storage');
const mime = require('mime');
const path = require('path');
const recursive = require('recursive-fs');
const creds = require('./config.json'); //API keys
const NFT_STORAGE_KEY = creds.nftStorageKEY;

async function pinFileToIPFS(file, name, description) {

    const nftstorage = new NFTStorage({ token: NFT_STORAGE_KEY })  
    const content = await fs.createReadStream(file);
    const type = mime.getType(file);
    const image = new File([content], path.basename(file), { type });

    return nftstorage.store({
        image,
        name,
        description,
    });
}

async function pinDirectoryToIPFS(folderPath, name, description) {

    const nftstorage = new NFTStorage({ token: NFT_STORAGE_KEY });

    recursive.readdirr(folderPath, function (err, dirs, files) {

        files.forEach((file) => {
            //for each file stream, include relative file path
            const content = fs.createReadStream(file);
            const type = mime.getType(file);
            const image = new File([content], path.basename(file), { type });

            const result = nftstorage.store({
                image,
                name,
                description,
            });

            console.log(result);

            return result;           

        })
        
    });
}

async function main() {
    pinFileToIPFS('../generator/img/_VDLC_data.json','kittez_json_solo','kittez_json_solo');      
    //fs.writeFileSync(`./ipfs_output.json`, JSON.stringify(info, null, 2)) //write results
}

main()
  .catch(err => {
      console.error(err)
      process.exit(1)
  })