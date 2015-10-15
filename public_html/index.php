<?php

echo 'Hello<br><br>';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$mc = new Memcached('mc');
$mc->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

if($_SERVER['HTTP_HOST'] == '52.88.213.113')
{
    echo 'SERVER A<br>';
  $servers = array(
    array('172.31.20.208', 11211, 70),
    array('52.17.214.233', 11211, 30)
  );    
}
else
{
    echo 'SERVER B<br>';
  $servers = array(
    array('172.31.20.86', 11211, 70),
    array('52.88.250.80', 11211, 30)
  );    
}

if (!count($mc->getServerList())) 
{
        $mc->addServers($servers);
        echo 'Added Servers';
}

if(!empty($_GET['flush']))
{
        $mc->flush();
}

if(!empty($_GET['gg']))
{
    if(isset($_GET['key']))
    {
        $mc->setByKey($_GET['key'], 'gg', $_GET['gg']);
        $mc->setByKey($_GET['key'], 'ip', $_SERVER['HTTP_HOST']);
    }
    else
    {
        $mc->set('gg', $_GET['gg']);
        $mc->set('ip', $_SERVER['HTTP_HOST']);
    }
}

if(!empty($_GET['del']))
{
    $mc->delete('gg');
}

echo $mc->get('gg').'<br>';
echo $mc->get('ip');

