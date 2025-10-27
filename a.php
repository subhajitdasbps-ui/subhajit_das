<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Weekly Attendance Tracker</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; max-width: 800px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
    th { background-color: #f2f2f2; }
    .total-cell { font-weight: bold; }
  </style>
</head>
<body>
  <h2>Weekly Attendance and Payment Tracker</h2>
  <p>Each attended day adds ₹13.</p>
  <table id="attendanceTable">
    <thead>
      <tr>
        <th>Member</th>
        <th>Mon</th>
        <th>Tue</th>
        <th>Wed</th>
        <th>Thu</th>
        <th>Fri</th>
        <th>Sat</th>
        <th>Sun</th>
        <th>Total ₹</th>
      </tr>
    </thead>
    <tbody>
      <!-- 8 Members -->
      <script>
        for (let i = 1; i <= 8; i++) {
          document.write('<tr>');
          document.write(`<td>Member ${i}</td>`);
          for (let j = 0; j < 7; j++) {
            document.write(`<td><input type="checkbox" onchange="calculateTotals()"></td>`);
          }
          document.write(`<td class="total-cell">₹0</td>`);
          document.write('</tr>');
        }
      </script>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="8" style="text-align: right;"><strong>Overall Total:</strong></td>
        <td class="total-cell" id="overallTotal">₹0</td>
      </tr>
    </tfoot>
  </table>

  <script>
    const rate = 13;

    function calculateTotals() {
      const table = document.getElementById('attendanceTable');
      let overall = 0;

      for (let i = 1; i <= 8; i++) {
        const row = table.rows[i];
        const checkboxes = row.querySelectorAll('input[type="checkbox"]');
        let count = 0;

        checkboxes.forEach(cb => {
          if (cb.checked) count++;
        });

        const memberTotal = count * rate;
        row.cells[8].textContent = `₹${memberTotal}`;
        overall += memberTotal;
      }

      document.getElementById('overallTotal').textContent = `₹${overall}`;
    }
  </script>
</body>
</html>
