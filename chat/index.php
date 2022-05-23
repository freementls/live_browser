<?php

//$recipients = array('Charlie', 'Baba', 'RainbowFairy', 'Finnsda', 'shawncase', 'Freement'); // hard-coded
$handle = opendir('.');
while(($entry = readdir($handle)) !== false) {
    if($entry === '.' || $entry === '..') {
        // ignore it
    } elseif(is_dir($entry)) {
        // ignore it
    } else {
        $file_extension = file_extension($entry);
        //if($file_extension === '.xml') {
        if($file_extension === 'xml') {
            // assume it's a chat log
            $recipients[] = substr($entry, 0, strpos_last($entry, $file_extension));
        }
    }
}
closedir($handle);

function file_extension($string) {
	return pathinfo($string)['extension'];
    print('what about basename constant, there may be an extension constant');exit(0);
    if(strpos($string, '://') !== false && substr_count($string, '/') < 3 /* (=2) */) { // it's a naked domain so don't grab .com or .org or whatever as the extension
		return false;
	}
	// anchor # always comes after query string ?
	//$last_hash_position = life::strpos_last($string, '#'); // would like to use life's function... which would mean chat would become an action in the contructor
    $last_hash_position = strpos_last($string, '#');
	if($last_hash_position !== false) {
		$string = substr($string, 0, $last_hash_position);
	}
	$string = str_replace('\\', '/', $string);
	$last_slash_position = strpos_last($string, '/');
	$last_question_position = strpos_last($string, '?');
	if($last_question_position === false) {
		$last_question_position = strpos_last($string, '9o9quest9o9');
	}
	if($last_question_position == false) {
		$last_dot_position = strpos_last($string, '.');
	} else {
		$last_dot_position = strpos_last(substr($string, 0, $last_question_position), '.');
	}
	if($last_dot_position === false || $last_dot_position < $last_slash_position/* || $last_dot_position < strpos_last($string, '\\')*/) {
		//if($last_question_position === false) {
			return false;
		/*} else {
			return '.' . substr($string, $last_slash_position + 1, $last_question_position - $last_slash_position - 1);
		}*/
	} elseif($last_question_position === false) {
		if($last_dot_position === false) {
			return false;
		} else {
			return substr($string, $last_dot_position);
		}
	} elseif($last_question_position < $last_dot_position) { // this is pretty wacky
		$last_dot_between_slash_and_question_position = strpos_last(substr($string, 0, $last_question_position), '.', $last_slash_position);
		if($last_question_position < $last_dot_between_slash_and_question_position) {
			print('$string, $last_question_position, $last_dot_position: ');var_dump($string, $last_question_position, $last_dot_position);
			fatal_error('not sure how to calculate file_extension from these');
			return false;
		} else {
			return substr($string, $last_dot_between_slash_and_question_position, $last_question_position - $last_dot_between_slash_and_question_position);
		}
	} else {
		return substr($string, $last_dot_position, $last_question_position - $last_dot_position);
	}
	return false; // should never get here if there are enough conditions above to handle everything
}

public function strpos_last($haystack, $needle, $offset = 0) {
	//print('$haystack, $needle: ');var_dump($haystack, $needle);
    return strrpos($haystack, $needle, -1 * $offset);
	if(strlen($needle) === 0) {
		return false;
	}
	$len_haystack = strlen($haystack);
	$len_needle = strlen($needle);
	$pos = strpos(strrev($haystack), strrev($needle), $offset);
	if($pos === false) {
		return false;
	}
	return $len_haystack - $pos - $len_needle;
}

$source = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//print('$source, $recipients: ');var_dump($source, $recipients);
//$destination = 'wewakelife.great-site.net/live_browser/chat/new_message.php'; // hard-coded

?>
<html>
<head>
<title>live_browser chat</title>
<script src="jquery-3.6.0.min.js"></script>
<script src="twemoji.min.js"></script>
<script src="DisMojiPicker.js"></script>
<link rel="stylesheet" href="emojis.css" />
<script src="correctingInterval.js"></script>
<script>
$(document).ready(function(){

refreshing = false;
updating = false;

/*$("#emojis").disMojiPicker();
twemoji.parse(document.body);
$("#emojis").picker(
    emoji => console.log(emoji)
);*/

$("#emojis").disMojiPicker()
//$("#emojis").picker(emoji => console.log(emoji));
$("#emojis").picker(emoji => $('#message').append(emoji));
twemoji.parse(document.body);
$('#toggle_picker').click(function() {
    alert('toggle_picker clicked; display attribute is: ' + $("#emojis").css('display'));
    if($("#emojis").css('display') === 'block') {
        $("#emojis").css('display', 'none');
    } else {
        $("#emojis").css('display', 'block');


    }
});

$counter = 0; // is used for sound, and...?
function new_chat_recieved() {
    chat_integer = Math.floor(Math.random() * 3) + 1;
    new_audio(1, 'chat-' + chat_integer + '.ogg');
}

function new_audio(volume, source = false) {
    if(source == false) {
        sound = 'expand.wav';
    }
    //id = id + $counter;
    setTimeout(function(){
        $('<audio id="sound' + ($counter + 1) + '" class="sound-player" autoplay="autoplay" style="display:none;">'
        + '<source src="' + source + '" />'
        + '<embed src="' + source + '" hidden="true" autostart="true" loop="false"/>'
        + '</audio>'
        ).appendTo('body');
        //$('audio').volume = 1/10;
        document.getElementById('sound' + ($counter + 1)).volume = volume;
    });
    $counter++;
    // could use class sound-player to play the sound again, for instance. e.g.:
//     stopSound: function () {
//             $(".sound-player").remove();
//         }
}

debug_counter = 0;
refresh_interval = 100; // in milliseconds; every 0.1 seconds; should be interactive enough for chat while not overstraining server resources
//var intervalID = window.setInterval(live, 10000); // every 10 seconds
activity_factor = 0;
//last_action_time = 9652210734000; // random number; something like the year 2411, in milliseconds whoops! past 2039?!?
//alert('initial refresh_interval, activity_factor, last_action_time, millitime(): ' + refresh_interval + ', ' + activity_factor + ', ' + last_action_time + ', ' + millitime());
last_action_time = millitime();
//alert('initial refresh_interval, activity_factor, last_action_time, millitime(): ' + refresh_interval + ', ' + activity_factor + ', ' + last_action_time + ', ' + millitime());
//var livingID = window.setInterval(test1(), refresh_interval); // don't use brackets because reasons
//var livingID = window.setInterval(live, refresh_interval);
//var livingID = setInterval(live, refresh_interval);
//var interval = interval(live, get_refresh_interval(), 86400);
var livingID = setCorrectingInterval(live, get_refresh_interval());

$('#message').bind("enterKey",function(e){
    //alert("Enter");
    send_message(true);
});
$('#message').keyup(function(e){
    if(e.keyCode == 13) {
        $(this).trigger("enterKey");
    }
});
$('#send_message').click(function() {
    send_message();
});

/*$('#other_recipient').bind("otherenterKey",function(e){
    //alert("Enter");
    set_recipient();
});
$('#other_recipient').keyup(function(e){
    if(e.keyCode == 13) {
        $(this).trigger("otherenterKey");
    }
});
$('#set_other_recipient').click(function() {
    set_recipient();
});*/

$('#local_recipients').click(function() {
    update_all_local_recipients_activity();
}

$('#local_recipients').change(function() {
    $('#message_box').empty();
    $('#other_recipient').val('');
    refresh();
});
$('#other_recipient').keyup(function() {
    $('#message_box').empty();
    set_recipient($(this).val());
    refresh();
});

function get_refresh_interval() {
    return refresh_interval * Math.pow(2, activity_factor);
}

function test1() {
   console.log(test1);
}

function live() {
    //debug_counter++;
    //if(debug_counter > 200) {
    //    return;
    //}
    //alert('last_action_time in live(): ' + last_action_time);
    elapsed_time = millitime() - last_action_time;
    //elapsed_interval = millitime() - last_action_time; // why does javascript need this syntactically..?
    //alert('last_action_time, millitime(), get_refresh_interval(), elapsed_time, 10 * get_refresh_interval(), elapsed_time > 10 * get_refresh_interval(): ' + last_action_time + ', ' + millitime() + ', ' + get_refresh_interval() + ', ' + elapsed_time + ', ' + 10 * get_refresh_interval() + ', ' + (elapsed_time > 10 * get_refresh_interval()));
    if(activity_factor > 9) {
        console.log('greatest activity factor (standby mode)');
        //var timeoutID = window.setTimeout(refresh(), get_refresh_interval());
    } else if(elapsed_time > 10 * get_refresh_interval()) { // then ratchet it up
    //} else if(last_action_time - millitime() > 0.01 * get_refresh_interval()) { // then ratchet it up (since it's in milliseconds; multiplying by 0.01 = dividing by 1000 then multiplying by 10)
        //last_action_time = millitime();
        activity_factor++;
        console.log('increased activity factor by one to: ' + activity_factor);
        //alert('activity_factor, get_refresh_interval(): ' + activity_factor + ', ' + get_refresh_interval());
        relive();
    }// else {
    //    console.log('living');
    //    clearInterval(livingID);
    //    var livingID = window.setTimeout(live(), get_refresh_interval());
    //    //sleep(get_refresh_interval());
    //    //live2();
    //    refresh();
    //}

    console.log('living');
    update();
}

function update_local_recipients_activity() { // alias
    return update_all_local_recipients_activity();
}

function update_all_local_recipients_activity() {
    $('#local_recipients option').each(function(){
        update_local_recipient_activity($(this).val());
    });
}

function update_local_recipient_activity(local_recipient) {
    $.ajax({
        type: 'GET',
        url: 'last_active.php',
        data: { to: local_recipient },
        success: function(data) {
            //alert('data from last_active.php: ' + data);
            $('#local_recipients option[val="' + local_recipient + '"]').html(local_recipient + ' (last active ' + data + '<abbr title="seconds">s</abbr> ago)');
        }
    });
}

function relive() {
    //alert('livingID before clear: ' + livingID);
    //alert('interval before clear: ' + interval);
    //clearInterval(livingID);
    //interval.clear();
    // Later in your script...
    //clearCorrectingInterval(livingID);
    clear_all_intervals(); // shouldn't be necessary if we had a handle on the IDs but works...!
    //alert('livingID after clear: ' + livingID);
    //alert('interval after clear: ' + interval);
    //var livingID = window.setInterval(live, get_refresh_interval()); // can comment out for debug after first activity factor
    //var livingID = setInterval(live, get_refresh_interval()); // can comment out for debug after first activity factor
    var livingID = setCorrectingInterval(live, get_refresh_interval());
    //var interval = interval(live, get_refresh_interval(), 86400);
    //alert('livingID after reset: ' + livingID);
    //alert('interval after reset: ' + interval);
}

function clear_all_intervals() {
    // pretty hacky
    // notice it may not work if we send more than 100 messages in a session! the proper solution would be to keep track of the interval IDs such as in an array
    counter = 0;
    while(counter < 100) {
        clearCorrectingInterval(counter);
        counter++;
    }
}

function interval(func, wait, times){
    var interv = function(w, t){
        return function(){
            if(typeof t === "undefined" || t-- > 0){
                setTimeout(interv, w);
                try{
                    func.call(null);
                }
                catch(e){
                    t = 0;
                    throw e.toString();
                }
            }
        };
    }(wait, times);

    setTimeout(interv, wait);
    return { clear: function() { t = 0 } };
};

/*
interval(function(){
    // Code block goes here
}, 1000, 10);
*/

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

//function refresh(force = false) {
function refresh() {
    if(refreshing) {
        return false;
    }
    refreshing = true;
    // refresh the chat
    //local_recipients other_recipient
    to = get_recipient();
    //if(force) {
    //    $('#message_box').empty();
    //}
    //message_box_html = $('#message_box').html();
    //if(message_box_html.trim() === '') {
    //    time = 0; // so that all the messages are gotten
    //} else {
    //    time = last_action_time;
    //}
    $.ajax({
        type: 'GET',
        url: 'refresh.php',
        //data: {person_id:getUserID},
        data: { to: to },
        headers: {
            //             Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
            //             "Header Name Two": 'Header Value Two'  //for object property name, use quoted notation shown in second
            //    'Accept': 'blah',
            //    'Sec-Fetch-Site': 'cross-origin',
            //    'Sec-Fetch-Mode': 'no-cors',
        },
        success: function(data) {
            //alert('data from refresh.php: ' + data);
            // would like to only get new but that's more complicated
            //$("#processing").hide();
            //$("#person-data").html(data);
            // if there's a change (hack, instead of only returning changed content from the .xml)
            //alert('data, $(\'#message_box\').html(): ' + data + ', ' + $('#message_box').html());
            //alert('last_action_time, time: ' + last_action_time + ', ' + time);
            //if(data.length > 0) {
            //if(data.length > 0 && last_action_time == time) {
            if(data.length > 0) {
                //$('#message_box ').empty();
                $('#message_box').append(data);
                //alert('reset action by refresh!');
                last_action_time = millitime();
                activity_factor = 0;
                relive();
                //refresh();
            } // otherwise assume it was refreshed asynchronously already
        }
    });
    update_all_local_recipients_activity();
    refreshing = false;
}

function update() {
    if(updating) {
        return false;
    }
    updating = true;
    // update the chat
    //local_recipients other_recipient
    to = get_recipient();
    //if(force) {
    //    $('#message_box').empty();
    //}
    message_box_html = $('#message_box').html();
    if(message_box_html.trim() === '') {
        time = 0; // so that all the messages are gotten
    } else {
        time = last_action_time;
    }
    $.ajax({
        type: 'GET',
        url: 'update.php',
        //data: {person_id:getUserID},
        data: { to: to, time: time },
        headers: {
            //             Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
            //             "Header Name Two": 'Header Value Two'  //for object property name, use quoted notation shown in second
            //    'Accept': 'blah',
            //    'Sec-Fetch-Site': 'cross-origin',
            //    'Sec-Fetch-Mode': 'no-cors',
        },
        success: function(data) {
            //alert('data from update.php: ' + data);
            // would like to only get new but that's more complicated
            //$("#processing").hide();
            //$("#person-data").html(data);
            // if there's a change (hack, instead of only returning changed content from the .xml)
            //alert('data, $(\'#message_box\').html(): ' + data + ', ' + $('#message_box').html());
            //alert('last_action_time, time: ' + last_action_time + ', ' + time);
            //if(data.length > 0) {
            //if(data.length > 0 && last_action_time == time) {
            if(typeof data !== 'undefined' && data.length > 0 && (time == 0 || last_action_time == time)) {
                //$('#message_box ').empty();
                $('#message_box').append(data);
                //alert('reset action by update!');
                last_action_time = millitime();
                activity_factor = 0;
                new_chat_recieved();
                relive();
                //update();
            } // otherwise assume it was refreshed asynchronously already
        }
    });
    update_local_recipient_activity($('#local_recipients option:selected').val());
    updating = false;
}


function set_recipient(recipient) {
    //$("#local_recipients select").val('');
    $('#local_recipients option[value=""]').attr('selected','selected'); // first blank it
    //$('#local_recipients option').removeAttr('selected');
    $('#local_recipients option[value="' + recipient + '"]').attr('selected','selected'); // then set to an existing one (if possible)
    // would like to add recipient to the list...
}

function get_recipient() {
    local_recipient = $('#local_recipients option:selected').val();
    if(local_recipient.length > 0) {
        recipient = local_recipient;
    } else {
        other_recipient = $('#other_recipient').val();
        if(other_recipient.length > 0) {
            recipient = other_recipient;
        } else {
            recipient = '';
        }
    }
    return recipient;
}

//     $.post('testajax.php', { }, function( data ) {
//         alert('data from testajax.php: ' + data);
//     }); // works

//     $.ajax({
//         type: 'GET',
//         url: 'testajax.php',
//         data: { },
//         success: function(data) {
//             alert('data from testajax.php: ' + data);
//         }
//     }); // works



function send_message(enter_sent = false) {
    //alert('send message');
    // local
    source = '<?php print($source) ?>';
    from = $('#user').val();
    to = get_recipient();
    divider_string = '?to=';
    question_position = to.indexOf(divider_string);
    //alert('divider_string, question_position: ' + divider_string + ', ' + question_position);return;
    if(question_position != -1) {
        //alert('cross site message!');
        temp_to = to;
        url = temp_to.substr(0, question_position);
        to = temp_to.substr(question_position + divider_string.length, temp_to.length - question_position - divider_string.length);
    } else {
        url = 'new_message.php';
    }
    time = millitime() / 1000;
    message = $('#message').val();
    //message = message.trim(); // sending the message with enter also adds newline to the end of the message
    if(enter_sent) {
        message = message.substr(0, message.length - 1);
    }
    // don't do .val without brackets! breaks things; could be exploited
    //alert('url, source, from, to, time, message: ' + url + ', ' + source + ', ' + from + ', ' + to + ', ' + time + ', ' + message);
//     $.post('new_message.php', { source: source, from: from, time: time, message: message }, function( data ) {
//         alert('data from new_message.php: ' + data);
//         $('#message_box').append(data);
//     });
    $.ajax({
        type: 'GET',
        url: url,
        //data: {person_id:getUserID},
        data: { source: source, from: from, to: to, time: time, message: message },
        headers: {
//             Header_Name_One: 'Header Value One',   //If your header name has spaces or any other char not appropriate
//             "Header Name Two": 'Header Value Two'  //for object property name, use quoted notation shown in second
        //    'Accept': 'blah',
        //    'Sec-Fetch-Site': 'cross-origin',
        //    'Sec-Fetch-Mode': 'no-cors',
        },
        success: function(data) {
            //alert(data);
            //alert('data from new_message.php: ' + data);
            //$("#processing").hide();
            //$("#person-data").html(data);
            $('#message_box').append(data);
            scroll_message_box();
            //setTimeout(scroll_message_box(), refresh_interval * 20);
            //alert('reset action by send_message!');
            last_action_time = millitime();
            activity_factor = 0;
            relive();
            //refresh();
        }
    });
    $('#message').val(''); // empty the message box
    // remote

    // scroll the message box to the bottom
    //setTimeout(scroll_message_box(), refresh_interval / 2);
    //$('#message_box').scrollIntoView();
    //$('#message_box').scrollTop(this.offsetHeight);
}

function millitime() {
    //return millitime();
    d = new Date();
    return d.getTime();
    time = d.getTime();
    return time;
}

function scroll_message_box() {
    var message_box = document.getElementById('message_box');
    message_box.scrollTop = message_box.scrollHeight; // no idea why this mostly does not work (on time?)
}

});
</script>

<style>
#chat { height: 100%; border: 1px solid red; }
#participants { width: 100%; position: fixed; height: 10%; min-height: 200px; }
#message_box { width: 99%; position: relative; top: 10%; height: 79%; border: 1px solid black; /*overflow: scroll;*/ overflow-y: scroll; overflow-x: hidden; }
#input { width: 100%; position: fixed; top: 90%; height: 10%; vertical-align: top; }
#send_message { height: 90%; margin-top: -80px; /* why  */ }
button {  }
</style>
</head>
<body>
<div id="emojis"></div><button id="toggle_picker">toggle picker</button>
<div id="chat">
<div id="participants">
<label for="user"><img src="merkaba_small.jpg" alt="Merkaba" /> Me: </label><input type="text" id="user" name="user" /><br />
<label for="local_recipients"><img src="fractal_destination_small.jpg" alt="Fractal Destination" /> To: </label>
<select id="local_recipients" name="local_recipients">
<?php

/*print('<option value="" title="title on an option (for )"> (open)</option>
');*/
foreach($recipients as $recipient) {
    // could do all the fancy stuff like blocking access, keeping track of friends, avoiding spoofing
    /*print('<option value="' . $destination . '?to=' . $recipient . '">' . $recipient . ' (last activity an unknown time ago)</option>
');*/
    // local for now
    print('<option value="' . $recipient . '" title="title on an option (for ' . $recipient . ')">' . $recipient . ' (last activity an unknown time ago)</option>
');
    // live, last activity
}

// expand new chat column (+)
// update title tab when new message (1) blinking
// enter to send message
// delete own messages?
// online indicator... ? make it more interesting than green circle
// load previous messages
// green + ✳️ morph to red X ❌
// 3D message box(es)
// remove all hard-coded
// darg and drop content into chat (emojis, images, videos?)
// only refresh since last check (use <time>)
// autoscroll excludes last line; not sure why
// autofocus to chat (which allows everybody to chat to everyone and see all messages by default; not really scalable (to the universe!))
// sound effects
// emojis and twitch emotes... ;p better twitch tv
// http return codes
/*function uniform_resource_exists($url) {
   $headers = get_headers($url);
   return stripos($headers[0], '200 OK')?true:false;
}*/

// get chat to show on chat2, reduce resources used
// message if "connection" is not made; if user meh
?>
</select>
or <label for="other_recipient">other: </label><input type="text" id="other_recipient" name="other_recipient" size="60" placeholder="www.google.com/live_browser/chat/new_message.php?to=myfriend123" /><!--button id="set_other_recipient" name="set_other_recipient">Set</button-->
</div>
<div id="message_box">

</div>
<div id="input">
<textarea id="message" name="message" cols="40" rows="3"></textarea><button id="send_message" name="send_message">Send</button>
</div>
</div>
</body>
</html>
