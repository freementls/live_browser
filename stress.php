<?php

$stress = new stress();
$stress->full();
$stress->dump_total_time_taken();

class stress {

function __construct() {
	$this->stress_initial_time = stress::getmicrotime();
	include('life.php');
	$this->life = new life();
	$this->life->debug();
}

function full() {
	stress::recursive_file_list_to_array('cache');
	stress::delete_empty_files();
	//exit(0);
	stress::cache_file_type_detection();
	// others
}

function delete_empty_files() {
	foreach($this->files as $file) {
		if(filesize($file) === 0) {
			unlink($file);
			print('deleted ' . $file . '.<br />
');
		}
	}
}

function cache_file_type_detection() {
	$total = sizeof($this->files);
	$matches = 0;
	foreach($this->files as $file) {
		$contents = file_get_contents($file);
		/*$file_type_from_contents = stress::file_type_from_contents($contents);
		$file_type_by_extension = substr(stress::file_extension($file), 1);
		print('$file, $file_type_from_contents, $file_type_by_extension: ');var_dump($file, $file_type_from_contents, $file_type_by_extension);
		if($file_type_from_contents == NULL) { // programming languages can output any file extension
			print('$contents: ');var_dump($contents);
			//print('strpos($contents, \'‰PNG\'): ');var_dump(strpos($contents, '‰PNG'));
			stress::fatal_error('file type missed!');
		} elseif($file_type_by_extension === 'php') { // programming languages can output any file extension
			$matches++;
		} elseif($file_type_from_contents != $file_type_by_extension) {
			print('$contents: ');var_dump($contents);
			stress::fatal_error('file type mismatch!');
		} else {
			$matches++;
		}*/
		if($this->life->verify_file_type($contents, $file)) {
			$matches++;
		}
	}
	print($matches . ' / ' . $total . ' = ' . ($matches / $total * 100) . '%<br />
');
}

function file_type_from_contents($contents) {
	// determine file type based on contents
	// sort of most specific (static file type contents) to least (programming languages)
	// with some interweaving for ones that can subsume each other e.g. js and css
	// it's certainly worth grouping into the if conditions by file type result and putting the more 
	// processing intensive tests in later order and more common patterns earlier for saving processing time
	if(substr($contents, 0, 3) === 'GIF') {
		$file_type = 'gif';
	} elseif(substr($contents, 1, 3) === 'PNG') {
		$file_type = 'png';
	} elseif(substr($contents, 6, 4) === 'JFIF') {
		$file_type = 'jpg';
	} elseif(strpos($contents, '<feed') !== false || strpos($contents, '<rss') !== false) {
		$file_type = 'rss';
	} elseif(strpos($contents, '<html') !== false || preg_match('/<!DOCTYPE\s+html/is', $contents, $matches)) {
		$file_type = 'html';
	} elseif(strpos($contents, 'Math.random') !== false || strpos($contents, '.toLowerCase(') !== false || strpos($contents, '.css(') !== false || strpos($contents, '.html(') !== false) {
		$file_type = 'js';
	} elseif(strpos($contents, 'overflow:') !== false || strpos($contents, 'width:') !== false || strpos($contents, 'color:') !== false) {
		$file_type = 'css';
	} /*elseif(strpos($contents, 'position:') !== false) { // ambiguous between js and css
		$file_type = 'css';
	} */elseif(strpos($contents, 'function(') !== false || strpos($contents, '.document') !== false) {
		$file_type = 'js';
	}
	if($file_type === false) {
		print('$contents, $file_type: ');var_dump($contents, $file_type);
		stress::fatal_error('did not determine file type in digest()');
	}
	return $file_type;
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

function file_extension($string) {
	$string = str_replace('\\', '/', $string);
	$last_dot_position = stress::strpos_last($string, '.');
	$last_slash_position = stress::strpos_last($string, '/');
	$last_question_position = stress::strpos_last($string, '?');
	if($last_question_position === false) {
		$last_question_position = stress::strpos_last($string, '9o9quest9o9');
	}
	if($last_dot_position === false || $last_dot_position < $last_slash_position/* || $last_dot_position < stress::strpos_last($string, '\\')*/) {
		//return false;
		return '.' . substr($string, $last_slash_position + 1, $last_question_position - $last_slash_position - 1);
	}
	if($last_question_position === false) {
		return substr($string, $last_dot_position);
	} elseif($last_question_position < $last_dot_position) { // this is pretty wacky
		$last_dot_between_slash_and_question_position = stress::strpos_last(substr($string, 0, $last_question_position), '.', $last_slash_position);
		if($last_question_position < $last_dot_between_slash_and_question_position) {
			print('$string, $last_question_position, $last_dot_position: ');var_dump($string, $last_question_position, $last_dot_position);
			stress::fatal_error('not sure how to calculate file_extension from these');
			return false;
		} else {
			return substr($string, $last_dot_between_slash_and_question_position, $last_question_position - $last_dot_between_slash_and_question_position);
		}
	} else {
		return substr($string, $last_dot_position, $last_question_position - $last_dot_position);
	}
}

function recursive_file_list_to_array($directory) {
	if(is_dir($directory)) {
		$d = dir($directory);
		while(FALSE !== ($entry = $d->read())) {
			if($entry == '.' || $entry == '..') {
				continue;
			}
			$Entry = $directory . DIRECTORY_SEPARATOR . $entry;
			if(is_dir($Entry)) {
				$this->folder_counter++;
				stress::recursive_file_list_to_array($Entry);
				continue;
			} else {
				//print($Entry . "\r\n<br>");
				$this->files[] = $Entry;
				$this->file_counter++;
			}
		}
		$d->close();
	}
}

function fatal_error($message) {
	print('<span style="color: red;">' . $message . '</span>');exit(0);
}

function fatal_error_once($string) {
	if(!isset($this->printed_strings[$string])) {
		print('<span style="color: red;">' . $string . '</span>');exit(0);
		$this->printed_strings[$string] = true;
	}
	return true;
}

function warning($message) {
	print('<span style="color: orange;">' . $message . '</span><br />
');
}

function warning_if($string, $count) {
	if($count > 1) {
		stress::warning($string);
	}
}

function warning_once($string) {
	if(!isset($this->printed_strings[$string])) {
		print('<span style="color: orange;">' . $string . '</span><br />
');
		$this->printed_strings[$string] = true;
	}
}

function good_message($message) {
	print('<span style="color: green;">' . $message . '</span><br />
');
}

function good_message_once($string) {
	if(!isset($this->printed_strings[$string])) {
		print('<span style="color: green;">' . $string . '</span><br />
');
		$this->printed_strings[$string] = true;
	}
}

function getmicrotime() {
	list($usec, $sec) = explode(' ', microtime());
	return (float)$usec + (float)$sec;
}

function dump_total_time_taken() {
	$time_spent = stress::getmicrotime() - $this->stress_initial_time;
	print('Total time spent querying XML: ' . $time_spent . ' seconds.<br />');
}

}

?>