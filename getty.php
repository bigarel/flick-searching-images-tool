<?php

function defaultImage($file) {

    /* Create a black image */
    $dst  = imagecreatetruecolor(250, 188);
    $bgc = imagecolorallocate($dst, 255, 0, 0);
    $tc  = imagecolorallocate($dst, 0, 0, 0);

    imagefilledrectangle($dst, 0, 0, 250, 188, $bgc);

    /* Output an error message */
    imagestring($dst, 1, 5, 5, 'Error Creating Image '.$file, $tc);
    return $dst;    	

}

function textImage($message) {

    /* Create a black image */
    $dst  = imagecreatetruecolor(250, 188);
    $bgc = imagecolorallocate($dst, 0, 255, 0);
    $tc  = imagecolorallocate($dst, 0, 0, 0);

    imagefilledrectangle($dst, 0, 0, 250, 188, $bgc);

    /* Output an error message */
    imagestring($dst, 1, 5, 5, $message, $tc);
    return $dst;    	

}

function resizeImage($file, $w, $h, $crop=FALSE) {
	list($width, $height) = getimagesize($file);
	$ratio = $width / $height;

	if ($crop) {
    	if ($width > $height) {
        	$width = ceil($width-($width*abs($ratio-$w/$h)));
    	}
    	else {
        	$height = ceil($height-($height*abs($ratio-$w/$h)));
    	}
    	$newwidth = $w;
    	$newheight = $h;
	}
	else {
	    if ($w/$h > $ratio) {
    	    $newwidth = $h*$ratio;
        	$newheight = $h;
    	}
    	else {
        	$newheight = $w/$ratio;
        	$newwidth = $w;
    	}
	}


    $src = imagecreatefromjpeg($file);

    if (!$src)
    {
    	return defaultImage($file);
    }

    $dst = imagecreatetruecolor($newwidth, $newheight);
    if (!$dst)
    {
    	imagedestroy($src);
    	return defaultImage($file);
    }
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height) or die();
    return $dst;
}

header('Content-Type: image/jpeg');

if ( isset($_GET["src"]))
{
	$src=htmlentities($_GET["src"]);
	if ($src == "{{item.media.m}}")
		$img = textImage("Please wait");
	else
		$img = resizeImage($_GET["src"], 250, 188, true);
}
else
	$img = resizeImage("unknown.jpeg", 250, 188);

imagejpeg($img);
imagedestroy($img)
?>