var player;
function playerReady(obj) {
	//alert('the videoplayer '+obj['id']+' has been instantiated');
	player = document.getElementById(obj['id']);
};

function createPlayer(file, autoplay, image){
	var so = new SWFObject('/flash/swfplayer.swf','flash-player','356','200','9');
	so.addParam('allowfullscreen', 'true');
	so.addParam('allowscriptaccess', 'always');
	so.addParam('wmode', 'transparent');
	so.addVariable('enablejs', 'true');
	so.addVariable('javascriptid', 'jw_player');
	so.addVariable('file', file);

	if(image){
		so.addVariable('image', image);
	}

	so.addVariable('autostart', autoplay);
	so.addVariable('skin', '/flash/modieus.swf');
	so.addVariable('backcolor', '2A4864');
	so.addVariable('frontcolor', 'FFFFFF');
	so.addVariable('lightcolor', '999999');
	so.addVariable('screencolor', '000000');
	so.addVariable('controlbar','over');
 so.addVariable('stretching','fill');
	so.write('video-player');
}

function rulesPopup(rules){
	window.open(rules, 'rules', 'width=580,height=420,toolbar=0,menubar=0,status=1,location=0,scrollbars=1');
	return false;
}

function toggleDiv(div){
	div = document.getElementById(div);

	if(div.style.display == 'block'){
		div.style.display = 'none';
	} else {
		div.style.display = 'block';
	}
}

function showDiv(div){
	div = document.getElementById(div);
	div.style.display = 'block';
}

function hideDiv(div){
	div = document.getElementById(div);
	div.style.display = 'none';
}

$(document).ready(function(){
	$("#gsoc_poll").submit(function(){
		var poll_id = $("#poll_id").val();
		var answer  = $("input[@name='answer']:checked").val();

		if(answer === undefined){
			alert('Please select an option for the poll.');
			return false;
		} else {
			//alert('Thank you for selecting option #' + answer);

			$.get("/includes/ajax.poll.php", {answer: answer, poll_id: poll_id}, function(data){
				//alert(data.toString());
				$("#poll").html(data);
			});

			return false;
		}
	});

 $("#season-menu").change(function() {
  location.href = '?season=' + $("#season-menu option:selected").val();
 });
});