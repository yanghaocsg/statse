<form class="clearfix" name="form" method="get" id="form" onsubmit="">
<input id="keyword" name="keyword" type="text" value="<?php echo $_GET['keyword']; ?>" class="txt f16 pl10" autocomplete="off" maxlength="" data-smart="true">
<input type="submit" id="click_button" class="btn f18" value="解码">
</form>

<?php
require_once(dirname(__FILE__)."/utils.php");
if (!empty($_GET['keyword'])) {
    $result = $_GET['keyword'];
    $result = urldecode($result);
    $result = urldecode($result);
    //print $result."<BR/>";
    #$result = "A8rjaCzBCJYnaG4XtRTS7Y5iU4vsZpQuj3p9fwVaL8pRiS15/MjAc01RhrSpZjVzf9NFuU2R7LKy9uJxGXpCyK4P+RmZuTx71RDgbXi+IxmnDrHT38nmdA==";    
    $data = base64_decode($result);
    $dataSize = @strlen($data);
    if($dataSize < HEADER_SIZE) {
        print "Invalid Size";        
        die();
    }
    $botnet_cryptkey_bin = rc4Init($botnet_cryptkey);
    rc4($data, $botnet_cryptkey_bin);
    visualDecrypt($data);
    if (strcmp(md5(substr($data, HEADER_SIZE), true), substr($data, HEADER_MD5, 16)) !== 0) {
        print "Invalid MD5";        
        die();
    }
    $list = unpack("L2", substr($data, 0, HEADER_MD5));
    $response_len = $list[2];
    $response = substr($data, HEADER_SIZE);
    print $response."<BR/>";
}
?>
