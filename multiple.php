<?php

/**
 *  An example CORS-compliant method.  It will allow any GET, POST, or OPTIONS requests from any
 *  origin.
 *
 *  In a production environment, you probably want to be more restrictive, but this gives you
 *  the general idea of what is involved.  For the nitty-gritty low-down, read:
 *
 *  - https://developer.mozilla.org/en/HTTP_access_control
 *  - https://fetch.spec.whatwg.org/#http-cors-protocol
 *
 */
function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    echo "You have CORS!";
}

//print('$_SERVER: ');var_dump($_SERVER);exit(0);
//print('getallheaders() before: ');var_dump(getallheaders());
//print('$_SERVER[\'HTTP_ORIGIN\']: ');var_dump($_SERVER['HTTP_ORIGIN']);
//print('$_SERVER[\'REQUEST_METHOD\']: ');var_dump($_SERVER['REQUEST_METHOD']);
//cors();
//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
////header('Access-Control-Allow-Origin: *');
////header('Access-Control-Allow-Credentials: true');
////header('Access-Control-Max-Age: 86400');    // cache for 1 day
//header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
////header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
////header('Content-Security-Policy: default-src \'self\'');
//print('<br /><br />');
//print('getallheaders() after: ');var_dump(getallheaders());exit(0);

//child-src 'self'
//frame-src 'self'
//X-Frame-Options: DENY
//X-Frame-Options: SAMEORIGIN
/*header('Content-Security-Policy: child-src *');*/
$URL = 'http://freement.great-site.net/live_browser/multiple.php';
//header('Content-Security-Policy: frame-src *;');
//header('Content-Security-Policy: "frame-ancestors *;"');
print('headers: ');var_dump(get_headers($URL, true));

?>

<html>
<head>
<title></title>
<style>
iframe { border: 10px solid black; float: left; }
p { clear: both; }
</style>
</head>
<body>
<p>external iframes</p>
<iframe id="iframe1" src="https://duckduckgo.com/?q=iframe1"></iframe>
<iframe id="iframe2" src="https://duckduckgo.com/?q=iframe2"></iframe>
<iframe id="iframe3" src="https://duckduckgo.com/?q=iframe3"></iframe>
<p>internal iframes</p>
<iframe id="iframe4" src="slide.php"></iframe>
<iframe id="iframe5" src="input.php"></iframe>
<iframe id="iframe6" src="interact.php"></iframe>
</body>
</html>
<?php

print('headers: ');var_dump(get_headers($URL, true));exit(0);

?>