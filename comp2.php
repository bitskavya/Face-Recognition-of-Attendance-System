<?php
include "comp.php";  // your face comparison function
// Folders
$dir1 = "uploads/";           // Registered faces
$dir2 = "uploads/uploads2/";  // Captured attendance faces
// Get files
$files1 = glob($dir1 . "*.{jpg,jpeg,png}", GLOB_BRACE);
$files2 = glob($dir2 . "*.{jpg,jpeg,png}", GLOB_BRACE);
$matched = false;
foreach ($files2 as $file2) {   // Loop captured faces
    foreach ($files1 as $file1) {  // Loop registered faces
        $result = compareFaces($file1, $file2);
        if ($result['status']) {
            $rollno = pathinfo($file1, PATHINFO_FILENAME); // filename (roll no)
            $date = date("Y-m-d");
            $time = date("H:i:s");
            // Prevent duplicate attendance for same student on same date
            $csvFile = "attendance.csv";
            $alreadyMarked = false;
            if (file_exists($csvFile)) {
                $fp = fopen($csvFile, "r");
                while (($row = fgetcsv($fp)) !== false) {
                    if ($row[0] == $rollno && $row[1] == $date) {
                        $alreadyMarked = true;
                        break;
                    }
                }
                fclose($fp);
            }
            if (!$alreadyMarked) {
                $fp = fopen($csvFile, "a");
                fputcsv($fp, [$rollno, $date, $time, "Present"]);
                fclose($fp);
                echo "✅ Attendance Marked for Roll No: $rollno on $date at $time";
            } else {
                echo "⚠️ Attendance already marked for Roll No: $rollno today.";
            }
            $matched = true;
            exit();
        }
    }
}
// If no matches found
if (!$matched) {
    echo "❌ No Match Found. Attendance not marked.";
}
?>
