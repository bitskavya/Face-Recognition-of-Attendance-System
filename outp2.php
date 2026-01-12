<?php
echo("<h1> attendence marked fail</h1>");
$dir = "uploads/";

// Get all files (for example, only PNG)
$files = glob($dir . "*"); // * = all files

foreach($files as $file) {
    echo ($file) . "<br>"; // basename() removes folder path
}
?>