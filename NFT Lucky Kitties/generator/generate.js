const { readFileSync, writeFileSync, readdirSync, rmSync, existsSync, mkdirSync, fs } = require('fs');
const sharp = require('sharp');

const template = `
    <svg width="550" height="550" viewBox="0 0 550 550" xmlns="http://www.w3.org/2000/svg">
        <!-- bg -->
        <!-- body -->
        <!-- hair -->
        <!-- tongue -->
        <!-- color-btm -->
        <!-- color-top -->
        <!-- eyes -->        
        <!-- collar -->
        <!-- symbol -->        
    </svg>
`
const takenz = {};
const JSONoutput = {};
let idx = 1;
let maxOut = 5000;

function zeroPad(num, places = 4){
    return String(num).padStart(places, '0');
}

function randInt(max) {
    return Math.floor(Math.random() * (max + 1));
}

function randIntExcluded(max,exclude){
    let rand = null; 
    if(exclude instanceof Array){
        while(rand === null || exclude.includes(rand)){
            rand = randInt(max);
        }  
    } else {
        while(rand === null || rand === exclude){
            rand = randInt(max);
        }  
    }    
    return rand;
}

function glueName(bg,body,eyes,colorBtm,colorTop,symbol) {   
    const bgLabel = 'green,pink,teal,maroon,red,yellow,purple,orange,hackorz,sailor,honeycomb,wave'.split(','); 
    const bodyLabel = 'left-tail black,right-tail black,left-tail white,right-tail white,left-tail brown,right-tail brown,right-tail golden,left-tail golden,right-tail grey,left-tail grey'.split(',');
    const colorBtmLabel = 'red,purple,green,pink'.split(',');
    const colorTopLabel = 'gold,silver,green'.split(',');
    const eyesLabel = 'plain ole,sweet,nerdy,chill'.split(',');
    const symbolsLabel = 'crypto,heart,cat,love,luck'.split(',');

    const name =  `LUCKY KITTEH | A collection of cute kitties with random traits wearing various lucky charms. | This KITTEH is a: ${eyesLabel[eyes]}-eyed ${bodyLabel[body]} body with ${colorBtmLabel[colorBtm]} & ${colorTopLabel[colorTop]} highlights and (${symbolsLabel[symbol]}) pendant on a ${bgLabel[bg]} background.`;

    return name;
}

function outputAttribute(type,value) {   
    const bgLabel = 'green,pink,teal,maroon,red,yellow,purple,orange,hackorz,sailor,honeycomb,wave'.split(','); 
    const bodyLabel = 'left-tail black,right-tail black,left-tail white,right-tail white,left-tail brown,right-tail brown,right-tail golden,left-tail golden,right-tail grey,left-tail grey'.split(',');
    const hairLabel = 'calico,tabby'.split(',');
    const colorBtmLabel = 'red,purple,green,pink'.split(',');
    const colorTopLabel = 'gold,silver,green'.split(',');
    const eyesLabel = 'plain-ole,sweet,nerdy,chill'.split(',');
    const collarLabel = 'dots,stars,paws'.split(',');
    const symbolsLabel = 'crypto,heart,cat,love,luck'.split(',');

    return eval(type)[value];
}

function getLayer(name, skip=0.0) {
    const namePH = '<!-- '+name+' -->';
    const svg = readFileSync(`./layers/${name}.svg`, 'utf-8');
    const re = /(?<=\<svg\s*[^>]*>)([\s\S]*?)(?=\<\/svg\>)/g
    const layer = svg.match(re)[0];
    return Math.random() > skip ? layer : namePH;
}

async function renderImages(name) {
    const src = `./img/${name}.svg`;
    const dest = `./img/${name}.png`;
    const img = sharp(src)
    .resize(1080)
    .toFile(dest)
    .then( data => { 
        rmSync(src); //remove SVG source
     }) 
    .catch( err => { 
        console.log(err) 
    });    
}

function createImage(idx) {

    let bg = randInt(11);
    let body = randInt(9);
    let hair = randInt(1);
    let eyes = randInt(3);
    let colorBtm = randInt(2); 
    let colorTop = randInt(2); 
    let collar = randInt(2);
    let symbol = randInt(4);
    let weight = 0;

    //re-roll rules 

    //no black on black
    if((body == 0 || body == 1) && (colorTop == 1)) {
        //console.log('skip: black on black');
        colorTop = randIntExcluded(2,1);
    }

    //no green on white   
    /* 
    if((body == 2 || body == 3) && (colorTop == 2)) {
        //console.log('skip: green on white');
        colorTop = randIntExcluded(1,2);
    } */

    //no gold or green on gold
    if((body == 6 || body == 7) && (colorTop == 0 || colorTop == 2)) {
        colorTop = randIntExcluded(2,[0,2]);
    }

    //no gold or green on brown
    if((body == 4 || body == 5) && (colorTop == 0 || colorTop == 2)) {
        colorTop = randIntExcluded(2,[0,2]);
    }

    //force crypto symbol on hackorz kitteh
    if((bg == 8) && (symbol != 0)) {
        symbol = 0;
    }   
            
    //force lucky symbol on sailor kitteh
    if((bg == 9) && (symbol != 4)) {
        symbol = 4;
    }
    
    const kittez = [bg,body,hair,eyes,colorBtm,colorTop,collar,symbol].join('');

    if (takenz[kittez]) {
        createImage(idx);
    } else {
        const name = glueName(bg,body,eyes,colorBtm,colorTop,symbol);
        console.log("#"+idx+" "+name);
        takenz[kittez] = kittez;
        var hairLabel = 'none';
        var tongueLabel = 'none';

        const final = template
            .replace('<!-- bg -->', getLayer(`bg${bg}`))
            .replace('<!-- body -->', getLayer(`body${body}`))
            .replace('<!-- hair -->', getLayer(`hair${hair}`,0.5))
            .replace('<!-- tongue -->', getLayer('tongue',0.9))
            .replace('<!-- eyes -->', getLayer(`eyes${eyes}`))
            .replace('<!-- color-btm -->', getLayer(`color-btm${colorBtm}`))
            .replace('<!-- color-top -->', getLayer(`color-top${colorTop}`))
            .replace('<!-- collar -->', getLayer(`collar${collar}`))
            .replace('<!-- symbol -->', getLayer(`symbol${symbol}`))

        if(final.indexOf('<!-- hair') == -1) {
            hairLabel = outputAttribute('hairLabel',hair);
            weight += 50;
        }

        if(final.indexOf('<!-- tongue') == -1) {
            tongueLabel = 'has';
            weight += 100;
        }

        if(eyes > 0) {
            weight += 25;
        }

        if(bg > 7) {
            weight += 5;
        }

        //generate images
        writeFileSync(`./img/VDLC_${zeroPad(idx)}.svg`, final);
        renderImages('VDLC_'+zeroPad(idx));   

        const meta = {
            ID: zeroPad(idx), 
            name: `Lucky Kitty ID #${kittez}`,
            description: `${name}`,
            image: `VDLC_${zeroPad(idx)}.png`,
            attributes: [
                { 
                    trait_type: 'Background',
                    value: outputAttribute('bgLabel',bg),
                    unique: .0833
                },
                { 
                    trait_type: 'Body',
                    value: outputAttribute('bodyLabel',body),
                    unique: .1
                },
                { 
                    trait_type: 'Fur Pattern',
                    value: hairLabel,
                    unique: .5
                },
                { 
                    trait_type: 'Eyes',
                    value: outputAttribute('eyesLabel',eyes),
                    unique: .25
                },
                { 
                    trait_type: 'Top Color',
                    value: outputAttribute('colorTopLabel',colorTop),
                    unique: .33
                },
                { 
                    trait_type: 'Bottom Color',
                    value: outputAttribute('colorBtmLabel',colorBtm),
                    unique: .5
                },
                { 
                    trait_type: 'Collar',
                    value: outputAttribute('collarLabel',collar),
                    unique: .33
                },
                { 
                    trait_type: 'Pendant Symbol',
                    value: outputAttribute('symbolsLabel',symbol),
                    unique: .2
                },
                { 
                    trait_type: 'Tongue',
                    value: tongueLabel,
                    unique: .1
                },
                { 
                    display_type: 'number', 
                    trait_type: 'Rating', 
                    value: weight
                }
            ]
        }

        //log each meta entry to array to parse into json
        JSONoutput[idx] = meta;
             
    }

    //output final results as a json receipt
    writeFileSync(`./img/_VDLC_data.json`, JSON.stringify(JSONoutput));  

}

function generateNFTs() {
    // Create dir if not exists
    if (!existsSync('./img')){
        mkdirSync('./img');
    }

    // Cleanup dir before each run
    readdirSync('./img/').forEach(f => rmSync(`./img/${f}`,{ recursive: true }));

    do {
        createImage(idx);
        idx++;
    } while (idx <= maxOut);
}

generateNFTs();