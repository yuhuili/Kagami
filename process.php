<?php

$restricted = true;
$allowed_users = ["yuhuili"];

$num_dir_from_root = 1;

// Process URL
$url_parts = explode("/",$_SERVER['REQUEST_URI']);
if (count($url_parts)<$num_dir_from_root+3 || count($url_parts)>$num_dir_from_root+4) {
  // 0: empty
  // 1: kagami
  // 2: GitHub username
  // 3: Name
  // 4: Any value for recolor white
  die();
}

$recolor_white = count($url_parts)==5;
$username = $url_parts[2];
$name = rawurldecode($url_parts[3]);
if ($restricted && !in_array($username, $allowed_users)) {
  die();
}

$cache_dir = "./cache/".$username;
$t_left_width = 6;
$t_middle_width = 1;
$t_right_width = 6;
$icon_left_margin = 6;
$icon_top_margin = 3;
$icon_size = 14;
$name_top_margin = 3;
$name_left_margin = 2*$icon_left_margin + $icon_size;
$name_width = calculateLength($name);
$img_width = $name_left_margin + $name_width + $icon_left_margin;
$img_height = 20;

function calculateLength($text) {
  // font 3 has 6x9 pixel and 1 pixel spacing
  $w = strlen($text)*7;
  return $w;
}

// Reset to 200
header("HTTP/1.1 200 OK");
header("Status: 200 OK");


// Check if cached
if (file_exists($cache_dir)) {
  header("Content-type: image/png");
  header("Kagami: Cache");
  readfile($cache_dir);
  die();
}


// Create image
$kagami = imagecreatetruecolor($img_width, $img_height);
$transparent = imagecolorallocatealpha($kagami, 0, 0, 0, 127);
$text_color = imagecolorallocate($kagami, 255, 255, 255);
imagefill($kagami, 0, 0, $transparent);
imagesavealpha($kagami, true);

$t_left = imagecreatefrompng("./resources/left.png");
imagecopy($kagami, $t_left, 0, 0, 0, 0, $t_left_width, $img_height);
$t_middle = imagecreatefrompng("./resources/middle.png");
imagecopyresized($kagami, $t_middle, $t_left_width, 0, 0, 0, $img_width-$t_left_width-$t_right_width, $img_height, $t_middle_width, $img_height);
$t_right = imagecreatefrompng("./resources/right.png");
imagecopy($kagami, $t_right, $img_width-$t_right_width, 0, 0, 0, $t_right_width, $img_height);
$icon = @imagecreatefrompng("https://github.com/".$username.".png");

if (!$icon) {
  $icon=imagecreatefromjpeg("https://github.com/".$username.".png");
}

if ($recolor_white) $icon_white = imagefilter($icon, IMG_FILTER_COLORIZE, 255, 255, 255);
imagecopyresized($kagami, $icon, $icon_left_margin, $icon_top_margin, 0, 0, $icon_size, $icon_size, imagesx($icon), imagesx($icon));

imagestring($kagami, 3, $name_left_margin, $name_top_margin, $name, $text_color);

header("Content-type: image/png");
header("Kagami: New Image");
imagepng($kagami, $cache_dir);
imagepng($kagami);


?>