<?php

include("encrypt_decrypeted.php");

  $id="e0007";
  $level="1";
 $idver = encryptText($id, $level);

 header("Location: test_verfiy_url.php?id=".$idver, true, 301);  



?>