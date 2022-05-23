
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
  
//});

//$(document).ready(function(){
// keyboard capture
id_counter = 0;
fraction = '';
last_key_timestamp = -1;
//saves = {}; // object, not array as would be defined using []
//maximum_input_delay = 1000; // milliseconds
// how long does it take the average person to type a command?
//maximum_intervening_input_delay = 500; // milliseconds
maximum_intervening_input_delay = 1000; // milliseconds
maximum_input_delay = 2000; // milliseconds // not used.
minimum_input_spacing = 2000; // milliseconds
accept_new_input = true;

local = 'accoladens.com';
local_icon = 'accolade-logo-400x400.png';

// we should adaptively change this value according to the user (typing or pecking speeds vary)
//console.log('here001');
document.addEventListener('keypress', function(e) {
	fraction = fraction + e['key'];
	
		last_key_timestamp = e['timeStamp'];
		timeoutID = setTimeout(function(){
		//if(load('last_key_timestamp') == last_key_timestamp) { // if another key has not been pressed
		if(last_key_timestamp == e['timeStamp']) { // if another key has not been pressed
			if(fraction.length > 0) {
				command();
			}
		}
		}, maximum_intervening_input_delay);
	
}, false);

function save(variable, value) {
	saves[variable] = value;
	return true;
}
function load(variable) {
	return saves[variable];
}
function command() {
	id_counter++;
	$('#fraction').append('<u><span id="drop' + id_counter + '">' + fraction + '</span></u> ');
	text_drop(id_counter);
    fraction = '';
	//live(node, groweth);
	live('', fraction, local, local_icon, false); // we don't know which node is best and want to find out!
	
}

async function live(node, groweth, local, local_icon, add_thickness) {
$.ajax({
    type: 'POST',
    url: 'live.php',
    //data: input
	data: {'node': node, 'groweth': groweth, 'local': local, 'local_icon': local_icon, 'add_thickness': add_thickness}
}).then(
    // resolve/success callback
    async function(response) {
		//alert('response (from live.php): ' + response);
		//response = eval('(' + response + ')'); // parse the JSON
		//response = JSON.parse(response); // parse the JSON
		//response = $.parseJSON(response);
		//response = JQuery.parseJSON(response);
		// $actions, $friends, $downloads, $games
		
		//$.getJSON('http://localhost:8888/myfile.php', function(data) {
		//	console.log(data);
		//});
		//console.log(response);
		//alert('key1, key2, skey2, key3: ' + response.key1 + ', ' + response.key2 + ', ' + response.key2.skey2 + ', ' + response.key3);
		// just hack it instead of dealing with JSON nonsense
		if(response.substr(0, 6) != 'XXX9o9') {
			throw new Error('unexpected response response (from live.php) ');
		}
		
		//actions = response[0];
		// 'newlink' => array($best_URL, $title, $icon)
		//alert('actions: ' + actions);
		//console.log(actions);
	//	friends = response[1];
	//	downloads = response[2];
	//	games = response[3];
		//actions.foreach()
		// dropping a button will go here (if the score is high enough?)
		//actions = response.toString(); // not sure why it needs to be cast as a string
		//actions = response + ''; // not sure why it needs to be cast as a string
		// not sure why need to cast to string
		//alert('actions, response: ' + actions + ', ' + response);
		//if(actions.newlink == false) { // newlink is the only action as of now
		actions = response;
		if(actions == 'XXX9o9XXXXXXXXX9o9XXX') { // newlink is the only action as of now
	//		//https://yandex.com/search/?text=something
	//		soundy('button', 400, '<img src="qm.jpg" width="100" height="100" />', 'https://yandex.com/search/?text=something' + groweth, newlink_parameters[1], 1, 'expand.wav');
		} else {
			//newlink_parameters = actions.newlink;
			//alert('newlink_parameters: ' + newlink_parameters);
			//$best_URL = newlink_parameters[0];
			//$title = newlink_parameters[1];
			//$icon = newlink_parameters[2];
			
			actions = actions.substr(6);
			best_URL = actions.substr(0, actions.indexOf('XXX'));
			actions = actions.substr(actions.indexOf('XXX') + 3);
			title = actions.substr(0, actions.indexOf('XXX'));
			actions = actions.substr(actions.indexOf('XXX') + 3);
			icon = actions.substr(0, actions.indexOf('XXX9o9'));
			//throw new Error('debugging JSON decode');
			//alert('best_URL, title, icon: ' + best_URL + ', ' + title + ', ' + icon);
			//alert('$best_URL, $title, $icon: ' + $best_URL, $title, $icon);
			if(best_URL.indexOf(local) == false) {
				soundy('button', 400, '<img src="' + icon + '" width="100" height="100" />', best_URL, title, 1, 'expand.wav');
			} else {
				soundy('button', 400, '<img src="' + icon + '" width="100" height="100" />', best_URL, title, 0.5, 'bell.wav');
			}
		}
		
    },
    // reject/failure callback
    function() {
		alert('There was some error in live!');
    }
);
}

function text_drop(id){
    
	for(var j = 0; j < 10; ++j) {

		$('#drop' + id).animate({'top':(50 * j) +'px'},10); // 1 is like time taken in milliseconds
		$('#drop' + id).animate({'font-size':(520-(50 * j))+'px'},10);

	}

}
// selection capture
function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}

maximum_intervening_selection_input_delay = 1000; // milliseconds
//document.onmouseup = document.onkeyup = document.onselectionchange = function() {
last_selection_timestamp = -1;
document.onselectionchange = function() {
  //document.getElementById("sel").value = getSelectionText();
  // not sure whether to use the same input delay for selection and for typed strings...
  // for now just hard-code them separately but the same, as the need to adapt them separately is ideal.
selection_text = getSelectionText();
if(selection_text.length > 0) {
if(accept_new_input) {
	//last_selection_timestamp = Date();
	// no idea why this timestamp stuff is not working, but this will work for tapping at least
	//timeoutID = setTimeout(function(){
	//alert('Date.now(), last_selection_timestamp, maximum_intervening_selection_input_delay: ' + Date.now() + ', ' + last_selection_timestamp + ', ' + maximum_intervening_selection_input_delay);
	//}, maximum_intervening_selection_input_delay);
	//if(Date.now() - last_selection_timestamp > maximum_intervening_selection_input_delay) { // if another selection has not been made
		selection_command(selection_text);
		accept_new_input = false;
		setTimeout(function(){
			// wait the minimum amount between inputs
			accept_new_input = true;
		}, minimum_input_spacing);
	//	last_selection_timestamp = Date.now();
	//}
}
}
};

function selection_command(selection_text) {
	id_counter++;
	//selection_text = getSelectionText();
	$('#fraction').append('<u><span id="drop' + id_counter + '">' + selection_text + '</span></u> ');
	text_drop(id_counter);
	live('', selection_text, local, local_icon, false); // we don't know which node is best and want to find out!
	
}


