<?php

echo 'Hello<br><br>';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$m = new Memcached();

$servers = array(
    array('52.88.250.80', 11211, 33),
    array('52.17.214.233', 11211, 67)
);
$m->addServers($servers);

if(!empty($_GET['gg']))
{
    $m->set('gg', $_GET['gg']);
}

echo $m->get('gg');

