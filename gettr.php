<html>
<head>
<title>wowzo</title>
<style>
iframe { width: 50%; z-index: 1; }
table { width: 50%; }
#clicko { position: absolute; right: 100; bottom: 100; z-index: 10; }
</style>
<script src="jquery-3.5.0.js"></script>
<script>
// live
$(document).ready(function() { 
/* code here */
//alert('alert1'); 
var interval_frequency = 2500; // expressed in miliseconds
var interval = 0;
//alert('alert1.1');
startLoop();
//alert('alert1.9'); 

// STARTS and Resets the loop if any
function startLoop() { // stop
    //alert('alert1.2'); 
	if(interval > 0) {
		//alert('alert1.3'); 
		clearInterval(interval); 
	}
	//alert('alert1.4'); 
    //interval = setInterval('live(' + $('#firstrow td').innerHTML + ')', interval_frequency);  // run
	interval = setInterval(function(){ 
	//alert('Hello'); 
	console.log('hello every ' + interval_frequency / 1000 + ' seconds');
	groweth = 1000; // default to new node?
	live($('#firstrow td').html());
	}, interval_frequency);
}

async function live(node, groweth) {
$.ajax({
    type: 'POST',
    url: 'live.php',
    //data: input
	data: {'node': node, 'groweth': groweth}
}).then(
    // resolve/success callback
    async function(response) {
		//alert('living');
		alert('response (from live.php): ' + response);
		//$('#action').append('<u>' + response + '</u> ');
		//$('#firstrow td').append('<u>' + response + '</u> ');
		//$('#firstrow td').html(response);
		
		//$.getJSON('http://localhost:8888/myfile.php', function(data) {
		//	console.log(data);
		//});
		/*$.each(response, function(i, field){
			//$('tbody').append(field + ' ');
			$('tbody').append('<tr><th>new</th><td>' + field + '</td></tr>');
		});*/
		
    },
    // reject/failure callback
    function() {
		alert('There was some error in live!');
    }
);

}

});
//$(function() { /* code here */alert('alert2'); });
//document.getElementById('dinker_table').onload = function() {


//}



</script>
</head>
<body>
<iframe src="slide.php">

</iframe>
<table id="dinker_table" border="1">
<thead>
<tr>
<th scope="col">adress</th>
<th scope="col">score</th>
</tr>
</thead>
<tbody>
<tr id="firstrow">
<th>google.ca</th>
<td>500</td>
</tr>
</tbody>
</table>
<img id="clicko" src="" width="50" height="50" />
</body>
</html>