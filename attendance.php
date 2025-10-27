<?php
$conn = new mysqli("localhost", "admin", "", "attend");

// Fetch members
$members = $conn->query("SELECT * FROM members ORDER BY id");

// Get today's date
$today = date('Y-m-d');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  foreach ($_POST['present'] as $member_id => $is_present) {
    // Prevent duplicate entry
    $stmt = $conn->prepare("REPLACE INTO attendance (member_id, date, present) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $member_id, $today, $is_present);
    $stmt->execute();
  }
  echo "<script>alert('Attendance saved!');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Attendance Form</title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; padding: 20px; background: #f4f6f8; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
    th, td { border: 1px solid #ddd; padding: 10px; text-align: center; }
    th { background: #0066cc; color: white; }
    tr:nth-child(even) { background: #f9f9f9; }
    input[type=submit] { background: #28a745; color: white; padding: 10px 20px; border: none; margin-top: 15px; cursor: pointer; }
  </style>
</head>
<body>

<h2>Mark Attendance for <?php echo date("l, d M Y"); ?></h2>

<form method="POST">
  <table>
    <tr>
      <th>Member</th>
      <th>Present</th>
    </tr>
    <?php while($row = $members->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['name']); ?></td>
        <td>
          <input type="checkbox" name="present[<?php echo $row['id']; ?>]" value="1">
        </td>
      </tr>
    <?php endwhile; ?>
  </table>
  <input type="submit" value="Submit Attendance">
</form>

</body>
</html>
