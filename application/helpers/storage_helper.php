<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

function dir_size($dir)
{
    $line = exec('du -sh ' . $dir);
    $line = trim(str_replace($dir, '', $line));
    return $line;
}

function array_multisum($arr) {
    $sum = array_sum($arr);
    foreach($arr as $child) {
        $sum += is_array($child) ? array_multisum($child) : 0;
    }
    return $sum;
}

function filechek($nip, $dir, $act) {
  $files = glob("$dir/$nip*.{jpg,JPG,png,PNG,jpeg,JPEG,pdf,PDF}", GLOB_BRACE);
  // INFO FILES
  if($act == 'read') {
 		return $files;
 	}
  // UKURAN FILES
  if($act == 'size') {
    $size_all = [];
    foreach($files as $k) {
      $size_all[] = filesize($k);
    }
    return $size_all;
  }
  // JUMLAH FILES
  if($act == 'jml') {
    return count($files);
  }
  // DELETE
  if($act == 'del') {
    foreach($files as $file){ // iterate files
      if(file_exists($file) && is_file($file)) {
        unlink($file); // delete file
      }
    }
  }
}

function multicheckfiles($nip, $dir=[],$act) {
  foreach($dir as $d => $k) {
    $files = glob("$k/$nip*.{pdf,PDF,png,jpg,jpeg,JPG,JPEG,PNG}", GLOB_BRACE); 
    $jml[] = count($files);
    $file[] = $files;
  }
  if($act == 'size') {
    $size_all = [];
    foreach($file as $v) {
      foreach($v as $k) {
        $size_all[] = filesize($k);
      }
    }
    return $size_all;
  }
  if($act == 'jml') {
    return $jml;
  }
  if($act == 'del') {
    foreach($file as $v) {
      foreach($v as $k){ // iterate files
        if(file_exists($k) && is_file($k)) {
          unlink($k); // delete file
        }
      }
    }
  }
  
}

?>
