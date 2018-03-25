<?php
$things = apc_fetch('db_results');

if (null == $things)
{
    //get data from the database
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
    $things = $stmt->fetchAll(PDO::FETCH_ASSOC);
    apc_add('db_results', $things, 86400); //store results in the cache for 1 day (1 day = 86400 seconds)
}
var_dump($things);
//do something with the $things
