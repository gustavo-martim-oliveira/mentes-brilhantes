/**
 * Generate a Stove
 */
class Stove {
    constructor(color, dimensions, brand, burners) {
        this.color = color;
        this.dimensions = dimensions;
        this.brand = brand;
        this.burners = burners.map((value, index) => new Burner(`Burner ${index}`, value));
        this.oven = new Oven();
    }
}

/**
 * Generate burner for Stove
 */
class Burner {
    constructor(name, color) {
        this.name = name;
        this.color = color;
    }
}

/**
 * Generate oven for Stove
 */
class Oven {
    constructor() {
        this.door = new Door(`Glass ${1}`, `Dimensions ${1}`);
    }
}

/**
 * Generate Glass Door for Oven
 */
class Door {
    constructor(glass, dimensions) {
        this.glass = glass;
        this.dimensions = dimensions;
    }
}

const myStove = new Stove("#e8e8e8", "30 x 60 x 90 cm", "GM Industries", ['red', 'green', 'blue', 'black', 'red']);

// Retrieve all stove elements
let stoveElement = document.getElementById('stove');
let dimensions = document.getElementById('dimensions');
let stoveBrand = document.getElementById('brand-name');
let buttonOvenLamp = document.getElementById('lamp-button');
let ovenLamp = document.getElementById('oven-lamp');
let burners = document.getElementById('burners');

//Set dimension text
dimensions.innerHTML = myStove.dimensions;

//Set background Color
stoveElement.style = 'background: ' + myStove.color;

//Set Brand name
stoveBrand.innerHTML = myStove.brand;

//Clear default burners
burners.innerHTML = '';

//Each burners
myStove.burners.forEach( el => {
    var i = document.createElement('i');
    i.style = 'background-color: ' + el.color;
    burners.append(i);
});

/**
 * Toggle Lamp Light
 */
let lampLight = false;
function toggleLamp(){
    if(!lampLight){
        buttonOvenLamp.innerText = "Lamp on";
        buttonOvenLamp.classList.add('light');
        ovenLamp.classList.add('light');
        lampLight = true;
    }else{
        buttonOvenLamp.innerText = "Lamp off";
        buttonOvenLamp.classList.remove('light');
        ovenLamp.classList.remove('light');
        lampLight = false;
    }

    return true;
}