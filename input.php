<html>
<head>
<title></title>
<script src="jquery-3.5.0.js"></script>
<script>
async function set1() {
  fraction('google');
  fraction('straw hats');
  think('google');

  //100 milliseconds wasn't long enough??
  /*setTimeout(function(){
  // simulate a significant amount of time before fractions (as there would be with a human, although when there isn't with modern computers and this is coupled with AJAP which is asynchronous the... MIND can be corrupted :)
  }, 2500);*/
  await sleep(1000);

  think('straw hats');
}
function set2() {
  fraction('chat');
  fraction('with');
  fraction('sam');
  think('chat');
  think('with');
  think('sam');
}
function set3() {
  fraction('which friend wanted to buy a cowboy hat?');
  fraction('link [friend] hat');
  think('which friend wanted to buy a cowboy hat?');
  think('link [friend] hat');
}
function set4() {
  //fraction('google');
  //fraction('straw hats');
}
function breakset() {
  fraction('xx');
  think('xx');
  fraction('xxxxx');
  think('xxxxx');
  fraction('xxxxxxxxxxx');
  think('xxxxxxxxxxx');
  fraction('xxxxxxxxxxxxxxxxxxxxxxxx');
  think('xxxxxxxxxxxxxxxxxxxxxxxx');
}
function fraction(fraction) {
  $('#fraction').append('<u>' + fraction + '</u> ');
  //alert('fraction: ' + fraction);
}
async function think(data) {
$.ajax({
    type: "POST",
    url: 'ment.php',
    data: data
}).then(
    // resolve/success callback
    async function(response) {



      //alert('response (from ment.php): ' + response);
      $('#action').append('<u>' + response + '</u> ');
    },
    // reject/failure callback
    function() {
      alert('There was some error!');
    }
);

}

function sleep(ms) {
  return new Promise(resolve => setTimeout(resolve, ms));
}

async function demo() {
  console.log('Taking a break...');
  await sleep(2000);
  console.log('Two seconds later, showing sleep in a loop...');

  // Sleep in loop
  for (let i = 0; i < 5; i++) {
    if (i === 3)
      await sleep(2000);
    console.log(i);
  }
}

demo();

</script>
</head>
<body>
  <!--
  reward uniqueness rather than conformity not by a currency but by a spotlight?? art not science... also fights bots
  ... content owner gets more flow: copycats and slight minor editions
  holographic system positions itself above hierarchical so as to benefit from the greediest, like a fountainhead, but there must be a purifying filter to not shower everyone with corrupted shit... or rather preserve the sweet innocence that has flowed up and let the corruption flow down and sediment

  green and white freement measuring social medium like facebook
  putting the fountainhead above the hierarchy allows the freement (in the place of currency) to flow to everyone, toroidally and total freement (as a delta to freedom) can thus be measured, also total (real) economy, by flow rate which would be faster than just sucking to the top
  websites that can talk to each other
  suggestions about how to be more free
  need the right principles for them not to be corrupted
  - give away your riches; at least for those with riches, it will generally be better to give them to others with little thereby increasing freedom, but sometimes some should accept riches also.
  - love your neighbor
  - good is greater than the sum of its parts... density not dimension... transcendance... supersummation
  -->
<!-- would be good if we didn't have to model the frames in the mind since they are already structured XML -->
<p>nasty bug maybe having to do with _new() but probably due to some offset problem somewhere in LOM but I haven't isolated it. we are forcing inputs to occur with humanish tempo to avoid issues wth asynchronous writing of mind.xml and which is not catching some thoughts.</p>
<p>paragraph0020</p>
<button id="set1" onclick="set1()">set1</button> google straw hats<br />
<button id="set2" onclick="set2()">set2</button> chat with sam<br />
<button id="set3" onclick="set3()">set3</button> which friend wanted to buy a cowboy hat? fulfil their request with the link?<br />
<button id="set4" onclick="set4()">set4</button> monsters<br />
<button id="breakset" onclick="breakset()">breakset</button> breakset<br />
<div id="fraction" style="border: 10px solid green;"></div>
<div id="action" style="border: 10px solid #cfc;"></div>
</body>
</html>
