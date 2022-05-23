id_counter = 0;
fraction = '';
last_key_timestamp = -1;
//saves = {}; // object, not array as would be defined using []
//maximum_input_delay = 1000; // milliseconds
// how long does it take the average person to type a command?
//maximum_intervening_input_delay = 500; // milliseconds
maximum_intervening_input_delay = 1000; // milliseconds
maximum_input_delay = 2000; // milliseconds // not used.
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
    fraction = '';
	text_drop(id_counter);
}
function text_drop(id){
    
	for(var j = 0; j < 10; ++j) {

		$('#drop' + id).animate({'top':(50 * j) +'px'},10); // 1 is like time taken in milliseconds
		$('#drop' + id).animate({'font-size':(520-(50 * j))+'px'},10);

	}

}