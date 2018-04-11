<?php
$tags = "";
if ( isset($_GET["request"]) )
	$tags = htmlentities($_GET["request"]);

$url = "https://api.flickr.com/services/feeds/photos_public.gne?format=json&tagmode=ANY&tags=$tags";
$data = file_get_contents($url);
$root = "jsonFlickrFeed";


$jsonData = substr($data, strlen($root) + 1, strlen($data) - (strlen($root) + 2));
echo $jsonData;

?>
