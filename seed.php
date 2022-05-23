<?php

define('DS', DIRECTORY_SEPARATOR);
$seed = new seed();
$path = $seed->get_by_request('path');
//print('$path: ');var_dump($path);exit(0);
print('<form action="seed.php" method="get">
Seed: <input type="text" ');
if($path == false) {
	print(' placeholder="seed path"');
} else {
	print(' value="' . $path . '"');
} 
print(' /><br />
<input type="submit" />
</form>');
if($path == false) {
	exit(0);
}
// creating local.xml
if(is_dir($path)) {
	$seed->recursive_file_list_to_array($path);
} else {
	// simplistic; could become more complicated
	preg_match_all('/ href="([^"]+)"/is', file_get_contents($path), $href_matches);
	$seed->files = $href_matches[1];
}
$local_contents = '';
//print('$seed->web_content_extensions, $seed->web_content_extensions[0], $seed->web_content_extensions[5]: ');var_dump($seed->web_content_extensions, $seed->web_content_extensions[0], $seed->web_content_extensions[5]);
foreach($seed->files as $file) {
	$file_extension = $seed->file_extension($file);
	//print('$file_extension: ');var_dump($file_extension);
	foreach($seed->web_content_extensions as $web_content_extension) {
		//print('$file_extension, $web_content_extension: ');var_dump($file_extension, $web_content_extension);
		if($file_extension === $web_content_extension) { // NO IDEA why this doesn't work
		//if($file_extension === '.html') {
			if(strpos($file, $path) === 0) {
				$file = substr($file, strlen($path));
			}
			$local_contents .= '<a dress="' . $file . '"></a>
';
			break;
		}
	}
	//exit(0);
}
//print('$local_contents: ');var_dump($local_contents);exit(0);
if(is_dir($path)) { // if path points to another folder, put local.xml there
	file_put_contents($path . DS . 'local.xml', $local_contents);
} elseif(uniform_resource_exists($path)) {// if is url put local.xml where seed is run from
	file_put_contents('local.xml', $local_contents);
} else { // assume it's a local file
	file_put_contents($seed->fileless($path) . DS . 'local.xml', $local_contents);
}

class seed {

function __construct() {
	seed::set_web_content_extensions();
	return true;
}

function set_web_content_extensions() {
	$this->web_content_extensions = array('.txt', '.html', /* basic contents */
	/* server pages */ '.avfp', '.asp', '.aspx', '.cshtml', '.vbhtml', '.cfm', '.go', '.gs', '.php', '.hs', '.jsp', '.do', '.ssjs', /*'.js', */'.lasso', '.lp', '.op', '.lua', '.p', '.cgi', '.ipl', '.pl', '.php', '.php3', '.php4', '.phtml', '.py', '.rhtml', '.rb', '.rbw', '.tcl', '.dna', '.tpl', '.r', '.w');
	return true;
}

function uniform_resource_exists($url) {
   $headers = get_headers($url);
   return stripos($headers[0], '200 OK')?true:false;
}

function extension($string) { // alias
	return seed::file_extension($string);
}

function file_extension($string) {
	// could absolutize the path to be able to resolve everything but for now just use a gimped function
	if(strpos($string, '://') !== false && substr_count($string) < 3 /* (=2) */) { // it's a naked domain so don't grab .com or .org or whatever as the extension
		return false;
	}
	// anchor # always comes after query string ?
	$last_hash_position = seed::strpos_last($string, '#');
	if($last_hash_position !== false) {
		$string = substr($string, 0, $last_hash_position);
	}
	$string = str_replace('\\', '/', $string);
	$last_slash_position = seed::strpos_last($string, '/');
	$last_question_position = seed::strpos_last($string, '?');
	if($last_question_position === false) {
		$last_question_position = seed::strpos_last($string, '9o9quest9o9');
	}
	if($last_question_position == false) {
		$last_dot_position = seed::strpos_last($string, '.');
	} else {
		$last_dot_position = seed::strpos_last(substr($string, 0, $last_question_position), '.');
	}
	//print('$string, $last_slash_position, $last_dot_position: ');var_dump($string, $last_slash_position, $last_dot_position);exit(0);
	if($last_dot_position === false || $last_dot_position < $last_slash_position) {
		return false;
	} elseif($last_question_position === false) {
		if($last_dot_position === false) {
			return false;
		} else {
			return substr($string, $last_dot_position);
		}
	} elseif($last_question_position < $last_dot_position) { // this is pretty wacky
		$last_dot_between_slash_and_question_position = seed::strpos_last(substr($string, 0, $last_question_position), '.', $last_slash_position);
		if($last_question_position < $last_dot_between_slash_and_question_position) {
			print('$string, $last_question_position, $last_dot_position: ');var_dump($string, $last_question_position, $last_dot_position);
			seed::fatal_error('not sure how to calculate file_extension from these');
			return false;
		} else {
			return substr($string, $last_dot_between_slash_and_question_position, $last_question_position - $last_dot_between_slash_and_question_position);
		}
	} else {
		return substr($string, $last_dot_position, $last_question_position - $last_dot_position);
	}
	return false; // should never get here if there are enough conditions above to handle everything
}

function fileless($path) { // alias
	return seed::fileless_path($path);
}

function fileless_path($path) {
	$last_slash_position = seed::strpos_last($path, '/');
	if($last_slash_position === false) {
		return $path;
	} else {
		return substr($path, 0, $last_slash_position + 1);
	}
}

public function strpos_last($haystack, $needle, $offset = 0) {
	//print('$haystack, $needle: ');var_dump($haystack, $needle);
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

function get_by_request($variable) {
	return $_REQUEST[$variable];
}

function recursive_file_list_to_array($path) {
	if(is_dir($path)) {
		$d = dir($path);
		while(FALSE !== ($entry = $d->read())) {
			if($entry == '.' || $entry == '..') {
				continue;
			}
			$Entry = $path . DIRECTORY_SEPARATOR . $entry;
			if(is_dir($Entry)) {
				$this->folder_counter++;
				seed::recursive_file_list_to_array($Entry);
				continue;
			} else {
				//print($Entry . "\r\n<br>");
				$this->files[] = $Entry;
				$this->file_counter++;
			}
		}
		$d->close();
	} else {
		$this->files[] = $Entry;
		$this->file_counter++;
	}
}

}

?>