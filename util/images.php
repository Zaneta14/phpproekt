<?php
function process_image($dir, $filename) {
    // Set up the variables
    $i = strrpos($filename, '.');
    $image_name = substr($filename, 0, $i);
    $ext = substr($filename, $i);

    // Set up the read path
    $image_path = $dir . $filename;

    // Set up the write paths
    $image_path_m = $dir . $image_name . '_m' . $ext;
}
