<?php
$filename = 'phpinfo.php';

if (file_exists($filename)) {
	echo "The file $filename exist";
} else {
	echo "The file $filename does not exist";
}
?>

