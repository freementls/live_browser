<html>
<head>
<title></title>
<style>
iframe { border: 10px solid black; height: 480px; width: 200px; }
#universe { height: 500px; }
/* would need to adapt the displayed universe properties to the device, e.g. desktop or phone */
p { clear: both; }
</style>
<script src="jquery-3.5.0.js"></script>
<script>
// slide, input, interact, economy
//$('#frame1').css('position', 'absolute').css('left', '150').css('top', '250');
universe_width = 1000; // arbitrarily hard-coded for now
// want to use living measures and values
iframes_heights = 480; // static for now
iframes_widths = 200; // static for now
// go really simple: 1D positive for now...
speed = 400;
frame_counter = 1; // frame_index?
function set1() {
  new_frame('input.php');
  /*$('#frame1').animate({
    //opacity: 0.25,
    left: "-=250",
    //height: "toggle"
  }, speed, function() {
    // Animation complete.
  });
  $('#frame2').animate({
    //opacity: 0.25,
    left: "+=250",
    //height: "toggle"
  }, speed, function() {
    // Animation complete.
  });*/
  // want to dynamically calculate where frames get pushed around to
  move_to_index('frame0', 0);
  move_to_index('frame1', 1);
}
function new_frame(source, frame_index = frame_counter) { // frame_counter is assumed to always be above the frame index
  $('#universe').append('<iframe id="frame' + frame_counter + '" src="' + source + '" index="' + frame_index + '"></iframe>');
  $('#frame' + frame_counter).css('position', 'absolute').fadeOut(0);
  move_to_index('frame' + frame_counter, frame_index);
  $('#frame' + frame_counter).fadeIn(speed);
  frame_counter++;
}
function move_to_index(id, index) {
  center_x = (universe_width / 2) - (iframes_widths / 2);
  if(index == 0) { // special case
    x = center_x - (iframes_widths / 2);
  } else {
    x = center_x + (index * (iframes_widths / 2) * (0.618 ** (Math.abs(index) - 1))); // golden ratio; important for life
  }
  //alert('id, x in move_to_index: ' + id + ', ' + x);
  // tricky bug: CSS or jquery won't won't to a fractional pixel... or not
  //x = Math.floor(x);
  // bubble map should be like a fountain sprouting from the center?
  z_index = 100 - Math.abs(index); // 1D and uncolored specific
  $('#' + id).animate({/*opacity: 0.25,*/ top: "10px",/* hard-coded for now */ left: x, zIndex: z_index, /*height: "toggle"*/}, {queue: false}, speed, function() { /* Animation complete. */});
  $('#' + id).attr('index', index);
}
function change_index(existing_index, new_index) {
  move_to_index(id_of_frame_with_index(existing_index), new_index);
}
function set2() {
  new_frame('interact.php', 2);
  change_index(1, -2);
  change_index(2, 1);
}
function id_of_frame_with_index(index) { // 1D and uncolored specific. this function will become more complex once our tracking is more complex and not only one-dimensional e.g. colors, borders, etc
  id = $('iframe[index=' + index + ']').attr('id');
  //alert('id: ' + id);
  return id;
}
function delete_frame_with_id(id) {
  $('iframe[id=' + id + ']').remove();
}
function delete_frame_with_index(index) {
  $('iframe[index=' + index + ']').remove();
}
function set3() {
  new_frame('economy.php');
  new_frame('economy.php');
  delete_frame_with_index(3);
  change_index(1, 7);
  change_index(2, 1);

  new_frame('economy.php');
  new_frame('economy.php');
  delete_frame_with_index(4);
  change_index(7, 2);
  change_index(2, -2);

  delete_frame_with_index(5);
  new_frame('economy.php');
  new_frame('economy.php');
  change_index(4, -4);
  change_index(5, -3);
}
</script>
</head>
<body>
<!-- bubbles in 2D with more functionality, intuitiveness to be done. x,y instead of just x. also context and highlighting colors etc -->
<div id="universe">
<iframe id="frame0" src="slide.php" style="position: absolute; left: 50; top: 50;"></iframe>
</div>
<p>paragraph00026</p>
<p>wrong formula for position calculation. also fadeout on delete</p>
<button id="set1" onclick="set1()">set1</button> add frame and push existing frame over<br />
<button id="set2" onclick="set2()">set2</button> move c+2 index to c+1 and c+1 to c-2 noting overlaps...<br />
<button id="set3" onclick="set3()">set3</button> monsters<br />
</body>
</html>
