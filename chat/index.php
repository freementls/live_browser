<?php

include_once('../life.php');
$life = new life();
// if(!file_exists('chat.txt')) {
//     $put_result = file_put_contents('chat.txt', 'chat');
//     if(!$put_result) {
//         chmod('..', 0777);
//         $put_result = file_put_contents('chat.txt', 'chat');
//     }
//     if(!$put_result) {
//         $life->fatal_error('permissions problem; solve on the webserver manually');
//     }
// }
$source = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
$to = urlencode($_REQUEST['to']);
$to_local = false;
if($to == false) {
    $to_local = true;
} else {
    $fileless_source = $life->fileless($life->absolutize($life->scheme . '://' . $source));
    $fileless_to = $life->fileless($life->absolutize($to));
    //print('$fileless_source, $fileless_to: ');var_dump($fileless_source, $fileless_to);exit(0);
    if($fileless_source === $fileless_to) {
        $to_local = true;
    }
}
if($to_local && !file_exists($to . '.xml')) { // only write files locally!
    file_put_contents($to . '.xml', '');
}
$recipients = array();
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
            $recipients[] = substr($entry, 0, strpos_last($entry, $file_extension) - 1);
        }
    }
}
closedir($handle);
asort($recipients);
$random = rand(0, 9001);

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

function strpos_last($haystack, $needle, $offset = 0) {
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


//print('$source, $recipients: ');var_dump($source, $recipients);
$title = 'live_browser chat';

?>
<!-- <!DOCTYPE html> -->
<html>
<head>
<title><?php print($title); ?></title>
<script src="jquery-3.6.0.min.js"></script>
<!--script src="twemoji.min.js"></script-->
<script src="DisMojiPicker.js"></script>
<link rel="stylesheet" href="emojis.css" />
<script src="correctingInterval.js"></script>
<script>
$(document).ready(function(){

//refreshing = false;
//updating = false;
emojis_picker_open = false;
random = <?php print($random); ?>;
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
//var livingID = setCorrectingInterval(live, get_refresh_interval());
var intervals = [];
//intervals.push(setCorrectingInterval(live, get_refresh_interval()));
intervals.push(setCorrectingInterval(refresh, get_refresh_interval()));
//initial_time = millitime();
reset_user_activity();
to = '<?php print($to); ?>';
if(to != false) {
    set_recipient(to);
}

/*$("#emojis").disMojiPicker();
twemoji.parse(document.body);
$("#emojis").picker(
    emoji => console.log(emoji)
);*/

$("#emojis").disMojiPicker();
//$("#emojis").picker(emoji => console.log(emoji));
//$("#emojis").picker(console.log('uh test'));
$("#emojis").picker();
//$("#emojis").disMojiPicker(emoji => console.log(emoji));
//$("#emojis").picker(emoji => $('#message').append(emoji));
//$("#emojis").disMojiPicker(emoji => $('#message').append(emoji));
//twemoji.parse(document.body); // time consuming... what does it do?
// $('body').click(function() {
//     alert('clicked body; emojis_picker_open: ' + emojis_picker_open);
//     if(emojis_picker_open) {
//         close_emojis_picker();
//     }
// });
$('#toggle_picker').click(function() {
    //alert('toggle_picker clicked; display attribute is: ' + $("#emojis").css('display'));
    if(emojis_picker_open) {
        close_emojis_picker();
    } else {
        open_emojis_picker();
    }
});

function open_emojis_picker() {
    //alert('opening emojis picker');
    $("#emojis").css('display', 'block');
    //$("#toggle_picker").css('top', '-100px');
//    $("#toggle_picker").css('left', '-502px');
    emojis_picker_open = true;
}

function close_emojis_picker() {
    //alert('closing emojis picker');
    $("#emojis").css('display', 'none');
    //$("#toggle_picker").css('top', '-150px');
//    $("#toggle_picker").css('left', '-100px');
    emojis_picker_open = false;
}

$counter = 0; // is used for sound, and...?
function new_chat_recieved() {
    chat_integer = Math.floor(Math.random() * 3) + 1; // pick random keyboard sound effect
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

function reset_user_activity() {
    //alert('reset user activity');
    //last_user_activity = millitime();
    unseen_chats = 0;
}

$('html').keyup(function(e){
    reset_user_activity();
});

$('html').click(function(e){
    reset_user_activity();
});

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

// $('#other_recipient').bind("otherenterKey",function(e){
//     //alert("Enter");
//     set_recipient();
// });
// $('#other_recipient').keyup(function(e){
//     if(e.keyCode == 13) {
//         $(this).trigger("otherenterKey");
//     }
// });
// $('#set_other_recipient').click(function() {
//     set_recipient();
// });

$('#local_recipients').click(function() {
    update_all_local_recipients_activity();
});

$('#local_recipients').change(function() {
//$('#local_recipients').mouseup(function() {
    die();
    $('#chat_log').empty();
    $('#other_recipient').val('');
    refresh();
    //live();
    //update();
});
$('#other_recipient').keyup(function() {
    die();
    $('#chat_log').empty();
    set_recipient($(this).val());
    refresh();
    //live();
    //update();
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
//        console.log('greatest activity factor (standby mode)');
        //var timeoutID = window.setTimeout(refresh(), get_refresh_interval());
    } else if(elapsed_time > 10 * get_refresh_interval()) { // then ratchet it up
    //} else if(last_action_time - millitime() > 0.01 * get_refresh_interval()) { // then ratchet it up (since it's in milliseconds; multiplying by 0.01 = dividing by 1000 then multiplying by 10)
        //last_action_time = millitime();
        activity_factor++;
//        console.log('increased activity factor by one to: ' + activity_factor);
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

//    console.log('living');
    update();
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
    //var livingID = setCorrectingInterval(live, get_refresh_interval());
    intervals.push(setCorrectingInterval(live, get_refresh_interval()));
    //var interval = interval(live, get_refresh_interval(), 86400);
    //alert('livingID after reset: ' + livingID);
    //alert('interval after reset: ' + interval);
}

function die() {
    clear_all_intervals();
    last_action_time = millitime();
    activity_factor = 10;
}

function update_local_recipients_activity() { // alias
    return update_all_local_recipients_activity();
}

function update_all_local_recipients_activity() {
    $('#local_recipients option').each(function(){
        //alert('$(this).val() in update_all_local_recipients_activity(): ' + $(this).val());
        if($(this).val() == random) {
            // leave it
        } else {
            update_local_recipient_activity($(this).val());
        }
    });
}

function update_local_recipient_activity(local_recipient) {
    //alert('update_local_recipient_activity()');
    if(local_recipient == random) {
        return false;
    }
    $.ajax({
        type: 'GET',
        url: 'last_active.php',
        data: { to: local_recipient },
        success: function(data) {
            //last_active = Math.floor(data - last_action_time);
            //alert('data, last_active in update_local_recipient_activity(): ' + data + ', ' + last_active);
            //alert('data in update_local_recipient_activity(): ' + data);
            dec_local_recipient = $('#local_recipients option[value="' + local_recipient + '"]').attr('dec');
            updated_contents = dec_local_recipient + ' (last active ' + data + ' ago)';
            $('#local_recipients option[value="' + local_recipient + '"]').html(updated_contents);
            //$('option').html(updated_contents);
            //$('option[value="' + local_recipient + '"]').html(updated_contents);
            //$('#testdiv').html(updated_contents);
        }
    });
}

function update_title() {
    //$('#link1').click(function(){
    //milliseconds_passed = Math.floor(millitime() - initial_time);
    //seconds_passed = Math.floor((millitime() - initial_time) / 1000);
    //$('head title', window.parent.document).text('(' + seconds_passed + ') new');
    //});
    // what about blinking?
    // what about favicon?
    if(unseen_chats > 0) {
        $('head title', window.parent.document).text('(' + unseen_chats + ') <?php print($title); ?>');
    } else {
        $('head title', window.parent.document).text('<?php print($title); ?>');
    }
}

function clear_all_intervals() {
    // pretty hacky
    // notice it may not work if we send more than 100 messages in a session! the proper solution would be to keep track of the interval IDs such as in an array
    //counter = 0;
    //while(counter < 100) {
    //    clearCorrectingInterval(counter);
    //    counter++;
    //}
    for(let index = 0; index < intervals.length; ++index) {
        const element = intervals[index];
        // ...use `element`...
        clearCorrectingInterval(element);
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

// interval(function(){
//     // Code block goes here
// }, 1000, 10);

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

//function refresh(force = false) {
function refresh() {
//    if(refreshing) {
//        return false;
//    }
//    refreshing = true;
    // refresh the chat
    //local_recipients other_recipient
    to = get_recipient();
    if(to === random) { // blank it <-- hackers
        to = '';
    }
    //alert('to in refresh: ' + to);
    //if(force) {
    //    $('#chat_log').empty();
    //}
    //chat_log_html = $('#chat_log').html();
    //if(chat_log_html.trim() === '') {
    //    time = 0; // so that all the messages are gotten
    //} else {
    //    time = last_action_time;
    //}
    $.ajax({
        type: 'GET',
        url: 'refresh.php',
        //data: {person_id:getUserID},
        data: { to: to, source: '<?php print($source) ?>' },
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
            //alert('data, $(\'#chat_log\').html(): ' + data + ', ' + $('#chat_log').html());
            //alert('last_action_time, time: ' + last_action_time + ', ' + time);
            //if(data.length > 0) {
            //if(data.length > 0 && last_action_time == time) {
            if(data.length > 0) {
                $('#chat_log ').empty(); // because of async...
                $('#chat_log').append(data);
                //alert('reset action by refresh!');
                last_action_time = millitime();
                activity_factor = 0;
                relive();
                //refresh();
            } // otherwise assume it was refreshed asynchronously already
        }
    });
    update_all_local_recipients_activity();
//    refreshing = false;
}

function update() {
//    if(updating) {
//        return false;
//    }
//    updating = true;
    // update the chat
    //local_recipients other_recipient
    to = get_recipient();
    //if(force) {
    //    $('#chat_log').empty();
    //}
    chat_log_html = $('#chat_log').html();
    if(chat_log_html.trim() === '') {
        time = 0; // so that all the messages are gotten
    } else {
        time = last_action_time;
    }
    //console.log('updating, time: ' + to + ', ' + time);
    //alert('updating; to, time: ' + to + ', ' + time);
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
            //alert('data, $(\'#chat_log\').html(): ' + data + ', ' + $('#chat_log').html());
            //alert('last_action_time, time: ' + last_action_time + ', ' + time);
            //if(data.length > 0) {
            //if(data.length > 0 && last_action_time == time) {
            if(data === chat_log_html) { // avoid duplication; intended for <code like NO COMMUNICATIONS and HTTP but also affects duplicated messages (which should be impossible)

            } else if(typeof data !== 'undefined' && data.length > 0 && (time == 0 || last_action_time == time)) {
                //$('#chat_log ').empty();
                $('#chat_log').append(data);
                //alert('reset action by update!');
                last_action_time = millitime();
                activity_factor = 0;
                if(data.IndexOf('<code') === 0) {

                } else {
                    new_chat_recieved();
                    unseen_chats++;
                    relive();
                    //update();
                }
            } // otherwise assume it was refreshed asynchronously already
        }
    });
    update_local_recipient_activity($('#local_recipients option:selected').val());
    update_title();
//    updating = false;
}


function set_recipient(recipient) {
    //alert('set_recipient recipient: ' + recipient);
    //$("#local_recipients select").val('');
    //$('#local_recipients option[value=""]').attr('selected','selected'); // first blank it

    $.ajax({
        type: 'GET',
        url: 'urlencode.php',
        data: { string: recipient },
        success: function(data) {
            recipient = data;
        }
    });

    $('#local_recipients option').removeAttr('selected');
    if($('#local_recipients option[value="' + recipient + '"]').length) { // bit wierd, but an existing element has a length so this functions as a check for whether the element exists
        $('#local_recipients option[value="' + recipient + '"]').attr('selected','selected'); // then set to an existing one (if possible)
    } else {
        $('#local_recipients option[value="' + random + '"]').attr('selected','selected'); // blank it
    }
    // would like to add recipient to the list...
}

function get_recipient() {
    local_recipient = $('#local_recipients option:selected').val();
    //local_recipient = $('#local_recipients option:selected').attr('dec'); // this may be different from val
    other_recipient = $('#other_recipient').val();
//    alert('local_recipient, other_recipient, random in get_recipient: ' + local_recipient + ', ' + other_recipient + ', ' + random);
    //if(local_recipient.length > 0) { // <-- hackers
    if(local_recipient == random) {
        recipient = other_recipient;
    } else if(other_recipient.length === 0) {
        recipient = local_recipient;
    } else {
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
//         $('#chat_log').append(data);
//     });
    //alert('source, from, to, time, message in send_message(): ' + source + ', ' + from + ', ' + to + ', ' + time + ', ' + message);
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
            $('#chat_log').append(data);
            scroll_chat_log();
            //setTimeout(scroll_chat_log(), refresh_interval * 20);
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
    //setTimeout(scroll_chat_log(), refresh_interval / 2);
    //$('#chat_log').scrollIntoView();
    //$('#chat_log').scrollTop(this.offsetHeight);

    close_emojis_picker();
    //$("#emojis").disMojiPicker();
    //$("#emojis").picker();
}

function millitime() {
    //return millitime();
    d = new Date();
    return d.getTime();
    //time = d.getTime();
    //return time;
}

function scroll_chat_log() {
    var chat_log = document.getElementById('chat_log');
    chat_log.scrollTop = chat_log.scrollHeight; // no idea why this mostly does not work (on time?)
}

function dropHandler(ev) {
  console.log('File(s) dropped');

  // Prevent default behavior (Prevent file from being opened)
  ev.preventDefault();

  if (ev.dataTransfer.items) {
    // Use DataTransferItemList interface to access the file(s)
    for (let i = 0; i < ev.dataTransfer.items.length; i++) {
      // If dropped items aren't files, reject them
      if (ev.dataTransfer.items[i].kind === 'file') {
        const file = ev.dataTransfer.items[i].getAsFile();
        console.log('… file[' + i + '].name = ' + file.name);
      }
    }
  } else {
    // Use DataTransfer interface to access the file(s)
    for (let i = 0; i < ev.dataTransfer.files.length; i++) {
      console.log('… file[' + i + '].name = ' + ev.dataTransfer.files[i].name);
    }
  }
}

function dragOverHandler(ev) {
    alert('drag over event');
}

$('#message').focus();

});
</script>

<style>

/*

consciousness parameters orange yellow red
space   ()          ->  black
sky     (words)     ->  light blue
trees   (forest)    ->  green
water   (buttons)   ->  blue (transparent)
earth   (bottom)    ->  (dark) brown

*/

body { background-color: #223322; }
body { background: url(back4.jpg); }
#chat { /*height: 99%; border: 1px solid red;*/ /*background: url(back3.jpg);*/ }
#participants { height: 10%; overflow-y: scroll; }
#chat_log {  /*border: 1px solid black;*/ /*overflow: scroll;*/ height: 80%; overflow-y: scroll; overflow-x: hidden; }
#input { width: 100%; position: fixed; top: 90%; height: 10%; vertical-align: top; }
#send_message { /*height: 90%; margin-top: -80px;  why  */ }
button {  }

#participants { color: #DDCCAA; color: #000000; }
#chat_log { color: #CCCCDD; color: #000000; /*background-color: #223322;*/ /*border: 4px inset blue;*/ }
#input { color: #CCCCDD; color: #000000; /*background-color: #223322;*/ }

#root { float: right; margin-right: 10px; }
#message { min-height: 20px; height: 100%; }
#send_message { min-height: 20px; height: 100%; }
#toggle_picker { position: fixed; /*bottom: -30px; left: -30px;*/ min-height: 20px; height: 10%; }
#emojis { z-index: 105; min-height: 20px; height: 10%; }
#drop_zone { z-index: 105; min-height: 20px; height: 10%; }
#send_message { width: 50px; }
#message, #send_message, #toggle_picker, #emojis, #drop_zone { float: left; }
code { text-transform: uppercase; }
#drop_zone {
  border: 5px solid blue;
  width:  200px;
  height: 100px;
  display: none;
}


</style>
</head>
<body>
<div id="chat">

<div id="participants">
<label for="user"><img src="merkaba_small.jpg" alt="Merkaba" /> Me: </label><input type="text" id="user" name="user" /><br />
<label for="local_recipients"><img src="fractal_destination_small.jpg" alt="Fractal Destination" /> To: </label>
<select id="local_recipients" name="local_recipients">
<?php

//print('<option value="" title="title on an option (for )"> (open)</option>' . PHP_EOL);
print('<option value="' . $random . '"></option>' . PHP_EOL); // you, who are looking at this code, are welcome to play around ;p
foreach($recipients as $recipient) {
    // could do all the fancy stuff like blocking access, keeping track of friends, avoiding spoofing
    /*print('<option value="' . $destination . '?to=' . $recipient . '">' . $recipient . ' (last activity an unknown time ago)</option>
');*/
    // local for now
    //print('<option value="' . $recipient . '" title="title on an option (for ' . $recipient . ')">' . $recipient . ' (last activity an unknown time ago)</option>' . PHP_EOL);
    if($recipient === '') {
        print('<option value="' . $recipient . '" dec="' . urldecode($recipient) . '" selected="selected">' . urldecode($recipient) . ' (last activity an unknown time ago)</option>' . PHP_EOL);
    } else {
        print('<option value="' . $recipient . '" dec="' . urldecode($recipient) . '">' . urldecode($recipient) . ' (last activity an unknown time ago)</option>' . PHP_EOL);
    }
    // live, last activity
}

// - expand new chat column (+). no need; just open multiple tabs for now and generalize into live_browser functionality
// - green + ✳️ morph to red X ❌
// + enter to send message
// - delete own messages? there are not accounts!
// + load previous messages
// + remove all hard-coded
// + only refresh since last check (use <time>)
// - autoscroll excludes last line; not sure why
// + autofocus to chat (which allows everybody to chat to everyone and see all messages by default; not really scalable (to the universe!))
// x emojis and twitch emotes... ;p better twitch tv
// / figure out why can't add emotes sometimes, why chat doubles content sometimes, typing the recipient causes MULTIPLE chat log duplication, emojis sometimes do not work after sending a message... are these related?
// x int clear_all_intervals() { // pretty hacky
// + get chat to show on chat2, reduce resources used
// x int  http return codes; don't need a list and interpretation when they are being shown directly unfiltered to the user!
// x message if "connection" is not made; if user meh
// x should be able to type ../chat2 or ../chat2/index.php or ../chat2/new_message.php or ../chat2/new_message.php?to=myfriend into other recipient
// + last activity an unknown time ago ... number new messages
// - takes super long since basic local recipients are causing NO COMMUNICATIONS
// - online indicator... ? make it more interesting than green circle
// - 3D message box(es)
// update title tab when new message (1) blinking
// unseen chats not working
// drag and drop content into chat (emojis, images, videos?)
// sound effects. Autoplay is only allowed when approved by the user, the site is activated by the user, or media is muted. ... sound sometimes works
// dark green (text) trees on pale blue sky (background)
// computer digital stuff on glass surface in front of natural imagery like church windows separating inside from out
// wind sound instead of keyboard ... chatting up a storm
// have to think about chat logs not being saved as typed because of, for instance, spaces creating bad HTTP requests when chatting with a remote getting turned into pluses in the filename... and maybe more characters... urlencode() and have to deal with recipients with + in their name etc.
// emojis sometimes don't work; why?
// emojis stop working after chatting
// x emojis ugly
// write test
// test
// wadlof
// backups of remote chats
// bugs:
// memory leak
// have to shift-refresh page to get emojis to work after other input...
?>
</select>
or <label for="other_recipient">other: </label><input type="text" id="other_recipient" name="other_recipient" size="60" placeholder="www.google.com/live_browser/chat/new_message.php?to=myfriend123" /><!--button id="set_other_recipient" name="set_other_recipient">Set</button-->
</div>
<div id="emojis"></div>
<div id="chat_log">

</div>

<div id="input">
<textarea id="message" name="message" cols="42" rows="3"></textarea>
<button id="send_message" name="send_message">Send</button>
<button id="toggle_picker">😀</button>
<div id="drop_zone" ondrop="dropHandler(event);" ondragover="dragOverHandler(event);">
  <p>Drag one or more files to this <i>drop zone</i>.</p>
</div>
<div id="root"><a href="https://github.com/freementls/live_browser"><img src="root.png" width="32" height="32" /></a></div>
<!--div id="testdiv"><a href="https://github.com/freementls/live_browser"><img src="root.png" width="32" height="32" /></a></div-->
</div>
</div>
</body>
</html>
