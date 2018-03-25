<?php
//define the memcached host and port to connect to
$memcache_host = '127.0.0.1';
$memcache_port = '11211';

//connect to memcached server
$memcache = new Memcache();
$is_cache = $memcache->connect($memcache_host, $memcache_port);

if ($is_cache)
{
    $things = $memcache->get('things');

    if (null == $things)
    {
        //if data hasn't been cached yet
        try {
            $db = new PDO('mysql:host=localhost;dbname=adi_oauth', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e)
        {
            echo $e->getMessage();
        }

        $query = "SELECT * FROM `oauth_users`";
        $stmt  = $db->prepare($query);
        $stmt->execute();
        $things = $stmt->fetchAll(PDO::FETCH_CLASS);

        $memcache->set('things', $things, false, 86400); //cache the data
    }
    var_dump($things);
}
