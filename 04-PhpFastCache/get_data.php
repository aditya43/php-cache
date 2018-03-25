<?php

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
return $stmt->fetchAll(PDO::FETCH_CLASS);
