<?php
$file = "attendance.csv";

if (file_exists($file)) {
    header("Content-Description: File Transfer");
    header("Content-Type: application/vnd.ms-excel");
    header("Content-Disposition: attachment; filename=\"attendance_" . date("Y-m-d") . ".csv\"");
    header("Content-Length: " . filesize($file));
    readfile($file);
    exit;
} else {
    echo "No attendance file found.";
}
?>
