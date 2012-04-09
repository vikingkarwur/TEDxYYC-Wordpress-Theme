/* 

Author: FLIPP Advertising Inc. 

*/

//var showFlag = 'false';

$(document).ready(function() {

	/*$(window).resize(function(){
		if ($(window).width() < 1024){
			showFlag = 'false';
		} else {
			showFlag = 'true';
		}
	});*/

	$('a.logo_sm').fadeTo(0,0);
	
	//$('.mainHeader').html(showFlag);

	$('div#main').waypoint(function(event, direction) {
		if (direction === 'down') {
			$('a.logo_sm').fadeTo(400,1);
			$('a.flagNav').animate({'margin-left':'0px'},400);
		} else {
			$('a.logo_sm').fadeTo(200,0);
			$('a.flagNav').animate({'margin-left':'-195px'},400);
		}
	});

});