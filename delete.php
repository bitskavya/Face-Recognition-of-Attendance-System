<?php
if (isset($_GET['index'])) {
    $index = (int) $_GET['index'];
    $csvFile = "attendance.csv";

    if (file_exists($csvFile)) {
        $rows = [];
        $fp = fopen($csvFile, "r");
        while (($row = fgetcsv($fp)) !== false) {
            $rows[] = $row;
        }
        fclose($fp);

        // Delete the selected row
        if (isset($rows[$index])) {
            unset($rows[$index]);
            $rows = array_values($rows); // Re-index array

            $fp = fopen($csvFile, "w");
            foreach ($rows as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
        }
    }
}

// Redirect back to main page after delete
header("Location: attendance_admin.php"); // change to your file name if it's different
exit;
?>
