<?php

$recipients = array('Charlie', 'Baba', 'RainbowFairy', 'Finnsda', 'shawncase', 'Freement'); // hard-coded
$source = 'wewakelife.great-site.net/live_browser/chat/index.php'; // hard-coded
//$destination = 'wewakelife.great-site.net/live_browser/chat/new_message.php'; // hard-coded

?>
<html>
<head>
<title>live_browser chat</title>
<script src="jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){

refresh_interval = 100; // in milliseconds; every 0.1 seconds; should be interactive enough for chat while not overstraining server resources
//var intervalID = window.setInterval(live, 10000); // every 10 seconds
var intervalID = window.setInterval(live, refresh_interval);

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

function live() {
    //alert('live (every 10 seconds)');
    // refresh the chat
    //local_recipients other_recipient
    to = get_recipient(); // hard-coded
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
        success: function(data){
            //alert(data);
            //alert('data from refresh.php: ' + data);
            // would like to only get new but that's more complicated
            //$("#processing").hide();
            //$("#person-data").html(data);
            $('#message_box').empty();
            $('#message_box').append(data);
        }
    });
    // refresh other counters
}

function set_recipient() {
    //$("#local_recipients select").val('');
    $('#local_recipients option[value=""]').attr('selected','selected');
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
//         success: function(data){
//             alert('data from testajax.php: ' + data);
//         }
//     }); // works



function send_message(enter_sent = false) {
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
    const d = new Date();
    let time = d.getTime() / 1000;
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
        success: function(data){
            //alert(data);
            //alert('data from new_message.php: ' + data);
            //$("#processing").hide();
            //$("#person-data").html(data);
            $('#message_box').append(data);
            scroll_message_box();
            //setTimeout(scroll_message_box(), refresh_interval * 20);
        }
    });
    $('#message').val(''); // empty the message box
    // remote

    // scroll the message box to the bottom
    //setTimeout(scroll_message_box(), refresh_interval / 2);
    //$('#message_box').scrollIntoView();
    //$('#message_box').scrollTop(this.offsetHeight);
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
<div id="chat">
<div id="participants">
<label for="user"><img src="merkaba_small.jpg" alt="Merkaba" /> Me: </label><input type="text" id="user" name="user" /><br />
<label for="local_recipients"><img src="fractal_destination_small.jpg" alt="Fractal Destination" /> To: </label>
<select id="local_recipients" name="local_recipients">
<?php

print('<option value="" title="title on an option (for )"> (open)</option>
');
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

// get chat to show on chat2, reduce resources used
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
