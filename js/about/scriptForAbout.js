
//----------- CARDS TO DROP IN ABOUT---------------------


function init(){

	body = document.body;
	stage = document.getElementById('stage');
	nullObject = document.createElement('div');
	TweenLite.defaultEase = Power2.easeOut;
	spacerZ = 50, maxDrag = 300, perspective = 800;

	TweenMax.set(stage, {
		perspective:perspective,
		perspectiveOrigin:'50% -100%'
	})
   TweenMax.set('#info',{
     position:'absolute',
     left:'50%',
     xPercent:-50,
     top:'10%',
     fontFamily:'Roboto Slab',
     fontSize:32,
     color:'rgba(44,46,47,1)',
     textAlign:'center'
   })
	TweenMax.set(nullObject, {
		position:'absolute',
		x:0
	})

	cardDataArray = [
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/science.png', cardTitle:'Une application web', cardBody:'Calendap n\'est pas un site, c\'est une application web dynamique qui génère du contenu à partir des actions des différents utilisateurs'},
    {imageUrl:'https://c1.staticflickr.com/2/1254/1201680715_30a011f08e_b.jpg', cardTitle:'Deux types d\'utilisateurs', cardBody:'Le concept est de faciliter la mise en relation entre des professionnels du secteur tertiaire et leurs clients en facilitant la recherche et la prise de rendez-vous'},
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/folds.png', cardTitle:'Un calendrier interactif', cardBody:'L\'élément central du projet est un calendrier interactif qui affiche les horaires libres des différents professionnels. Les clients peuvent prendre rendez vous directement sur le calendrier'},
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/building.png', cardTitle:'Une carte à personnaliser', cardBody:'Les professionnels ont également la possibilité de personnaliser leur carte de présentation(choix des couleurs, des animations etc..)'},
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/bars.png', cardTitle:'Un service de mise en avant', cardBody:'Le modèle économique est basé sur le programme "coup de pouce" qui permet à un professionnel de payer pour être mis en avant sur des recherches ciblées (équivalent de l\'achat de mots clés chez google) '},
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/shards.png', cardTitle:'Un projet "user centric"', cardBody:'La conception orientée utilisateur est une philosophie et une démarche de conception où les besoins et les attentes des utilisateurs sont pris en compte à chaque étape du processus de développement '},
    {imageUrl:'https://s3-us-west-2.amazonaws.com/s.cdpn.io/35984/wet.png', cardTitle:'Un modèle économique agile', cardBody:'On a choisi d\'adopter un modèle basé sur un MVP( minimum viable product) qui est directement mis à disposition du public et qu\'on va ensuite faire évoluer grace aux retours de nos premiers utilisateurs'}];

	cardElementArray = []

	createCards();


	Draggable.create(nullObject, {
		type:'x',
		trigger:stage,
		throwProps:true,
		onDrag:throwUpdate,
		onThrowUpdate:throwUpdate,
		onDragEnd:dragEnd,
		snap:[0]
	})
}

function createCards(){

	for(var i = 0; i < cardDataArray.length; i++){

		// var cardSymbol = sym.createChildSymbol(cardDataArray[i], stage);
		// cardElement = cardSymbol.getSymbolElement();
		cardElement = document.createElement('div');
		cardImage = document.createElement('img');
		cardTitle = document.createElement('div');
		cardTitle.className = 'card-title';
		cardPanel = document.createElement('div');
		cardBodyText = document.createElement('div');
		cardShareText = document.createElement('div');
		cardActionText = document.createElement('div');
		cardImage.setAttribute('src', cardDataArray[i].imageUrl);

		TweenMax.set(cardImage, {
			position:'absolute',
			alpha:0.8
		})

		cardTitle.innerHTML = cardDataArray[i].cardTitle;
		cardBodyText.innerHTML = cardDataArray[i].cardBody
		TweenMax.set(cardTitle, {
			position:'absolute',
			top:136,
			left:15,
			width:345,
			fontSize:26,
			color:'#fff',
			fontFamily:'Roboto Slab, sans-serif'
		})
		;

		TweenMax.set(cardPanel, {
			position:'absolute',
			top:185,
			left:0,
			width:360,
			height:135,
			backgroundColor:'#fff',
			color:'#000',
			fontFamily:'Roboto, sans-serif'
		})
		TweenMax.set(cardBodyText, {
			position:'absolute',
			top:200,
			left:15,
			width:330,
			height:100,
			fontSize:15,
			color:'#000',
			fontFamily:'Roboto, sans-serif'
		})
		;
		TweenMax.set([cardActionText, cardShareText], {
			position:'absolute',
			top:290,
			width:80,
			height:50,
			fontSize:15,
			color:'#000',
			fontFamily:'Roboto, sans-serif'
		})

		TweenMax.set(cardActionText, {
			left:115,
      color:'#FFAB40'
		})
		TweenMax.set(cardShareText, {
			left:15
		})
		;

		TweenMax.set(cardElement, {
			position:'absolute',
			left:'50%',
			xPercent:-50,
			top:'50%',
			yPercent:-50,
			z:-(i * spacerZ),
			//autoAlpha:0,
			zIndex:-i,
			transformPerspective:'150% -20%',
			width:360,
			height:320,
			backgroundColor:'#000',
			borderRadius:'2px',
			overflow:'hidden',
			boxShadow:'0px 0px 5px 2px rgba(0,0,0,0.2)',
        scale:0
		})

		cardElement.appendChild(cardImage);
		cardElement.appendChild(cardPanel);
		cardElement.appendChild(cardBodyText);
		cardElement.appendChild(cardTitle);
		cardElement.appendChild(cardShareText);
		cardElement.appendChild(cardActionText);
		stage.appendChild(cardElement);

		cardElementArray.push(cardElement);
	}
    TweenMax.staggerFromTo(cardElementArray, 1, {
      scale:0
    }, {
      scale:1,
      force3D:true,
      ease:Elastic.easeOut.config(0.7,0.8)
    }, 0.1, function(){
      //cardElementArray.reverse()
    })

}

function throwUpdate(){

	var i = cardElementArray.length;


	while(--i > -1){


		var rot = nullObject._gsTransform.x/20;
		var z = Math.abs(cardElementArray[i]._gsTransform.z/200);
		var x = nullObject._gsTransform.x;
		var y = nullObject._gsTransform.y;
		TweenMax.to(cardElementArray[i], 0.7, {
			x:x - (x * z),
			y:-nullObject._gsTransform.x/10,
			rotation:rot - (rot * z),
        force3D:true,
			ease:Power2.easeOut


		})

	}

	throwSpeed = ThrowPropsPlugin.getVelocity(this.target, "x")/1000;

}

function dragEnd(){

	var time = (nullObject._gsTransform.x / throwSpeed)/100;

	if(nullObject._gsTransform.x > (maxDrag) || throwSpeed > 3){

		time = (time>3) ? 1 : time;
		TweenMax.to(cardElementArray[0], time, {
			left:'+=50%',
			ease:Power2.easeOut,
			onStart:removeCard

		})
	}

}

function removeCard(){

	var c = cardElementArray.shift();


	TweenMax.to(cardElementArray, 1, {
		z:'+=' + spacerZ,
    // ease:Back.easeOut,
		onComplete:checkCards,
    onCompleteParams:[c]
	})

}


function checkCards(c){
  c.parentNode.removeChild(c);
	if(cardElementArray.length == 0){

		createCards();
	}
}

init();


// NAVIGATION IN ABOUT

var toc = document.querySelector( '.toc' );
var tocPath = document.querySelector( '.toc-marker path' );
var tocItems;

// Factor of screen size that the element must cross
// before it's considered visible
var TOP_MARGIN = 0.1,
    BOTTOM_MARGIN = 0.2;

var pathLength;

window.addEventListener( 'resize', drawPath, false );
window.addEventListener( 'scroll', sync, false );

drawPath();

function drawPath() {

  tocItems = [].slice.call( toc.querySelectorAll( 'li' ) );

  // Cache element references and measurements
  tocItems = tocItems.map( function( item ) {
    var anchor = item.querySelector( 'a' );
    var target = document.getElementById( anchor.getAttribute( 'href' ).slice( 1 ) );

    return {
      listItem: item,
      anchor: anchor,
      target: target
    };
  } );

  // Remove missing targets
  tocItems = tocItems.filter( function( item ) {
    return !!item.target;
  } );

  var path = [];
  var pathIndent;

  tocItems.forEach( function( item, i ) {

    var x = item.anchor.offsetLeft - 5,
        y = item.anchor.offsetTop,
        height = item.anchor.offsetHeight;

    if( i === 0 ) {
      path.push( 'M', x, y, 'L', x, y + height );
      item.pathStart = 0;
    }
    else {
      // Draw an additional line when there's a change in
      // indent levels
      if( pathIndent !== x ) path.push( 'L', pathIndent, y );

      path.push( 'L', x, y );

      // Set the current path so that we can measure it
      tocPath.setAttribute( 'd', path.join( ' ' ) );
      item.pathStart = tocPath.getTotalLength() || 0;

      path.push( 'L', x, y + height );
    }

    pathIndent = x;

    tocPath.setAttribute( 'd', path.join( ' ' ) );
    item.pathEnd = tocPath.getTotalLength();

  } );

  pathLength = tocPath.getTotalLength();

  sync();

}

function sync() {

  var windowHeight = window.innerHeight;

  var pathStart = pathLength,
      pathEnd = 0;

  var visibleItems = 0;

  tocItems.forEach( function( item ) {

    var targetBounds = item.target.getBoundingClientRect();

    if( targetBounds.bottom > windowHeight * TOP_MARGIN && targetBounds.top < windowHeight * ( 1 - BOTTOM_MARGIN ) ) {
      pathStart = Math.min( item.pathStart, pathStart );
      pathEnd = Math.max( item.pathEnd, pathEnd );

      visibleItems += 1;

      item.listItem.classList.add( 'visible' );
    }
    else {
      item.listItem.classList.remove( 'visible' );
    }

  } );

  // Specify the visible path or hide the path altogether
  // if there are no visible items
  if( visibleItems > 0 && pathStart < pathEnd ) {
    tocPath.setAttribute( 'stroke-dashoffset', '1' );
    tocPath.setAttribute( 'stroke-dasharray', '1, '+ pathStart +', '+ ( pathEnd - pathStart ) +', ' + pathLength );
    tocPath.setAttribute( 'opacity', 1 );
  }
  else {
    tocPath.setAttribute( 'opacity', 0 );
  }

}
