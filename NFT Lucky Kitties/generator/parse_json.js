const { readFileSync, writeFileSync, readdirSync, rmSync, existsSync, mkdirSync, fs } = require('fs');

const CID = 'XXXXXXXXX'; //from IPFS
const CIDimgURL = 'https://gateway.pinata.cloud/ipfs/'+CID+'/';
const srcFile = './img/_VDLC_data.json';
const externalURL = 'https://vectordefector.com';

function renderNFTJSON(file) {

    // Create dir if not exists
    if (!existsSync('./json')){
        mkdirSync('./json');
    }

    // Cleanup dir before each run
    readdirSync('./json/').forEach(f => rmSync(`./json/${f}`));

    const jsonData = JSON.parse(readFileSync(file, 'utf-8'));
    const objCount  = Object.keys(jsonData).length;
    
    //console.log(objCount); 
    
    for(x=1;x<=objCount;x++) {

        const meta = {            
            name: jsonData[x].name,
            description: jsonData[x].description,
            image: CIDimgURL+jsonData[x].image,
            external_link: externalURL,
            attributes: [
                { 
                    trait_type: 'Background',
                    value: jsonData[x].attributes[0].value,
                    unique: jsonData[x].attributes[0].unique
                },
                { 
                    trait_type: 'Body',
                    value: jsonData[x].attributes[1].value,
                    unique: jsonData[x].attributes[1].unique
                },
                { 
                    trait_type: 'Fur Pattern',
                    value: jsonData[x].attributes[2].value,
                    unique: jsonData[x].attributes[2].unique
                },
                { 
                    trait_type: 'Eyes',
                    value: jsonData[x].attributes[3].value,
                    unique: jsonData[x].attributes[3].unique
                },
                { 
                    trait_type: 'Top Color',
                    value: jsonData[x].attributes[4].value,
                    unique: jsonData[x].attributes[4].unique
                },
                { 
                    trait_type: 'Bottom Color',
                    value: jsonData[x].attributes[5].value,
                    unique: jsonData[x].attributes[5].unique
                },
                { 
                    trait_type: 'Collar',
                    value: jsonData[x].attributes[6].value,
                    unique: jsonData[x].attributes[6].unique
                },
                { 
                    trait_type: 'Pendant Symbol',
                    value: jsonData[x].attributes[7].value,
                    unique: jsonData[x].attributes[7].unique
                },
                { 
                    trait_type: 'Tongue',
                    value: jsonData[x].attributes[8].value,
                    unique: jsonData[x].attributes[8].unique
                },
                { 
                    display_type: 'number', 
                    trait_type: 'Rating', 
                    value: jsonData[x].attributes[9].value,
                }
            ]
        }

        console.log("output meta: "+jsonData[x].ID);
        writeFileSync(`./json/VDLC_${jsonData[x].ID}.json`, JSON.stringify(meta));  

    }
}

renderNFTJSON(srcFile);
