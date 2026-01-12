<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User — Attendance Records</title>
  <style>
    :root{
      --bg:#0f172a;
      --card:#0b1024;
      --text:#e5e7eb;
      --muted:#94a3b8;
      --accent:#6366f1;
      --accent2:#22d3ee;
      --success:#22c55e;
      --radius:14px;
      --shadow:0 10px 30px rgba(2,6,23,.45);
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{
      font-family:"Segoe UI",sans-serif;
      background:
        radial-gradient(1200px 600px at 10% -10%, rgba(34,211,238,.12), transparent 60%),
        radial-gradient(1000px 500px at 110% 10%, rgba(99,102,241,.14), transparent 60%),
        linear-gradient(180deg, #0b122b, #0f172a 40%, #0a0f23);
      color: var(--text);
      min-height:100vh;display:flex;flex-direction:column;align-items:center;padding:20px;
    }
    h2{text-align:center;margin-bottom:20px;font-size:2rem;
      background: linear-gradient(90deg, var(--accent), var(--accent2));
      -webkit-background-clip: text;-webkit-text-fill-color: transparent;}
    .table-container{width:100%;max-width:900px;background:var(--card);
      padding:20px;border-radius:var(--radius);box-shadow:var(--shadow);overflow-x:auto;}
    table{width:100%;border-collapse:collapse;min-width:700px;}
    th,td{padding:12px 10px;text-align:center;border-bottom:1px solid rgba(255,255,255,.1);}
    th{background:rgba(99,102,241,.1);font-weight:600;color:var(--text);}
    td{color:var(--text);}
    tr:hover{background:rgba(34,211,238,.1);transition:0.2s;}
    .download-btn{background:var(--success);color:white;padding:10px 18px;border-radius:10px;
      text-decoration:none;font-weight:600;display:inline-block;margin-top:20px;transition:0.2s;}
    .download-btn:hover{filter:brightness(1.1);}
  </style>
</head>
<body>

  <h2>📅 Your Attendance Records</h2>

  <div class="table-container">
    <table>
      <tr>
        <th>Roll No</th>
        <th>Date</th>
        <th>Time</th>
        <th>Status</th>
      </tr>
      <?php
      $csvFile = "attendance.csv";
      if (file_exists($csvFile)) {
          $fp = fopen($csvFile, "r");
          $rows = [];
          while (($row = fgetcsv($fp)) !== false) {
              $rows[] = $row;
          }
          fclose($fp);

          foreach ($rows as $row) {
              echo "<tr>";
              foreach ($row as $col) {
                  echo "<td>" . htmlspecialchars($col) . "</td>";
              }
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='4'>No attendance records found</td></tr>";
      }
      ?>
    </table>
  </div>

  <?php if (file_exists("attendance.csv")): ?>
    <a href="download.php" class="download-btn">⬇️ Download Excel</a>
  <?php endif; ?>

</body>
</html>
