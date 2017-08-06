<?php  
include("siteRgex.php");

include ("txtimgCreate.php");

include('GifCreator.php');
// Create an array containing file paths, resource var (initialized with imagecreatefromXXX), 
// image URLs or even binary code from image files.
// All sorted in order to appear.

$frames = array(
    $matches3[1][1], // Binary source code
    $imagem,
);


// Create an array containing the duration (in millisecond) of each frames (in order too)
$durations = array(40, 40);

// Initialize and create the GIF !
$gc = new GifCreator();
$gc->create($frames, $durations, -1);
?>