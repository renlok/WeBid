<?php

$w = $_GET['w'];
$fromfile = $_GET['fromfile'];

function ErrorPNG($err)
{
    header("Content-type: image/png");
    $im = imagecreate(100, 30);
    $bgc = imagecolorallocate($im, 255, 255, 255);
    $tc = imagecolorallocate($im, 0, 0, 0);
    imagefilledrectangle($im, 0, 0, 100, 30, $bgc);
    imagestring($im, 1, 5, 5, $err, $tc);
    imagepng($im);
}
// control parameters and file existence
if (!isset($_GET['fromfile'])) {
    ErrorPNG("params empty");
    exit;
} elseif (!file_exists($_GET['fromfile']) && !fopen($_GET['fromfile'], "r")) {
    ErrorPNG("img doesn't exist");
    exit;
}

if (function_exists('imagetypes')) {
    if (!is_dir("uploaded/cache")) mkdir("uploaded/cache", 0777);

    if (!isset($_GET['w'])) $w = 100;
    $img = @getimagesize($fromfile);
    if (is_array($img)) {
        switch ($img[2]) {
            case 1 :
                if (!(imagetypes() &IMG_GIF)) {
                    if (!function_exists("imagecreatefromgif")) $nomanage = true;
                    else {
                        $outype = "png";
                        $img['mime'] = "image/png";
                    }
                } else $outype = "gif";
                $imtype = "gif";
                break;
            case 2 :
                if (!(imagetypes() &IMG_JPG)) $nomanage = true;
                $outype = "jpeg";
                $imtype = "jpeg";
                break;
            case 3 :
                if (!(imagetypes() &IMG_PNG)) $nomanage = true;
                $imtype = "png";
                $outype = "png";
                break;
            default :
                echo ErrorPNG("wrong img type");
                exit;
        }
        $ratio = floatval($img[0] / $w);
        $h = ceil($img[1] / $ratio);
    } else {
        echo ErrorPNG("not image type");
        exit;
    }
} else {
    $nomanage = true;
    $img = getimagesize($fromfile);
}
if ($nomanage) {
    ErrorPNG("image type not supported");
    exit;
}

$ou = imagecreatetruecolor($w, $h);
imagealphablending($ou, false);
$funcall = "imagecreatefrom$imtype";
imagecopyresampled($ou, $funcall($fromfile), 0, 0, 0, 0, $w, $h, $img[0], $img[1]);
$funcall = "image$outype";
$funcall($ou, "uploaded/cache/" . md5($_SERVER['QUERY_STRING']));
header("Content-type: " . $img['mime']);
$funcall($ou);

?>