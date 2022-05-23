<?php

include('life.php');
$life = new life();
//print('$_REQUEST: ');var_dump($_REQUEST);exit(0);
// for some reason there's a __test key with a value in the request array; maybe because it's ajax, to give it an identifier
// node, growth, search
$node = $life->get_by_request('node');
$node = $life->normalize_path($node);
//print($node + 1);
//print('$node: ');var_dump($node);
//if($node === NULL) {
//	exit(0);
//}
$groweth = $life->get_by_request('groweth');
//print('$groweth: ');var_dump($groweth);
if($groweth === NULL) {
	exit(0);
}
if(strlen($groweth) === 0) {
	exit(0);
}
$add_thickness = $life->get_by_request('add_thickness'); // we only don't if it's a local "locked" site which we do not want to grow (proprietary etc.)
//print('$add_thickness: ');var_dump($add_thickness);
$local = $life->get_by_request('local');
$local_icon = $life->get_by_request('local_icon');
//print('live001<br />');
//error_reporting(E_ALL & ~E_NOTICE);
define(DS, DIRECTORY_SEPARATOR);
//print('live001.1<br />');
include('..' . DS . 'LOM' . DS . 'O.php');
//print('live001.2<br />');
if(!file_exists('local.xml')) {
	//print('live001.3<br />');
	file_put_contents('local.xml', '');
}
//print('live002<br />');
$O = new O('local.xml');
//print('live003<br />');
if(!is_dir('cache')) {
	mkdir('cache');
}
//print('live004<br />');



//array($O, $total_of_scores, $best_score, $best_URL)
$local_scoring_results = score_results($groweth, $O, $life);
$O = $local_scoring_results[0];
$number_of_adresses = $local_scoring_results[1];
$adress_exists = $search_scoring_results[2];
$total_of_scores = $local_scoring_results[3];
$best_score = $local_scoring_results[4];
$best_URL = $local_scoring_results[5];

// external search disabled for now
/*if($best_score > 0 && $best_score > $average_score * 10) {

} else {
	//print('do not recommend a link.');
	// take a search result instead of local result
	// https://yandex.com/search/?text=something
	//$search_page_contents = file_get_contents('https://yandex.com/search/?text=' . $groweth);
	$search_page_contents = $life->get_contents('https://yandex.com/search/?text=' . $groweth);
	print('$search_page_contents: ');var_dump($search_page_contents);exit(0);
	$search_adresses_contents = '';
	preg_match_all('/ role="text" href="([^"]+)"/is', $search_page_contents, $search_result_link_matches);
	foreach($search_result_link_matches[0] as $index => $value) {
		$search_result_link = $search_result_link_matches[1][$index];
		$search_adresses_contents .= '<a dress="' . $search_result_link . '"></a>
';
	}
	print('$search_adresses_contents: ');var_dump($search_adresses_contents);
	$search = new O($search_adresses_contents);
	//array($O, $total_of_scores, $best_score, $best_URL)
	$search_scoring_results = score_results($groweth, $search, $life);
	$search = $search_scoring_results[0];
	$number_of_adresses = $search_scoring_results[1];
	$adress_exists = $search_scoring_results[2];
	$total_of_scores = $search_scoring_results[3];
	$best_score = $search_scoring_results[4];
	$best_URL = $search_scoring_results[5];
	
}*/
// if it stands out enough then make the decision to link to the user
//$average_score = $total_of_scores / sizeof($adresses);
$average_score = $total_of_scores / $number_of_adresses;
$actions = array();
$friends = array();
$downloads = array();
$games = array();
// save to IPFS, archive.is 
// this site uses proprietary or closed source code. we are open source; connected to source. this page may not display properly
// for hosts that don't have content-security-policy bullshit enable frame, others: create wget
// wget (localize) (source-connect)
// so: like with fractal_zip: test for 7zip executable and handle both the case when it's there and when it's not; such with content-security-policy
// newlink will have to become more sophisticated; favicon, external or internal, 
// simplistic
// possible to recommend more than one link?
//print('$average_score, $best_score: ');var_dump($average_score, $best_score);
if($best_score > 0 && $best_score > $average_score * 10) { // basically one order of magniture since we are using log10
	//print('recommend a link!');
	$best_URL_contents = $life->get_contents($best_URL);
	//print('$local_icon: ');var_dump($local_icon);
	$icon = 'qm.jpg';
	if(strlen($local_icon) > 0 && strpos($best_URL, $local) !== false || strpos($best_URL, '://') === false) {
		$icon = $local_icon;
	} else {
		preg_match('/<link[^>]*? rel="icon"[^>]*? href="([^"]+)">/is', $best_URL_contents, $icon_matches);
		if(strlen($icon_matches[1]) > 0) {
			$icon = $icon_matches[1];
		}
	}
	$title = 'default title';
	preg_match('/<title[^>]*?>([^<]+)<\/title>/is', $best_URL_contents, $title_matches);
	if(strlen($title_matches[1]) > 0) {
		$title = $title_matches[1];
	} else {
		// try a PHP script variable, although catching every possibility is likely not practical
		// $title = 'Hiking'
		preg_match('/title = \'([^\']+)\'/is', $best_URL_contents, $title_matches);
		$title = $title_matches[1];
	}
	$actions[] = array('newlink' => array($best_URL, $title, $icon));
}/* else {
	//print('do not recommend a link.');
	// take a search result
	// https://yandex.com/search/?text=something
	$search_page_contents = file_get_contents('https://yandex.com/search/?text=' . $groweth);
}*/

//print('$add_thickness: ');var_dump($add_thickness);
if($add_thickness) {
	if(!$adress_exists && strlen($node) > 0) {
		$O->_new('<a dress="' . $node . '" hits="1"></a>');
	}
	if($best_URL !== false) { // add thickness
		// what if the best is itself??
		//print('$O->enc($best_URL): ');var_dump($O->enc($best_URL));
		$best_a = $O->get_tagged('a@dress=' . $O->enc($best_URL));
		//print('$best_URL, $best_score, $best_a: ');var_dump($best_URL, $best_score, $best_a);
		if($O->_('b@a=' . $O->enc($node), $best_a) === false) { // make it
			//print('make it<br />');
			$O->_new('<b a="' . $O->enc($node) . '" score="' . $best_score . '" />', $best_a);
		} else {
			//print('score it<br />');
			$O->att_add('score', $best_score, $best_a);
		}
	}
	// once the path is chosen, thicken it
	//while($O->depth($selector) > 0) {
	//		$O->add_to_attr('score', $to_add, $adress);
	//		$selector = $O->get_parent($selector);
	//	}
		// path merging: if node A goes to node B and node B goes to node A then merge them and add the scores?
		// promote: if a child's score is greater than that of the parent and its other children, promote the high score one and the tree of the previous parent becomes a child of the high score
		// local universe to remote (internet) universe matching. the keywords and voice commands and browsing and any activities represent the local universe and search engine usage and tree of "life" represents the remote universe
	//print('live010<br />');
}
// check unique IP, frequency of action... there is a smarter way; for multi-users (social medium by default) and spam prevention
//$arr = array ('a'=>1,'b'=>2,'c'=>3,'d'=>4,'e'=>5);
//echo json_encode($arr); // {"a":1,"b":2,"c":3,"d":4,"e":5}
//print(json_encode(array('key1' => 'value1', 'key2' => 'value2')));
//////print(json_encode(array($actions, $friends, $downloads, $games)));
// too annoying for now. just hack it so that we don't have to deal with this JSON decode nonsense
$return_contents = 'XXX9o9';
//foreach($actions as $index => $value) {
//	$return_contents .= $value . 'XXX';
//}
//print('$actions: ');var_dump($actions);
$return_contents .= $actions[0]['newlink'][0] . 'XXX';
$return_contents .= $actions[0]['newlink'][1] . 'XXX';
$return_contents .= $actions[0]['newlink'][2] . 'XXX';
$return_contents .= '9o9XXX';
print($return_contents);
//print(json_encode(array('key1' => 'value1', 'key2' => array('skey2' => 'svalue2'), 'key3' => 'value3')));
/*$scores_array = array();
foreach($O->get_var('adresses') as $index => $value) {
	$scores_array[$value[0]] = $O->get_attr('score', $value[1]);
}
print(json_encode($scores_array));*/
//print('$O->code: ');var_dump($O->code);exit(0);
//if($made_a_change) {
	$O->save_if_needed();
//}

function score_results($groweth, $O, $life) {
	$words = explode(' ', $groweth);
	$adresses = $O->get_tagged('a');
	//print('$adresses: ');var_dump($adresses);
	//$O->variable('adresses', $adresses);
	// if adress does not exist then create it
	//$made_a_change = false;
	//print('live005<br />');
	$adress_exists = false;
	$best_score = 0;
	$total_of_scores = 0;
	$best_a = false;
	$counter = sizeof($adresses) - 1;
	$number_of_adresses = $counter + 1;
	while($counter > -1) { // go in reverse order to avoid offset issues from writing (although this could be achieved with a living variable)
	//foreach($adresses as $adress) {
		$adress = $adresses[$counter];
		//print('live006<br />');
		//print('$adress: ');var_dump($adress);//exit(0);
		// adress processing here
		//$URL = $O->tagless($adress[0]);
		$URL = $O->get_attr('dress', $adress);
		$URL = $life->normalize_path($URL);
		//print('$URL: ');var_dump($URL);
		$download_time = $O->get_attr('download_time', $adress);
		// try locally first
		$contents = file_get_contents($URL);
		if(strlen($contents) > 0) {
			// then it was found locally
		} else {
			$contents = $life->get_contents($URL, false, $download_time);
			//print('$URL, $life->downloaded_file: ');var_dump($URL, $life->downloaded_file);exit(0);
		}
		//print('$contents: ');var_dump($contents);
		if($life->downloaded_file) {
			$O->set_attr('download_time', time(), $adress);
		}
		if(strlen($contents) === 0) {
			print('$URL, $contents: ');var_dump($URL, $contents);
			$O->fatal_error('tried to get the contents of a file but failed!');
			// have to fix this at some point. some sites have bot countermeasures, so it comes down to spoofing or an arms race etc.
			$counter--;
			continue;
		}
		//print('$URL, $node: ');var_dump($URL, $node);
		if($URL === $node) {
			//print('$URL === $node!');
			$O->inc_attr('hits', $adress);
			$adress_exists = true;
		}
		// remove stop words?
		//$counts = array(); // very simplistic artificial intelligence
		$count = 0;
		foreach($words as $word) {
			//print('live007<br />');
			//$counts[$word] += substr_count($contents, $word); // += instead of set on the off-chance a word appears more than once
			//$score += substr_count($contents, $word);
			// don't just go by number, go by density
			$count += substr_count($contents, $word);
		}
		//$score = $count / strlen($contents);
		$score = log10($count) / strlen($contents);
		//print('$contents, $count, $URL, $score: ');var_dump($contents, $count, $URL, $score);
		//print('$URL, $count, $score: ');var_dump($URL, $count, $score);
		$total_of_scores += $score;
		if($score > $best_score) {
			$best_score = $score;
			$best_URL = $URL;
		}
		$counter--;
	}
	return array($O, $number_of_adresses, $adress_exists, $total_of_scores, $best_score, $best_URL);
}

?>