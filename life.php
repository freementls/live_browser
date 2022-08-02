<?php

// will us fs to make differential copies of files
// will use fractal_zip to only keep changed data at an in-file level rather than keeping a whole file with only few changes
// will use sweeper to clean files to make them easier to process (the internet's a wild place)

class life {

function __construct() {
	//define(DS, DIRECTORY_SEPARATOR);
// 	if(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
// 		//echo 'This is a server using Windows!';
 		define('DS', '/');
// 	} else {
// 		//echo 'This is a server not using Windows!';
// 		define('DS', '\\');
//	}
	// foreslash seems to work for linux too!
	
	$this->action = life::query_decode($_REQUEST['action']);
	life::set_user_agents();
	$this->request_counter = 100; // initialization: over 10 is set to switch user agent by increment_user_agent();
	life::increment_user_agent();
	$this->scheme = life::default_scheme($_REQUEST['path']);
//	header_remove(); // Caution This function will remove all headers set by PHP, including cookies, session and the X-Powered-By headers. https://www.php.net/manual/en/function.header-remove.php
	//header_remove(); // doing it twice changes nothing
	//header('Dnt: 1');
//	header('User-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36');
//	header('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
//	header('Content-Encoding: gzip, deflate, br');
//	header('Accept-language: en-US,en;q=0.9');
//	header('Upgrade-insecure-requests: 1');
//	header('Referrer: https://duckduckgo.com/?q=life&t=h_'); // could rotate this too. it would be natural when scraping for the referrer to be of the same domain, and specifically a file the was visited to get the link
//	header('Sec-fetch-site: none');
//	header('Sec-fetch-mode: navigate');
//	header('Sec-fetch-user: ?1');
//	header('Sec-fetch-dest: document');
	//header('Accept-language: en-GB,en-US;q=0.9,en;q=0.8');
	//header('User-agent: some shit');
	//print('headers_list(): ');var_dump(headers_list());exit(0);
	//print('get_headers(\'.\', true): ');var_dump(get_headers('.', true));
	//print('stream_context_get_default(), stream_context_get_options(), stream_context_get_params(): ');var_dump(stream_context_get_default(), stream_context_get_options(), stream_context_get_params());
	//print('$_SERVER: ');var_dump($_SERVER);
	
	life::set_markup_languages();
	life::set_server_side_languages();
	life::set_robot_behavior();
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

function increment_user_agent() {
	if($this->request_counter > 10) { // rotate user agent
		$this->user_agent = life::random_user_agent();
		header('User-agent: ' . $this->user_agent); // probably won't work since headers cannot be changed after content is written to the page but worth a try. could collect the messages and print them all out later if needed.
		$this->request_counter = 0;
	} else {
		$this->request_counter++;
	}
	return true;
}

function get_user_agent() {
	life::increment_user_agent();
	return $this->user_agent;
}

function get_context_stream() { // alias
	return life::get_stream_context();
}

function get_stream_context() {
	$opts = array(
		'http' => array(
			'method' => 'GET',
//			'header' => 'Dnt: 1',
//'Upgrade-insecure-requests: 1
//User-agent: ' . life::get_user_agent() . '
//Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9
//Sec-fetch-site: none
//Sec-fetch-mode: navigate
//Sec-fetch-user: ?1
//Sec-fetch-dest: document
//Accept-language: en-GB,en-US;q=0.9,en;q=0.8')
			//'header' => array('Dnt: 1',
			//'Upgrade-insecure-requests: 1',
			//'User-agent: ' . life::get_user_agent(),
			//'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
			//'Sec-fetch-site: none',
			//'Sec-fetch-mode: navigate',
			//'Sec-fetch-user: ?1',
			//'Sec-fetch-dest: document',
			//'Accept-language: en-GB,en-US;q=0.9,en;q=0.8')*/
			'header' => array()
		)
	);
	
	//header('User-agent: Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36');
	//header('Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9');
	//header('Content-Encoding: gzip, deflate, br');
	//header('Accept-language: en-US,en;q=0.9');
	//header('Upgrade-insecure-requests: 1');
	//header('Referrer: https://duckduckgo.com/?q=life&t=h_'); // could rotate this too. it would be natural when scraping for the referrer to be of the same domain, and specifically a file the was visited to get the link
	//header('Sec-fetch-site: none');
	//header('Sec-fetch-mode: navigate');
	//header('Sec-fetch-user: ?1');
	//header('Sec-fetch-dest: document');
	
	$context = stream_context_create($opts);
	//print('$opts, $context: ');var_dump($opts, $context);exit(0);
	return NULL; // uh.... it could very well be that anti-bot measures don't like the stream context or method get at all!
	return $context;
}

function set_user_agents() {
	$this->user_agents = array(
	// http://useragentstring.com/
	'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/99.0.4844.51 Safari/537.36',
	'Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)',
	'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0; Avant Browser; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)',
	//'Mozilla/5.0 (Macintosh; U; PPC Mac OS X Mach-O; XH; rv:8.578.498) fr, Gecko/20121021 Camino/8.723+ (Firefox compatible)',
	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36',
	'Mozilla/5.0 (compatible; MSIE 8.0; Windows NT 6.0; SV1; Crazy Browser 9.0.04)',
	'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.102 Safari/537.36 Edge/18.19582',
	'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:77.0) Gecko/20190101 Firefox/77.0',
	'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; en-US) AppleWebKit/534.7 (KHTML, like Gecko) Flock/3.5.3.4628 Chrome/7.0.517.450 Safari/534.7',
	'Mozilla/5.0 (Windows NT 6.1; WOW64; Trident/7.0; AS; rv:11.0) like Gecko',
	//'Mozilla/5.0 (X11; Linux x86_64; rv:17.0) Gecko/20121202 Firefox/17.0 Iceweasel/17.0.1',
	'Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US) AppleWebKit/533.1 (KHTML, like Gecko) Maxthon/3.0.8.2 Safari/533.1',
	//'Mozilla/5.0 (Windows; U; Win 9x 4.90; SG; rv:1.9.2.4) Gecko/20101104 Netscape/9.1.0285',
	'Opera/9.80 (X11; Linux i686; Ubuntu/14.10) Presto/2.12.388 Version/12.16.2',
	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:25.6) Gecko/20150723 Firefox/31.9 PaleMoon/25.6.0',
	'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_3) AppleWebKit/537.75.14 (KHTML, like Gecko) Version/7.0.3 Safari/7046A194A',
	);
}

function random_user_agent() {
	return $this->user_agents[rand(0, sizeof($this->user_agents) - 1)];
}

function unparse_url($parsed_url) { // may never use, but helpful reference
	$protocol   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : $this->scheme . '://';
	$host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
	$port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
	$user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
	$pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
	$pass     = ($user || $pass) ? "$pass@" : '';
	$path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
	$query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
	$fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';
	return "$protocol$user$pass$host$port$path$query$fragment";
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
	//$this->server_side_language_file_extensions = array('.avfp', '.asp', '.aspx', '.cshtml', '.vbhtml', '.cfm', '.go', '.gs', '.php', '.hs', '.jsp', '.do', '.ssjs', /*'.js', */'.lasso', '.lp', '.op', '.lua', '.p', '.cgi', '.ipl', '.pl', '.php', '.php3', '.php4', '.phtml', '.py', '.rhtml', '.rb', '.rbw', '.tcl', '.dna', '.tpl', '.r', '.w');
	$this->server_side_language_file_extensions = array('avfp', 'asp', 'aspx', 'cshtml', 'vbhtml', 'cfm', 'go', 'gs', 'php', 'hs', 'jsp', 'do', 'ssjs', /*'js', */'lasso', 'lp', 'op', 'lua', 'p', 'cgi', 'ipl', 'pl', 'php', 'php3', 'php4', 'phtml', 'py', 'rhtml', 'rb', 'rbw', 'tcl', 'dna', 'tpl', 'r', 'w');
	return true;
}

function set_markup_languages() {
	$this->markup_language_file_extensions = array('htm', 'html', 'shtml', 'xml');
	return true;
}

function set_robot_behavior() {
	// for robots.txt
	if($this->debug) {
		life::warning_once('hard-coded robots.txt instead of downloading robots.txt and handling it');
	}
	$this->paths_disallowed_to_robots = array(
		'/nam/hopi/toth/huruing.cgi',
		'/cdshop/cdcat.htm',
		'/tarot/pkt/tarot0.htm',
		'/tarot/pkt/tarot0f.htm',
		'/tarot/pkt/tarot1.htm',
		'/tarot/pkt/tarot1f.htm',
	);
	return true;
}

function file_type_from_extension($path) { // alias
	return life::file_type_by_extension($path);
}

function file_type_by_extension($path) {
	//print('$path, life::file_extension($path) in file_type_by_extension: ');var_dump($path, life::file_extension($path));
	//$file_extension_of_path = life::file_extension($path);
	$extension_result = life::file_extension($path);
	//print('$extension_result in file_type_by_extension(): '); var_dump($extension_result);
	//if($file_extension_of_path == false) {
	//	return true;
	//}
//	$extension_result = substr($file_extension_of_path, 1);
	if($this->debug) {
		life::warning_once('forcing extensions when probably shouldn\'t be');
		print('questionable extension: ');var_dump($extension_result);
		if(strpos($extension_result, '-') !== false) {
			print('dash in extension' . PHP_EOL);
			return true;
		}
		if(strlen($extension_result) > 10) {
			print('extension too long' . PHP_EOL);
			return true;
		}
	}
	if($extension_result === false) {
		return true;
	} elseif($extension_result === 'cur') {
		$file_type = 'ico';
	} elseif($extension_result === 'webmanifest') {
		$file_type = 'json';
	} elseif($extension_result === 'tif') {
		$file_type = 'tiff';
	} elseif($extension_result === 'apng') {
		$file_type = 'png';
	} elseif($extension_result === 'jpeg' || $extension_result === 'jfif' || $extension_result === 'pjpeg' || $extension_result === 'pjp') {
		$file_type = 'jpg';
	} elseif($extension_result === 'cgi') {
		//$file_type = true; // could be anything... sometimes cgi files make images
		$file_type = 'gif';
	} elseif($extension_result === 'php') {
		$file_type = true; // php can be html or rss or anything else
	} elseif($extension_result === 'php' || $extension_result === 'asp' || $extension_result === 'htm' || $extension_result === 'jsp') {
		$file_type = 'html';
	} else {
		$file_type = $extension_result;
	}
	return $file_type;
}

function has_web_extension($path) {
	return life::web_extension(life::extension($path));
}

function is_web_extension($extension) { // alias
	return life::web_extension($extension);
}

function web_extension($extension) {
	//$this->server_side_language_file_extensions
	$web_extensions = array_merge($this->server_side_language_file_extensions, $this->markup_language_file_extensions);
	foreach($web_extensions as $web_extension) {
		if($web_extension === $extension) {
			return true;
		}
	}
	return false;
}

function generate_sitemap() {
	/*<?xml version="1.0" encoding="UTF-8"?>
	<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
	<url>
		<loc>http://www.example.com/foo.html</loc>
		<lastmod>2018-06-04</lastmod>
	</url>
	</urlset>*/
	//print('gs001<br />' . PHP_EOL);
	$path = $_REQUEST['path'];
	$site_root = $_REQUEST['site_root'];
	//print('gs002<br />' . PHP_EOL);
	$sitemap_contents = '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
';
	/*$handle = opendir($path);
	while(($entry = readdir($handle)) !== false) {
		if(life::has_web_extension($path . '/' . $entry)) {
			$sitemap_contents .= '<url>
	<loc>http://www.example.com/foo.html</loc>
	<lastmod>' . filemtime($path . '/' . $entry) . '</lastmod>
</url>';
		}
	}
	closedir($handle);*/
	life::recursive_file_list_to_array($path);
	foreach($this->files as $file) {
		if(life::has_web_extension($file)) {
			$sitemap_contents .= '<url>
	<loc>' . str_replace($path, $site_root, $file) . '</loc>
	<lastmod>' . date('Y-m-d', filemtime($file)) . '</lastmod>
</url>
';
		}
	}
	//print('gs003<br />' . PHP_EOL);
	$sitemap_contents .= '</urlset>';
	print('$sitemap_contents: ');var_dump($sitemap_contents);exit(0);
	//print('gs004<br />' . PHP_EOL);
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
				life::recursive_file_list_to_array($Entry);
				continue;
			} else {
				//print($Entry . "\r\n<br />");
				$this->files[] = $Entry;
				$this->file_counter++;
			}
		}
		$d->close();
	}
}

function scrape_file($path) {
	$this->current_path = life::query_decode($path);
	//print('$this->current_path, $this->last_path in scrape1: ');var_dump($this->current_path, $this->last_path);
	//print('scrape05<br />');
	$this->domain = life::domain($this->current_path);
	//print('$this->domain in scrape1.5: ');var_dump($this->domain);exit(0);
	//print('scrape06<br />');exit(0);
	if(substr($this->current_path, 0, 2) === '//') {
		$this->current_path = life::default_scheme($this->current_path) . $this->current_path;
	}
	$this->scheme = life::scheme($this->current_path, $this->contents);
	//print('scrape07<br />');exit(0);
	//$headers = get_headers($this->current_path);print('$headers: ');var_dump($headers); // debug
	$this->contents = life::get_contents($this->current_path, $this->last_path);
	//print('$this->contents in scrape1.6: ');var_dump($this->contents);
	//print('$this->current_path, $this->last_path, $this->contents in scrape2: ');var_dump($this->current_path, $this->last_path, $this->contents);exit(0);
	life::digest($this->contents, life::file_type_from_contents($this->contents), $this->current_path, $this->last_path, 'scrape');
	$this->last_path = $this->current_path;
}

function scrape() {
	if($_REQUEST['path'] == '') {
		print('Path not properly specified in scrape.<br />');
	} else {
		// https://www.scrapehero.com/how-to-prevent-getting-blacklisted-while-scraping/
		//print('scrape01<br />');
		$this->files_to_scrape = array();
		//print('scrape02<br />');
		$this->files_scraped = array();
		//print('scrape03<br />');
		//print('scrape04<br />');
		$this->last_path = life::query_decode($_REQUEST['last_path']);
		life::scrape_file($_REQUEST['path']);
		// clean up the files array
		/*foreach($this->files_to_scrape as $file_to_scrape => $scrape) {
			if($scrape || $this->domain === life::domain($file_to_parse)) { // only download from the same domain otherwise it could download the internet ...although... it should be noted that having centralized domains is what we're eschewing
				$this->files_to_scrape[$file_to_scrape] = true;
			} else {
				unset($this->files_to_scrape[$index]);
			}
		}*/
		//$this->files_to_scrape = array(life::absolutize_path('totosms.gif') => true); // debug
		//$this->files_to_scrape = array('http://www.pocketgamer.info/images/get_stone.gif' => true); // debug
		//$this->files_to_scrape = array('http://www.pocketgamer.info/manifest.json' => true); // debug
		//print('$this->action, $this->files_to_scrape before while loop: ');var_dump($this->action, $this->files_to_scrape);//exit(0);
		while(sizeof($this->files_to_scrape) > 0) {
			$random_key = array_rand($this->files_to_scrape);
			life::scrape_file($random_key);
			//print('scraped ' . $random_key . '<br />' . PHP_EOL);
			unset($this->files_to_scrape[$random_key]);
			$this->files_scraped[$random_key] = true;
			//$this->files_to_scrape = life::reindex($this->files_to_scrape); // would maybe like to sleep while reindexing since it could take significant time
			//sleep(rand(250, 1250) / 1000);
		//	usleep(rand(250000, 1250000));
		//	usleep(rand(250000, 12500000)); // longer for picky sites?
			//print('$this->files_to_scrape at end of while loop: ');var_dump($this->files_to_scrape);
			//if($this->debug && $this->debug_counter > 100) {
			//	life::fatal_error('$this->debug_counter > 100');
			//}
			$this->debug_counter++;
		}
		// respect robots.txt?
		// + randomize file download order
		// \ delay between downloads
		// \ nofollow tag. CSS style display:none. color disguised to blend in with the page’s background color?
		// make sure javascript runs... eventually
		// randomized Mouse Movement, Clicks, Scrolls, Tab Changes?
		// proxy? would make more sense with user agent rotating
	}
}

function reindex($array) {
	return array_values($array);
}

function normalize_URL($URL) {
	// consider using prase_url if this function gets more complicated
	$URL = str_replace('view-source:', '', $URL);
	if(strpos($URL, 'http') === false && strpos($URL, '://') === false) {
		$URL = 'http://' . $URL;
	}
	return $URL;
}

function parsed_url($path) { // alias
	return parse_url($path);
}

function normalize($path) { // alias
	return life::normalize_path($path);
}

function normalize_path($path) {
	// consider using prase_url if this function gets more complicated
	$path = str_replace('
', '', $path); // line breaks
	if(strpos($path, '#') !== false) {
		$path = substr($path, 0, strpos($path, '#'));
	}
	return $path;
}

function absolutize($path) { // alias
	return life::absolutize_path($path);
}

function absolutize_path($path, $last_path = false, $do_not_add_default_page = false) {
	//life::warning_once('should use realpath or parse_url');
	//print('ap000<br />' . PHP_EOL);
	//$debug_break_at_end_of_function = false;
	//if(strpos($path, 'fire/index') !== false/* || strpos($path, 'circularDNA') !== false*/) {
	//	$initial_path = $path;
	//	$debug_break_at_end_of_function = true;
	//}
	if($last_path === false) {
		$last_path = $this->last_path;
	}
	//print('$path, $this->current_path, $last_path at start of absolutize_path: ');var_dump($path, $this->current_path, $last_path);
	//if(strpos($path, 'cache/') !== false) {
	//	print('$path, $last_path, $download_time in absolutize_path(): ');var_dump($path, $last_path, $download_time);
	//	life::fatal_error('should never be passed a download path with cache; fix where it is coming from');
	//}
	//print('$path, substr($path, 0, 2) in absolutize_path() 01: ');var_dump($path, substr($path, 0, 2));
	//print('ap001<br />' . PHP_EOL);
	if(strpos($path, '/') === false && strpos($path, '.') === false) {
		$path = $path . '/';
	}
	//print('ap002<br />' . PHP_EOL);
	if(strpos($path, '://') === false && strpos($last_path, '://') === false) {
		$best_path = $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	} else {
		$best_path = $path;
	}
	if(strlen($this->current_path) > 0) {
		$best_path = $this->current_path;
	}
	if(strlen($this->last_path) > 0) {
		if(strpos($this->current_path, '://') === false && strpos($last_path, '://') !== false) {
		//if(strpos($last_path, '://') !== false) {
			$best_path = $last_path;
		}
	}
	if(strpos($best_path, '://') === false) {
		$best_path = $this->scheme . '://' . $best_path;
	}
	//print('$best_path: ' . $best_path . '<br />' . PHP_EOL);
	//print('ap003<br />' . PHP_EOL);
	if(substr($path, 0, 2) === './') {
		//print('ap004<br />' . PHP_EOL);
		$path = life::site_root_from_path($best_path) . substr($path, 1);
		//print('$path in absolutize_path() 01.1: ');var_dump($path);
	} elseif(substr($path, 0, 2) === '//') {
		//print('ap005<br />' . PHP_EOL);
		$path = $this->scheme . ':' . $path;
		//print('$path in absolutize_path() 01.2: ');var_dump($path);
	} elseif(substr($path, 0, 6) === 'cache/') {
		//print('ap006<br />' . PHP_EOL);
		$path = $this->scheme . '://' . substr($path, 6);
		//print('$path in absolutize_path() 01.3: ');var_dump($path);
	} elseif(strpos($path, '://') === false) {
		//print('ap007<br />' . PHP_EOL);
		//$path = str_replace('//', '/', $path);
		//print('$path, $last_path in absolutize_path() 01.4: ');var_dump($path, $last_path);
		/*if(strpos($this->current_path, '://') === false) {
			if(strpos($path, '/') === false && strpos($path, '.') === false) {
				$path = life::site_root_from_path($last_path) . $path . '/';
			} elseif($path[0] === '/') {
				$path = life::site_root_from_path($last_path) . substr($path, 1);
				//$path = life::site_root_from_path($last_path) . $path;
				//print('$path in absolutize_path() 01.4.1: ');var_dump($path);
			} else {
				$path = life::fileless_path($last_path) . $path;
				//print('$path in absolutize_path() 01.4.2: ');var_dump($path);
			}
		} else {*/
			/*if(strpos($path, '/') === false && strpos($path, '.') === false) {
				$path = life::site_root_from_path($this->current_path) . $path . '/';
			} else*/if($path[0] === '/') {
				//print('ap008<br />' . PHP_EOL);
				$path = life::site_root_from_path($best_path) . substr($path, 1);
				//$path = life::site_root_from_path($last_path) . $path;
				//print('$path in absolutize_path() 01.4.1: ');var_dump($path);
			} elseif(strpos($path, '.') !== false) {
				//print('ap008.5<br />' . PHP_EOL);
				//print('$this->current_path, $path before root and rootless processing in absolutize_path: ');var_dump($this->current_path, $path);
				//$path = life::fileless($best_path) . '/' . $path;
				if(strpos($path, '../') === 0) { // leave it to have its commands processed?
					//print('ap008.6<br />' . PHP_EOL);
					$path = life::fileless($best_path) . '/' . $path;
				} else {
					//print('ap008.7<br />' . PHP_EOL);
					$path = life::site_root_from_path($best_path) . '/' . life::rootless($path);
				}
				//print('$path after root and rootless processing in absolutize_path: ');var_dump($path);
			} else {
				//print('ap009<br />' . PHP_EOL);
				$path = life::site_root_from_path($best_path) . life::path_by_parsing($path);
				//print('$path in absolutize_path() 01.4.2: ');var_dump($path);
			}
		//}
	}
	//print('ap010<br />' . PHP_EOL);
	if(!$do_not_add_default_page) {
		if($path[strlen($path) - 1] === '/') {
			//print('ap011<br />' . PHP_EOL);
			$path .= life::default_page($path, $this->contents);
			//print('$path in absolutize_path() 04.3: ');var_dump($path);
		}
		//print('ap011.5 parse_url($path): ');var_dump(parse_url($path));//exit(0);
		$parsed_url = parse_url($path);
		//print('absolutize_path $path, $parsed_url: ');var_dump($path, $parsed_url);
		if(!isset($parsed_url['path'])) {
			//print('ap011.7<br />' . PHP_EOL);
			$path .= '/' . life::default_page($path, $this->contents);
			//print('$path in absolutize_path() 04.4: ');var_dump($path);
		}
	}
	//print('ap012<br />' . PHP_EOL);
	//print('$path before processing commands: ');var_dump($path);
	//$path = realpath($path);
	$protocol_position = strpos($path, '://');
	$protocol = substr($path, 0, $protocol_position + 3);
	$protocolless_path = substr($path, $protocol_position + 3);
	$protocolless_path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $protocolless_path);
	$parts = array_filter(explode(DIRECTORY_SEPARATOR, $protocolless_path), 'strlen');
	$absolutes = array();
	foreach ($parts as $part) {
		if ('.' == $part) continue;
		if ('..' == $part) {
			array_pop($absolutes);
		} else {
			$absolutes[] = $part;
		}
	}
	$protocolless_path = implode(DIRECTORY_SEPARATOR, $absolutes);
	$path = $protocol . $protocolless_path;
	//print('ap013<br />' . PHP_EOL);
	//print('$path after processing commands: ');var_dump($path);

	// would probably also like to resolve the up one level '..' commands otherwise they'll accumulate!
	// too crude? probably not.
	/****$path = str_replace('/./', '/', $path);
	//print('$path in absolutize_path() 02: ');var_dump($path);
	while(strpos($path, '../') !== false) {
		//$path = preg_replace('/\.\.\/[^\.\/]+\//is', '', $path); // nope! that would be down one level which isn't what .. means!
		$path = preg_replace('/[^\.\/]+\/\.\.\//is', '', $path);
	}
	//print('$path in absolutize_path() 03: ');var_dump($path);
	// ugly hack
	$domain = life::domain($path, $last_path);
	$path = str_replace($domain . '/' . $domain, $domain, $path);
	//print('$path in absolutize_path() 04: ');var_dump($path);
	if(substr($path, 0, 2) === './') {
		$path = substr($path, 2);
		//print('$path in absolutize_path() 04.1: ');var_dump($path);
	}****/
	//if(life::file_extension($path) === false && $path[strlen($path) - 1] !== '/') { // add the slash since it's a directory and not a file
	//	$path .= '/';
	//	//print('$path in absolutize_path() 04.2: ');var_dump($path);
	//}
	// the above is not strictly speaking true. you can have an extensionless file, and probably a folder without an ending / web developers can be tricky!
	//if($path[strlen($path) - 1] === '/') {
	//	$path .= life::default_page($path, $this->contents);
	//	//print('$path in absolutize_path() 04.3: ');var_dump($path);
	//}
	//if($this->debug) {
		if($path[0] === '/') {
			print('$path, $last_path: ');var_dump($path, $last_path);
			life::fatal_error('should never be getting a relative path out of absolutize_path');
		}
		if(strpos($path, 'cache/') === 0) {
			print('$path, $last_path: ');var_dump($path, $last_path);
			life::fatal_error('should never be getting a local cache path out of absolutize_path');
		}
		if(strpos($path, 'scrape/') === 0) {
			print('$path, $last_path: ');var_dump($path, $last_path);
			life::fatal_error('should never be getting a local scrape path out of absolutize_path');
		}
	//}
	//print('$path at end of absolutize_path: ');var_dump($path);
	//if($debug_break_at_end_of_function) {
	//	print('$debug_break_at_end_of_function (absolutize_path) $initial_path, $path: ');var_dump($initial_path, $path);exit(0);
	//}
	return $path;
}

function ensure_scheme($path) {
	if(strpos($path, '://') === false) {
		$path = $this->scheme . '://' . $path;
	}
	return $path;
}

function get_contents($path, $last_path = false, $download_time = false) {
	if(substr($path, 0, 2) === '//') {
		$path = life::default_scheme($path) . ':' . $path;
	}
	$contents = life::download_if($path, $last_path, $download_time);
	//print('$path, $contents in get_contents(): ');var_dump($path, $contents);exit(0);
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

function download_if($download_path = false, $last_path = false, $download_time = false/*, $mode = false*/) {
	// ideally, we would simply check the metadata of a file, say an image, to see if it has been updated instead of wastefully downloading when 
	// unnecessary or missing an updated file due to caching. the internet is not structured this way... YET! IPFS
	//print('$download_path, $last_path, $download_time at start of download_if(): ');var_dump($download_path, $last_path, $download_time);
	if($download_path === false) {
		$download_path = $this->current_path;
	}
	if($last_path === false) {
		$last_path = $this->last_path;
	}
	//if($mode === false) {
	//	$mode = 'browse';
	//}
	//$download_path = $absolute_path = life::absolutize_path($download_path, $last_path);
	// try locally first
	//if(file_exists($download_path)) { // not sure if 
	//	$contents = life::digest($contents, $file_type, $download_path);
	//}
	$download_file = false;
	$this->downloaded_file = false;
	//print('uh here00z001<br />');
	//$local_path = life::filename_encode(life::local_path($download_path, $absolute_path)); // hilarious
	$download_path = life::absolutize_path($download_path);
	$local_scrape_path = life::local_path($download_path, 'scrape');
	print('$download_path, $local_scrape_path in download_if(): ');var_dump($download_path, $local_scrape_path);
	$got_contents_from_scrape = false;
	if(file_exists($local_scrape_path)) {
		if($download_time === false) {
			$download_time = filemtime($local_scrape_path);
		}
		//print('$download_time: ');var_dump($download_time);
		if(time() - $download_time > 60 * 60 * 24 * 365) { // one year
			print('file was not recently scraped<br />' . PHP_EOL);
		} else {
			print('file was recently scraped<br />' . PHP_EOL);
			$contents = file_get_contents($local_scrape_path); // local
			$got_contents_from_scrape = true;
		}
	}
	//print('$this->current_path, $this->last_path, $download_path, $local_scrape_path, $got_contents_from_scrape: ');var_dump($this->current_path, $this->last_path, $download_path, $local_scrape_path, $got_contents_from_scrape);
	if(!$got_contents_from_scrape) {
		$local_path = life::local_path($download_path, 'browse');
		//print('$download_path, $local_path mid download_if(): ');var_dump($download_path, $local_path);
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
				print('file was not recently browsed<br />' . PHP_EOL);
			} else {
				//print('do not update file<br />');
				$contents = file_get_contents($local_path); // local
				print('file was not recently browsed<br />' . PHP_EOL);
			}
		} else {
			//print('file does not exist<br />');
			$download_file = true;
		}
	}
	if($download_file) {
		//print('download file<br />');
		//print('$download_path before downloading: ');var_dump($download_path);
		//life::fatal_error('stopping before downloading remote');
		$contents = file_get_contents($download_path, false, life::get_stream_context()); // remote
		if($this->debug) {
			if($contents == false) {
				life::fatal_error('problem downloading contents in download_if(). possibly not connected to the internet. possibly server forbade download.');
			}
		}
		//usleep(rand(250000, 1250000));
		//usleep(rand(250000, 3250000));
		usleep(rand(250000, 12500000));
		if(strlen($contents) == 0) {
			//print('did not download file<br />');
			//$download_path = $download_path . $last_path;
			//$contents = file_get_contents($download_path, false, life::get_stream_context());
			// don't do that; makes no sense anyways
			$this->downloaded_file = false;
			// it's possible to have broken links or images etc but mainly digest() is not yet (2022-03-15) discerning enough to know whether things it grabs are from not working code, such as comments or things that aren't run
		} else {
			//print('downloaded file<br />');
			$this->downloaded_file = true;
		//	$initial_contents = $contents;
			//$file_type = substr(life::file_extension($local_path), 1);
			$file_type = life::file_extension($local_path);
			$contents = life::digest($contents, $file_type, $download_path);
		}
		if($this->downloaded_file) {
			print('downloaded file:' . $download_path . '<br />' . PHP_EOL);
		}
	}
	
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

function default_page($path, $contents = false) {
	//print('$path in default_page: ');var_dump($path);
	//print('dp001<br />' . PHP_EOL);
	if(strpos($path, 'php') !== false) {
		//print('dp002<br />' . PHP_EOL);
		return 'index.php';
	} elseif(strpos($path, 'cfm') !== false) {
		//print('dp003<br />' . PHP_EOL);
		return 'index.cfm';
	} elseif(strpos($path, 'aspx') !== false) {
		//print('dp004<br />' . PHP_EOL);
		return 'index.aspx';
	} elseif(strpos($path, 'asp') !== false) {
		//print('dp005<br />' . PHP_EOL);
		return 'index.asp';
	} /*elseif(strpos($last_path, 'php') !== false) {
		return 'index.php';
	} elseif(strpos($last_path, 'cfm') !== false) {
		return 'index.cfm';
	} elseif(strpos($last_path, 'aspx') !== false) {
		return 'index.aspx';
	} elseif(strpos($last_path, 'asp') !== false) {
		return 'index.asp';
	} */ elseif(strlen($contents) > 0) {
		//print('dp006<br />' . PHP_EOL);
		$default_extension = life::default_extension($contents);
		if($default_extension !== false) {
			return 'index.' . $default_extension;
		}
	} else {
		//print('dp007<br />' . PHP_EOL);
		// mini version of local_path (that doesn't use default_page, to avoid recursion)
		$absolute_path = life::filename_encode(life::absolutize_path($path, false, true));
		$local_path = 'scrape' . DS . substr($absolute_path, strpos($absolute_path, '://') + 3);
		if(file_exists($local_path . '/index.html')) {
			//print('dp008<br />' . PHP_EOL);
			return 'index.html';
		} elseif(file_exists($local_path . '/index.htm')) {
			//print('dp009<br />' . PHP_EOL);
			return 'index.htm';
		} elseif(file_exists($local_path . '/index.php')) {
			//print('dp010<br />' . PHP_EOL);
			return 'index.php';
		} elseif(file_exists($local_path . '/index.cfm')) {
			//print('dp011<br />' . PHP_EOL);
			return 'index.cfm';
		} elseif(file_exists($local_path . '/index.aspx')) {
			//print('dp012<br />' . PHP_EOL);
			return 'index.aspx';
		} elseif(file_exists($local_path . '/index.asp')) {
			//print('dp013<br />' . PHP_EOL);
			return 'index.asp';
		}
	}
	// just default to index.html (since it's a webserver) although variations like index.php or index.asp or home.htm or default.html will have to eventually be handled.
	//print('dp014<br />' . PHP_EOL);
	return 'index.html';
}

function local_path($path, $mode = false) {
	/*if(substr($path, 0, 6) === 'cache/') { // keep it as is
		return $path;
	}
	$protocol_end_limiter_position = strpos($path, '://');
	if($protocol_end_limiter_position === false) {
		$local_relative_path = $path;
		print('$local_relative_path01: ');var_dump($local_relative_path);
	} else {
		//$local_relative_path = life::filename_encode(substr($path, strpos($path, '://') + 3));
		$local_relative_path = substr($path, $protocol_end_limiter_position + 3);
		print('$local_relative_path02: ');var_dump($local_relative_path);
		if(strlen($local_relative_path) === 0) {
			print('$local_relative_path: ');var_dump($local_relative_path);
			life::fatal_error('cannot have an empty $local_relative_path');
		}
	}
	if($local_relative_path[strlen($local_relative_path) - 1] === '/') {
		$local_relative_path .= life::default_page($local_relative_path, $this->contents);
		print('$local_relative_path03: ');var_dump($local_relative_path);
	}
	if(life::file_extension($local_relative_path) === false) {
		$local_relative_path .= '/' . life::default_page($local_relative_path, $this->contents);
		print('$local_relative_path04: ');var_dump($local_relative_path);
	}*/
	//print('$local_relative_path: ');var_dump($local_relative_path);
	//if(life::file_extension($path) === false && $path[strlen($path) - 1] !== '/') { // add the slash since it's a directory and not a file
	//	$path .= '/';
	//	//print('$path in absolutize_path() 04.2: ');var_dump($path);
	//}
	if($mode === false) {
		$mode = 'browse';
	}
	if($path[strlen($path) - 1] === '/') {
		$path .= life::default_page($path, $this->contents);
		//print('$path in absolutize_path() 04.3: ');var_dump($path);
	}
	//if($absolute_path === false) {
		$absolute_path = life::filename_encode(life::absolutize_path($path));
	//}
	if($mode === 'browse') {
		return 'cache' . DS . substr($absolute_path, strpos($absolute_path, '://') + 3);
	} elseif($mode === 'scrape') {
		return 'scrape' . DS . substr($absolute_path, strpos($absolute_path, '://') + 3);
	} else {
		print('$mode, $this->action: ');var_dump($mode, $this->action);
		life::fatal_error('unhandled action in local_path()');
	}
}

function convert() {
	// will probably want a function to convert between cache and scrape at some point
}

function fileless($path) { // alias
	return life::fileless_path($path);
}

function fileless_path($path) {
	//print('$path at start of fileless_path: ');var_dump($path);
	//return substr($path, 0, life::strpos_last($path, basename($path))); // works with query and fragment??
	// doesn't work at last with http://www.goldenmean.info/ basename seems to fail
	if(strpos($path, '://') !== false && substr_count($path, '/') >= 3) {
		$last_slash_position = life::strpos_last($path, '/');
		if($last_slash_position === false) {
			return $path;
		} else {
			return substr($path, 0, $last_slash_position + 1);
		}
	}
	return $path;
}

function lifeless_path($path) { // inside joke/palindrome/anagram
	return life::fileless_path($path);
}

function browse() {
	if($_REQUEST['path'] == '') {
		print('Path not properly specified in browse.<br />');
	} else {
		$this->current_path = life::query_decode($_REQUEST['path']);
		$this->last_path = life::query_decode($_REQUEST['last_path']);
		$this->domain = life::domain($this->current_path);
		$this->contents = life::get_contents($this->current_path, $this->last_path);
		$this->scheme = life::scheme($this->current_path, $this->contents);
		//print('$this->current_path, $this->last_path, $this->contents in browse: ');var_dump($this->current_path, $this->last_path, $this->contents);exit(0);
		$this->contents = life::digest($this->contents);
		$up_one_level_path = life::up_one_level_path($this->current_path);
		if($up_one_level_path !== false) {
			$this->contents = life::append($this->contents, '<a href="do.php?action=browse&path=' . life::query_encode($up_one_level_path) . '&last_path=' . life::query_encode($this->current_path) . '">Up one level</a>');
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

function default_extension($contents) {
	// for now nothing specific like looking for internal references to the filename in the contents of the file
	// could use basename and parse_url to ensure we are getting references to real files from the contents
	preg_match_all('/([\'"])([^\'"]+)(\.\w+)\1/is', $contents, $extension_matches);
	$extension_counts = array();
	foreach($extension_matches[3] as $extension) {
		$extension_counts[$extension]++; 
	}
	ksort($extension_counts);
	//print('$contents, $extension_matches, $extension_counts in default_extension: ');var_dump($contents, $extension_matches, $extension_counts);
	// just pick the most prevalent
	foreach($extension_counts as $extension => $count) {
		if(strpos($extension, '.htm') === 0) {
			//return $extension;
			return substr($extension, 1);
		}
	}
	// otherwise just take the most prevalent one
	foreach($extension_counts as $extension => $count) {
		//return $extension;
		return substr($extension, 1);
	}
	//return '.html';
	return 'html';
}

function uniform_resource_exists($url) {
   $headers = get_headers($url);
   return stripos($headers[0], '200 OK')?true:false;
}

function default_protocol_old($contents = false, $path = false) {
	// could use parse_url to ensure we are getting references to real files from the contents
	// for now nothing specific like looking for internal references to the filename in the contents of the file
	if(strlen($contents) > 0) {
		preg_match_all('/(\w+):\/\//is', $contents, $protocol_matches);
		//print('$contents, $protocol_matches: ');var_dump($contents, $protocol_matches);exit(0);
		$protocol_counts = array();
		foreach($protocol_matches[1] as $protocol) {
			$protocol_counts[$protocol]++;
		}
		ksort($protocol_counts);
		// just pick the most prevalent
		foreach($protocol_counts as $protocol => $count) {
			if(strpos($protocol, 'http') === 0) {
				return $protocol . ':';
			}
		}
		// otherwise just take the most prevalent one
		foreach($protocol_counts as $protocol => $count) {
			return $protocol . ':';
		}
	}
	$protocol_limiter_position = strpos($path, '://');
	print('$path, $protocol_limiter_position: ');var_dump($path, $protocol_limiter_position);
	if($protocol_limiter_position !== false) {
		return substr($path, 0, $protocol_limiter_position) . ':';
	}
	if($path !== false && life::uniform_resource_exists('https:') . $path) { // path starting with two forward slashes //
		return 'https:';
	} else {
		return 'http:';
	}
}

function protocol_old($path, $contents = false) {
	return life::protocol_from_path($path, $contents);
}

function protocol_from_path_old($path, $contents = false) {
	// protocol is at the start of the path and ends with a colon e.g. http:// ftp:// magnet: mailto:
	// could use parse_url to ensure we are getting references to real files from the contents
	$protocol_end_limiter_position = strpos($path, '://');
	if($protocol_end_limiter_position !== false) {
		$protocol = substr($path, 0, $protocol_end_limiter_position) . ':';
	} else { // try to grab it from the contents
		return life::default_protocol($contents, $path);
	}
	//print('$path, $protocol in protocol_from_path: ');var_dump($path, $protocol);
	return $protocol;
}

function default_scheme($path = false, $contents = false) {
	// could use parse_url to ensure we are getting references to real files from the contents
	// for now nothing specific like looking for internal references to the filename in the contents of the file
	if(strlen($contents) > 0) {
		preg_match_all('/(\w+):\/\//is', $contents, $scheme_matches);
		//print('$contents, $scheme_matches: ');var_dump($contents, $scheme_matches);exit(0);
		$scheme_counts = array();
		foreach($scheme_matches[1] as $scheme) {
			$scheme_counts[$scheme]++;
		}
		ksort($scheme_counts);
		// just pick the most prevalent
		foreach($scheme_counts as $scheme => $count) {
			if(strpos($scheme, 'http') === 0) {
				return $scheme;
			}
		}
		// otherwise just take the most prevalent one
		foreach($scheme_counts as $scheme => $count) {
			return $scheme;
		}
	}
	$scheme_limiter_position = strpos($path, '://');
	//print('$path, $scheme_limiter_position: ');var_dump($path, $scheme_limiter_position);
	//if($scheme_limiter_position !== false) {
	if($scheme_limiter_position > 0) {
		return substr($path, 0, $scheme_limiter_position);
	}
	if($path !== false && life::uniform_resource_exists('https:') . $path) { // path starting with two forward slashes //
		return 'https';
	} else {
		return 'http';
	}
}

function scheme($path, $contents = false) {
	return life::scheme_from_path($path, $contents);
}

function scheme_from_path($path, $contents = false) {
	// scheme is at the start of the path and ends before the colon e.g. http:// ftp:// magnet: mailto:
	// could use parse_url to ensure we are getting references to real files from the contents
	$scheme_end_limiter_position = strpos($path, '://');
	if($scheme_end_limiter_position !== false) {
		$scheme = substr($path, 0, $scheme_end_limiter_position) . ':';
	} else { // try to grab it from the contents
		return life::default_scheme($path, $contents);
	}
	//print('$path, $scheme in scheme_from_path: ');var_dump($path, $scheme);
	return $scheme;
}

function domain($path, $last_path = false) {
	return life::domain_from_path($path, $last_path);
}

function domain_from_path($path, $last_path = false) {
	//print('$path in domain_from_path: ');var_dump($path);
//	if(substr($path, 0, 6) === 'cache/') {
//		//print('domain case 1<br />');
//		return substr($path, 6, strpos($path, '/', 6) - 6); // :O
//	}

	if(substr($path, 0, 6) === 'cache/') {
		$path = substr($path, 6);
	}
	$parsed_path_url = parse_url($path);
	if(!isset($parsed_path_url['host']) && isset($parsed_path_url['path'])) {
		$parsed_path_url['host'] = $parsed_path_url['path'];
	}
	if($parsed_path_url['host'] == '') {
		if(substr($last_path, 0, 6) === 'cache/') {
			$last_path = substr($last_path, 6);
		}
		$parsed_last_path_url = parse_url($last_path);
		if(!isset($parsed_last_path_url['host']) && isset($parsed_last_path_url['path'])) {
			$parsed_last_path_url['host'] = $parsed_last_path_url['path'];
			if($parsed_path_url['host'] == '') {
				$parsed_path_url = $parsed_last_path_url;
			}
		}
		if($parsed_path_url['host'] == '') {
			print('$path, $last_path, $parsed_path_url, $parsed_last_path_url: ');var_dump($path, $last_path, $parsed_path_url, $parsed_last_path_url);
			life::fatal_error('should never not find a host using domain_from_path() from $path and $last_path.');
		}
	}
	life::warning_once('will have to think about how to store websites that use different ports... theoretically there could be fully different websites simply by different use of ports');
	$host     = isset($parsed_path_url['host']) ? $parsed_path_url['host'] : '';
	$port     = isset($parsed_path_url['port']) ? ':' . $parsed_path_url['port'] : ''; // should domain include password? haven't come across this case yet
	//$user     = isset($parsed_path_url['user']) ? $parsed_path_url['user'] : '';
	//$pass     = isset($parsed_path_url['pass']) ? ':' . $parsed_path_url['pass']  : '';
	//$pass     = ($user || $pass) ? "$pass@" : '';
	return "$host$port";
	//return "$scheme$user$pass$host$port";
	/****
	elseif(strpos($path, '://') === false) {
		//print('domain case 2<br />');
		$first_slash_position = strpos($path, '/');
		$first_dot_position = strpos($path, '.');
		if($first_dot_position < $first_slash_position) {
			$domain = substr($path, 0, $first_slash_position);
		} elseif(strpos($last_path, '://') !== false) {
			//print('domain case 2.0<br />');
			$domain = life::domain_from_path($last_path);
		} elseif($first_dot_position > $first_slash_position || $first_dot_position === false) {
			return false;
		} elseif($first_slash_position === false) {
			//print('domain case 2.1<br />');
			$domain = $path;
		} else {
			//print('domain case 2.2<br />');
			$domain = substr($path, 0, $first_slash_position);
		}
		//print('$path, $last_path: ');var_dump($path, $last_path);
		//life::fatal_error('not sure how to calculate site root from these');
	}
	//print('DS, substr_count($path, DS): ');var_dump(DS, substr_count($path, DS));
	//if(substr_count($path, DS) < 3) {
	 elseif(substr_count($path, '/') < 3) { // remote (sites) always uses foreward slash as opposed to unix vs windows systems
		//print('domain case 3<br />');
		$domain = $path;
	} else {
		//print('domain case 4<br />');
		$protocol_end_limiter_position = strpos($path, '://');
		//$domain = substr($path, 0, life::strpos_nth($path, DS, 3) + 1);
		//$domain = substr($path, 0, life::strpos_nth($path, DS, 3)); // omit the last slash
		$domain = substr($path, $protocol_end_limiter_position + 3, life::strpos_nth($path, '/', 3) - $protocol_end_limiter_position - 3); // omit the last slash
	}
	while($domain[0] === '/') {
		$domain = substr($domain, 1);
	}
	//print('$path, $domain in domain_from_path: ');var_dump($path, $domain);
	return $domain;****/
}

function rootless($path) {
	//print('$path at the start of rootless: ' . $path . '<br />' . PHP_EOL);
	if(substr_count($path, '/') > 2) {
		$end_of_root_slash_position = life::strpos_nth($path, '/', 3);
	} elseif(substr_count($path, '/') > 0) {
		$end_of_root_slash_position = strpos($path, '/');
	} else {
		$end_of_root_slash_position = strlen($path);
	}
	//print('$path at the end of rootless: ' . substr($path, $end_of_root_slash_position + 1) . '<br />' . PHP_EOL);
	return substr($path, $end_of_root_slash_position + 1);
}

function site_root_from_path($path, $last_path = false) {
	if($last_path === false) {
		$last_path = $this->last_path;
	}
	//print('$path in site_root_from_path: ');var_dump($path);
 	//$parsed_path_url = parse_url($path);
 	//if($parsed_path_url['host'] == '') {
 	//	$parsed_last_path_url = parse_url($last_path);
 	//	if($parsed_path_url['host'] == '') {
 	//		print('$parsed_path_url, $parsed_last_path_url: ');var_dump($parsed_path_url, $parsed_last_path_url);
 	//		life::fatal_error('should never not find a host using site_root_from_path() from $path and $last_path.');
 	//	}
 	//	$parsed_path_url = $parsed_last_path_url;
 	//}
	if(substr($path, 0, 6) === 'cache/') {
		$path = substr($path, 6);
	}
	if(strpos($path, '://') === false) {
		$path = $this->scheme . '://' . $path;
	}
	$parsed_path_url = parse_url($path);
	//print('$parsed_path_url in site_root_from_path: ');var_dump($parsed_path_url);
	if(!isset($parsed_path_url['host']) && isset($parsed_path_url['path'])) { // mini version of absolutize path... instead or recursion!
		$parsed_path_url['host'] = $parsed_path_url['path'];
	}
	if($parsed_path_url['host'] == '') {
		if(substr($last_path, 0, 6) === 'cache/') {
			$last_path = substr($last_path, 6);
		}
		$parsed_last_path_url = parse_url($last_path);
		if(!isset($parsed_last_path_url['host']) && isset($parsed_last_path_url['path'])) {
			$parsed_last_path_url['host'] = $parsed_last_path_url['path'];
			if($parsed_path_url['host'] == '') {
				$parsed_path_url = $parsed_last_path_url;
			}
		}
		if($parsed_path_url['host'] == '') {
			print('$path, $last_path, $parsed_path_url, $parsed_last_path_url: ');var_dump($path, $last_path, $parsed_path_url, $parsed_last_path_url);
			life::fatal_error('should never not find a host using site_root_from_path() from $path and $last_path.');
		}
	}
	//print('$path, $last_path, $parsed_path_url, $parsed_last_path_url in site_root_from_path: ');var_dump($path, $last_path, $parsed_path_url, $parsed_last_path_url);
	$protocol   = isset($parsed_path_url['scheme']) ? $parsed_path_url['scheme'] . '://' : $this->scheme . '://';
	$host     = isset($parsed_path_url['host']) ? $parsed_path_url['host'] : '';
	$port     = isset($parsed_path_url['port']) ? ':' . $parsed_path_url['port'] : '';
	$user     = isset($parsed_path_url['user']) ? $parsed_path_url['user'] : '';
	$pass     = isset($parsed_path_url['pass']) ? ':' . $parsed_path_url['pass']  : '';
	$pass     = ($user || $pass) ? "$pass@" : '';
	return "$protocol$user$pass$host$port";

	// need the protocol
	if(strpos($path, '://') === false) {
		//print('site root1<br />');
		if(strpos($last_path, '://') === false) {
			//print('site root2<br />');
			if($this->debug) {
				print('$path, $last_path in site_root_from_path: ');var_dump($path, $last_path);
				life::fatal_error('should never not find a protocol in both path and last_path');
			}
			return false;
			// could just guess http:// but that does not work for our eventual goals and it's better to fix where the protocol is being lost in the code
		} else {
			//print('site root3<br />');
			if(substr_count($last_path, '/') < 3) { // remote (sites) always uses foreward slash as opposed to unix vs windows systems
				//print('site root4<br />');
				$site_root = $last_path;
			} else {
				//print('site root5<br />');
				$protocol_end_limiter_position = strpos($last_path, '://');
				//$site_root = substr($path, 0, life::strpos_nth($path, DS, 3) + 1);
				//$site_root = substr($path, 0, life::strpos_nth($path, DS, 3)); // omit the last slash
				$site_root = substr($last_path, $protocol_end_limiter_position + 3, life::strpos_nth($last_path, '/', 3) - $protocol_end_limiter_position - 3); // omit the last slash
			}
		}
	} else {
		//print('site root6<br />');
		//print('$path in site_root_from_path: ');var_dump($path);
		//life::fatal_error('should never find a protocol in a path starting with cache/ fix this');
		if(substr_count($path, '/') < 3) { // remote (sites) always uses foreward slash as opposed to unix vs windows systems
			//print('site root7<br />');
			$site_root = $path;
		} else {
			//print('site root8<br />');
			$protocol_end_limiter_position = strpos($path, '://');
			$site_root = substr($path, 0, life::strpos_nth($path, '/', 3) + 1);
			//$site_root = substr($path, 0, life::strpos_nth($path, DS, 3)); // omit the last slash
			//$site_root = substr($path, $protocol_end_limiter_position + 3, life::strpos_nth($path, '/', 3) - $protocol_end_limiter_position - 3); // omit the last slash
		}
	}
	//print('$path, $site_root in site_root_from_path: ');var_dump($path, $site_root);
	return $site_root;
}

function path_by_parsing($path) {
	// really funky function that doesn't currently (2022-07-14) have general usage
	//print('$path in path_by_parsing: ');var_dump($path);
	if(substr($path, 0, 6) === 'cache/') {
		$path = substr($path, 6);
	}
	$parsed_path_url = parse_url($path);
	if(!isset($parsed_path_url['host']) && isset($parsed_path_url['path'])) {
		return '';
	}
	return $parsed_path_url['path'];
}

function sweep($contents) {
	// placeholder function for now
	return $contents;
}

function is_browser_content($path) {
	// just so that we don't try to scrape things like mailto: links as a start
	// it's worth examining what things are looked for in this function for ideas about what live_browser should ultimately do
	if(stripos($path, 'mailto:') !== false || stripos($path, 'tel:') !== false) {
		return false;
	}
	// most things should get through this filter; there isn't much that isn't supported on the internet!
	// gotta say though, there's probably interesting data to grab here... email adresses, torrents, telephone numbers, usernames etc
	return true;
}

function verify_file_type($contents, $path) {
	$match = false;
	$file_type_by_contents = life::file_type_by_contents($contents);
	$file_type_by_extension = life::file_type_by_extension($path);
	if($file_type_by_extension === true || $file_type_by_extension === $file_type_by_contents) {
		$match = true;
	}
	if($this->debug && !$match) {
		print('life::file_type_by_contents($contents), life::file_type_by_extension($path), $path, $contents: ');var_dump(life::file_type_by_contents($contents), life::file_type_by_extension($path), $path, $contents);
		life::fatal_error('debug somehow file types of $contents and $path are not matching');
	}
	return $match;
}

function digest($contents, $file_type = false, $path = false, $last_path = false, $mode = false) {
	//if($contents === false) {
	//	$contents = $this->contents;
	//}
	if(strlen($contents) === 0) { // could use this for making a broken links report
		return false;
	}
	if($file_type === false) {
		$file_type = life::file_type_from_contents($contents);
	}
	if($path === false) {
		$path = $this->current_path;
	}
	if($last_path === false) {
		$last_path = $this->last_path;
	}
	if($mode === false) {
		$mode = $this->action;
	}
	$initial_contents = $contents;
	$local_scrape_path = life::local_path($path, 'scrape');
	//print('$path, $local_scrape_path, $file_type, $contents at start of digest: ');var_dump($path, $local_scrape_path, $file_type, $contents);
	life::save_if($local_scrape_path, $contents, $initial_contents);
	if($this->debug) {
		if(!file_exists($local_scrape_path)) {
			print('$local_scrape_path, $contents, $initial_contents: ');var_dump($local_scrape_path, $contents, $initial_contents);
			life::fatal_error('debug error file not saving to scrape in digest');
		}
		life::verify_file_type($contents, $local_scrape_path); // debug
		//print('$this->initial_contents in digest: ');var_dump($this->initial_contents);
		//print('$file_type, $path in digest: ');var_dump($file_type, $path);
		life::warning_once('have to dig image links out of javascript (both in js and in html) like from sega.jp');
		life::warning_once('have to accept super old quotesless attributes... maybe update them rather than change the regex');
		life::warning_once('<meta http-equiv="Last-Modified" content="Thu, 14 Dec 2017 05:28:48 GMT">');
		life::warning_once('handle byte order marker');
	}
	/*function add_BOM() {
		$this->code = chr(0xEF) . chr(0xBB) . chr(0xBF) . $this->code;
	}*/
	/*{
  "name": "ポケットゲーマー",
  "short_name": "ポケットゲーマー",
  "start_url": "menu.htm",
  "icons": [ {
    "src": "images/logo.svg",
    "sizes": "267x77",
    "type": "image/png",
    "density": "3.0"
  }],
  "display": "standalone"
}*/
	$contents = life::sweep($contents);
	//if(strpos($contents, 'nofollow') !== false) {
	//	print('$contents: ');var_dump($contents);
	//	life::fatal_error('nofollow found in contents. this has not been coded for yet');
	//}
	
	//print('$file_type, $path, $last_path, $mode, $contents in digest: ');var_dump($file_type, $path, $last_path, $mode, $contents);
	$site_root = life::site_root_from_path($path, $last_path);
	if($file_type === 'xml') {
		// would be natural to do. RSS for one, and XML is well-structured
		if($this->debug) {
			life::warning_once('hmm, maybe interesting data in this XML file!');
		}
	} elseif($file_type === 'js') {
		// could do
		//preg_match_all('/"http[^"]+"/is', $contents, $matches);
		// but for the moment do nothing since a parser is really needed to determine which resources to grab and how to modify the contents
	} elseif($file_type === 'css') {
		preg_match_all('/url\(\s*?\'([^\']*?)\'\s*?\)/is', $contents, $matches);
		//print('$matches in css in digest: ');var_dump($matches);
		foreach($matches[0] as $index => $value) {
			$path_in_code = life::normalize_path(life::filename_decode($matches[1][$index]));
			if(!life::is_browser_content($path_in_code)) {
				continue;
			}
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				//$download_path = $path_in_code;
			}/* elseif($path_in_code[0] === '/') {
				$download_path = $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = life::fileless_path($this->current_path) . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}*/
			$download_path = life::absolutize_path($path_in_code);
			//print('css file in digest $path_in_code, $download_path: ');var_dump($path_in_code, $download_path);
			if($mode === 'scrape') {
				life::scrape_decide($download_path);
			} else {
				$local_path = life::local_path($download_path);
				/*if(substr($contents, $value[1] + strlen($value[0]), 5) === '<meta') {
					continue;
				} else {*/
					life::download_if($download_path);
				//}
				$contents = str_replace($value, 'url(\'' . $local_path . '\')', $contents);
			}
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
		// honeypots
		$contents = preg_replace('/<!--([^>\{]+)(href|src)=("|\')([^"\']*?)\3([^>\{]*?)-->/is', '<!--$19o9$29o9=$3$4$3$5-->', $contents); // avoiding a basic honeypot where a reference to some file is in a comment a human would not notice from normal webpage use
		// change links to local and download remote stuff to local
		preg_match_all('/<(link|script|img)([^>]*?)\s+(href|src)=("|\')([^"\']*?)\4([^>]*?)>/is', $contents, $matches, PREG_OFFSET_CAPTURE);
		//print('link|script|img $matches: ');var_dump($matches);exit(0);
		// we add metadata to these to compare against our own files (as a first step; repairing the internet)
		// IPFS would be better since it is content adressing and it's impossible to have duplicated content
		foreach($matches[0] as $index => $value) {
			// if this external content already has metadata, just leave it and assume the CRC and data checking will be written within a year!
			$path_in_code = life::normalize_path(life::filename_decode($matches[5][$index][0]));
			//print('link|script|img $value, $path_in_code: ');var_dump($value, $path_in_code);
			if(!life::is_browser_content($path_in_code)) {
				//print('isn\'t browser content<br />' . PHP_EOL);
				continue;
			}
			//print('is browser content<br />' . PHP_EOL);
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				//$download_path = $path_in_code;
			}/* elseif($path_in_code[0] === '/') {
				$download_path = $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = life::fileless_path($this->current_path) . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}*/
			$download_path = life::absolutize_path($path_in_code);
			//print('html file 1 in digest $path_in_code, $download_path: ');var_dump($path_in_code, $download_path);
			if($this->debug) {
				if(strpos($download_path, 'https://img/') !== false) {
					print('link|script|img $value, $download_path: ');var_dump($value, $download_path);
					life::fatal_error('image path not properly handled');
				}
			}
			if($mode === 'scrape') {
				life::scrape_decide($download_path);
			} else {
				$local_path = life::local_path($download_path);
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
				//print('after digesting first resource debug break');exit(0);
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
			$path_in_code = life::normalize_path(life::filename_decode($matches[2][$index]));
			if(!life::is_browser_content($path_in_code)) {
				continue;
			}
			if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
				if(!$this->debug) {
					continue;
				}
				//$download_path = $path_in_code;
			}/* elseif($path_in_code[0] === '/') {
				$download_path = $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = life::fileless_path($this->current_path) . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}*/
			$download_path = life::absolutize_path($path_in_code);
			//print('html file 2 in digest $path_in_code, $download_path: ');var_dump($path_in_code, $download_path);
			if($mode === 'scrape') {
				life::scrape_decide($download_path);
			} else {
				$local_path = life::local_path($download_path);
				/*if(substr($contents, $value[1] + strlen($value[0]), 5) === '<meta') {
					continue;
				} else {*/
					life::download_if($download_path);
				//}
				$contents = str_replace($value, ' style="' . $matches[1][$index] . 'url(\'' . $local_path . '\')' . $matches[3][$index] . '"', $contents);
			}
		}
		
		preg_match_all('/<(area|a|form)([^>]*?)\s+(href|action)=("|\')([^"\']*?)\4([^>]*?)>/is', $contents, $matches);
		//print('$matches looking for (a|form) references in digest: ');var_dump($matches);//exit(0);
		foreach($matches[0] as $index => $value) {
			$path_in_code = life::normalize_path(life::filename_decode($matches[5][$index]));
			if($path_in_code[0] === '#') { // ignore anchors
				continue;
			}
			if(!life::is_browser_content($path_in_code)) {
				continue;
			}
			if($mode === 'scrape' && (strpos($matches[2][$index], 'nofollow') !== false || strpos($matches[6][$index], 'nofollow') !== false)) {
				continue;
			}
			//if(substr($path_in_code, 0, 6) === 'cache/') { // leave it
			if(substr($path_in_code, 0, 20) === 'do.php?action=browse') { // leave it
				if(!$this->debug) {
					continue;
				}
				//$download_path = $path_in_code;
			}/* elseif($path_in_code[0] === '/') {
				$download_path = $site_root . $path_in_code;
			} elseif(strpos($path_in_code, '://') === false) {
				$download_path = life::fileless_path($this->current_path) . $path_in_code;
			} else {
				$download_path = $path_in_code;
			}*/
			$download_path = life::absolutize_path($path_in_code);
			//print('$value, $mode at href in digest: ');var_dump($value, $mode);
			//print('html file 3 in digest $path_in_code, $download_path: ');var_dump($path_in_code, $download_path);
			if($mode === 'scrape') {
				life::scrape_decide($download_path);
			} else {
				$local_path = life::local_path($download_path);
				$contents = str_replace($value, '<' . $matches[1][$index] . $matches[2][$index] . ' ' . $matches[3][$index] . '=' . $matches[4][$index] . 'do.php?action=browse&path=' . life::query_encode($path_in_code) . '&last_path=' . life::query_encode($this->current_path) . $matches[4][$index] . $matches[6][$index] . '>', $contents);
			}
		}
		// other mods? other content?
		
	}
	$local_cache_path = life::local_path($path, 'browse');
	//print('$local_cache_path: ');var_dump($local_cache_path);
	if($mode === 'browse') {
		life::save_if($local_cache_path, $contents, $initial_contents);
		if($this->debug && !file_exists($local_cache_path)) {
			life::fatal_error('debug error file not saving to cache in digest');
		}
		if($file_type === 'html') {
			// warn if using proprietary or non-open source
			$open_source = true;
			if(strpos($contents, '"http') !== false) {
				$open_source = false;
			}
			if($open_source) {
				foreach($this->server_side_language_file_extensions as $file_extension) {
					//if(preg_match('/' . $file_extension . '[^\w]/is', $contents, $matches)) {
					if(preg_match('/\.' . $file_extension . '[^\w]/is', $contents, $matches)) {
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
	}
	return $contents;
	//return array();
}

function scrape_decide($download_path) {
	//print('$download_path in scape_decide(): ');var_dump($download_path);
	if($this->debug) {
		if(strpos($download_path, '://') === false) {
			print('$download_path: ');var_dump($download_path);
			life::fatal_error('missing a protocol on $download_path');
		}
	}
	if($this->files_scraped[$download_path]) { // it was already scraped
		//print('file was already scraped.<br />' . PHP_EOL);
		return false;
	} elseif($this->files_to_scrape[$download_path]) { // it's already queued
		//print('file is already queued.<br />' . PHP_EOL);
	} elseif($this->domain === life::domain($download_path)) {
		//print('file added to files_to_scrape.<br />' . PHP_EOL);
// 		if($this->debug) {
// 			// do these even work?
// 			if(strpos($download_path, 'google') !== false) {
// 				print('$download_path: ');var_dump($download_path);
// 				life::fatal_error('maybe should not download this possible google honeypot');
// 			}
// 			if(strpos($download_path, 'amazon') !== false || strpos($download_path, 'aws') !== false) {
// 				print('$download_path: ');var_dump($download_path);
// 				life::fatal_error('maybe should not download this possible amazon honeypot');
// 			}
// 		}
		foreach($this->paths_disallowed_to_robots as $disallowed_path) {
			if(strpos($download_path, $disallowed_path) !== false) {
				return true;
			}
		}
		$this->files_to_scrape[$download_path] = true;
	} else {
		//print('something else in scrape_decide.<br />' . PHP_EOL);
		return false;
		//print('$download_path, $this->domain, life::domain($download_path): ');var_dump($download_path, $this->domain, life::domain($download_path));
		//life::fatal_error('should never get here in scrape_decide()');
	}
	return true;
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
	if($this->debug) {
		if($path == false || $contents == false || $initial_contents == false) {
			print('$path, $contents, $initial_contents: ');var_dump($path, $contents, $initial_contents);
			fatal_error('problem with parameters in save_if()');
		}
		if(strlen($path) === 0 || strlen($path) === 0 || strlen($path) === 0) {
			print('$path, $contents, $initial_contents: ');var_dump($path, $contents, $initial_contents);
			fatal_error('problem with parameters length in save_if()');
		}
	}
	print('$path in save_if(): ');var_dump($path);
	if($contents !== $initial_contents) {
		//print('$path, $contents before save in save_if: ');var_dump($path, $contents);exit(0);
		//print('saved because of new contents in save_if()<br />');
		return life::save($path, $contents);
	} elseif(!file_exists($path)) {
		//print('saved because of new file in save_if()<br />');
		return life::save($path, $contents);
	}/* else {
		print('did not save in save_if()<br />');
	}*/
	//exit(0);
	return false;
}

function save($path, $contents) {
	life::mkdir_to_root($path);
	if($this->debug) {
		print('$path, life::filename_encode($path) in save(): ');var_dump($path, life::filename_encode($path));//exit(0);
	}
	$put_result = file_put_contents(life::filename_encode($path), $contents);
	if($this->debug) {
		if($put_result == false) {
			print('$path, $contents: ');var_dump($path, $contents);
			fatal_error('file was not properly saved!');
		}
	}
	return $put_result;
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

function file_type_by_contents($contents) { // alias
	return life::file_type_from_contents($contents);
}

function file_type_from_contents($contents) {
	// determine file type based on contents
	// sort of most specific (static file type contents) to least (such as programming and markup languages)
	// with some interweaving for ones that can subsume each other e.g. js and css
	// it's certainly worth grouping into the if conditions by file type result and putting the more 
	// processing intensive tests in later order and more common patterns earlier for saving processing time
	// notice that markup languages HTML, XML, RSS etc are case insensitve and so stripos is used. js and css are case sensitive. others?
	// this may need to become quite sophisticated since you could have something like javascript that just prints a bunch of html, so you'd have to consider code hierarchy across many potential language potentially nesting each other...
	$file_type = 'txt'; // default to txt... risky?
	//print('$contents, strpos($contents, \'}]\'), $contents[0], $contents[strlen($contents) - 1]: ');var_dump($contents, strpos($contents, '}]'), $contents[0], $contents[strlen($contents) - 1]);
	// testing for file type markers at the start of the file
	if(substr($contents, 0, 3) === 'GIF') {
		return 'gif';
		$file_type = 'gif';
	} elseif(substr($contents, 0, 2) === 'PK') { // Phil Katz zip, PKZIP, which we just generalize to zip these days
		return 'zip';
		$file_type = 'zip';
	//} elseif(substr($contents, 12, 2) === 'ks') {
	//} elseif(substr($contents, 0, 3) === '�') {
	} elseif(substr($contents, 0, 3) === chr(0x1F) . chr(0x8B) . chr(0x08)) {
		return 'gz';
		$file_type = 'gz';
	} elseif(substr($contents, 0, 4) === '%PDF') {
		return 'pdf';
		$file_type = 'pdf';
	} elseif(substr($contents, 1, 3) === 'PNG') {
		return 'png';
		$file_type = 'png';
	} elseif(substr($contents, 0, 3) === '  ') {
		return 'ico';
		$file_type = 'ico';
	} elseif(substr($contents, 0, 4) === 'ÿØÿá' || substr($contents, 6, 4) === 'JFIF' || substr($contents, 6, 4) === 'Exif') {
		return 'jpg';
		$file_type = 'jpg';
	//} elseif($contents[0] === '{' && strpos($contents, '}]') !== false) {
	} elseif(($contents[0] === '{' || $contents[3] === '{') && $contents[strlen(trim($contents)) - 1] === '}') { // there may be a byte order marker
		return 'json';
		$file_type = 'json';
	}
	// testing for markers in the contents with precedence since we can have complex contents (mixing more than one type) but one identified first is more likely to be the main type of contents
	// since we are now using precedence, it's important to use the markers that signal a content type change like <script showing js in html or <style showing css in html or .html( showing html in js or :before showing html in css etc
	$marks_tests_array = array(
	//array('rss' => array(array('i', '<feed'), array('i', '<rss'))), // RSS may not require specific treatment different from its XML superset?
	array('xml' => array(array('i', '<feed'), array('i', '<rss'))),
	array('svg' => array(array('i', '<svg'))),
	array('js' => array(array('', 'document.getElementById('), array('', 'console.log('), array('', 'Math.random'), array('', '.toLowerCase('), array('', 'document.write'), array('', '.css('), array('', '.html('))),
	array('html' => array(array('i', '<script'), array('i', '<style'), array('i', '<html'), array('i', '/<!DOCTYPE\s+html/is'))),
	array('js' => array(array('', 'XMLHttpRequest'), array('', 'function('), array('', '.document'))),
	//'document.' // ambiguous between js and txt
	array('css' => array(array('', 'body {'), array('', 'margin-left:'), array('', 'margin-right:'), array('', 'overflow:'), array('', ':before'), array('', 'width:'), array('', 'color:'))),
	//'position:' // ambiguous between js and css
	);
	$file_type_positions = array();
	foreach($marks_tests_array as $marks_test) {
		foreach($marks_test as $possible_file_type => $tests) {
			foreach($tests as $index => $parameters) {
				if($parameters[0] === 'i') { // case insensitive
					$position = stripos($contents, $parameters[1]);
					if($position !== false) { // could also do counts or weights?
						$file_type_positions[$position] = $possible_file_type;
					}
				} else { // case sensitive
					$position = strpos($contents, $parameters[1]);
					if($position !== false) { // could also do counts or weights?
						$file_type_positions[$position] = $possible_file_type;
					}
				}
			}
		}
	}
	ksort($file_type_positions);
	foreach($file_type_positions as $position => $file_type) { break; }
	if($file_type == false) {
		print('$contents, $file_type: ');var_dump($contents, $file_type);
		life::fatal_error('did not determine file type by contents');
	}
	return $file_type;
}

function filename_minus_extension($string) {
	return substr($string, 0, life::strpos_last($string, '.'));
}

function extension($string) { // alias
	return life::file_extension($string);
}

function file_extension($string) {
	return pathinfo($string)['extension'];
	if(strpos($string, '://') !== false && substr_count($string, '/') < 3 /* (=2) */) { // it's a naked domain so don't grab .com or .org or whatever as the extension
		return false;
	}
	// anchor # always comes after query string ?
	$last_hash_position = life::strpos_last($string, '#');
	if($last_hash_position !== false) {
		$string = substr($string, 0, $last_hash_position);
	}
	$string = str_replace('\\', '/', $string);
	$last_slash_position = life::strpos_last($string, '/');
	$last_question_position = life::strpos_last($string, '?');
	if($last_question_position === false) {
		$last_question_position = life::strpos_last($string, '9o9quest9o9');
	}
	if($last_question_position == false) {
		$last_dot_position = life::strpos_last($string, '.');
	} else {
		$last_dot_position = life::strpos_last(substr($string, 0, $last_question_position), '.');
	}
	if($last_dot_position === false || $last_dot_position < $last_slash_position/* || $last_dot_position < life::strpos_last($string, '\\')*/) {
		//if($last_question_position === false) {
			return false;
		/*} else {
			return '.' . substr($string, $last_slash_position + 1, $last_question_position - $last_slash_position - 1);
		}*/
	} elseif($last_question_position === false) {
		if($last_dot_position === false) {
			return false;
		} else {
			return substr($string, $last_dot_position);
		}
	} elseif($last_question_position < $last_dot_position) { // this is pretty wacky
		$last_dot_between_slash_and_question_position = life::strpos_last(substr($string, 0, $last_question_position), '.', $last_slash_position);
		if($last_question_position < $last_dot_between_slash_and_question_position) {
			print('$string, $last_question_position, $last_dot_position: ');var_dump($string, $last_question_position, $last_dot_position);
			life::fatal_error('not sure how to calculate file_extension from these');
			return false;
		} else {
			return substr($string, $last_dot_between_slash_and_question_position, $last_question_position - $last_dot_between_slash_and_question_position);
		}
	} else {
		return substr($string, $last_dot_position, $last_question_position - $last_dot_position);
	}
	return false; // should never get here if there are enough conditions above to handle everything
}

public function strpos_last($haystack, $needle, $offset = 0) {
	//print('$haystack, $needle: ');var_dump($haystack, $needle);
	return strrpos($haystack, $needle, -1 * $offset);
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

function queryless($string) {
	// could use parse_url to ensure we are getting references to real files from the contents
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
	$last_slash_position = life::strpos_last($string, '/');
	if($last_slash_position === false) {
		return $string;
	}
	$substring = substr($string, $last_slash_position);
	//var_dump(urlencode('&'));exit(0);
	//$string = str_replace('?', '%3f', $string);
	//$string = str_replace('?', '&#63;', $string);
	$substring = str_replace('?', '9o9quest9o9', $substring);
	$substring = str_replace('|', '9o9bar9o9', $substring);
	$substring = str_replace(':', '9o9colon9o9', $substring);
	// could just use htmlentities() if this works and there is the need for more than encoding of ?
	// unfortunately seems like we have to invent our own encoding since url decoding and html entity decoding are automatic in places
	$string = substr($string, 0, $last_slash_position) . $substring;
	return $string;
}

function filename_decode($string) {
	$last_slash_position = life::strpos_last($string, '/');
	if($last_slash_position === false) {
		return $string;
	}
	$substring = substr($string, $last_slash_position);
	//$string = str_replace('%3f', '?', $string);
	//$string = str_replace('&#63;', '?', $string);
	$substring = str_replace('9o9quest9o9', '?', $substring);
	$substring = str_replace('9o9bar9o9', '|', $substring);
	$substring = str_replace('9o9colon9o9', ':', $substring);
	// could just use html_entity_decode() if this works and there is the need for more than decoding of ?
	// unfortunately seems like we have to invent our own encoding since url decoding and html entity decoding are automatic in places
	$string = substr($string, 0, $last_slash_position) . $substring;
	return $string;
}

function get_by_request($variable) {
	return life::query_decode($_REQUEST[$variable]);
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

function query_clean($string) {
	// would maybe like to use parse_url
	// probably want to urlencode()
	$query_position = strpos($string, '?') + 1;
	if($query_position === false) {
		$query_position = 0;
	}
	$query_part = substr($string, $query_position);
	$query_part = str_replace(' ', '+', $query_part);
	$string = substr($string, 0, $query_position) . $query_part;
	return $string;
}

function query_dirty($string) {
	life::fatal_error('probably do not use query_dirty');
	$string = str_replace('+', ' ', $string);
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
