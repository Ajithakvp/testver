<?php
include("encrypt_decrypeted.php");
$id= $_GET["id"];
$level="1";


            echo $decryptedText = decryptText($id, $level);

?>