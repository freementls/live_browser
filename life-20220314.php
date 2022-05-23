<?php

class life {

function __construct() {
	//define(DS, DIRECTORY_SEPARATOR);
	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		//echo 'This is a server using Windows!';
		define('DS', '/');
	} else {
		//echo 'This is a server not using Windows!';
		define('DS', '\\');
	}
	life::set_server_side_languages();
	life::debug();
	return true;
}

function debug() {
	$this->debug = true;
	$this->debug_counter = 0;
}

function debug_on() { // alias
	return life::debug();
}

function debug_off() {
	$this->debug = false;
	unset($this->debug_counter);
}

function set_server_side_languages() {
/*ActiveVFP (*.avfp)
ASP (*.asp)
ASP.NET Web Forms (*.aspx)
ASP.NET Web Pages (*.cshtml, *.vbhtml)
ColdFusion Markup Language (*.cfm)
Go (*.go)
Google Apps Script (*.gs)
Hack (*.php)
Haskell (*.hs) (example: Yesod)
Java (*.jsp, *.do) via JavaServer Pages
JavaScript using Server-side JavaScript (*.ssjs, *.js) (example: Node.js)
Lasso (*.lasso)
Lua (*.lp *.op *.lua)
Parser (*.p)
Perl via the CGI.pm module (*.cgi, *.ipl, *.pl)
PHP (*.php, *.php3, *.php4, *.phtml)
Python (*.py) (examples: Pyramid, Flask, Django)
R (*.rhtml)
Ruby (*.rb, *.rbw) (example: Ruby on Rails)
Tcl (*.tcl)
WebDNA (*.dna,*.tpl)
Progress WebSpeed (*.r,*.w)*/
	$this->server_side_language_file_extensions = array('.avfp', '.asp', '.aspx', '.cshtml', '.vbhtml', '.cfm', '.go', '.gs', '.php', '.hs', '.jsp', '.do', '.ssjs', /*'.js', */'.lasso', '.lp', '.op', '.lua', '.p', '.cgi', '.ipl', '.pl', '.php', '.php3', '.php4', '.phtml', '.py', '.rhtml', '.rb', '.rbw', '.tcl', '.dna', '.tpl', '.r', '.w');
	return true;
}

function normalize_URL($URL) {
	$URL = str_replace('view-source:', '', $URL);
	if(strpos($URL, 'http') === false && strpos($URL, '://') === false) {
		$URL = 'http://' . $URL;
	}
	return $URL;
}

function get_by_request($variable) {
	return $_REQUEST[$variable];
}

function get_contents($path, $last_path = false, $download_time = false) {
	$contents = life::download_if($path, $last_path, $download_time);
	return $contents;
}

function download_if_changed($path, $last_path = false, $download_time = false) { // alias
	return life::download($path, $last_path, $download_time);
}

function download_if_needed($path, $last_path = false, $download_time = false) { // alias
	return life::download($path, $last_path, $download_time);
}

//function download_if($path, $last_path = false, $download_time = false) { // alias
//	return life::download($path, $last_path, $download_time);
//}

function download_if($download_path = false, $last_path = false, $download_time = false) {
	// ideally, we would simply check the metadata of a file, say an image, to see if it has been updated instead of wastefully downloading when 
	// unnecessary or missing an updated file due to caching. the internet is not structured this way... YET! IPFS
	if($download_path === false) {
		$download_path = $this->browse_path;
	}
	if($last_path === false) {
		$last_path = $this->last_browse_path;
	}
	//print('$download_path, $last_path, $download_time in download_if(): ');var_dump($download_path, $last_path, $download_time);
	$download_file = false;
	$this->downloaded_file = false;
	//print('uh here00z001<br />');
	$local_path = life::filename_encode(life::local_path($download_path));
	//print('$local_path in download_if(): ');var_dump($local_path);
	if(file_exists($local_path)) {
		//print('file exists<br />');
		// update it if it's been a certain amount of time since it was downloaded (check metadata, date modified) have metadata available to live browser so that user can make choices
		//print('here123<br />');
		if($download_time === false) {
			//print('here124<br />');
			$download_time = filemtime($local_path);
		}
		//print('$download_path, filemtime($local_path), $download_time: ');var_dump($download_path, filemtime('cache' . DS . $local_relative_path), $download_time);exit(0);
		//print('time(), $download_time: ');var_dump(time(), $download_time);
		if(time() - $download_time > 60 * 60 * 24 * 365) { // one year
			//print('update file<br />');
			$download_file = true;
		} else {
			//print('do not update file<br />');
			$contents = file_get_contents($local_path); // local
		}
	} else {
		//print('file does not exist<br />');
		$download_file = true;
	}
	if($download_file) {
		//print('download file<br />');
		$contents = file_get_contents($download_path); // remote
		if(strlen($contents) == 0) {
			$download_path = $download_path . $last_path;
			$contents = file_get_contents($download_path);
		}
		$this->downloaded_file = true;
		//print('downloaded file<br />');
	}
	$initial_contents = $contents;
	$file_type = substr(life::file_extension($local_path), 1);
	$contents = life::digest($contents, $file_type, $download_path);
	//if(strpos($local_path, 'light') !== false) { // debug
	//	print('light $local_path, $contents: ');var_dump($local_path, $contents);exit(0);
	//}
	//print('$download_path, $contents, $file_type in download: ');var_dump($download_path, $contents, $file_type);exit(0);
	/*if($contents !== $initial_contents) {	
		//$new_path = $local_path;
		//print('$new_path: ');var_dump($new_path);
		//life::mkdir_to_root(life::query_encode_filename($new_path));
		life::mkdir_to_root($local_path);
		file_put_contents($local_path, $contents);
		//$put_result = file_put_contents(life::queryless($local_path), $contents); // debug
		//print('$put_result: ');var_dump($put_result);
	}*/
	return $contents;
}

function local_path($path) {
	if(substr($path, 0, 6) === 'cache/') { // keep it as is
		return $path;
	}
	$protocol_end_limiter_position = strpos($path, '://');
	if($protocol_end_limiter_position === false) {
		$local_relative_path = $path;
	} else {
		//$local_relative_path = life::filename_encode(substr($path, strpos($path, '://') + 3));
		$local_relative_path = substr($path, $protocol_end_limiter_position + 3);
		if(strlen($local_relative_path) === 0) {
			print('$local_relative_path: ');var_dump($local_relative_path);
			life::fatal_error('cannot have an empty $local_relative_path');
		}
		if($local_relative_path[strlen($local_relative_path) - 1] === '/') {
			// just default to index.html (since it's a webserver) although variations like index.php or index.asp or home.htm or default.html will have to eventually be handled.
			$local_relative_path .= 'index.html';
			//if() {
			//	
			//} else {
			//	print('$local_relative_path: ');var_dump($local_relative_path);
			//	life::fatal_error('cannot end $local_relative_path with / (and thus have an empty filename)');
			//}
		}
	}
	//print('$local_relative_path: ');var_dump($local_relative_path);
	return 'cache' . DS . $local_relative_path;
}

function browse() {
	if($_REQUEST['path'] == '') {
		print('Path not properly specified.<br>');
	} else {
		$this->browse_path = life::query_decode($_REQUEST['path']);
		$this->last_browse_path = life::query_decode($_REQUEST['last_path']);
		$this->contents = life::get_contents($this->browse_path, $this->last_browse_path);
		//print('$path, $last_path, $this->contents: ');var_dump($path, $last_path, $this->contents);exit(0);
		$this->contents = life::digest($this->contents);
		$up_one_level_path = life::up_one_level_path($this->browse_path);
		if($up_one_level_path !== false) {
			$this->contents = life::append($this->contents, '<a href="do.php?action=browse&path=' . life::query_encode($up_one_level_path) . '&last_path=' . life::query_encode($this->browse_path) . '">Up one level</a>');
		}
		print($this->contents);
	}
	// advantages of using last_path (last_browse_path) instead of http referrer?
}

function append($code, $string) {
	$code = str_replace('</body>', $string . '</body>', $code);
	return $code;
}

function up_one_level_path($path) {
	$offset = strlen($path) - 1;
	$found_last_slash = false;
	while($offset > -1) {
		if($found_last_slash) {
			if($path[$offset] === '/') {
				return substr($path, 0, $offset);
			}
		} elseif($path[$offset] === '/') { // assume we only care about remote content and thus only foreward slash path separators
			$found_last_slash = true;
			if($path[$offset - 1] === '/') {
				return false;
			}
		}
		$offset--;
	}
}

function site_root_from_path($path) {
	//print('$path in site_root_from_path: ');var_dump($path);
	if(substr($path, 0, 6) === 'cache/') {
		//print('site root case 1<br />');
		return substr($path, 6, strpos($path, '/', 6) - 6); // :O
	} elseif(strpos($path, '://') === false) {
		//print('site root case 2<br />');
		if(strpos($path, '/') === false) {
			print('site root case 2.1<br />');
			return $path;
		} else {
			print('site root case 2.2<br />');
			return substr($path, 0, strpos($path, '/'));
		}
		//print('$path, $last_path: ');var_dump($path, $last_path);
		//life::fatal_error('not sure how to calculate site root from these');
	}
	//print('DS, substr_count($path, DS): ');var_dump(DS, substr_count($path, DS));
	//if(substr_count($path, DS) < 3) {
	 elseif(substr_count($path, '/') < 3) { // remote (sites) always uses foreward slash as opposed to unix vs windows systems
		//print('site root case 3<br />');
		$site_root = $path;
	} else {
		//print('site root case 4<br />');
		$protocol_end_limiter_position = strpos($path, '://');
		//$site_root = substr($path, 0, life::strpos_nth($path, DS, 3) + 1);
		//$site_root = substr($path, 0, life::strpos_nth($path, DS, 3)); // omit the last slash
		$site_root = substr($path, $protocol_end_limiter_position + 3, life::strpos_nth($path, '/', 3) - $protocol_end_limiter_position - 3); // omit the last slash
	}
	//print('$path, $site_root in site_root_from_path: ');var_dump($path, $site_root);
	return $site_root;
}

function digest($contents = false, $file_type = false, $path = false) {
	if($contents === false) {
		$contents = $this->contents;
	}
	if($path === false) {
		$path = $this->browse_path;
	}
	$initial_contents = $contents;
	//print('$this->initial_contents in digest: ');var_dump($this->initial_contents);
	//print('$file_type, $path in digest: ');var_dump($file_type, $path);
	
	if($file_type === false) {
		// determine file type based on contents
		if(strpos($contents, '<!DOCTYPE html') !== false) {
			$file_type = 'html';
		} elseif(strpos($contents, 'color:') !== false) {
			$file_type = 'css';
		} elseif(strpos($contents, 'function(){') !== false || strpos($contents, 'Math.random') !== false) {
			$file_type = 'js';
		} elseif(strpos($contents, '‰PNG') === 0) {
			$file_type = 'png';
		}
		// this detection could become far more sophisticated
		if($file_type === false) {
			print('$contents, $file_type: ');var_dump($contents, $file_type);
			life::fatal_error('did not determine file type in digest()');
		}
	}
	//print('$path, $file_type in digest: ');var_dump($path, $file_type);
	$site_root = life::site_root_from_path($path);
	if($file_type === 'js') {
		// could do
		//preg_match_all('/"http[^"]+"/is', $contents, $matches);
		// but for the moment do nothing since a parser is really needed to determine which resources to grab and how to modify the contents
	} elseif($file_type === 'css') {
		preg_match_all('/url\(\s*?\'([^\']*?)\'\s*?\)/is', $contents, $matches);
		//print('$matches in css in digest: ');var_dump($matches);
		foreach($matches[0] as $index => $value) {
			$path_in_code = life::filename_decode($matches[1][$index]);
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				$download_path = $path_in_code;
			} elseif($path_in_code[0] === '/') {
				$download_path = 'http://' . $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = $this->browse_path . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}
			$local_path = life::local_path($download_path);
			/*if(substr($contents, $value[1] + strlen($value[0]), 5) === '<meta') {
				continue;
			} else {*/
				life::download_if($download_path);
			//}
			$contents = str_replace($value, 'url(\'' . $local_path . '\')', $contents);
		}
	} elseif($file_type === 'html') {
		if($this->debug) {
			preg_match_all('/cache[^"]+cache/is', $contents, $matches);
			if(sizeof($matches[0]) > 0) { // debug
				print('$matches: ');var_dump($matches);
				life::fatal_error('doubly caching files is a problem');
			}
			preg_match_all('/cache[^"=]+:\/\//is', $contents, $matches);
			if(sizeof($matches[0]) > 0) { // debug
				print('$matches: ');var_dump($matches);
				life::fatal_error('protocol should not be part of the cached path');
			}
		}
		// change links to local and download remote stuff to local
		preg_match_all('/<(link|script|img)([^>]*?)\s+(href|src)=("|\')([^"\']*?)\4([^>]*?)>/is', $contents, $matches, PREG_OFFSET_CAPTURE);
		//print('link|script|img $matches: ');var_dump($matches);
		// we add metadata to these to compare against our own files (as a first step; repairing the internet)
		// IPFS would be better since it is content adressing and it's impossible to have duplicated content
		foreach($matches[0] as $index => $value) {
			// if this external content already has metadata, just leave it and assume the CRC and data checking will be written within a year!
			$path_in_code = life::filename_decode($matches[5][$index][0]);
			//print('$value, $path_in_code: ');var_dump($value, $path_in_code);
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				$download_path = $path_in_code;
			} elseif($path_in_code[0] === '/') {
				$download_path = 'http://' . $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = $this->browse_path . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}
			//$local_path = life::filename_double_encode(life::local_path($download_path));
			$local_path = life::filename_encode(life::local_path($download_path));
			//$local_path = life::local_path($download_path);
			//print('resource $local_path in digest: ');var_dump($local_path);exit(0);
		// you should do this check to avoid time-consumingly getting the contents or downloading when it's unnecessary, but at least while we are refining the digestion, just get the contents anyway
			if(!$this->debug && substr($contents, $value[1] + strlen($value[0]), 5) === '<meta') {
				print('resource metadata already exists<br />');
				continue;
			} else {
				//print('download if<br />');
				life::download_if($download_path);
			}
			$local_file_contents = file_get_contents($local_path);
			//print('start of digestion break');exit(0);
			$end_of_tag_piece = $matches[6][$index][0];
			if($end_of_tag_piece[strlen($end_of_tag_piece) - 1] === '/') {
				$offset = strlen($end_of_tag_piece) - 1;
				while($offset > -1) {
					if(!preg_match('/[\s\/]/is', $end_of_tag_piece[$offset], $self_closing_matches)) {
						break;
					}
					$offset--;
				}
				$end_of_tag_piece = substr($end_of_tag_piece, 0, $offset + 1);
			} // else it's probably implicitly treated as self-closing by browsers and we don't need to remove the ending / but still, we'll add metadata
			$contents = str_replace($value[0], '<' . $matches[1][$index][0] . $matches[2][$index][0] . ' ' . $matches[3][$index][0] . '=' . $matches[4][$index][0] . $local_path . $matches[4][$index][0] . $end_of_tag_piece . '><meta name="date_modified" content="' . time() . '" /><meta name="CRC32" content="' . life::generate_checksum($local_file_contents) . '" /></' . $matches[1][$index][0] . '>', $contents);
		}
		// hack instead of better code handling both self-closing and opening-closing tag pairs better
		$contents = str_replace('</link></link>', '</link>', $contents);
		$contents = str_replace('</script></script>', '</script>', $contents);
		$contents = str_replace('</img></img>', '</img>', $contents);
		// some scripts, e.g.
		// <script src="/includes/js/mobile.js?v=1643523584"></script>
		// are not being caught for some reason
		// will need to handle google stuff; analytics, adblocking etc.
		
		preg_match_all('/\s+style="([^"]*?)url\(\'([^\']*?)\'\)([^"]*?)"/is', $contents, $matches);
		//var_dump($matches);exit(0);
		foreach($matches[0] as $index => $value) {
			$path_in_code = life::filename_decode($matches[2][$index]);
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				$download_path = $path_in_code;
			} elseif($path_in_code[0] === '/') {
				$download_path = 'http://' . $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = $this->browse_path . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}
			$local_path = life::local_path($download_path);
			/*if(substr($contents, $value[1] + strlen($value[0]), 5) === '<meta') {
				continue;
			} else {*/
				life::download_if($download_path);
			//}
			$contents = str_replace($value, ' style="' . $matches[1][$index] . 'url(\'' . $local_path . '\')' . $matches[3][$index] . '"', $contents);
		}
		
		preg_match_all('/<(a|form)([^>]*?)\s+(href|action)=("|\')([^"\']*?)\4([^>]*?)>/is', $contents, $matches);
		//var_dump($matches);exit(0);
		foreach($matches[0] as $index => $value) {
			$path_in_code = life::filename_decode($matches[5][$index]);
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				$download_path = $path_in_code;
			} elseif($path_in_code[0] === '/') {
				$download_path = 'http://' . $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = $this->browse_path . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}
			$local_path = life::local_path($download_path);
			$contents = str_replace($value, '<' . $matches[1][$index] . $matches[2][$index] . ' ' . $matches[3][$index] . '=' . $matches[4][$index] . 'do.php?action=browse&path=' . $local_path . '&last_path=' . $this->browse_path . $matches[4][$index] . $matches[6][$index] . '>', $contents);
		}
		// other mods?
		
	}
	life::save_if(life::local_path($path), $contents, $initial_contents);
	if($file_type === 'html') {
		// warn if using proprietary or non-open source
		$open_source = true;
		if(strpos($contents, '"http') !== false) {
			$open_source = false;
		}
		if($open_source) {
			foreach($this->server_side_language_file_extensions as $file_extension) {
				if(preg_match('/' . $file_extension . '[^\w]/is', $contents, $matches)) {
					$open_source = false;
					break;
				}
			}
		}
		// icons or buttons
		if(!$open_source) {
			//$contents = str_replace('</body>', '<div style="z-index: 10; position: absolute; bottom: 50; right: 50;" title="Closed source code! Some elements may not work.">❗</div></body>', $contents);
			$contents = life::append($contents, '<div style="z-index: 10; position: absolute; bottom: 50; right: 50;" title="Closed source code! Some elements may not work.">❗</div>', $contents);
		}
	}
	return $contents;
	//return array();
}

function generate_checksum($string) {
	//$i = crc32('1');
	$i = crc32($string);
	//printf("%u\n", $i);
	if(0 > $i)	{
		// Implicitly casts i as float, and corrects this sign.
		$i += 0x100000000;
	}
	return $i;
}

function save_if($path, $contents = false, $initial_contents = false) {
	if($contents === false) {
		$contents = $this->contents;
	}
	if($initial_contents === false) {
		$initial_contents = $this->initial_contents;
	}
	//print('$path in save_if(): ');var_dump($path);
	if($contents !== $initial_contents) {
		//print('$path, $contents before save in save_if: ');var_dump($path, $contents);exit(0);
		return life::save($path, $contents);
		//print('saved because of new contents in save_if()<br />');
	} elseif(!file_exists($path)) {
		return life::save($path, $contents);
		//print('saved because of new file in save_if()<br />');
	}/* else {
		print('did not save in save_if()<br />');
	}*/
	//exit(0);
	return false;
}

function save($path, $contents) {
	life::mkdir_to_root($path);
	return file_put_contents(life::filename_encode($path), $contents);
	//file_put_contents($path, $contents);
}

function mkdir_to_root($path) {
	return life::build_directory_structure_for($path);
}

function build_directory_structure_for($filename) {
	//print('$filename in build_directory_structure_for: ');var_dump($filename);
	$folders = explode(DS, $filename);
	//print('$folders in build_directory_structure_for: ');var_dump($folders);
	$folder_string = '';
	foreach($folders as $index => $folder_name) {
		//print('$folder_string in build_directory_structure_for: ');var_dump($folder_string);
		if($index === sizeof($folders) - 1) {
			break;
		}
		$folder_string .= $folder_name . DS;
		if(!is_dir($folder_string)) {
			mkdir($folder_string);
		}
	}
}

function strpos_nth($haystack, $needle, $n) {
	//print('uh here00z002<br />');
	//print('$haystack, $needle, $n in strpos_nth: ');var_dump($haystack, $needle, $n);
	$counter = 0;
	//$substr = $haystack;
	while($counter < $n) {
		$strpos = strpos($haystack, $needle, $strpos + 1);
		//print('$strpos in strpos_nth: ');var_dump($strpos);
		//$substr = substr($haystack, $strpos + 1);
		$counter++;
	}
	return $strpos;
}

function recursiveChmod($path, $filePerm=0644, $dirPerm=0755) {
	// Check if the path exists
	if(!file_exists($path)) {
		return(false);
	}
	// See whether this is a file
	if(is_file($path)) {
		// Chmod the file with our given filepermissions
		chmod($path, $filePerm);
	} elseif(is_dir($path)) { // If this is a directory...
		// Then get an array of the contents
		$foldersAndFiles = scandir($path);
		// Remove "." and ".." from the list
		$entries = array_slice($foldersAndFiles, 2);
		// Parse every result...
		foreach($entries as $entry) {
			// And call this function again recursively, with the same permissions
			if(is_dir($path . '\\' . $entry)) {
				life::recursiveChmod($path . '\\' . $entry, $filePerm, $dirPerm);
			} else {
				chmod($path . '\\' . $entry, $dirPerm);
			}
		}
		// When we are done with the contents of the directory, we chmod the directory itself
		chmod($path, $dirPerm);
	}
	// Everything seemed to work out well, return true
	return(true);
}

function filename_minus_extension($string) {
	return substr($string, 0, life::strpos_last($string, '.'));
}

function extension($string) { // alias
	return life::file_extension($string);
}

function file_extension($string) {
	$last_dot_position = life::strpos_last($string, '.');
	if($last_dot_position === false || $last_dot_position < life::strpos_last($string, '/') || $last_dot_position < life::strpos_last($string, '\\')) {
		return false;
	}
	$last_question_position = life::strpos_last($string, '?');
	if($last_question_position === false) {
		$last_question_position = life::strpos_last($string, '9o9quest9o9');
	}
	if($last_question_position === false) {
		return substr($string, $last_dot_position);
	} elseif($last_question_position < $last_dot_position) { // this is pretty wacky
		print('$string, $last_question_position, $last_dot_position: ');var_dump($string, $last_question_position, $last_dot_position);
		life::fatal_error('not sure how to calculate file_extension from these');
		return false;
	} else {
		return substr($string, $last_dot_position, $last_question_position - $last_dot_position);
	}
}

public function strpos_last($haystack, $needle) {
	//print('$haystack, $needle: ');var_dump($haystack, $needle);
	if(strlen($needle) === 0) {
		return false;
	}
	$len_haystack = strlen($haystack);
	$len_needle = strlen($needle);		
	$pos = strpos(strrev($haystack), strrev($needle));
	if($pos === false) {
		return false;
	}
	return $len_haystack - $pos - $len_needle;
}

function queryless($string) {
	$query_position = strpos($string, '?');
	if($query_position !== false) {
		if(strpos($string, '/', $query_position + 1) !== false) {
			print('$string, $query_position: ');var_dump($string, $query_position);
			life::fatal_error('/ detected after ? in queryless(); not sure how to proceed');
		} else { // clip the query
			$string = substr($string, 0, $query_position);
		}
	}
	return $string;
}

function filename_double_encode($string) {
	//var_dump(urlencode('&'));exit(0);
	$string = str_replace('?', '%3f', $string);
	// ---
	$string = str_replace('%', '%25', $string);
	return $string;
}

function filename_encode($string) {
	//var_dump(urlencode('&'));exit(0);
	//$string = str_replace('?', '%3f', $string);
	//$string = str_replace('?', '&#63;', $string);
	$string = str_replace('?', '9o9quest9o9', $string);
	// could just use htmlentities() if this works and there is the need for more than encoding of ?
	// unfortunately seems like we have to invent our own encoding since url decoding and html entity decoding are automatic in places
	return $string;
}

function filename_decode($string) {
	//$string = str_replace('%3f', '?', $string);
	//$string = str_replace('&#63;', '?', $string);
	$string = str_replace('9o9quest9o9', '?', $string);
	// could just use html_entity_decode() if this works and there is the need for more than decoding of ?
	// unfortunately seems like we have to invent our own encoding since url decoding and html entity decoding are automatic in places
	return $string;
}

function query_encode($string) {
	//var_dump(urlencode('&'));exit(0);
	$string = str_replace('&', '%26', $string);
	return $string;
}

function query_decode($string) {
	$string = str_replace('%26', '&', $string);
	return $string;
}

// does not handle / vs \ use for windows or unix systems
//function shortpath($string) {
//	return substr($string, life::strpos_last($string, DS));
//}

function preg_search_escape($string) { // alias
	return life::preg_escape($string);
}

function preg_escape($string) {
	return str_replace('/', '\/', preg_quote($string));
}

function preg_replace_escape($string) { // alias
	return life::preg_escape_replacement($string);
}

function preg_replacement_escape($string) { // alias
	return life::preg_escape_replacement($string);
}

function preg_escape_replacement($string) {
	$string = str_replace('$', '\$', $string);
	$string = str_replace('{', '\{', $string);
	$string = str_replace('}', '\}', $string);
	return $string;
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
		life::warning($string);
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

}

?>