<?php
$conn = new mysqli("localhost", "admin", "", "attend");

// 7-day window
$from = date('Y-m-d', strtotime('-6 days'));
$to = date('Y-m-d');

$sql = "
  SELECT m.name, COUNT(a.present) as days_present, COUNT(a.present) * 13 AS total_amount
  FROM members m
  LEFT JOIN attendance a ON m.id = a.member_id AND a.present = 1 AND a.date BETWEEN '$from' AND '$to'
  GROUP BY m.id
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Weekly Summary</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; padding: 20px; background: #eef2f7; }
    table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
    th, td { padding: 10px; border: 1px solid #ccc; text-align: center; }
    th { background-color: #343a40; color: white; }
    tr:nth-child(even) { background-color: #f2f2f2; }
    h2 { color: #333; }
  </style>
</head>
<body>

<h2>Weekly Attendance Summary (<?php echo $from . " to " . $to; ?>)</h2>

<table>
  <tr>
    <th>Member</th>
    <th>Days Present</th>
    <th>Total ₹</th>
  </tr>
  <?php $overall = 0; ?>
  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?php echo htmlspecialchars($row['name']); ?></td>
      <td><?php echo $row['days_present']; ?></td>
      <td>₹<?php echo $row['total_amount']; $overall += $row['total_amount']; ?></td>
    </tr>
  <?php endwhile; ?>
  <tr>
    <td colspan="2"><strong>Overall Total</strong></td>
    <td><strong>₹<?php echo $overall; ?></strong></td>
  </tr>
</table>

</body>
</html>
