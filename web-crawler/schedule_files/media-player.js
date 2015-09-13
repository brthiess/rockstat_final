var player;
function playerReady(obj) {
	//alert('the videoplayer '+obj['id']+' has been instantiated');
	player = document.getElementById(obj['id']);
	player.addEventListener(MediaEvent.JWPLAYER_MEDIA_MUTE, muteTracker);
};

function muteTracker(MediaEvent) { 
    trace('the new mute state is: '+evt.mute); 
}

function createPlayer(file, autoplay, image, div, width, height, preroll){
	width   = typeof(width)   != 'undefined' ? width   : '392';
	height  = typeof(height)  != 'undefined' ? height  : '245';
	preroll = typeof(preroll) != 'undefined' ? preroll : '';

	var so = new SWFObject('/flash/swfplayer.swf','flash-player',width,height,'9');
	so.addParam('allowfullscreen', 'true');
	so.addParam('allowscriptaccess', 'always');
	so.addParam('wmode', 'transparent');
	so.addVariable('enablejs', 'true');
	so.addVariable('javascriptid', 'jw-' + div);
	so.addVariable('file', file);
	
	if(image){
		so.addVariable('image', image);
	}
	
	if(preroll != ''){
		so.addVariable('plugins','adtvideo,gapro-1');
		so.addVariable('adtvideo.config', preroll);
	}
	
	so.addVariable("gapro.accountid", "UA-8601864-1");
	
	so.addVariable('autostart', autoplay);
	so.addVariable('skin', '/flash/modieus.swf');
	so.addVariable('backcolor', '000000');
	so.addVariable('frontcolor', '999999');
	so.addVariable('lightcolor', '999999');
	so.addVariable('screencolor', '000000');
	so.addVariable('controlbar','over');
 so.addVariable('stretching','fill');
	so.write(div);
}

/*
var stor    = -1;
var maxstor = 5;
var timeout = 0;
var changed = [];

$(document).ready(function(){
	autorot();
});

function autorot() {
	showNext();
	
	timeout = setTimeout('autorot();', 5000);
}

function rotateDiv(stor){
//	var divs = document.getElementsByClassName("ui-tabs-panel");
	var divs = document.getElementById("tabs").getElementsByClassName("ui-tabs-panel");
	for (var i=0; i < divs.length; i++ ){
	var div = divs[i];

	if((div.id != "")){
			div.style.display = "none";
		}
	}

	div               = divs[stor];
	div.style.display = "block";

//	var spans = document.getElementsByClassName("ui-state-default");
	var spans = document.getElementById("tabs-thumbs").getElementsByClassName("ui-state-default");
	for (var i=0; i < spans.length; i++ ) {
		var span = spans[i];
		
		if((span.id != "")){
			if(i != stor)
				span.style.className = "none";
			else
				span.style.className = "ui-state-active";
		}
	}
}

function stoprot() {
	clearTimeout(timeout);
}


function showNext(){
	if(stor < maxstor)
		stor++;
	else
		stor = 0;
	rotateDiv(stor);
}

function showPrev(){
	if(stor > 0)
		stor--;
	else
		stor = maxstor;

	rotateDiv(stor);
}

function showStory(num){
	stor = num-1;
	clearTimeout(timeout);
	rotateDiv(stor);
}
*/