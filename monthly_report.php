<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Monthly Attendance Report</title>
  <style>
    body { font-family: Arial, sans-serif; background:#0f172a; color:#e5e7eb; }
    h2 { text-align:center; margin-top:20px; color:#22d3ee; }
    table { border-collapse: collapse; width: 85%; margin: 20px auto; box-shadow:0 4px 12px rgba(0,0,0,0.4); }
    th, td { border: 1px solid #333; padding: 10px; text-align: center; }
    th { background: #6366f1; color:#fff; }
    tr:nth-child(even) { background:#1e293b; }
    tr:nth-child(odd) { background:#0f172a; }
    a.back { display:block; width:150px; text-align:center; margin:20px auto; padding:10px; background:#22c55e; color:#fff; border-radius:6px; text-decoration:none; }
    a.back:hover { background:#16a34a; }
  </style>
</head>
<body>
  <?php
  $csvFile = "attendance.csv";
  $currentMonth = date("Y-m");
  ?>
  <h2>📅 Monthly Attendance Report (<?php echo date("F Y"); ?>)</h2>
  <table>
    <tr>
      <th>Roll No</th>
      <th>Date</th>
      <th>Time</th>
      <th>Status</th>
    </tr>
    <?php
    if (file_exists($csvFile)) {
        if (($fp = fopen($csvFile, "r")) !== false) {
            $found = false;
            while (($row = fgetcsv($fp)) !== false) {
                if (strpos($row[1], $currentMonth) === 0) {
                    echo "<tr>";
                    foreach ($row as $col) echo "<td>" . htmlspecialchars($col) . "</td>";
                    echo "</tr>";
                    $found = true;
                }
            }
            fclose($fp);
            if (!$found) echo "<tr><td colspan='4'>No records this month</td></tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No attendance records found</td></tr>";
    }
    ?>
  </table>
  <a href=" reports.html " class="back">⬅ Back to Reports</a>
</body>
</html>
