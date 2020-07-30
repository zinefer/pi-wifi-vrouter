<?php

$config = json_decode(file_get_contents('config.json'), true);

?><!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Pi Wifi vRouter</title>
 
    <link href="/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <style>
      #refresh-networks {
        cursor: pointer;
      }

      .text-small {
        font-size: .75rem!important;
      }

      .logo {
        width: 2em;
        margin-top: -0.8em;
        margin-right: 0.25em;
      }

      /* for md */

      .custom-switch.custom-switch-md .custom-control-label {
          padding-left: 2rem;
          padding-bottom: 1.5rem;
      }

      .custom-switch.custom-switch-md .custom-control-label::before {
          height: 1.5rem;
          width: calc(2rem + 0.75rem);
          border-radius: 3rem;
      }

      .custom-switch.custom-switch-md .custom-control-label::after {
          width: calc(1.5rem - 4px);
          height: calc(1.5rem - 4px);
          border-radius: calc(2rem - (1.5rem / 2));
      }

      .custom-switch.custom-switch-md .custom-control-input:checked ~ .custom-control-label::after {
          transform: translateX(calc(1.5rem - 0.25rem));
      }

      .bi::before {
        display: inline-block;
        content: "";
        background-repeat: no-repeat;
        height: 1.5rem;
        width: 1.5rem;
        padding-right: 2.5em;
        margin-top: 0.5em;
      }

      .bi-unlock-fill::before {
        background-image: url("data:image/svg+xml,<svg viewBox='0 0 16 16' class='bi bi-unlock-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'><path d='M.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z'/><path fill-rule='evenodd' d='M8.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z'/></svg>");
      }

      .bi-lock-fill::before {
        background-image: url("data:image/svg+xml,<svg viewBox='0 0 16 16' xmlns='http://www.w3.org/2000/svg'><path d='M2.5 9a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V9z'/><path fill-rule='evenodd' d='M4.5 4a3.5 3.5 0 1 1 7 0v3h-1V4a2.5 2.5 0 0 0-5 0v3h-1V4z'/></svg>");
      }

      .list-group-item.active {
        background-color: #7DBAFF;
      }

      #available-networks {
        height: 21vh;
      }
    </style>
  </head>
  <body class="bg-light">
    <div class="container">
      <div class="py-5 text-center">
        <h2><img class="logo" src="logo.svg"/>Pi Wifi vRouter</h2>
        <p class="lead">Configure Wifi, DHCP, DNS and Wireguard</p>
      </div>

      <!---     WIFI CLIENT CONFIGURATION      --->
      <form action="/update.php" method="post">
      <div class="row">
        <div class="col">
          <h4 class="">
            <span class="text-muted">
              Available Networks
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-clockwise" fill="currentColor" xmlns="http://www.w3.org/2000/svg" id="refresh-networks">
                <path fill-rule="evenodd" d="M3.17 6.706a5 5 0 0 1 7.103-3.16.5.5 0 1 0 .454-.892A6 6 0 1 0 13.455 5.5a.5.5 0 0 0-.91.417 5 5 0 1 1-9.375.789z"/>
                <path fill-rule="evenodd" d="M8.147.146a.5.5 0 0 1 .707 0l2.5 2.5a.5.5 0 0 1 0 .708l-2.5 2.5a.5.5 0 1 1-.707-.708L10.293 3 8.147.854a.5.5 0 0 1 0-.708z"/>
              </svg>
            </span>
            <!-- <span class="badge badge-secondary badge-pill">3</span> -->
          </h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <ul class="list-group mb-3 overflow-auto" id="available-networks">
          </ul>
        </div>
        <div class="col-md-6">
          <div class="mb-3">
            <label for="wifi-client-ssid">SSID</label>
            <input type="text" class="form-control" id="wifi-client-ssid" name="wifi-client-ssid" required value="<?= $config['wifi']['client']['ssid'] ?>">
            <div class="invalid-feedback">
              Please enter your client wifi ssid
            </div>
          </div>
          <div class="mb-3">
            <label for="wifi-client-pass">Passphrase</label>
            <input type="password" class="form-control" id="wifi-client-pass" name="wifi-client-pass" required value="<?= $config['wifi']['client']['pass'] ?>">
            <div class="invalid-feedback">
              Please enter your client wifi passphrase
            </div>
          </div>
        </div>
      </div>
      
      <hr/>
      
      <!---     WIREGUARD CONFIGURATION      --->
      <div class="row">
        <div class="col">
          <h4>
            <span class="text-muted">Wireguard</span>
          </h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wireguard-interface-priv">Interface Private Key</label>
            <input type="password" class="form-control" id="wireguard-interface-priv" name="wireguard-interface-priv" required value="<?= $config['wireguard']['interface']['priv'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard interface private key
            </div>
          </div>          
          <div class="mb-3">
            <label for="wireguard-interface-address">Interface Addresses</label>
            <input type="text" class="form-control" id="wireguard-interface-address" name="wireguard-interface-address" required value="<?= $config['wireguard']['interface']['address'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard interface addresses
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wireguard-peer-endpoint">VPN Endpoint</label>
            <input type="text" class="form-control" id="wireguard-peer-endpoint" name="wireguard-peer-endpoint" required value="<?= $config['wireguard']['peer']['endpoint'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard vpn endpoint
            </div>
          </div>
          <div class="mb-3">
            <label for="wireguard-interface-pub">VPN DNS</label>
            <input type="text" class="form-control" id="wireguard-interface-dns" name="wireguard-interface-dns" required value="<?= $config['wireguard']['interface']['dns'] ?>">
            <div class="invalid-feedback">
              Please enter your vpn interface dns server address
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wireguard-peer-address">Peer Allowed IPs</label>
            <input type="text" class="form-control" id="wireguard-peer-address" name="wireguard-peer-address" required value="<?= $config['wireguard']['peer']['address'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard peer allowed ips
            </div>
          </div>
          <div class="mb-3">
            <label for="wireguard-peer-pub">Peer Public Key</label>
            <input type="text" class="form-control" id="wireguard-peer-pub" name="wireguard-peer-pub" required value="<?= $config['wireguard']['peer']['pub'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard peer public key
            </div>
          </div>
          <div class="mb-3">
            <label for="wireguard-peer-preshared">Peer Pre-Shared Key</label>
            <input type="text" class="form-control" id="wireguard-peer-preshared" name="wireguard-peer-preshared" value="<?= $config['wireguard']['peer']['preshared'] ?>">
            <div class="invalid-feedback">
              Please enter your wireguard peer preshared key
            </div>
          </div>
        </div>  
      </div>

      <hr/>
      
      <!---     WIFI CLIENT CONFIGURATION      --->
      <div class="row">
        <div class="col">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Access Point</span>
          </h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wifi-ap-ssid">SSID</label>
            <input type="text" class="form-control" id="wifi-ap-ssid" name="wifi-ap-ssid" required value="<?= $config['wifi']['ap']['ssid'] ?>">
            <div class="invalid-feedback">
              Please enter your access point ssid
            </div>
          </div>
          <div class="mb-3">
            <label for="wifi-ap-ssid">Passphrase</label>
            <input type="password" class="form-control" id="wifi-ap-pass" name="wifi-ap-pass" required value="<?= $config['wifi']['ap']['pass'] ?>">
            <div class="invalid-feedback">
              Please enter your access point passphrase
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="mb-3">
            <label for="wifi-ap-ip">IP Address</label>
            <input type="text" class="form-control" id="wifi-ap-ip" name="wifi-ap-ip" value="<?= $config['wifi']['ap']['ip'] ?>">
            <div class="invalid-feedback">
              Please enter your access point ip
            </div>
          </div>
          <div class="mb-3">
            <label for="wifi-ap-dns">DNS Server</label>
            <input type="text" class="form-control" id="wifi-ap-dns" name="wifi-ap-dns" value="<?= $config['wifi']['ap']['dns'] ?>">
            <div class="invalid-feedback">
              Please enter your access point dns
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="custom-control custom-switch custom-switch-md">
            <input type="checkbox" class="custom-control-input" id="wifi-ap-forward" name="wifi-ap-forward" <?= $config['wifi']['ap']['forward'] ? 'checked' : '' ?>>
            <label class="custom-control-label" for="wifi-ap-forward">Forward traffic</label>
          </div>
        </div>
      </div>
      <hr/>
      <button class="btn btn-primary btn-lg float-right" type="submit">Save</button>
    </div>
    </form>

    <br/>

    <footer class="my-3 pt-5 text-muted text-center text-small">
      Made with 
      <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-heart-fill" fill="red" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z"/>
      </svg>
      on
      <a href="https://github.com/zinefer/pi-wifi-vrouter">Github</a>
    </footer>
  </div>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>
  <script>
    $('#refresh-networks').click(function(){
      $('#available-networks').load('scan.php', function(){
        $('#available-networks li').each(function(){
          if ($(this).find('.ssid').text() == $('#wifi-client-ssid').val()) {
            $('#available-networks li').removeClass('active');
            $(this).addClass('active');
          }
        });
      });
    }).click();
    $('#available-networks').on('click', 'li', function(){
      $('#available-networks li').removeClass('active');
      $(this).addClass('active');
      $('#wifi-client-ssid').val($(this).find('.ssid').text());
    });
  </script>
</body>
</html>