<?php

$urls = array('www.google.com', 'madeup.neet', 'somesite.site', 'example.com', 'clubfeet', 'localhost', 'localhost/LOM', 'localhost/LOM/text.php', 'localhost/LOM/textxxx.php', 'www.google.com/madeupdir', 'www.google.com/zerg', 'www.google.com/uhhh', 'techreport.com', 'yandex.com/', 'yandex.com/search/?text=sseesaw', 'www.dogpile.com', 'https://www.dogpile.com/serp?q=sseesaw', 'duckduckgo.com/?q=sseesaw', 'www.hopkinsmedicine.org/health/conditions-and-diseases/clubfoot', 'www.mayoclinic.org/search/search-results?q=sseesaw');
foreach($urls as $url) {
    //print($url . ' with response: ');var_dump(get_headers('http://' . $url));
    print($url . ' with response: ');var_dump(get_headers('https://' . $url));
}

// https doesn't work localhost, http works localhost

?>
