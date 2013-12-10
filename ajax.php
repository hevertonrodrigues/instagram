<?php

//add instagram.php class
require_once( 'instagram.php' );

//define instagram Client ID
$client_id = 'YOUR_CLIENT_ID_HERE';

//get the hashtag parammeter by $_GET from ajax
$tag = $_GET['hashtag'];

//Creating a new Instagram Object
$instagram = new Instagram( $client_id, $tag );

//call function getPhotos with a US default since date
echo $instagram->getPhotos( '2013-12-07' );

?>
