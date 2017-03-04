// Script trouvé sur Le Webmestre www.le-webmestre.net info@le-webmestre.net

// Retrouvez des centaines de scripts et bien plus...



// Taille de la boîte en largeur

var scrollerwidth=130



// Taille de la boîte en hauteur

var scrollerheight=80



// La couleur du background

var scrollerbgcolor='lightyellow'



// URL de l'image du background, ne mettez rien si vous l'en voulez pas.

var scrollerbackground=''



var messages=new Array()



// Vos messages, on peut mettre du code HTML aussi et N'OUBLIEZ PAS LES TAGS DE FERMETURE ! !.

messages[0]="Message 1"

messages[1]="Message 2"

messages[2]="Message 3"



if (messages.length>1)

i=2

else 

i=0



function move1(whichlayer){

tlayer=eval(whichlayer)

if (tlayer.top>0&&tlayer.top<=5){

tlayer.top=0

setTimeout("move1(tlayer)",3000)

setTimeout("move2(document.main.document.second)",3000)

return }

if (tlayer.top>=tlayer.document.height*-1){

tlayer.top-=5 //lwf

setTimeout("move1(tlayer)",100)}

else{ tlayer.top=scrollerheight

tlayer.document.write(messages[i])

tlayer.document.close()

if (i==messages.length-1)

i=0

else 

i++ }}



function move2(whichlayer){

tlayer2=eval(whichlayer)

if (tlayer2.top>0&&tlayer2.top<=5){

tlayer2.top=0

setTimeout("move2(tlayer2)",3000)

setTimeout("move1(document.main.document.first)",3000)

return}

if (tlayer2.top>=tlayer2.document.height*-1){

tlayer2.top-=5 //lwf

setTimeout("move2(tlayer2)",100)}

else{ tlayer2.top=scrollerheight

tlayer2.document.write(messages[i])

tlayer2.document.close()

if (i==messages.length-1)

i=0

else i++ }}



function move3(whichdiv){

tdiv=eval(whichdiv)

if (tdiv.style.pixelTop>0&&tdiv.style.pixelTop<=5){

tdiv.style.pixelTop=0

setTimeout("move3(tdiv)",3000)

setTimeout("move4(second2)",3000)

return}

if (tdiv.style.pixelTop>=tdiv.offsetHeight*-1){

tdiv.style.pixelTop-=5

setTimeout("move3(tdiv)",100)}

else{

tdiv.style.pixelTop=scrollerheight

tdiv.innerHTML=messages[i] //lwf

if (i==messages.length-1)

i=0 

else i++}}



function move4(whichdiv){

tdiv2=eval(whichdiv)

if (tdiv2.style.pixelTop>0&&tdiv2.style.pixelTop<=5){

tdiv2.style.pixelTop=0

setTimeout("move4(tdiv2)",3000)

setTimeout("move3(first2)",3000)

return}

if (tdiv2.style.pixelTop>=tdiv2.offsetHeight*-1){

tdiv2.style.pixelTop-=5

setTimeout("move4(second2)",100)}

else{

tdiv2.style.pixelTop=scrollerheight

tdiv2.innerHTML=messages[i]

if (i==messages.length-1)

i=0

else i++}}



function startscroll(){

if (document.all){

move3(first2)

second2.style.top=scrollerheight

second2.style.visibility='visible' }

else if (document.layers){

document.main.visibility='show'

move1(document.main.document.first)

document.main.document.second.top=scrollerheight+5

document.main.document.second.visibility='show'}}

