<?php
$service_url = 'https://api.mercadolibre.com/sites/MLB/shipping_options?zip_code_from=64076448&zip_code_to=22450000&dimensions=20x20x20,1000';

$curl = curl_init($service_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Type: application/json"));
$curl_response = curl_exec($curl);
if ($curl_response === false) {
    $info = curl_getinfo($curl);
    curl_close($curl);
    die('error occured during curl exec. Additioanl info: ' . var_export($info));
}
curl_close($curl);
$decoded = json_decode($curl_response);
print_r($decoded);
?>