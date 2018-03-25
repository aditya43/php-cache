<?php

$file                = 'cache/' . basename($_SERVER['SCRIPT_NAME']); //location of cache file
$current_time        = time();
$cache_last_modified = filemtime($file); //time when the cache file was last modified

if (file_exists($file) && ($current_time < strtotime('+1 day', $cache_last_modified)))
{
                   //check if cache file exists and hasn't expired yet
    include $file; //include cache file
}
else
{
    ob_start(); //start output buffering
?>

  <h1>Hello World!</h1>

<?php
/*
    some code accessing the database
    for some data here
     */

    /*
    probably some complex computations here
     */

    $fp = fopen($file, 'w');        //open cache file
    fwrite($fp, ob_get_contents()); //create new cache file
    fclose($fp);                    //close cache file
    ob_end_flush();                 //flush output buffered
}
?>
