<?php
    
    function parseSignal($signal) {
        $out = [
            'ssid'      => '',
            'channel'   => '',
            'rssi'      => '',
            'encrypted' => ''
        ];

        preg_match('/ESSID:"([^"]+)"/', $signal, $matches);
        $out['ssid'] = $matches[1];

        preg_match('/\(Channel (\d{1,2})\)/', $signal, $matches);
        $out['channel'] = $matches[1];

        preg_match('/Signal level=(-\d{1,3} dBm)/', $signal, $matches);
        $out['rssi'] = $matches[1];

        preg_match('/Encryption key:(off|on)/', $signal, $matches);
        $out['encrypted'] = ($matches[1] == 'on');

        return $out;
    }


    $output = shell_exec('sudo iwlist ap0 scan');

    $signals = preg_split('/Cell \d{2} - Address: [\dA-F:]{17}/m', $output);

    $networks = [];

    foreach ($signals as $signal) {
        $network = parseSignal($signal);

        if ($network['ssid'] == '') continue;

        $networks[] = $network;
    }
    
    foreach ($networks as $network) { ?>
        <li class="list-group-item d-flex justify-content-between lh-condensed">

            <? if ($network['encrypted']) { ?>
                <div class="bi bi-lock-fill"></div>
            <? } else { ?>
                <div class="bi bi-unlock-fill"></div>
            <? } ?>

            <div>
                <h6 class="my-0"><?= $network['ssid'] ?></h6>
                <small class="text-muted">Channel <?= $network['channel'] ?></small>
            </div>
            <span class="text-muted"><?= $network['rssi'] ?></span>
        </li>
<?php } ?>