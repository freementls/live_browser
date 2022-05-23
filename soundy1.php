<?php

// right thumb falling buttons with sound effects and nice thumb sized icons
// selection and typing input capture
// search with locked growth on the site (therefore preferring it) but also using search engines to look outside with favicons
// opening glowing circle introducing the user to the aspect that it's a living page that adapts to your actions
// the suggestions or recommendations are relevant to content interacted with
// make this all work as an include and server (php) page that can still do stuff like ajax

// x bounce deform?
// x since there's no text box to receive the keystrokes, have a fancy huge letter going small very quickly to show that typing is being reveived setup
// x bottom <del>attribute</del><ins>data</ins> instead of css to allow multiple buttons droppping at once
// x if local link don't target blank
// handle backspace on keyboard input eventually. probably don't want to go the route of creating a whole new word processor

?>
<html>
<head>
<title>soundy</title>
<style>
#thumb_buttons_column { 
position: absolute; 
top: 0; 
right: 0; 
z-index: 10; 
height: 99%; 
width: 100px; 
border: 1px solid red;
overflow: visible; 
}

.button {
position: absolute;
right: 0; 
height: 100px; 
width: 100px; 
/*background-color: yellow; */
opacity: 1;
overflow: visible;
}

.toggle {
position: absolute;
right: 100px; 
height: 100px; 
width: 100px;
/*opacity: 1;*/
/*overflow: visible;*/
max-width: 0;
overflow: hidden;
transition: all .5s;
/*background-color: blue;*/
width: 200px;
text-align: right;
vertical-align: middle;
line-height: 50px;
border: none;
}

.showntoggle{
max-width: 200px;
vertical-align: middle;
line-height: 50px;
border: 1px solid black;
border-radius: 5px;
}
a.button_link { text-decoration: none; color: black; }

</style>
<script src="jquery-3.5.0.js"></script>
<script>
$(document).ready(function(){
  local_domain = 'accoladens.com'
  $('#button1').click(function(){
	//alert('button1 clicked');
    //var box = $('<div style="color: orange; position: absolute; top: -100px; right: 100px; height: 100px; width: 100px;">1</div>');
	$('#thumb_buttons_column').append('<div id="simple_drop" style="background-color: orange; position: absolute; bottom: 500px; right: 0; height: 100px; width: 100px; border: 1px solid black; z-index: 11; opacity: 1;">1</div>');
	//$('#simple_drop').addClass('fade in');
	//var div = $("div");
    //box.animate({height: '300px', opacity: '0.4'}, 'slow');
    //div.animate({width: '300px', opacity: '0.8'}, 'slow');
    //div.animate({height: '100px', opacity: '0.4'}, 'slow');
    //div.animate({width: '100px', opacity: '0.8'}, 'slow');
	$('#simple_drop').animate({bottom: 'toggle'}, 2000).delay(800).fadeIn().fadeTo('slow', 0.33);
    //$('#simple_drop').animate({opacity: '0'}, 2000);
	//$('#simple_drop').fadeTo('slow', 0.33);
	//$('#simple_drop').css('slow', 0.33);
	//$('#simple_drop').removeClass('fade in');
	//$('#simple_drop').addClass('fade out');
  });
  $('#button2').click(function(){
	//var box1 = $('<div id="div1" style="width:90px;height:90px;display:none;background-color:black;"></div><br>');
	//var box2 = $('<div id="div2" style="width:90px;height:90px;display:none;background-color:green;"></div><br>');
	//var box3 = $('<div id="div3" style="width:90px;height:90px;display:none;background-color:blue;"></div><br>');
	//var box4 = $('<div id="div4" style="width:90px;height:90px;display:none;background-color:red;"></div><br>');
	//var box5 = $('<div id="div5" style="width:90px;height:90px;display:none;background-color:purple;"></div><br>');
	$('#thumb_buttons_column').append('<div id="div1" style="width:90px;height:90px;display:none;background-color:black;"></div><br>');
	$('#thumb_buttons_column').append('<div id="div2" style="width:90px;height:90px;display:none;background-color:green;"></div><br>');
	$('#thumb_buttons_column').append('<div id="div3" style="width:90px;height:90px;display:none;background-color:blue;"></div><br>');
	$('#thumb_buttons_column').append('<div id="div4" style="width:90px;height:90px;display:none;background-color:red;"></div><br>');
	$('#thumb_buttons_column').append('<div id="div5" style="width:90px;height:90px;display:none;background-color:purple;"></div><br>');
	$('#div1').delay('slow').fadeIn();
    $('#div2').delay('fast').fadeIn();
    $('#div3').animate({bottom: 'toggle'}, 2000).delay(800).fadeTo('slow', 0.33);
	//$('#div3').delay(800).animate({opacity: '0'}, 2000);
    $('#div4').delay(2000).fadeIn().delay(4000).remove();
    $('#div5').delay(4000).fadeIn().delay(8000).remove();

  });
   
  $counter = 0;
  // White_square_with_question_mark.jpg
  // accolade-logo-400x400.png
  $('#button5').click(function(){
  soundy('divx', 400, 'bounce contents');
  });
  $('#acc').click(function(){
  soundy('acc', 400, '<img src="accolade-logo-400x400.png" width="100" height="100" />', 'https://accoladens.com', 'text from accoladens.com title tag', 0.5, 'bell.wav');
  });
  $('#other').click(function(){
  soundy('other', 400, '<img src="qm.jpg" width="100" height="100" />', 'https://www.google.jp', 'other link', 1, 'expand.wav');
  });
function get_column_bottom() {
	//button = null;
	a_button_exists = false;
	$('.button').each(function() {
	  //return $(this).attr('bottom');
	  button = $(this);
	  a_button_exists = true;
	  //break;
	});
	if(a_button_exists === false) {
		return 0;
	} else {
		//return button.attr('bottom') + 100 + 'px';
	//	bottom_string = button.attr('bottom');
	//	pixels = bottom_string.substr(0, bottom_string.indexOf('px'));
		//return (100 + pixels) + 'px';
	//	return Number(100) + Number(pixels);
		return Number(100) + bottom_pixels(button);
		// assumes they are always in order and 100px high
	}
}

function bottom_pixels(element) {
	return element.data('bottom');
	/*bottom_string = element.data('bottom');
	alert('bottom_string: ' + bottom_string);
	pixels = bottom_string.substr(0, bottom_string.indexOf('px'));
	return Number(pixels);*/
}

function soundy(id, time, contents, link, code, volume, sound = false) {
if(sound == false) {
	sound = 'expand.wav';
}
id = id + $counter;
column_bottom = get_column_bottom();
//alert('column_bottom: ' + column_bottom);
bottom = Number(column_bottom) + Number(900);
bottom_data = Number(column_bottom);
target_blank_or_nothing = '';
if(link.indexOf(local_domain) != false) {
	target_blank_or_nothing = ' target="_blank"';
}
$('#thumb_buttons_column').append('<a href="' + link + '"' + target_blank_or_nothing + ' class="button_link"><div id="' + id + 'toggle" class="toggle" style="/*display: none;*/ bottom: ' + bottom + 'px; z-index: ' + (11 + $counter) + ';"><div>' + code + '</div></div><div id="' + id + '" class="button" style="bottom: ' + bottom + 'px; z-index: ' + (11 + $counter) + ';">' + contents + '</div></a>');
  $('#' + id).data('bottom', bottom_data);
  $('#' + id).animate({bottom: '-=900px'}, 2 * time);
  $('#' + id + 'toggle').animate({bottom: '-=900px'}, 2 * time);
  setTimeout(function(){
  $('<audio id="sound' + ($counter + 1) + '" class="sound-player" autoplay="autoplay" style="display:none;">'
		 + '<source src="' + sound + '" />'
		 + '<embed src="' + sound + '" hidden="true" autostart="true" loop="false"/>'
	   + '</audio>'
	 ).appendTo('body');
  //$('audio').volume = 1/10;
  document.getElementById('sound' + ($counter + 1)).volume = volume;
  }, 2 * time);
  $('#' + id).animate({width: '+=10px'}, 0.01 * time);
  $('#' + id).animate({height: '-=10px'}, 0.01 * time);
  $('#' + id).animate({width: '-=10px'}, 0.01 * time);
  $('#' + id).animate({height: '+=10px'}, 0.01 * time);
  $('#' + id).animate({bottom: '+=300px'}, 2 * time);
  //$('#' + id + 'toggle').animate({bottom: '+=300px'}, 2 * time);
  $('#' + id).animate({bottom: '-=300px'}, 2 * time);
  //$('#' + id + 'toggle').animate({bottom: '-=300px'}, 2 * time);
  setTimeout(function(){
  $('<audio id="sound' + ($counter + 2) + '" class="sound-player" autoplay="autoplay" style="display:none;">'
		 + '<source src="' + sound + '" />'
		 + '<embed src="' + sound + '" hidden="true" autostart="true" loop="false"/>'
	   + '</audio>'
	 ).appendTo('body');
  //$('audio').volume = 1/10;
  document.getElementById('sound' + ($counter + 2)).volume = 1/3 * volume;
  }, 6 * time);
  $('#' + id).animate({width: '+=5px'}, 0.005 * time);
  $('#' + id).animate({height: '-=5px'}, 0.005 * time);
  $('#' + id).animate({width: '-=5px'}, 0.005 * time);
  $('#' + id).animate({height: '+=5px'}, 0.005 * time);
  $('#' + id).animate({bottom: '+=100px'}, 2 * time);
  //$('#' + id + 'toggle').animate({bottom: '+=100px'}, 2 * time);
  $('#' + id).animate({bottom: '-=100px'}, 2 * time);
  //$('#' + id + 'toggle').animate({bottom: '-=100px'}, 2 * time);
  setTimeout(function(){
  $('<audio id="sound' + ($counter + 3) + '" class="sound-player" autoplay="autoplay" style="display:none;">'
		 + '<source src="' + sound + '" />'
		 + '<embed src="' + sound + '" hidden="true" autostart="true" loop="false"/>'
	   + '</audio>'
	 ).appendTo('body');
  //$('audio').volume = 1/10;
  document.getElementById('sound' + ($counter + 3)).volume = 1/9 * volume;
  $counter++;
  $counter++;
  $counter++;
  }, 10 * time);
  $('#' + id).animate({width: '+=2px'}, 0.002 * time);
  $('#' + id).animate({height: '-=2px'}, 0.002 * time);
  $('#' + id).animate({width: '-=2px'}, 0.002 * time);
  $('#' + id).animate({height: '+=2px'}, 0.002 * time);
  $('#' + id).delay(2 * time).animate({opacity: '-=0.67'}, 'slow');
  //$('#' + id).hover(function(){$('#' + id).css('opacity': 1)}, function(){$('#' + id).css('opacity': 0.2)});
  $('#' + id).hover(function(){ 
	$(this).css('opacity', 1);
	//$('#' + id + 'toggle').slideToggle();
	//$('#' + id + 'toggle').animate({width: 'toggle', display: 'inline'}, 'slow');
	$('#' + id + 'toggle').toggleClass('showntoggle');
  }, function(){ 
	$(this).css('opacity', 0.33);
	//$('#' + id + 'toggle').slideToggle();
	//$('#' + id + 'toggle').animate({width: 'toggle', display: 'inline'}, 'slow');
	$('#' + id + 'toggle').toggleClass('showntoggle');
  });
  $('#' + id).click(function(){ 
  //alert($(this).attr('id') + ' with bottom ' + $(this).data('bottom') + ' clicked.');
  specific_button_pop($(this));
  });
}
  
  $('#make').click(function(){
	//alert('make');
	$('#thumb_buttons_column').append('<div id="divx" style="background-color: green; position: absolute; bottom: 250px; right: 0; height: 100px; width: 100px; border: 10px solid red; z-index: 11; opacity: 1;">divx</div>');
  });
  $('#up').click(function(){
	//alert('up');
	$('#divx').animate({bottom: '+=100px'}, 'slow');
  });
  $('#down').click(function(){
	//alert('down');
	$('#divx').animate({bottom: '-=100px'}, 'slow');
  });
  $('#pfadeout').click(function(){
	//alert('pfadeout');
	$('#divx').animate({opacity: '-=0.3'}, 'slow');
  });
  $('#pfadein').click(function(){
	//alert('pfadein');
	$('#divx').animate({opacity: '+=0.3'}, 'slow');
  });
  $('#sound').click(function(){
	//alert('sound');
	$.playSound('bell.wav', 'testid');
  });
  $('#delete').click(function(){
	//alert('delete');
	$('#divx').remove();
  });
  $('#delete_last').click(function(){ // deletes last created button
	$('.button').each(function() {
	  button = $(this);
	});
	button.remove();
  });
  $('#button_pop').click(function(){ // effectively delete earliest created button
	button_pop();
  });
  function button_pop() {
	$('.button').each(function() {
		button = $(this).remove();
		//break;
		return true;
	});
  }
  function specific_button_pop(button) {
	//alert('id: ' + button.attr('id') + ' with bottom: ' + button.data('bottom'));
	$('.button').each(function() {
		//if(id == $(this).attr('id')) {
		//alert('id: ' + $(this).attr('id') + ' with bottom: ' + $(this).data('bottom'));
		//if(button == $(this)) {
		if(button.attr('id') == $(this).attr('id')) {
			//alert('matched button to pop');
			popped_bottom = bottom_pixels(button);
			button.remove();
			$('#' + $(this).attr('id') + 'toggle').remove();
			// slide higher buttons down
			$('.button').each(function() {
				if(bottom_pixels($(this)) > popped_bottom) {
					$(this).animate({bottom: '-=100px'}, 'slow');
					$(this).data('bottom', $(this).data('bottom') - 100);
					$('#' + $(this).attr('id') + 'toggle').animate({bottom: '-=100px'}, 'slow');
				}
			});
			//break;
			return true;
		}
	});
  }
  $('#slide_all').click(function(){
	//alert('delete');
	$('.button').animate({bottom: '-=100px'}, 'slow');
  });
  $('#audit').click(function(){
	string = '';
	$('.button').each(function() {
	  string = string + 'id: ' + $(this).attr('id') + ' bottom: ' + $(this).data('bottom') + "\r\n";
	});
	alert(string);
  });
  
});
</script>
</head>
<body>
<button id="button1">simple drop</button>
<button id="button2">multi</button>
<button id="button3">sequence3</button>
<button id="button4">sequence4</button>
<button id="button5">bounce</button><br />
<button id="make">make divx</button>
<button id="up">up 100px</button>
<button id="down">down 100px</button>
<button id="pfadeout">partial fade out</button>
<button id="pfadein">partial fade in</button>
<button id="sound">sound</button>
<button id="delete">delete divx</button><br />
<button id="acc">new accolade link</button>
<button id="other">new other link</button>
<button id="delete_last">delete last button</button>
<button id="button_pop">pop bottom button off</button>
<button id="slide_all">slide all</button>
<button id="audit">audit</button>
<div id="thumb_buttons_column"></div>
</body>
</html>