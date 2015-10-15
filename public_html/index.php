<?php

$start = microtime(true);

echo 'Hello<br><br>';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

$mc = new Memcached('mc');
$mc->setOption(Memcached::OPT_LIBKETAMA_COMPATIBLE, true);

if($_SERVER['HTTP_HOST'] == '52.88.213.113') //US
{
    echo 'SERVER A<br>';
  $servers = array(
    array('52.17.214.233', 11211) // EU
    //array('172.31.20.208', 11211) // US
    //array('52.91.169.15', 11211) // NV
    //array('52.91.157.18', 11211) // NV c4
  );
}
else if($_SERVER['HTTP_HOST'] == '52.64.117.146') //AU
{
    echo 'SERVER B<br>';
  $servers = array(
    array('52.17.214.233', 11211) // EU
    //array('52.88.250.80', 11211) // US
    //array('52.91.169.15', 11211) // NV
    //array('52.91.157.18', 11211) // NV c4
  );
}
else //UK
{
    echo 'SERVER C<br>';
  $servers = array(
    array('172.31.20.86', 11211) // EU
    //array('52.88.250.80', 11211) // US
    //array('52.91.169.15', 11211) // NV
    //array('52.91.157.18', 11211) // NV c4
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
    $mc->delete($_GET['del']);
}

echo $mc->get('gg').'<br>';
echo $mc->get('ip');

if(!empty($_GET['stats']))
{
    echo '<pre>';print_r($mc->getStats());echo '</pre>';
}

echo '<br>'.number_format((microtime(true)-$start), 3);

