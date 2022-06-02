<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('blob_filename'))
{
    
  function blob_filename($text = "") {
    $txt = preg_replace("/[^a-zA-Z0-9s.]/", "_", trim($text));
    return $txt;
	}
}

if ( ! function_exists('getImage'))
{
  function getImage($toWidth,$toHeight,$image)
  {
  $blob_binary = $image['image_data'];
  
  $width = $image['image_width'];
  $height = $image['image_height'];
  $xscale = $width/$toWidth;
  $yscale = $height/$toHeight;
  
  // Recalculate new size with default ratio
  if ($yscale>$xscale){
  $new_width = round($width * (1/$yscale));
  $new_height = round($height * (1/$yscale));
  }
    else {
  $new_width = round($width * (1/$xscale));
  $new_height = round($height * (1/$xscale));
  }
   
    $im = imagecreatefromstring($blob_binary);
    $new_image = imagecreatetruecolor($new_width, $new_height);
    $x = imagesx($im);
    $y = imagesy($im);
    imagecopyresampled($new_image, $im, 0, 0, 0, 0, $new_width, $new_height, $x, $y);
    imagedestroy($im);
    imagejpeg($new_image, null, 85);
   
    header("Content-type: ".$image['image_type']);
    echo $new_image;
  }
}
/* End of file rand_helper.php */