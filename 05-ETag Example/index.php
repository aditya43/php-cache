<?php
//This stop php’s default no-cache
session_cache_limiter('public');
// Optional expiry time in minutes
session_cache_expire(5);
//get the last-modified-date of this very file
$lastModified = filemtime($_SERVER['SCRIPT_FILENAME']);
//get a unique hash of this file (etag)
$etagFile = md5_file($_SERVER['SCRIPT_FILENAME']);
//get the HTTP_IF_MODIFIED_SINCE header if set
$ifModifiedSince = (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) ? $_SERVER['HTTP_IF_MODIFIED_SINCE'] : false);
//get the HTTP_IF_NONE_MATCH header if set (etag: unique file hash)
$etagHeader = (isset($_SERVER['HTTP_IF_NONE_MATCH']) ? stripslashes(trim($_SERVER['HTTP_IF_NONE_MATCH'])) : false);

//set last-modified header (Last-Modified date format : Wed, 29 Nov 2017 10:16:10 GMT)
header("Last-Modified: " . gmdate("D, d M Y H:i:s", $lastModified) . " GMT");
//set etag-header
header("ETag: \"$etagFile\"");
//make sure caching is turned on
header('Cache-Control: public');

//check if page has changed. If not, send 304 and exit
if (strtotime($ifModifiedSince) == $lastModified || $etagHeader == $etagFile)
{
    header("HTTP/1.1 304 Not Modified");
    exit;
}
?>

<html>
<head>
    <meta charset="UTF-8">
    <title>ETag Example | Aditya Hajare</title>
    <link rel="stylesheet" type="text/css" href="adi.css">
    <script type="text/javascript" src="adi.js"></script>
</head>
<body>
    <pre>ETag Example</pre> | Aditya Hajare <br>
    <pre>adi.css</pre> was last modified at: <pre><?=date("d.m.Y H:i:s", time());?></pre> <br>
    Change something under <pre>adi.css</pre> or <pre>adi.js</pre> and see if you are getting <pre>200</pre> or <pre>304</pre> response.
</body>
</html>
