<html>
<head>
<title></title>
<style>
iframe { border: 10px solid black; float: left; }
p { clear: both; }
</style>
<!--script src="https://code.jquery.com/jquery-3.5.0.js"></script-->
<script src="jquery-3.5.0.js"></script>
<script>
//function load() {
//  alert("load event detected!");
//}
//window.onload = load;
//alert('test start');
//$('#fraction').append('<u>test start fracting message</u> ');
//setInterval(function(){ alert("Hello"); }, 3000);
//setInterval(function(){ $('#fraction').append('<u>fracting every approximately 3000 milliseconds</u> '); }, 3000);

//last_page_selected_text = '';
//last_iframe1_selected_text = '';
setInterval(function(){
  //var selectedText = '';
  if (window.getSelection) {
      selectedText = window.getSelection();
  } else if (document.getSelection) {
      selectedText = document.getSelection();
  } else if (document.selection) {
      selectedText = document.selection.createRange().text;
  } else return;
  // To write the selected text into the textarea
  //document.testform.selectedtext.value = selectedText;
  //if(last_page_selected_text == selectedText) {
  if($('#page_last_fraction').val() == selectedText) {
    // don't repeat it
  } else {
    $('#fraction').append('<u>' + selectedText + '</u> ');
    //last_page_selected_text = selectedText;
    $('#page_last_fraction').val(selectedText);
  }

  console.log('herei001');
  iframe1 = document.getElementById('iframe1');
  var win = iframe1.contentWindow; // reference to iframe's window
  var doc = iframe1.contentDocument? iframe1.contentDocument:
        iframe1.contentWindow.document;
  //var selectedText = '';
  console.log('herei002');
  if(win.getSelection) {
    console.log('herei003');
    //alert('afocus001');
    selectedText = win.getSelection();
  } else if (doc.getSelection) {
    console.log('herei004');
    //alert('afocus002');
    selectedText = doc.getSelection();
  } else if (doc.selection) {
    console.log('herei005');
    //alert('afocus003');
    selectedText = doc.selection.createRange().text;
  } else return;
  console.log('$(\'#frame1_last_fraction\').val(), selectedText: ' + $('#frame1_last_fraction').val() + ', ' + selectedText);
  // To write the selected text into the textarea
  //document.testform.selectedtext.value = selectedText;
  //if(last_iframe1_selected_text == selectedText) {
  if($('#frame1_last_fraction').val() == selectedText) {
    // don't repeat it
    console.log('herei007');
  } else {
    $('#fraction').append('<u>' + selectedText + '</u> ');
    //last_iframe1_selected_text = selectedText;
    $('#frame1_last_fraction').val(selectedText)
  }

//}, 5000); // configuration
}, 100); // configuration

/*setInterval(
  //() => console.log('Hello every 3 seconds'),
  () => $('#fraction').append('<u>fracting every approximately 3000 milliseconds</u> ');
  3000
);*/

/*function myFunction() {
  document.getElementById("demo").innerHTML = "Hello World";
}*/
/*$('*').click(function() {
  //$( this ).slideUp();
  //alert('click');
  $('#fraction').append('<u>click</u> ');
});*/

// onclick

// highlight
//https://stackoverflow.com/questions/16018598/how-to-get-a-reference-to-an-iframes-window-object-inside-iframes-onload-handl
//https://blog.logrocket.com/the-ultimate-guide-to-iframes/
//https://www.dyn-web.com/tutorials/iframes/refs/frames.php
// what about the iframes?

// will need to keep track of frames created and destroyed instead of hard-coding 3 frames
//alert('window.frames.length: ' + window.frames.length);

//$('a').mouseup(function() {
//alert('test003');
//});
//$('#iframe2').mouseup(function() {
//alert('test002');
//});
//$('*').mouseup(function() {
//alert('test001');
//});

$('#iframe1').mouseup(function() {
    alert('mouseup iframe1');
    var win = iframe1.contentWindow; // reference to iframe's window
    var doc = iframe1.contentDocument? iframe1.contentDocument:
          iframe1.contentWindow.document;
    var selectedText = '';
    if(win.getSelection) {
        //alert('focus001');
        selectedText = win.getSelection();
    } else if (doc.getSelection) {
        //alert('focus002');
        selectedText = doc.getSelection();
    } else if (doc.selection) {
        //alert('focus003');
        selectedText = doc.selection.createRange().text;
    } else return;
    // To write the selected text into the textarea
    //document.testform.selectedtext.value = selectedText;
    $('#fraction').append('<u>' + selectedText + '</u> ');
});

$('#iframe2').mouseup(function() {
    alert('mouseup iframe2');
    iframe2 = document.getElementById('iframe2');
    var win = iframe2.contentWindow; // reference to iframe's window
    var doc = iframe2.contentDocument? iframe2.contentDocument:
          iframe2.contentWindow.document;
    var selectedText = '';
    if(win.getSelection) {
        //alert('focus001');
        selectedText = win.getSelection();
    } else if (doc.getSelection) {
        //alert('focus002');
        selectedText = doc.getSelection();
    } else if (doc.selection) {
        //alert('focus003');
        selectedText = doc.selection.createRange().text;
    } else return;
    // To write the selected text into the textarea
    //document.testform.selectedtext.value = selectedText;
    $('#fraction').append('<u>' + selectedText + '</u> ');
});

$('#iframe3').mouseup(function() {
    alert('mouseup iframe3');
    iframe3 = document.getElementById('iframe3');
    var win = iframe3.contentWindow; // reference to iframe's window
    var doc = iframe3.contentDocument? iframe3.contentDocument:
          iframe3.contentWindow.document;
    var selectedText = '';
    if(win.getSelection) {
        //alert('focus001');
        selectedText = win.getSelection();
    } else if (doc.getSelection) {
        //alert('focus002');
        selectedText = doc.getSelection();
    } else if (doc.selection) {
        //alert('focus003');
        selectedText = doc.selection.createRange().text;
    } else return;
    // To write the selected text into the textarea
    //document.testform.selectedtext.value = selectedText;
    $('#fraction').append('<u>' + selectedText + '</u> ');
});

// for the whole window, not the iframes specifically, so grabbing what is clicked or selected in it but not in an iframe is not our goal but this code is the function that does it
function getSelectedText() {
    var selectedText = '';
    if (window.getSelection) {
        selectedText = window.getSelection();
    } else if (document.getSelection) {
        selectedText = document.getSelection();
    } else if (document.selection) {
        selectedText = document.selection.createRange().text;
    } else return;
    // To write the selected text into the textarea
    //document.testform.selectedtext.value = selectedText;
    $('#fraction').append('<u>' + selectedText + '</u> ');
}
function getSelectedText1() {
  alert('a mouseup iframe1');
iframe1 = document.getElementById('iframe1');
  var win = iframe1.contentWindow; // reference to iframe's window
  var doc = iframe1.contentDocument? iframe1.contentDocument:
        iframe1.contentWindow.document;
  var selectedText = '';
  if(win.getSelection) {
      alert('afocus001');
      selectedText = win.getSelection();
  } else if (doc.getSelection) {
      alert('afocus002');
      selectedText = doc.getSelection();
  } else if (doc.selection) {
      alert('afocus003');
      selectedText = doc.selection.createRange().text;
  } else return;
  // To write the selected text into the textarea
  //document.testform.selectedtext.value = selectedText;
  $('#fraction').append('<u>' + selectedText + '</u> ');
}
/*window.top.postMessage('reply', '*');
window.onmessage = function(event){
    if (event.data == 'reply') {
        console('Reply received!');
    }
};*/
/*$('input').select(function() {
  $( "div" ).text( "Something was selected" ).show().fadeOut( 1000 );
});*/
/*var words = $( "p" ).first().text().split( /\s+/ );
var text = words.join( "</span> <span>" );
$( "p" ).first().html( "<span>" + text + "</span>" );
$( "span" ).on( "click", function() {
$( this ).css( "background-color", "red" );
});*/

// hover

// triangulate or, in other words, take more than one piece of data -> AI
</script>
</head>
<body>
<p>wesnoth WML wiki iframes</p>
<iframe id="iframe1" src="frame1.html" height="480">
  <!DOCTYPE html>
  <!-- saved from url=(0051)https://wiki.wesnoth.org/WML_for_Complete_Beginners -->
  <html class="client-js flexbox flexwrap" lang="en" dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

  <title>WML for Complete Beginners - The Battle for Wesnoth Wiki</title>
  <script>document.documentElement.className = document.documentElement.className.replace( /(^|\s)client-nojs(\s|$)/, "$1client-js$2" );</script>
  <script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgCanonicalNamespace":"","wgCanonicalSpecialPageName":false,"wgNamespaceNumber":0,"wgPageName":"WML_for_Complete_Beginners","wgTitle":"WML for Complete Beginners","wgCurRevisionId":67934,"wgRevisionId":67934,"wgArticleId":5083,"wgIsArticle":true,"wgIsRedirect":false,"wgAction":"view","wgUserName":null,"wgUserGroups":["*"],"wgCategories":["WML for Complete Beginners"],"wgBreakFrames":false,"wgPageContentLanguage":"en","wgPageContentModel":"wikitext","wgSeparatorTransformTable":["",""],"wgDigitTransformTable":["",""],"wgDefaultDateFormat":"dmy","wgMonthNames":["","January","February","March","April","May","June","July","August","September","October","November","December"],"wgMonthNamesShort":["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"wgRelevantPageName":"WML_for_Complete_Beginners","wgRelevantArticleId":5083,"wgRequestId":"908c1ddf102878d2a5888f0a","wgIsProbablyEditable":false,"wgRelevantPageIsProbablyEditable":false,"wgRestrictionEdit":[],"wgRestrictionMove":[],"wgWikiEditorEnabledModules":[]});mw.loader.state({"site.styles":"ready","noscript":"ready","user.styles":"ready","user":"ready","user.options":"ready","user.tokens":"loading","ext.CookieWarning.styles":"ready","mediawiki.legacy.shared":"ready","mediawiki.legacy.commonPrint":"ready","mediawiki.sectionAnchor":"ready"});mw.loader.implement("user.tokens@15m2fsb",function($,jQuery,require,module){/*@nomin*/mw.user.tokens.set({"editToken":"+\\","patrolToken":"+\\","watchToken":"+\\","csrfToken":"+\\"});
  });mw.loader.load(["site","mediawiki.page.startup","mediawiki.user","mediawiki.hidpi","mediawiki.page.ready","mediawiki.searchSuggest","ext.CookieWarning","skins.wesmere.js"]);});</script>
  <link rel="stylesheet" href="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/load.php">
  <script async="" src="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/load(1).php"></script>
  <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
  <script>
  alert('alert from within iframe1');
  $('*').click(function{
    alert('alert by click from within iframe1');
  });
  </script>
  <style>
  .suggestions{overflow:hidden;position:absolute;top:0;left:0;width:0;border:0;z-index:1099;padding:0;margin:-1px 0 0 0}.suggestions-special{position:relative;background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;margin:0;margin-top:-2px;display:none;padding:0.25em 0.25em;line-height:1.25em}.suggestions-results{background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;padding:0;margin:0}.suggestions-result{color:#000;margin:0;line-height:1.5em;padding:0.01em 0.25em;text-align:left; overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.suggestions-result-current{background-color:#2a4b8d;color:#fff}.suggestions-special .special-label{color:#72777d;text-align:left}.suggestions-special .special-query{color:#000;font-style:italic;text-align:left}.suggestions-special .special-hover{background-color:#c8ccd1}.suggestions-result-current .special-label,.suggestions-result-current .special-query{color:#fff}.highlight{font-weight:bold}</style><style>
  .suggestions a.mw-searchSuggest-link,.suggestions a.mw-searchSuggest-link:hover,.suggestions a.mw-searchSuggest-link:active,.suggestions a.mw-searchSuggest-link:focus{color:#000;text-decoration:none}.suggestions-result-current a.mw-searchSuggest-link,.suggestions-result-current a.mw-searchSuggest-link:hover,.suggestions-result-current a.mw-searchSuggest-link:active,.suggestions-result-current a.mw-searchSuggest-link:focus{color:#fff}.suggestions a.mw-searchSuggest-link .special-query{ overflow:hidden;text-overflow:ellipsis;white-space:nowrap}</style><meta name="ResourceLoaderDynamicStyles" content="">
  <link rel="stylesheet" href="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/load(2).php">
  <meta name="generator" content="MediaWiki 1.31.16">
  <meta name="description" content="Welcome to the WML Guide for Complete Beginners!  From here, you can get started directly by heading to the Introduction or you can continue from the chapter you left off.">
  <link rel="shortcut icon" href="https://wiki.wesnoth.org/favicon.ico">
  <link rel="search" type="application/opensearchdescription+xml" href="https://wiki.wesnoth.org/opensearch_desc.php" title="The Battle for Wesnoth Wiki (en)">
  <link rel="EditURI" type="application/rsd+xml" href="https://wiki.wesnoth.org/api.php?action=rsd">
  <link rel="alternate" type="application/atom+xml" title="The Battle for Wesnoth Wiki Atom feed" href="https://wiki.wesnoth.org/index.php?title=Special:RecentChanges&amp;feed=atom">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/css" type="text/css">
  <link rel="stylesheet" type="text/css" href="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/wesmere-1.1.9.css">
  <script src="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/modernizr.js"></script><script src="./WML for Complete Beginners - The Battle for Wesnoth Wiki_files/load(3).php"></script>
  <link rel="apple-touch-icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/apple-touch-icon.png" sizes="180x180">
  <link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-32.png" sizes="32x32">
  <link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-16.png" sizes="16x16">
  <!--[if lt IE 9]><script src="/load.php?debug=false&amp;lang=en&amp;modules=html5shiv&amp;only=scripts&amp;skin=Wesmere&amp;sync=1"></script><![endif]-->
  </head>
  <body class="mediawiki ltr sitedir-ltr mw-hide-empty-elt ns-0 ns-subject page-WML_for_Complete_Beginners rootpage-WML_for_Complete_Beginners skin-Wesmere action-view"><div class="mw-cookiewarning-container"><div class="mw-cookiewarning-text"><span>Cookies help us deliver our services. By using our services, you agree to our use of cookies.</span><form method="POST"><input name="disablecookiewarning" class="mw-cookiewarning-dismiss" type="submit" value="OK"></form></div></div>
  <div id="main">

  <div id="nav" role="banner">
  <div class="centerbox">

  	<div id="logo">
  		<a href="https://www.wesnoth.org/" aria-label="Wesnoth logo"></a>
  	</div>

  	<ul id="navlinks">
  		<li><a href="https://www.wesnoth.org/">Home</a></li>
  		<li><a href="https://forums.wesnoth.org/viewforum.php?f=62">News</a></li>
  		<li><a href="https://wiki.wesnoth.org/Play">Play</a></li>
  		<li><a href="https://wiki.wesnoth.org/Create">Create</a></li>
  		<li><a href="https://forums.wesnoth.org/">Forums</a></li>
  		<li><a href="https://wiki.wesnoth.org/Project">About</a></li>
  	</ul>

  	<div id="sitesearch" role="search">
  		<form method="get" action="https://wiki.wesnoth.org/index.php">
  			<input id="searchbox" type="search" name="search" placeholder="Search" value="" title="Search this wiki [ctrl-option-f]" accesskey="f">
  			<span id="searchbox-controls">
  				<button id="search-go" class="search-button" type="submit" title="Search">
  					<i class="search-icon" aria-hidden="true"></i>
  					<span class="sr-label">Search this wiki</span>
  				</button>
  			</span>
  		</form>
  	</div>

  	<div class="reset"></div>
  </div>
  </div>


  <div id="content" class="mw-content" role="main">
  	<a id="top"></a>
  	<div id="wm-wiki-toolbar" role="toolbar"><ul class="wm-toolbar" role="toolbar" aria-label="Wiki"><li id="ca-nstab-main" class="selected"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners" role="button" title="View the content page [ctrl-option-c]" accesskey="c"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Page</span></a></li><li id="ca-talk" class="new"><a href="https://wiki.wesnoth.org/index.php?title=Talk:WML_for_Complete_Beginners&amp;action=edit&amp;redlink=1" rel="discussion" role="button" title="Discussion about the content page (page does not exist) [ctrl-option-t]" accesskey="t"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Discussion</span></a></li><li id="ca-history"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;action=history" role="button" title="Past revisions of this page [ctrl-option-h]" accesskey="h"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">History</span></a></li><li id="wm-places-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners#" title="Places" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Places</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="n-mainpage-description"><a href="https://wiki.wesnoth.org/Main_Page" role="menuitem" title="Visit the main page [ctrl-option-z]" accesskey="z"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Main page</span></a></li><li id="n-recentchanges"><a href="https://wiki.wesnoth.org/Special:RecentChanges" role="menuitem" title="A list of recent changes in the wiki [ctrl-option-r]" accesskey="r"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Recent changes</span></a></li><li id="n-randompage"><a href="https://wiki.wesnoth.org/Special:Random" role="menuitem" title="Load a random page [ctrl-option-x]" accesskey="x"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Random page</span></a></li><li id="n-help-mediawiki"><a href="https://www.mediawiki.org/wiki/Special:MyLanguage/Help:Contents" role="menuitem"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Help about MediaWiki</span></a></li></ul></li><li id="wm-advanced-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners#" title="Advanced" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Advanced</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="ca-viewsource"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;action=edit" role="menuitem" title="This page is protected.
  You can view its source [ctrl-option-e]" accesskey="e"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>View source</span></a></li><li id="t-whatlinkshere"><a href="https://wiki.wesnoth.org/Special:WhatLinksHere/WML_for_Complete_Beginners" role="menuitem" title="A list of all wiki pages that link here [ctrl-option-j]" accesskey="j"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>What links here</span></a></li><li id="t-recentchangeslinked"><a href="https://wiki.wesnoth.org/Special:RecentChangesLinked/WML_for_Complete_Beginners" rel="nofollow" role="menuitem" title="Recent changes in pages linked from this page [ctrl-option-k]" accesskey="k"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Related changes</span></a></li><li id="t-specialpages"><a href="https://wiki.wesnoth.org/Special:SpecialPages" role="menuitem" title="A list of all special pages [ctrl-option-q]" accesskey="q"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Special pages</span></a></li><li id="t-permalink"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;oldid=67934" role="menuitem" title="Permanent link to this revision of the page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Permanent link</span></a></li><li id="t-info"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;action=info" role="menuitem" title="More information about this page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Page information</span></a></li></ul></li></ul><ul class="wm-toolbar" role="toolbar" aria-label="User"><li id="wm-account-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners#" title="Your account" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Not logged in</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="pt-login"><a href="https://wiki.wesnoth.org/index.php?title=Special:UserLogin&amp;returnto=WML+for+Complete+Beginners" role="menuitem" title="You are encouraged to log in; however, it is not mandatory [ctrl-option-o]" accesskey="o"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Log in</span></a></li></ul></li></ul></div> <!-- wm-wiki-toolbar -->	<h1 class="firstHeading" lang="en">WML for Complete Beginners</h1>


  	<div id="bodyContent">
  					<div id="siteSub">From The Battle for Wesnoth Wiki</div>
  				<div id="contentSub"></div>

  		<!-- start wikipage -->
  		<div id="mw-content-text" lang="en" dir="ltr" class="mw-content-ltr"><div class="mw-parser-output"><div class="wikilangbox">
  <div class="wikilangs-caption" title="Other languages"><a href="https://wiki.wesnoth.org/Template:Translations" title="Template:Translations"><i class="fa fa-2x fa-globe"></i><span class="sr-label">Other languages:</span></a></div>
  <div class="wikilangs">
  <ul><li><a class="mw-selflink selflink">English</a></li><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners/zh-Hans" title="WML for Complete Beginners/zh-Hans">简体中文</a></li></ul>
  </div>
  </div>
  <p><br>
  Welcome to the WML Guide for Complete Beginners!  From here, you can get started directly by heading to the <a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Introduction" title="WML for Complete Beginners: Introduction">Introduction</a> or you can continue from the chapter you left off.
  </p>
  <h2><span class="mw-headline" id="Note_for_Improvements:">Note for Improvements:</span></h2>
  <p>1. Add to the numbers definition that numbers can include decimal point values (and reference the fact that WML will remove any unnecessary 0's when it performs the calculations or accesses the numerical value in question).
  </p><p>2. Finish chapters 6-11 (Partially Complete)
  </p>
  <hr>
  <h2><span class="mw-headline" id="Main_Index">Main Index</span></h2>
  <p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Introduction" title="WML for Complete Beginners: Introduction">WML_for_Complete_Beginners:_Introduction</a>
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_1" title="WML for Complete Beginners: Chapter 1">WML_for_Complete_Beginners:_Chapter_1</a> Syntax
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_2" title="WML for Complete Beginners: Chapter 2">WML_for_Complete_Beginners:_Chapter_2</a> The Userdata Directory and the Campaign Folder
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3" title="WML for Complete Beginners: Chapter 3">WML_for_Complete_Beginners:_Chapter_3</a> The _main.cfg
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_4" title="WML for Complete Beginners: Chapter 4">WML_for_Complete_Beginners:_Chapter_4</a> Creating Your First Scenario
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_5" title="WML for Complete Beginners: Chapter 5">WML_for_Complete_Beginners:_Chapter_5</a> Events
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_6" title="WML for Complete Beginners: Chapter 6">WML_for_Complete_Beginners:_Chapter_6</a> Custom Units
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_7" title="WML for Complete Beginners: Chapter 7">WML_for_Complete_Beginners:_Chapter_7</a> Variables Introduction
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8" title="WML for Complete Beginners: Chapter 8">WML_for_Complete_Beginners:_Chapter_8</a> Non-scalar Variables
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_9" title="WML for Complete Beginners: Chapter 9">WML_for_Complete_Beginners:_Chapter_9</a> Macros
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_10" title="WML for Complete Beginners: Chapter 10">WML_for_Complete_Beginners:_Chapter_10</a> Logic
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_11" title="WML for Complete Beginners: Chapter 11">WML_for_Complete_Beginners:_Chapter_11</a> More Logic
  </p><p><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Conclusion" title="WML for Complete Beginners: Conclusion">WML_for_Complete_Beginners:_Conclusion</a>
  </p>
  <!--
  NewPP limit report
  Cached time: 20211207190834
  Cache expiry: 86400
  Dynamic content: false
  CPU time usage: 0.011 seconds
  Real time usage: 0.013 seconds
  Preprocessor visited node count: 186/1000000
  Preprocessor generated node count: 363/1000000
  Post‐expand include size: 1529/2097152 bytes
  Template argument size: 64/2097152 bytes
  Highest expansion depth: 5/40
  Expensive parser function count: 18/100
  Unstrip recursion depth: 0/20
  Unstrip post‐expand size: 0/5000000 bytes
  -->
  <!--
  Transclusion expansion time report (%,ms,calls,template)
  100.00%    7.260      1 -total
  100.00%    7.260      1 Template:Translations
   77.12%    5.599     18 Template:TranslationsHelper
  -->
  </div>
  <!-- Saved in parser cache with key wiki-mw_:pcache:idhash:5083-0!canonical and timestamp 20211207190834 and revision id 67934
   -->
  </div>		<!-- end wikipage -->

  					<div class="printfooter">
  				Retrieved from "<a dir="ltr" href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;oldid=67934">https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners&amp;oldid=67934</a>"			</div>
  		<div id="catlinks" class="catlinks" data-mw="interface"><div id="mw-normal-catlinks" class="mw-normal-catlinks"><a href="https://wiki.wesnoth.org/Special:Categories" title="Special:Categories">Category</a>: <ul><li><a href="https://wiki.wesnoth.org/Category:WML_for_Complete_Beginners" title="Category:WML for Complete Beginners">WML for Complete Beginners</a></li></ul></div></div><div id="lastmod"> This page was last edited on 20 May 2021, at 00:18.</div>		<div class="visualClear"></div>
  			</div> <!-- bodyContent -->

  </div> <!-- end content -->

  </div> <!-- end main -->

  <div id="footer-sep"></div>

  <div id="footer"><div id="footer-content"><div>
  	<a href="https://wiki.wesnoth.org/StartingPoints">Site Map</a> • <a href="https://status.wesnoth.org/">Site Status</a><br>
  	Copyright © 2003–2021 by <a rel="author" href="https://wiki.wesnoth.org/Project">The Battle for Wesnoth Project</a>. Powered by <a href="https://www.mediawiki.org/">MediaWiki</a>.<br>
  	Site design Copyright © 2017–2021 by Iris Morelle.
  </div></div></div>

  <script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgPageParseReport":{"limitreport":{"cputime":"0.011","walltime":"0.013","ppvisitednodes":{"value":186,"limit":1000000},"ppgeneratednodes":{"value":363,"limit":1000000},"postexpandincludesize":{"value":1529,"limit":2097152},"templateargumentsize":{"value":64,"limit":2097152},"expansiondepth":{"value":5,"limit":40},"expensivefunctioncount":{"value":18,"limit":100},"unstrip-depth":{"value":0,"limit":20},"unstrip-size":{"value":0,"limit":5000000},"timingprofile":["100.00%    7.260      1 -total","100.00%    7.260      1 Template:Translations"," 77.12%    5.599     18 Template:TranslationsHelper"]},"cachereport":{"timestamp":"20211207190834","ttl":86400,"transientcontent":false}}});});</script><script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgBackendResponseTime":23});});</script></body></html>
</iframe>
<iframe id="iframe2" src="frame2.html" height="480">
<!DOCTYPE html>
<!-- saved from url=(0062)https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3 -->
<html class="client-js flexbox flexwrap" lang="en" dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>WML for Complete Beginners: Chapter 3 - The Battle for Wesnoth Wiki</title>
<script>document.documentElement.className = document.documentElement.className.replace( /(^|\s)client-nojs(\s|$)/, "$1client-js$2" );</script>
<script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgCanonicalNamespace":"","wgCanonicalSpecialPageName":false,"wgNamespaceNumber":0,"wgPageName":"WML_for_Complete_Beginners:_Chapter_3","wgTitle":"WML for Complete Beginners: Chapter 3","wgCurRevisionId":69082,"wgRevisionId":69082,"wgArticleId":5678,"wgIsArticle":true,"wgIsRedirect":false,"wgAction":"view","wgUserName":null,"wgUserGroups":["*"],"wgCategories":["WML for Complete Beginners"],"wgBreakFrames":false,"wgPageContentLanguage":"en","wgPageContentModel":"wikitext","wgSeparatorTransformTable":["",""],"wgDigitTransformTable":["",""],"wgDefaultDateFormat":"dmy","wgMonthNames":["","January","February","March","April","May","June","July","August","September","October","November","December"],"wgMonthNamesShort":["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"wgRelevantPageName":"WML_for_Complete_Beginners:_Chapter_3","wgRelevantArticleId":5678,"wgRequestId":"bcaa3400078a92718f035d1d","wgIsProbablyEditable":false,"wgRelevantPageIsProbablyEditable":false,"wgRestrictionEdit":[],"wgRestrictionMove":[],"wgWikiEditorEnabledModules":[]});mw.loader.state({"site.styles":"ready","noscript":"ready","user.styles":"ready","user":"ready","user.options":"ready","user.tokens":"loading","ext.CookieWarning.styles":"ready","mediawiki.legacy.shared":"ready","mediawiki.legacy.commonPrint":"ready","mediawiki.sectionAnchor":"ready"});mw.loader.implement("user.tokens@15m2fsb",function($,jQuery,require,module){/*@nomin*/mw.user.tokens.set({"editToken":"+\\","patrolToken":"+\\","watchToken":"+\\","csrfToken":"+\\"});
});mw.loader.load(["site","mediawiki.page.startup","mediawiki.user","mediawiki.hidpi","mediawiki.page.ready","mediawiki.toc","mediawiki.searchSuggest","ext.CookieWarning","skins.wesmere.js"]);});</script>
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/load.php">
<script async="" src="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/load(1).php"></script>
<style>
@media screen {
	.tochidden,.toctoggle{-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none}.toctoggle{font-size:94%}}
@media print {
	.toc.tochidden,.toctoggle{display:none}}
.suggestions{overflow:hidden;position:absolute;top:0;left:0;width:0;border:0;z-index:1099;padding:0;margin:-1px 0 0 0}.suggestions-special{position:relative;background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;margin:0;margin-top:-2px;display:none;padding:0.25em 0.25em;line-height:1.25em}.suggestions-results{background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;padding:0;margin:0}.suggestions-result{color:#000;margin:0;line-height:1.5em;padding:0.01em 0.25em;text-align:left; overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.suggestions-result-current{background-color:#2a4b8d;color:#fff}.suggestions-special .special-label{color:#72777d;text-align:left}.suggestions-special .special-query{color:#000;font-style:italic;text-align:left}.suggestions-special .special-hover{background-color:#c8ccd1}.suggestions-result-current .special-label,.suggestions-result-current .special-query{color:#fff}.highlight{font-weight:bold}</style><style>
.suggestions a.mw-searchSuggest-link,.suggestions a.mw-searchSuggest-link:hover,.suggestions a.mw-searchSuggest-link:active,.suggestions a.mw-searchSuggest-link:focus{color:#000;text-decoration:none}.suggestions-result-current a.mw-searchSuggest-link,.suggestions-result-current a.mw-searchSuggest-link:hover,.suggestions-result-current a.mw-searchSuggest-link:active,.suggestions-result-current a.mw-searchSuggest-link:focus{color:#fff}.suggestions a.mw-searchSuggest-link .special-query{ overflow:hidden;text-overflow:ellipsis;white-space:nowrap}</style><meta name="ResourceLoaderDynamicStyles" content="">
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/load(2).php">
<meta name="generator" content="MediaWiki 1.31.16">
<meta name="description" content="Note: this page borrows heavily from the BuildingCampaignsTheCampaignFile page.">
<link rel="shortcut icon" href="https://wiki.wesnoth.org/favicon.ico">
<link rel="search" type="application/opensearchdescription+xml" href="https://wiki.wesnoth.org/opensearch_desc.php" title="The Battle for Wesnoth Wiki (en)">
<link rel="EditURI" type="application/rsd+xml" href="https://wiki.wesnoth.org/api.php?action=rsd">
<link rel="alternate" type="application/atom+xml" title="The Battle for Wesnoth Wiki Atom feed" href="https://wiki.wesnoth.org/index.php?title=Special:RecentChanges&amp;feed=atom">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/css" type="text/css">
<link rel="stylesheet" type="text/css" href="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/wesmere-1.1.9.css">
<script src="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/modernizr.js"></script><script src="./WML for Complete Beginners_ Chapter 3 - The Battle for Wesnoth Wiki_files/load(3).php"></script>
<link rel="apple-touch-icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/apple-touch-icon.png" sizes="180x180">
<link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-32.png" sizes="32x32">
<link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-16.png" sizes="16x16">
<!--[if lt IE 9]><script src="/load.php?debug=false&amp;lang=en&amp;modules=html5shiv&amp;only=scripts&amp;skin=Wesmere&amp;sync=1"></script><![endif]-->
</head>
<body class="mediawiki ltr sitedir-ltr mw-hide-empty-elt ns-0 ns-subject page-WML_for_Complete_Beginners_Chapter_3 rootpage-WML_for_Complete_Beginners_Chapter_3 skin-Wesmere action-view"><div class="mw-cookiewarning-container"><div class="mw-cookiewarning-text"><span>Cookies help us deliver our services. By using our services, you agree to our use of cookies.</span><form method="POST"><input name="disablecookiewarning" class="mw-cookiewarning-dismiss" type="submit" value="OK"></form></div></div>
<div id="main">

<div id="nav" role="banner">
<div class="centerbox">

	<div id="logo">
		<a href="https://www.wesnoth.org/" aria-label="Wesnoth logo"></a>
	</div>

	<ul id="navlinks">
		<li><a href="https://www.wesnoth.org/">Home</a></li>
		<li><a href="https://forums.wesnoth.org/viewforum.php?f=62">News</a></li>
		<li><a href="https://wiki.wesnoth.org/Play">Play</a></li>
		<li><a href="https://wiki.wesnoth.org/Create">Create</a></li>
		<li><a href="https://forums.wesnoth.org/">Forums</a></li>
		<li><a href="https://wiki.wesnoth.org/Project">About</a></li>
	</ul>

	<div id="sitesearch" role="search">
		<form method="get" action="https://wiki.wesnoth.org/index.php">
			<input id="searchbox" type="search" name="search" placeholder="Search" value="" title="Search this wiki [ctrl-option-f]" accesskey="f">
			<span id="searchbox-controls">
				<button id="search-go" class="search-button" type="submit" title="Search">
					<i class="search-icon" aria-hidden="true"></i>
					<span class="sr-label">Search this wiki</span>
				</button>
			</span>
		</form>
	</div>

	<div class="reset"></div>
</div>
</div>


<div id="content" class="mw-content" role="main">
	<a id="top"></a>
	<div id="wm-wiki-toolbar" role="toolbar"><ul class="wm-toolbar" role="toolbar" aria-label="Wiki"><li id="ca-nstab-main" class="selected"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3" role="button" title="View the content page [ctrl-option-c]" accesskey="c"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Page</span></a></li><li id="ca-talk" class="new"><a href="https://wiki.wesnoth.org/index.php?title=Talk:WML_for_Complete_Beginners:_Chapter_3&amp;action=edit&amp;redlink=1" rel="discussion" role="button" title="Discussion about the content page (page does not exist) [ctrl-option-t]" accesskey="t"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Discussion</span></a></li><li id="ca-history"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;action=history" role="button" title="Past revisions of this page [ctrl-option-h]" accesskey="h"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">History</span></a></li><li id="wm-places-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Places" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Places</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="n-mainpage-description"><a href="https://wiki.wesnoth.org/Main_Page" role="menuitem" title="Visit the main page [ctrl-option-z]" accesskey="z"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Main page</span></a></li><li id="n-recentchanges"><a href="https://wiki.wesnoth.org/Special:RecentChanges" role="menuitem" title="A list of recent changes in the wiki [ctrl-option-r]" accesskey="r"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Recent changes</span></a></li><li id="n-randompage"><a href="https://wiki.wesnoth.org/Special:Random" role="menuitem" title="Load a random page [ctrl-option-x]" accesskey="x"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Random page</span></a></li><li id="n-help-mediawiki"><a href="https://www.mediawiki.org/wiki/Special:MyLanguage/Help:Contents" role="menuitem"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Help about MediaWiki</span></a></li></ul></li><li id="wm-advanced-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Advanced" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Advanced</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="ca-viewsource"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;action=edit" role="menuitem" title="This page is protected.
You can view its source [ctrl-option-e]" accesskey="e"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>View source</span></a></li><li id="t-whatlinkshere"><a href="https://wiki.wesnoth.org/Special:WhatLinksHere/WML_for_Complete_Beginners:_Chapter_3" role="menuitem" title="A list of all wiki pages that link here [ctrl-option-j]" accesskey="j"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>What links here</span></a></li><li id="t-recentchangeslinked"><a href="https://wiki.wesnoth.org/Special:RecentChangesLinked/WML_for_Complete_Beginners:_Chapter_3" rel="nofollow" role="menuitem" title="Recent changes in pages linked from this page [ctrl-option-k]" accesskey="k"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Related changes</span></a></li><li id="t-specialpages"><a href="https://wiki.wesnoth.org/Special:SpecialPages" role="menuitem" title="A list of all special pages [ctrl-option-q]" accesskey="q"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Special pages</span></a></li><li id="t-permalink"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;oldid=69082" role="menuitem" title="Permanent link to this revision of the page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Permanent link</span></a></li><li id="t-info"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;action=info" role="menuitem" title="More information about this page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Page information</span></a></li></ul></li></ul><ul class="wm-toolbar" role="toolbar" aria-label="User"><li id="wm-account-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Your account" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Not logged in</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="pt-login"><a href="https://wiki.wesnoth.org/index.php?title=Special:UserLogin&amp;returnto=WML+for+Complete+Beginners%3A+Chapter+3" role="menuitem" title="You are encouraged to log in; however, it is not mandatory [ctrl-option-o]" accesskey="o"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Log in</span></a></li></ul></li></ul></div> <!-- wm-wiki-toolbar -->	<h1 class="firstHeading" lang="en">WML for Complete Beginners: Chapter 3</h1>


	<div id="bodyContent">
					<div id="siteSub">From The Battle for Wesnoth Wiki</div>
				<div id="contentSub"></div>

		<!-- start wikipage -->
		<div id="mw-content-text" lang="en" dir="ltr" class="mw-content-ltr"><div class="mw-parser-output"><div id="toc" class="toc"><div class="toctitle" lang="en" dir="ltr"><h2>Contents</h2><span class="toctoggle">&nbsp;[<a role="button" tabindex="0" class="togglelink">hide</a>]&nbsp;</span></div>
<ul>
<li class="toclevel-1 tocsection-1"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#Chapter_3:_The_main.cfg"><span class="tocnumber">1</span> <span class="toctext">Chapter 3: The _main.cfg</span></a>
<ul>
<li class="toclevel-2 tocsection-2"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#The_Text_Domain"><span class="tocnumber">1.1</span> <span class="toctext">The Text Domain</span></a></li>
<li class="toclevel-2 tocsection-3"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#Defining_the_Campaign"><span class="tocnumber">1.2</span> <span class="toctext">Defining the Campaign</span></a></li>
<li class="toclevel-2 tocsection-4"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#The_Preprocessor"><span class="tocnumber">1.3</span> <span class="toctext">The Preprocessor</span></a>
<ul>
<li class="toclevel-3 tocsection-5"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#Preprocessor_Directives"><span class="tocnumber">1.3.1</span> <span class="toctext">Preprocessor Directives</span></a></li>
<li class="toclevel-3 tocsection-6"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#The_Binary_Path"><span class="tocnumber">1.3.2</span> <span class="toctext">The Binary Path</span></a></li>
<li class="toclevel-3 tocsection-7"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#Directory_Inclusion"><span class="tocnumber">1.3.3</span> <span class="toctext">Directory Inclusion</span></a></li>
</ul>
</li>
</ul>
</li>
</ul>
</div>

<h2><span class="mw-headline" id="Chapter_3:_The_main.cfg">Chapter 3: The _main.cfg</span></h2>
<p>Note: this page borrows heavily from the <a href="https://wiki.wesnoth.org/BuildingCampaignsTheCampaignFile" title="BuildingCampaignsTheCampaignFile">BuildingCampaignsTheCampaignFile</a> page.
</p><p>So we've created a campaign folder, but as of yet the game doesn't even know this new folder exists. In order for the game to find the folder, we have to create a special file called "_main.cfg" that tells the game where to find all of your campaign's data. Without this file, the game won't be able to find your campaign when it starts up, and consequently you won't be able to play your campaign.
</p><p>So let's get started creating a "_main.cfg" file so that the game can find your campaign.
</p><p>Navigate to your campaign folder, if you aren't already there. Now create a new text file and name it "_main.cfg" (just like that, including the underscore but without the quotes). Make sure you select a save-type of 'all files' and not 'text document (.txt)' for this file.  If you selected 'text document (.txt)' you will actually save a file named "_main.cfg.txt" which will not be recognized by Wesnoth.  Now you have created a file called "_main.cfg", but we're not done yet. Right now the file is empty, so the game still won't be able to locate your campaign yet. But fear not, all you have to do is write some specific WML inside the "_main.cfg" file and the game will be able to find your campaign just fine.
</p>
<h3><span class="mw-headline" id="The_Text_Domain">The Text Domain</span></h3>
<p>Open the "_main.cfg" file in your text editor if you haven't already. and add the following tagset:
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[textdomain]
[/textdomain]
</pre></div>
<p>This tagset which specifies where the game should look for translations to the strings in the campaign (at this stage you probably won't have any translations, but it's a common practice to add a text domain just in case you get translations later on). The textdomain tag specifies a name for the textdomain, which is what is used in the [campaign] tag, and is used in campaign scenarios to connect the strings with translations.
</p><p>Inside the [textdomain] tag, include the attributes <b>name</b> and <b>path</b> (don't assign values to them just yet, we'll do that in a moment):
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[textdomain]
    name=
    path=
[/textdomain]
</pre></div>
<ul><li><b>The "name" Attribute</b></li></ul>
<p>The attribute <b>name</b> specifies the name of the text domain you are creating. The textdomain name should be unique, and start with 'wesnoth-', to ensure that it does not conflict with other textdomains that might be specified on a given system. Let's name our text domain "my_first_campaign". Don't forget to start it with "wesnoth-". Now the contents of your _main.cfg file should look exactly like this:
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[textdomain]
    name="wesnoth-my_first_campaign"
    path=
[/textdomain]
</pre></div>
<ul><li><b>The "path" Attribute</b></li></ul>
<p>The attribute <b>path</b> specifies a path to the directory where the compiled translation files will be stored. This should be a file inside the campaign directory. Right now our translations folder is empty, but if you ever get translations for your campaign, this is the folder in which they would go. Let's assign the "translations" folder directory path, which should be "data/add-ons/my_first_campaign/translations",  to this attribute. Your _main.cfg should now look like this:
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[textdomain]
    name="wesnoth-my_first_campaign"
    path="data/add-ons/my_first_campaign/translations"
[/textdomain]
</pre></div>
<h3><span class="mw-headline" id="Defining_the_Campaign">Defining the Campaign</span></h3>
<p>And now we're going to add the [campaign] tagset. Yes, it's our old friend, the [campaign] tagset, from Chapter 1.
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[campaign]
[/campaign]
</pre></div>
<p>Next, inside the [campaign] tagset, include the following line:
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">    #textdomain wesnoth-my_first_campaign
</pre></div>
<p>This tells the game that the text strings in this file belong to the text domain you just defined above
</p><p>Next we need to give the attributes <b>id</b>,<b>name</b>,<b>abbrev</b>,<b>icon</b>,<b>image</b>,<b>first_scenario</b>,<b>description</b>,<b>difficulties</b>, and <b>difficulty_descriptions</b>. Don't assign any values to these attributes yet, we'll do that in a moment. For now, just make sure that you have all of these attributes in between the campaign tags, like so (the exact order of the attributes doesn't matter, but it is recommended that you follow the order given below to make things easier for yourself when following this tutorial):
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Expand" class="cb-expand" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Expand</span></a></li><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[campaign]
    #textdomain wesnoth-my_first_campaign
    id=
    name=
    abbrev=
    define=
    icon=
    image=
    first_scenario=
    description=
    difficulties=
    difficulty_descriptions=
[/campaign]
</pre></div>
<p>Now let's go over the attributes one by one and give them their values. I'll give you a specific value to assign to each attribute, and then I'll explain why we use that particular value.
</p>
<ul><li><b>The "id" Attribute</b></li></ul>
<dl><dd>The unique identifier of your campaign. The value of an "id" attribute can only contain lowercase alphanumeric characters and underscores. We are going to give this attribute the value "my_first_campaign", like so:</dd></dl>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">id=my_first_campaign
</pre></div>
<ul><li><b>The "name" Attribute</b></li></ul>
<dl><dd>The name of your campaign. This translatable string is the name that will show up in the in-game campaign menu, where you can select which campaign you want to play. Let's give it the value "My First Campaign". Since we want this string to be translatable, don't forget to include the translation mark (the underscore) in front of the first double quote.</dd></dl>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">name= _ "My First Campaign"
</pre></div>
<ul><li><b>The "abbrev" Attribute</b></li></ul>
<dl><dd>This attribute defines a campaign abbreviation that will be used as a prefix for the names of save files from that campaign. It should generally consist of the acronym of the campaign's name (i.e., the first letter of each of the words in the campaign's name, capitalized).</dd></dl>
<ul><li><b>The "define" Attribute</b></li></ul>
<p>This attribute creates a key that lets the game know when a user has selected to play a scenario from your campaign.
</p>
<ul><li><b>The "icon" Attribute</b></li></ul>
<p>The image that will be displayed next to the name of your campaign in the in-game campaign selection menu. Since we need the game to locate a specific file, we [...]
</p>
<ul><li><b>The "image" Attribute</b></li></ul>
<p>This defines the image that will appear under your campaign's description when your campaign is selected in the in-game campaign selection menu.
</p>
<ul><li><b>The "first_scenario" Attribute</b></li></ul>
<ul><li><b>The "description" Attribute</b></li></ul>
<ul><li><b>The "difficulties" Attribute</b></li></ul>
<ul><li><b>The "difficulty_descriptions" Attribute</b></li></ul>
<p><b>Note:</b> <i><b>(<a href="https://wiki.wesnoth.org/DevFeature" title="DevFeature">Version 1.13.2 and later only</a>)</b></i> The "difficulties" and "difficulty_descriptions" attributes have been replaced by the <a href="https://wiki.wesnoth.org/CampaignWML" title="CampaignWML">difficulty</a> tag. Please refer to a <a href="https://wiki.wesnoth.org/MakingCampaignInWML2#Difficulty" title="MakingCampaignInWML2">more recently-written tutorial</a>, and in that tutorial read on to its <a href="https://wiki.wesnoth.org/MakingCampaignInWML2#MACROS" title="MakingCampaignInWML2">macros</a> section too.
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Expand" class="cb-expand" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Expand</span></a></li><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[campaign]
    #textdomain wesnoth-my_first_campaign
    id=my_first_campaign
    name= _ "My First Campaign"
    abbrev= _ "MFC"
    define=CAMPAIGN_MY_FIRST_CAMPAIGN
    icon=
    image=
    first_scenario=my_first_scenario
    description= _ "This is my first campaign."
    difficulties=EASY
    difficulty_descriptions=
[/campaign]
</pre></div>
<h3><span class="mw-headline" id="The_Preprocessor">The Preprocessor</span></h3>
<p>Before any WML file is read by Wesnoth, it goes through the preprocessor. The preprocessor will prepare the file to be read by the game. It doesn't actually recognize WML. In fact, it ignores it. Instead, it reads the <b>preprocessor directives</b>, used to create and use <a rel="nofollow" class="external text" href="https://www.wesnoth.org/macro-reference.xhtml">macros</a>. Macros are used to reduce the repetition of information just like pronouns do with names and identifiers in the English language. Don't worry about macros now, we will talk about them later.
</p><p><br>
</p>
<h4><span class="mw-headline" id="Preprocessor_Directives">Preprocessor Directives</span></h4>
<p>As mentioned above, the Preprocessor doesn't recognize WML code. It only recognizes <b>preprocessor directives</b>. While apparently similar to comments, they have a much greater impact on the code. Not only can they define and use macros, they can also be used to apply a condition for the reading of a part of the file by Wesnoth (making a part of the code be read only if you are in the Hard difficulty, for example). Using preprocessor directives can create many things, but don't worry about it yet. We will talk about it in the future.
</p><p><br>
</p>
<h4><span class="mw-headline" id="The_Binary_Path">The Binary Path</span></h4>
<p>The binary path is used to tell the game to include a certain directory in the userdata folder whenever it searches for a file. For instance, if you had a custom image in your campaign called "my_face.png", whenever the game finds a reference to that file in a scenario (e.g., you want to display that image at one of the story screens in a scenario), it will first search the core gamedata directories, then it will search any folders included in the binary path. If it cannot find the file in either the gamedata directory or in any of the directories specified in the binary path, then it will give you an error.
</p><p>You will only need to include a binary path if your campaign contains custom images, sounds or music that is not included in mainline Wesnoth. If you do not have any custom images, sounds or music, then you should not include a binary path. Since we will be including some custom images in our campaign, we are going to need to include a binary path.
</p><p><i><b>(<a href="https://wiki.wesnoth.org/DevFeature" title="DevFeature">Version 1.15.3 and later only</a>)</b></i> you should always include a binary path, because it can also be used for map files. That will be explained in the next chapter's map_file section. This will be supported in Wesnoth 1.15.3 and later, but will never be added to any version of the 1.12 or 1.14 series.
</p><p>To create a binary path, use the following syntax:
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[binary_path]
    path=data/add-ons/my_first_campaign
[/binary_path]
</pre></div>
<p>This tells the game to search the specified userdata directory whenever it cannot locate a certain file in the gamedata directory. Note that the value of the "path" key must always begin with "data/add-ons/" followed by the name of your campaign folder.
</p>
<h4><span class="mw-headline" id="Directory_Inclusion">Directory Inclusion</span></h4>
<p>(The final _main.cfg should end up looking something like this:)
</p>
<div class="codebox"><div class="codectl"><ul><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Expand" class="cb-expand" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Expand</span></a></li><li><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_3#" title="Select All" class="cb-select" role="button"><i class="cb-icon" aria-hidden="true"></i><span class="sr-or-tinyff-label">Select All</span></a></li></ul></div><pre class="">[textdomain]
    name="wesnoth-my_first_campaign"
    path="data/add-ons/my_first_campaign/translations"
[/textdomain]

#textdomain wesnoth-my_first_campaign

[campaign]
    #wesnoth-My_First_Campaign
    id=my_first_campaign
    name= _ "My First Campaign"
    abbrev= _ "MFC"
    define=CAMPAIGN_MY_FIRST_CAMPAIGN
#need icon and image (take from core files, don't include external files for sake of simplicity)
    icon=
    image=
    first_scenario=my_first_scenario
    description= _ "This is my first campaign."
    difficulties=EASY
    difficulty_descriptions={MENU_IMG_TXT2 units/undead/shadow-s-attack-4.png  _"Easy"  _""}
[/campaign]

#ifdef CAMPAIGN_MY_FIRST_CAMPAIGN

[binary_path]
    path=data/add-ons/my_first_campaign
[/binary_path]

{~add-ons/my_first_campaign/macros}
{~add-ons/my_first_campaign/utils}

{~add-ons/my_first_campaign/scenarios}
#endif
</pre></div>
<p>(note: no units yet, save that for the adding custom units section)
</p><p>Next Chapter:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_4" title="WML for Complete Beginners: Chapter 4">WML for Complete Beginners: Chapter 4</a>
</p><p>Previous Chapter:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_2" title="WML for Complete Beginners: Chapter 2">WML for Complete Beginners: Chapter 2</a>
</p><p>Return to Main Index:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners" title="WML for Complete Beginners">WML for Complete Beginners</a>
</p>
<!--
NewPP limit report
Cached time: 20211207131226
Cache expiry: 86400
Dynamic content: false
CPU time usage: 0.008 seconds
Real time usage: 0.009 seconds
Preprocessor visited node count: 44/1000000
Preprocessor generated node count: 130/1000000
Post‐expand include size: 124/2097152 bytes
Template argument size: 4/2097152 bytes
Highest expansion depth: 3/40
Expensive parser function count: 0/100
Unstrip recursion depth: 0/20
Unstrip post‐expand size: 0/5000000 bytes
-->
<!--
Transclusion expansion time report (%,ms,calls,template)
100.00%    1.337      1 -total
 51.99%    0.695      1 Template:DevFeature1.13
 42.70%    0.571      1 Template:DevFeature1.15
-->
</div>
<!-- Saved in parser cache with key wiki-mw_:pcache:idhash:5678-0!canonical and timestamp 20211207131226 and revision id 69082
 -->
</div>		<!-- end wikipage -->

					<div class="printfooter">
				Retrieved from "<a dir="ltr" href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;oldid=69082">https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_3&amp;oldid=69082</a>"			</div>
		<div id="catlinks" class="catlinks" data-mw="interface"><div id="mw-normal-catlinks" class="mw-normal-catlinks"><a href="https://wiki.wesnoth.org/Special:Categories" title="Special:Categories">Category</a>: <ul><li><a href="https://wiki.wesnoth.org/Category:WML_for_Complete_Beginners" title="Category:WML for Complete Beginners">WML for Complete Beginners</a></li></ul></div></div><div id="lastmod"> This page was last edited on 6 December 2021, at 07:24.</div>		<div class="visualClear"></div>
			</div> <!-- bodyContent -->

</div> <!-- end content -->

</div> <!-- end main -->

<div id="footer-sep"></div>

<div id="footer"><div id="footer-content"><div>
	<a href="https://wiki.wesnoth.org/StartingPoints">Site Map</a> • <a href="https://status.wesnoth.org/">Site Status</a><br>
	Copyright © 2003–2021 by <a rel="author" href="https://wiki.wesnoth.org/Project">The Battle for Wesnoth Project</a>. Powered by <a href="https://www.mediawiki.org/">MediaWiki</a>.<br>
	Site design Copyright © 2017–2021 by Iris Morelle.
</div></div></div>

<script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgPageParseReport":{"limitreport":{"cputime":"0.008","walltime":"0.009","ppvisitednodes":{"value":44,"limit":1000000},"ppgeneratednodes":{"value":130,"limit":1000000},"postexpandincludesize":{"value":124,"limit":2097152},"templateargumentsize":{"value":4,"limit":2097152},"expansiondepth":{"value":3,"limit":40},"expensivefunctioncount":{"value":0,"limit":100},"unstrip-depth":{"value":0,"limit":20},"unstrip-size":{"value":0,"limit":5000000},"timingprofile":["100.00%    1.337      1 -total"," 51.99%    0.695      1 Template:DevFeature1.13"," 42.70%    0.571      1 Template:DevFeature1.15"]},"cachereport":{"timestamp":"20211207131226","ttl":86400,"transientcontent":false}}});});</script><script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgBackendResponseTime":24});});</script></body></html>
</iframe>
<iframe id="iframe3" src="frame3.html" height="480">
<!DOCTYPE html>
<!-- saved from url=(0062)https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8 -->
<html class="client-js flexbox flexwrap" lang="en" dir="ltr"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<title>WML for Complete Beginners: Chapter 8 - The Battle for Wesnoth Wiki</title>
<script>document.documentElement.className = document.documentElement.className.replace( /(^|\s)client-nojs(\s|$)/, "$1client-js$2" );</script>
<script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgCanonicalNamespace":"","wgCanonicalSpecialPageName":false,"wgNamespaceNumber":0,"wgPageName":"WML_for_Complete_Beginners:_Chapter_8","wgTitle":"WML for Complete Beginners: Chapter 8","wgCurRevisionId":58366,"wgRevisionId":58366,"wgArticleId":5683,"wgIsArticle":true,"wgIsRedirect":false,"wgAction":"view","wgUserName":null,"wgUserGroups":["*"],"wgCategories":["WML for Complete Beginners"],"wgBreakFrames":false,"wgPageContentLanguage":"en","wgPageContentModel":"wikitext","wgSeparatorTransformTable":["",""],"wgDigitTransformTable":["",""],"wgDefaultDateFormat":"dmy","wgMonthNames":["","January","February","March","April","May","June","July","August","September","October","November","December"],"wgMonthNamesShort":["","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],"wgRelevantPageName":"WML_for_Complete_Beginners:_Chapter_8","wgRelevantArticleId":5683,"wgRequestId":"c7c40616743719d9a6697f0b","wgIsProbablyEditable":false,"wgRelevantPageIsProbablyEditable":false,"wgRestrictionEdit":[],"wgRestrictionMove":[],"wgWikiEditorEnabledModules":[]});mw.loader.state({"site.styles":"ready","noscript":"ready","user.styles":"ready","user":"ready","user.options":"ready","user.tokens":"loading","ext.CookieWarning.styles":"ready","mediawiki.legacy.shared":"ready","mediawiki.legacy.commonPrint":"ready","mediawiki.sectionAnchor":"ready"});mw.loader.implement("user.tokens@15m2fsb",function($,jQuery,require,module){/*@nomin*/mw.user.tokens.set({"editToken":"+\\","patrolToken":"+\\","watchToken":"+\\","csrfToken":"+\\"});
});mw.loader.load(["site","mediawiki.page.startup","mediawiki.user","mediawiki.hidpi","mediawiki.page.ready","mediawiki.searchSuggest","ext.CookieWarning","skins.wesmere.js"]);});</script>
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/load.php">
<script async="" src="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/load(1).php"></script>
<style>
.suggestions{overflow:hidden;position:absolute;top:0;left:0;width:0;border:0;z-index:1099;padding:0;margin:-1px 0 0 0}.suggestions-special{position:relative;background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;margin:0;margin-top:-2px;display:none;padding:0.25em 0.25em;line-height:1.25em}.suggestions-results{background-color:#fff;cursor:pointer;border:1px solid #a2a9b1;padding:0;margin:0}.suggestions-result{color:#000;margin:0;line-height:1.5em;padding:0.01em 0.25em;text-align:left; overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.suggestions-result-current{background-color:#2a4b8d;color:#fff}.suggestions-special .special-label{color:#72777d;text-align:left}.suggestions-special .special-query{color:#000;font-style:italic;text-align:left}.suggestions-special .special-hover{background-color:#c8ccd1}.suggestions-result-current .special-label,.suggestions-result-current .special-query{color:#fff}.highlight{font-weight:bold}</style><style>
.suggestions a.mw-searchSuggest-link,.suggestions a.mw-searchSuggest-link:hover,.suggestions a.mw-searchSuggest-link:active,.suggestions a.mw-searchSuggest-link:focus{color:#000;text-decoration:none}.suggestions-result-current a.mw-searchSuggest-link,.suggestions-result-current a.mw-searchSuggest-link:hover,.suggestions-result-current a.mw-searchSuggest-link:active,.suggestions-result-current a.mw-searchSuggest-link:focus{color:#fff}.suggestions a.mw-searchSuggest-link .special-query{ overflow:hidden;text-overflow:ellipsis;white-space:nowrap}</style><meta name="ResourceLoaderDynamicStyles" content="">
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/load(2).php">
<meta name="generator" content="MediaWiki 1.31.16">
<meta name="description" content="So far we have only discussed scalar variables, i.e. variables that have only one value at any given time. Believe it or not, there are types of variables than can store more than one value simultaneously, or even other variables.">
<link rel="shortcut icon" href="https://wiki.wesnoth.org/favicon.ico">
<link rel="search" type="application/opensearchdescription+xml" href="https://wiki.wesnoth.org/opensearch_desc.php" title="The Battle for Wesnoth Wiki (en)">
<link rel="EditURI" type="application/rsd+xml" href="https://wiki.wesnoth.org/api.php?action=rsd">
<link rel="alternate" type="application/atom+xml" title="The Battle for Wesnoth Wiki Atom feed" href="https://wiki.wesnoth.org/index.php?title=Special:RecentChanges&amp;feed=atom">
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/css" type="text/css">
<link rel="stylesheet" type="text/css" href="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/wesmere-1.1.9.css">
<script src="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/modernizr.js"></script><script src="./WML for Complete Beginners_ Chapter 8 - The Battle for Wesnoth Wiki_files/load(3).php"></script>
<link rel="apple-touch-icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/apple-touch-icon.png" sizes="180x180">
<link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-32.png" sizes="32x32">
<link rel="icon" type="image/png" href="https://www.wesnoth.org/wesmere/img/favicon-16.png" sizes="16x16">
<!--[if lt IE 9]><script src="/load.php?debug=false&amp;lang=en&amp;modules=html5shiv&amp;only=scripts&amp;skin=Wesmere&amp;sync=1"></script><![endif]-->
</head>
<body class="mediawiki ltr sitedir-ltr mw-hide-empty-elt ns-0 ns-subject page-WML_for_Complete_Beginners_Chapter_8 rootpage-WML_for_Complete_Beginners_Chapter_8 skin-Wesmere action-view"><div class="mw-cookiewarning-container"><div class="mw-cookiewarning-text"><span>Cookies help us deliver our services. By using our services, you agree to our use of cookies.</span><form method="POST"><input name="disablecookiewarning" class="mw-cookiewarning-dismiss" type="submit" value="OK"></form></div></div>
<div id="main">

<div id="nav" role="banner">
<div class="centerbox">

	<div id="logo">
		<a href="https://www.wesnoth.org/" aria-label="Wesnoth logo"></a>
	</div>

	<ul id="navlinks">
		<li><a href="https://www.wesnoth.org/">Home</a></li>
		<li><a href="https://forums.wesnoth.org/viewforum.php?f=62">News</a></li>
		<li><a href="https://wiki.wesnoth.org/Play">Play</a></li>
		<li><a href="https://wiki.wesnoth.org/Create">Create</a></li>
		<li><a href="https://forums.wesnoth.org/">Forums</a></li>
		<li><a href="https://wiki.wesnoth.org/Project">About</a></li>
	</ul>

	<div id="sitesearch" role="search">
		<form method="get" action="https://wiki.wesnoth.org/index.php">
			<input id="searchbox" type="search" name="search" placeholder="Search" value="" title="Search this wiki [ctrl-option-f]" accesskey="f">
			<span id="searchbox-controls">
				<button id="search-go" class="search-button" type="submit" title="Search">
					<i class="search-icon" aria-hidden="true"></i>
					<span class="sr-label">Search this wiki</span>
				</button>
			</span>
		</form>
	</div>

	<div class="reset"></div>
</div>
</div>


<div id="content" class="mw-content" role="main">
	<a id="top"></a>
	<div id="wm-wiki-toolbar" role="toolbar"><ul class="wm-toolbar" role="toolbar" aria-label="Wiki"><li id="ca-nstab-main" class="selected"><a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8" role="button" title="View the content page [ctrl-option-c]" accesskey="c"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Page</span></a></li><li id="ca-talk" class="new"><a href="https://wiki.wesnoth.org/index.php?title=Talk:WML_for_Complete_Beginners:_Chapter_8&amp;action=edit&amp;redlink=1" rel="discussion" role="button" title="Discussion about the content page (page does not exist) [ctrl-option-t]" accesskey="t"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Discussion</span></a></li><li id="ca-history"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;action=history" role="button" title="Past revisions of this page [ctrl-option-h]" accesskey="h"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">History</span></a></li><li id="wm-places-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8#" title="Places" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Places</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="n-mainpage-description"><a href="https://wiki.wesnoth.org/Main_Page" role="menuitem" title="Visit the main page [ctrl-option-z]" accesskey="z"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Main page</span></a></li><li id="n-recentchanges"><a href="https://wiki.wesnoth.org/Special:RecentChanges" role="menuitem" title="A list of recent changes in the wiki [ctrl-option-r]" accesskey="r"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Recent changes</span></a></li><li id="n-randompage"><a href="https://wiki.wesnoth.org/Special:Random" role="menuitem" title="Load a random page [ctrl-option-x]" accesskey="x"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Random page</span></a></li><li id="n-help-mediawiki"><a href="https://www.mediawiki.org/wiki/Special:MyLanguage/Help:Contents" role="menuitem"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Help about MediaWiki</span></a></li></ul></li><li id="wm-advanced-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8#" title="Advanced" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Advanced</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="ca-viewsource"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;action=edit" role="menuitem" title="This page is protected.
You can view its source [ctrl-option-e]" accesskey="e"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>View source</span></a></li><li id="t-whatlinkshere"><a href="https://wiki.wesnoth.org/Special:WhatLinksHere/WML_for_Complete_Beginners:_Chapter_8" role="menuitem" title="A list of all wiki pages that link here [ctrl-option-j]" accesskey="j"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>What links here</span></a></li><li id="t-recentchangeslinked"><a href="https://wiki.wesnoth.org/Special:RecentChangesLinked/WML_for_Complete_Beginners:_Chapter_8" rel="nofollow" role="menuitem" title="Recent changes in pages linked from this page [ctrl-option-k]" accesskey="k"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Related changes</span></a></li><li id="t-specialpages"><a href="https://wiki.wesnoth.org/Special:SpecialPages" role="menuitem" title="A list of all special pages [ctrl-option-q]" accesskey="q"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Special pages</span></a></li><li id="t-permalink"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;oldid=58366" role="menuitem" title="Permanent link to this revision of the page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Permanent link</span></a></li><li id="t-info"><a href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;action=info" role="menuitem" title="More information about this page"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Page information</span></a></li></ul></li></ul><ul class="wm-toolbar" role="toolbar" aria-label="User"><li id="wm-account-menu" class="wm-dropdown"><a class="wm-dropdown-trigger" href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_8#" title="Your account" role="button"><i class="wm-toolbar-icon" aria-hidden="true"></i><span class="sr-label">Not logged in</span><i class="wm-toolbar-dropdown-marker" aria-hidden="true"></i></a><ul class="wm-dropdown-menu" role="menu"><li id="pt-login"><a href="https://wiki.wesnoth.org/index.php?title=Special:UserLogin&amp;returnto=WML+for+Complete+Beginners%3A+Chapter+8" role="menuitem" title="You are encouraged to log in; however, it is not mandatory [ctrl-option-o]" accesskey="o"><i class="wm-toolbar-icon" aria-hidden="true"></i><span>Log in</span></a></li></ul></li></ul></div> <!-- wm-wiki-toolbar -->	<h1 class="firstHeading" lang="en">WML for Complete Beginners: Chapter 8</h1>


	<div id="bodyContent">
					<div id="siteSub">From The Battle for Wesnoth Wiki</div>
				<div id="contentSub"></div>

		<!-- start wikipage -->
		<div id="mw-content-text" lang="en" dir="ltr" class="mw-content-ltr"><div class="mw-parser-output"><h2><span id="Chapter_8:_Array,_and_Container_Variables"></span><span class="mw-headline" id="Chapter_8:_Array.2C_and_Container_Variables">Chapter 8: Array, and Container Variables</span></h2>
<p>So far we have only discussed <i>scalar variables</i>, i.e. variables that have only one value at any given time. Believe it or not, there are types of variables than can store more than one value simultaneously, or even other variables.
</p><p><br>
</p>
<h3><span class="mw-headline" id="Container_Variables">Container Variables</span></h3>
<p>Container variables are variables that contain other variables within themselves. Just imagine how many variables you could create for information about one unit. There could be a variable my_leader_hitpoints, my_leader_name, my_leader_level, and so on. Instead of having all these different variables, wouldn't it be much easier if we could just put them all in one large box labeled "my_leader"? Well, with container variables, you can!
</p><p>Container variables are not restricted to containing scalar variables, however. They can also store other containers or even array variables.
</p>
<h3><span class="mw-headline" id="Array_Variables">Array Variables</span></h3>
<p>You will typically encounter Array variables when you need to store all the units or locations on the map that meet certain criteria. That is outside the scope of this beginner's tutorial, but later you can consult the ReferenceWML documentation for [store_unit] and [store_locations] when you are ready to do that.
</p><p><br>
Here are some basic facts about Array Variables. Every Array has a length, which is the number of its containers. And these containers are all numbered starting at container zero.
</p><p><br>
Next Chapter:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_9" title="WML for Complete Beginners: Chapter 9">WML for Complete Beginners: Chapter 9</a>
</p><p>Previous Chapter:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners:_Chapter_7" title="WML for Complete Beginners: Chapter 7">WML for Complete Beginners: Chapter 7</a>
</p><p>Return to Main Index:
<a href="https://wiki.wesnoth.org/WML_for_Complete_Beginners" title="WML for Complete Beginners">WML for Complete Beginners</a>
</p>
<!--
NewPP limit report
Cached time: 20211208130606
Cache expiry: 86400
Dynamic content: false
CPU time usage: 0.002 seconds
Real time usage: 0.003 seconds
Preprocessor visited node count: 10/1000000
Preprocessor generated node count: 16/1000000
Post‐expand include size: 0/2097152 bytes
Template argument size: 0/2097152 bytes
Highest expansion depth: 2/40
Expensive parser function count: 0/100
Unstrip recursion depth: 0/20
Unstrip post‐expand size: 0/5000000 bytes
-->
<!--
Transclusion expansion time report (%,ms,calls,template)
100.00%    0.000      1 -total
-->
</div>
<!-- Saved in parser cache with key wiki-mw_:pcache:idhash:5683-0!canonical and timestamp 20211208130606 and revision id 58366
 -->
</div>		<!-- end wikipage -->

					<div class="printfooter">
				Retrieved from "<a dir="ltr" href="https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;oldid=58366">https://wiki.wesnoth.org/index.php?title=WML_for_Complete_Beginners:_Chapter_8&amp;oldid=58366</a>"			</div>
		<div id="catlinks" class="catlinks" data-mw="interface"><div id="mw-normal-catlinks" class="mw-normal-catlinks"><a href="https://wiki.wesnoth.org/Special:Categories" title="Special:Categories">Category</a>: <ul><li><a href="https://wiki.wesnoth.org/Category:WML_for_Complete_Beginners" title="Category:WML for Complete Beginners">WML for Complete Beginners</a></li></ul></div></div><div id="lastmod"> This page was last edited on 18 April 2017, at 03:14.</div>		<div class="visualClear"></div>
			</div> <!-- bodyContent -->

</div> <!-- end content -->

</div> <!-- end main -->

<div id="footer-sep"></div>

<div id="footer"><div id="footer-content"><div>
	<a href="https://wiki.wesnoth.org/StartingPoints">Site Map</a> • <a href="https://status.wesnoth.org/">Site Status</a><br>
	Copyright © 2003–2021 by <a rel="author" href="https://wiki.wesnoth.org/Project">The Battle for Wesnoth Project</a>. Powered by <a href="https://www.mediawiki.org/">MediaWiki</a>.<br>
	Site design Copyright © 2017–2021 by Iris Morelle.
</div></div></div>

<script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgPageParseReport":{"limitreport":{"cputime":"0.002","walltime":"0.003","ppvisitednodes":{"value":10,"limit":1000000},"ppgeneratednodes":{"value":16,"limit":1000000},"postexpandincludesize":{"value":0,"limit":2097152},"templateargumentsize":{"value":0,"limit":2097152},"expansiondepth":{"value":2,"limit":40},"expensivefunctioncount":{"value":0,"limit":100},"unstrip-depth":{"value":0,"limit":20},"unstrip-size":{"value":0,"limit":5000000},"timingprofile":["100.00%    0.000      1 -total"]},"cachereport":{"timestamp":"20211208130606","ttl":86400,"transientcontent":false}}});});</script><script>(window.RLQ=window.RLQ||[]).push(function(){mw.config.set({"wgBackendResponseTime":29});});</script></body></html>
</iframe>
<p>Maybe on mouseup event complex event to avoid fracting while selecting; not sure. we'll have x,y all this stuff slide navigate from fractal_zip. essentially building a browser inevitably...</p>
<!-- color wheel, living additive browsing grows the bubble map; session -->
<p>Select any part of this sentence and press the button</p>
<button onclick="getSelectedText()">um033</button>
<button onclick="getSelectedText1()">um001</button>
<button onclick="getSelectedText2()">um002</button>
<button onclick="getSelectedText3()">um003</button><br />
<label for="page_last_fraction">Page Needs Fraction</label><input type="text" name="page_last_fraction" id="page_last_fraction" />
<label for="frame1_last_fraction">Frame1 Needs Fraction</label><input type="text" name="frame1_last_fraction" id="frame1_last_fraction" />
<p>fraction</p>
<div id="fraction" style="border: 10px solid green;"></div>
</body>
</html>
