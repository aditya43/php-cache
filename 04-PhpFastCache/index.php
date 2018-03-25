<?php

require_once 'vendor/autoload.php';

use phpFastCache\CacheManager;

/********************************************************************************************************/

// To use Filesystem cache

// $type   = 'files';
// $config = [
//     "storage"  => "files",
//     "path"     => "/cache", //path for cache files
//     "htaccess" => true     //set htaccess protection (default: true)
// ];

/********************************************************************************************************/

// To use APC cache.

// $type   = 'apc';
// $config = [];

/********************************************************************************************************/

// To use Memcached

$type   = 'memcache';
$config = [
    "server" => [
        ["127.0.0.1", 11211, 1]
    ]
];

/********************************************************************************************************/

$CacheInstance = CacheManager::getInstance('memcache', $config);

$key   = "oauth_users";
$cache = $CacheInstance->getItem($key);

if (is_null($cache->get()))
{
    $data = require_once 'get_data.php';
    $cache->set($data)->expiresAfter(5); //in seconds, also accepts Datetime
    $CacheInstance->save($cache);        // Save the cache item just like you do with doctrine and entities

    echo "Cache Type : {$type} | First time loading | Data saved to cache<br />";
    $data = $cache->get();
}
else
{
    echo "Reading data from cache..<br /> ";
    $data = $cache->get();
}
var_dump($data);
