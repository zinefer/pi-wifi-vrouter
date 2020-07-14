<?php

$config = [];

if (!isset($config['wifi'])) {
    $config['wifi'] = [];
}

if (!isset($config['wifi']['client'])) {
  $config['wifi']['client'] = [];
}

$config['wifi']['client']['ssid'] = $_POST['wifi-client-ssid'];
$config['wifi']['client']['pass'] = $_POST['wifi-client-pass'];

if (!isset($config['wifi']['ap'])) {
  $config['wifi']['ap'] = [];
}

$config['wifi']['ap']['ssid'] = $_POST['wifi-ap-ssid'];
$config['wifi']['ap']['pass'] = $_POST['wifi-ap-pass'];
$config['wifi']['ap']['ip']   = $_POST['wifi-ap-ip'];
$config['wifi']['ap']['dns']  = $_POST['wifi-ap-dns'];
$config['wifi']['ap']['forward'] = (isset($_POST['wifi-ap-forward']) && $_POST['wifi-ap-forward'] == 'on');

$config['wifi']['ap']['pass'] = $_POST['wifi-ap-pass'];
$config['wifi']['ap']['ip']   = $_POST['wifi-ap-ip'];
$config['wifi']['ap']['dns']  = $_POST['wifi-ap-dns'];

if (!isset($config['wireguard'])) {
  $config['wireguard'] = [
      'interface' => [],
      'peer' => []
  ];
}

$config['wireguard']['interface']['priv']    = $_POST['wireguard-interface-priv'];
$config['wireguard']['interface']['pub']     = $_POST['wireguard-interface-pub'];
$config['wireguard']['interface']['address'] = $_POST['wireguard-interface-address'];

$config['wireguard']['peer']['endpoint']  = $_POST['wireguard-peer-endpoint'];
$config['wireguard']['peer']['pub']       = $_POST['wireguard-peer-pub'];
$config['wireguard']['peer']['preshared'] = $_POST['wireguard-peer-preshared'];
$config['wireguard']['peer']['address']   = $_POST['wireguard-peer-address'];

$file = fopen('config.json','w+');
fwrite($file, json_encode($config));
fclose($file);

$cmd = '/bin/rpi-wifi.sh -a ' + $config['wifi']['ap']['ssid'] + ' ' + $config['wifi']['ap']['pass'] + ' -c ' + $config['wifi']['client']['ssid'] + ' ' + $config['wifi']['client']['pass']

if ($config['wifi']['ap']['forward']) {
  $cmd += ' --no-internet'
}

if (strlen($config['wifi']['ap']['ip']) > 0) {
  $cmd += ' -i ' + $config['wifi']['ap']['ip']
}

exec($cmd);

//
// /bin/rpi-wifi.sh -a MyAP myappass -c WifiSSID wifipass
//

header("Location: /");