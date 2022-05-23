<html>
<head>
<title></title>
<script src="jquery-3.5.0.js"></script>
<script>
id_counter = 0;
fraction = '';
last_key_timestamp = -1;
//maximum_input_delay = 1000; // milliseconds
// how long does it take the average person to type a command?
maximum_intervening_input_delay = 500; // milliseconds
maximum_input_delay = 2000; // milliseconds
//console.log('here001');
document.addEventListener('keypress', function(e) {
    //console.log('here001');
    //intervening_key = false;
    //console.log(e);
    if(e['timeStamp'] > last_key_timestamp + maximum_intervening_input_delay) {
        //console.log('here003');
        if(fraction.length > 0) {
          //console.log('here002');
          command();
        }
        fraction = e['key'];
    } else {
        //console.log('here003');
        fraction = fraction + e['key'];
    }
    //console.log('here006');
    last_key_timestamp = e['timeStamp'];
    //$('#fraction').append('<u>' + e['key'] + '</u> ');
    //intervening_key = false;
	//saved_delayed_input = false;
    timeoutID = setTimeout(function(){
      /*document.addEventListener('keypress', function(ee) {
        console.log('here004');
        intervening_key = true;
      });*/
      //console.log('here008');
      //if(intervening_key == false && fraction.length > 0) {
	if(fraction.length > 0) {
        //console.log('here005');
        command();
		//saved_delayed_input = true;
      }
    }, maximum_input_delay);
	/*if(fraction.length > 0) {
        console.log('here006');
        $('#fraction').append('<u>' + fraction + '</u> ');
        fraction = '';
		//saved_delayed_input = true;
      }*/
	/*if(saved_delayed_input == false && fraction.length > 0) {
        console.log('here006');
        $('#fraction').append('<u>' + fraction + '</u> ');
        fraction = '';
      }*/
    //console.log('here010');
    //clearTimeout(timeoutID);
}, false);

function command() {
	id_counter++;
	$('#fraction').append('<u>' + fraction + '</u> ');
    fraction = '';
	text_drop(id_counter);
}
function text_drop(id){
    
	for(var j = 0; j < 10; ++j) {

		$('#drop' + id).animate({'top':(50 * j) +'px'},10); // 1 is like time taken in milliseconds
		$('#drop' + id).animate({'font-size':(520-(50 * j))+'px'},10);

	}

}
/*document.getElementById('text3').addEventListener('keypress', function(e) {
    console.log(e);
}, false);*/
</script>
</head>
<body>
<p>finger gestures (swipes)</p>
<p>circle: load all? select all?</p>
<p>triangle: maybe not</p>
<p>square: save?</p>
<p>arrows and double arrows in each direction</p>
<p>keyboard...</p>
<p>not only get each key but break keylogging into commands</p>
<p>paragraph</p>
<p>paragraph</p>

<div id="fraction" style="border: 10px solid green;"></div>

</body>
</html>
