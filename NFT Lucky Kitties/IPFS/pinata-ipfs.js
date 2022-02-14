const fs = require('fs');
const axios = require('axios');
const FormData = require('form-data');
const recursive = require('recursive-fs');
const basePathConverter = require('base-path-converter');
const creds = require('./config.json'); //API keys

//test connection
async function testAuthentication() {
    const url = `https://api.pinata.cloud/data/testAuthentication`;
    return axios
        .get(url, {
            headers: {
                pinata_api_key: creds.pinataAPI,
                pinata_secret_api_key: creds.pinataSECRET,
            }
        })
        .then(function (response) {
            console.log(response);
        })
        .catch(function (error) {
            console.log(error);
        });
};

//pin single file
async function pinFileToIPFS(file,label) {
    const url = `https://api.pinata.cloud/pinning/pinFileToIPFS`;

    console.log("uploading "+file+" as /"+label);
    let data = new FormData();

    data.append('file', fs.createReadStream(file));

    const metadata = JSON.stringify({
        name: label,
        keyvalues: {
            exampleKey: 'exampleValue'
        }
    });

    data.append('pinataMetadata', metadata);
    
    /*
    //optional
    const pinataOptions = JSON.stringify({
        cidVersion: 0,
        customPinPolicy: {
            regions: [
                {
                    id: 'FRA1',
                    desiredReplicationCount: 1
                },
                {
                    id: 'NYC1',
                    desiredReplicationCount: 2
                }
            ]
        }
    });
    data.append('pinataOptions', pinataOptions);
    */

    return axios
        .post(url, data, {
            maxBodyLength: 'Infinity', // for axios large directories
            headers: {
                'Content-Type': `multipart/form-data; boundary=${data._boundary}`,
                pinata_api_key: creds.pinataAPI,
                pinata_secret_api_key: creds.pinataSECRET
            }
        })
        .then(function (response) {
            console.log(response.data);
        })
        .catch(function (error) {
            console.log(error);
        });
};

//pin full directory
async function pinDirectoryToIPFS(src,destFolder){
    const url = `https://api.pinata.cloud/pinning/pinFileToIPFS`;

    console.log("uploading "+src+" to /"+destFolder);
    
    recursive.readdirr(src, function (err, dirs, files) {
        let data = new FormData();
        files.forEach((file) => {
            //for each file stream, include relative file path
            data.append(`file`, fs.createReadStream(file), {
                filepath: basePathConverter(src, file)
            });
        });

        const metadata = JSON.stringify({
            name: destFolder,
            keyvalues: {
                exampleKey: 'exampleValue'
            }
        });

        data.append('pinataMetadata', metadata);

        return axios
            .post(url, data, {
                maxBodyLength: 'Infinity',
                headers: {
                    'Content-Type': `multipart/form-data; boundary=${data._boundary}`,
                    pinata_api_key: creds.pinataAPI,
                    pinata_secret_api_key: creds.pinataSECRET
                }
            })
            .then(function (response) {
                console.log(response.data);
            })
            .catch(function (error) {
                console.log(error);
            });
    });
};


//inits

//testAuthentication();
//pinDirectoryToIPFS('../generator/img','kittez_img');
//pinDirectoryToIPFS('../generator/json','kittez_json');
//pinFileToIPFS('../generator/img/_VDLC_data.json','kittez_json_solo');