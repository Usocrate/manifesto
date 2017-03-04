var menu= new Array();



function itemMenu(imgName,srcImgOff,srcImgOver,srcImgOn){

	this.img= new Array();

	// nb: le preload des images est géré ici

	this.img[0]= new Image();

	this.img[0].src = srcImgOff;

	this.img[1]= new Image();

	this.img[1].src = srcImgOver;

	this.img[2]= new Image();

	this.img[2].src = srcImgOn;

	this.name=imgName;

	this.activation=0;

	return this;

}

function activer(indiceItem){

	for (i=0; i<menu.length; i++){

		if (i!=indiceItem){

			document.images[menu[i].name].src = menu[i].img[0].src;

			menu[i].activation=0;		

		}

		else {

			document.images[menu[i].name].src = menu[i].img[2].src;

			menu[i].activation=1;

		}

	}

}

function survol_on(indiceItem){

	if (menu[indiceItem].activation==0){

		document.images[menu[indiceItem].name].src = menu[indiceItem].img[1].src;

	}

}

function survol_off(indiceItem){

	if (menu[indiceItem].activation==0){

		document.images[menu[indiceItem].name].src = menu[indiceItem].img[0].src;

	}

}

