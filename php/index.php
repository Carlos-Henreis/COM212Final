<?php


include_once("create.php");

$gifBinary = $gc->getGif();

header('Content-type: image/gif');
header('Content-Disposition: filename="butterfly.gif"');
echo $gifBinary;
exit;


?>