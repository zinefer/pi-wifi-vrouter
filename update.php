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
$config['wireguard']['interface']['address'] = $_POST['wireguard-interface-address'];
$config['wireguard']['interface']['dns']     = $_POST['wireguard-interface-dns'];

$config['wireguard']['peer']['endpoint']  = $_POST['wireguard-peer-endpoint'];
$config['wireguard']['peer']['pub']       = $_POST['wireguard-peer-pub'];
$config['wireguard']['peer']['preshared'] = $_POST['wireguard-peer-preshared'];
$config['wireguard']['peer']['address']   = $_POST['wireguard-peer-address'];

file_put_contents('config.json', json_encode($config));


// https://github.com/lukicdarkoo/rpi-wifi
$cmd  = 'curl https://raw.githubusercontent.com/lukicdarkoo/rpi-wifi/master/configure | bash -s --';
$args = '-a ' . $config['wifi']['ap']['ssid'] . ' ' . $config['wifi']['ap']['pass'] . ' -c ' . $config['wifi']['client']['ssid'] . ' ' . $config['wifi']['client']['pass'];

if ($config['wifi']['ap']['forward']) {
  $args .= ' --no-internet';
}

if (strlen($config['wifi']['ap']['ip']) > 0) {
  $args .= ' -i ' . $config['wifi']['ap']['ip'];
}

//exec($cmd . ' ' . $args);

$sock = stream_socket_client('unix:///run/vrouter-config', $errno, $errst);
fwrite($sock, json_encode($config) . PHP_EOL);
fclose($sock);


file_put_contents('/etc/wireguard/wg0.conf', <<<EOT
[Interface]
Address = {$config['wireguard']['interface']['address']}/24
DNS = {$config['wireguard']['interface']['dns']}
SaveConfig = true
PrivateKey = {$config['wireguard']['interface']['priv']}

[Peer]
PublicKey = {$config['wireguard']['peer']['pub']}
Endpoint = {$config['wireguard']['peer']['endpoint']}
AllowedIPs = {$config['wireguard']['peer']['address']}
EOT);

header("Location: /");