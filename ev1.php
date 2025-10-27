<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EV Charger UI</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #1C1C1C;
      color: white;
    }
    .card-custom {
      background-color: #2c2c2c;
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    }
    .progress-bar {
      background-color: #00FF00;
    }
    .progress {
      height: 25px;
    }
    .btn-custom {
      background-color: #0074D9;
      color: white;
      border-radius: 50px;
      padding: 12px 30px;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #005f99;
    }
    .icon {
      font-size: 50px;
      color: #00FF00;
    }
    .info-card {
      background-color: #333;
      border-radius: 15px;
      margin-top: 20px;
    }
    .card-header {
      background-color: #0074D9;
      color: white;
      font-size: 1.2em;
    }
  </style>
</head>
<body>

  <div class="container py-5">
    <!-- Charging Status -->
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card card-custom text-center p-4">
          <i class="fas fa-bolt icon"></i>
          <h2>Charging</h2>
          <h4 id="batteryPercentage">Battery: 0%</h4>
          
          <!-- Progress Bar -->
          <div class="progress my-4">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <!-- Time Remaining -->
          <h5 id="timeRemaining">Time Remaining: 0h 00m</h5>

          <!-- Start Button -->
          <button id="startBtn" class="btn btn-custom mt-3" onclick="startCharging()">
            <i class="fas fa-play-circle"></i> Start Charging
          </button>

          <!-- Stop Button (Initially Hidden) -->
          <button id="stopBtn" class="btn btn-custom mt-3" style="display: none;" onclick="stopCharging()">
            <i class="fas fa-stop-circle"></i> Stop Charging
          </button>

          <!-- Reset Button (Initially Hidden) -->
          <button id="resetBtn" class="btn btn-custom mt-3" style="display: none;" onclick="resetCharging()">
            <i class="fas fa-redo"></i> Reset Charging
          </button>
        </div>
      </div>
    </div>

    <!-- Charging Info -->
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card info-card">
          <div class="card-header">Charging Session Info</div>
          <div class="card-body">
            <p><strong>Charging Speed:</strong> <span id="chargingSpeed">0</span> kW</p>
            <p><strong>Total Energy Used:</strong> <span id="energyUsed">0</span> kWh</p>
            <p><strong>Cost:</strong> ₹ <span id="cost">0.00</span></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Settings and Notifications -->
    <div class="row justify-content-center mt-4">
      <div class="col-auto">
        <button class="btn btn-light btn-sm">
          <i class="fas fa-cogs"></i> Settings
        </button>
      </div>
      <div class="col-auto">
        <button class="btn btn-light btn-sm">
          <i class="fas fa-bell"></i> Notifications
        </button>
      </div>
    </div>
  </div>

  <!-- Bootstrap and FontAwesome JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let chargingInterval;
    let battery = 0;
    let energyUsed = 0;
    let chargingSpeed = 22; // initial charging speed in kW
    let costPerKWh = 23.25; // INR per kWh
    let initialChargingSpeed = 22;

    function startCharging() {
      // Hide Start button and show Stop/Reset buttons
      document.getElementById('startBtn').style.display = 'none';
      document.getElementById('stopBtn').style.display = 'inline-block';
      document.getElementById('resetBtn').style.display = 'inline-block';
      
      chargingInterval = setInterval(updateCharging, 1000); // Update every second
    }

    function stopCharging() {
      // Stop the charging process
      clearInterval(chargingInterval);
      
      // Show Start button and hide Stop/Reset buttons
      document.getElementById('startBtn').style.display = 'inline-block';
      document.getElementById('stopBtn').style.display = 'none';
      document.getElementById('resetBtn').style.display = 'inline-block';
    }

    function resetCharging() {
      // Reset all values
      battery = 0;
      energyUsed = 0;
      document.getElementById('batteryPercentage').textContent = `Battery: ${battery}%`;
      document.getElementById('progressBar').style.width = `${battery}%`;
      document.getElementById('progressBar').setAttribute('aria-valuenow', battery);
      document.getElementById('timeRemaining').textContent = `Time Remaining: 0h 00m`;
      document.getElementById('energyUsed').textContent = '0.00';
      document.getElementById('cost').textContent = '0.00';

      // If charging was active, stop it
      clearInterval(chargingInterval);

      // Show Start button, hide Stop/Reset buttons
      document.getElementById('startBtn').style.display = 'inline-block';
      document.getElementById('stopBtn').style.display = 'none';
      document.getElementById('resetBtn').style.display = 'none';
    }

    function updateCharging() {
      if (battery >= 100) {
        // Stop charging when battery is full
        stopCharging();
        return;
      }

      // Dynamic charging speed adjustment: Slower charging as battery fills up
      chargingSpeed = initialChargingSpeed * (1 - battery / 10);
      document.getElementById('chargingSpeed').textContent = chargingSpeed.toFixed(2);

      // Update battery percentage
      battery += (chargingSpeed / 3600); // Increase battery by charging speed per second
      document.getElementById('batteryPercentage').textContent = `Battery: ${battery.toFixed(1)}%`;

      // Update progress bar
      document.getElementById('progressBar').style.width = `${battery}%`;
      document.getElementById('progressBar').setAttribute('aria-valuenow', battery);

      // Calculate time remaining based on current battery level and charging speed
      let remainingBattery = 100 - battery;
      let timeRemaining = (remainingBattery / chargingSpeed) * 3600; // time in seconds
      let hours = Math.floor(timeRemaining / 3600);
      let minutes = Math.floor((timeRemaining % 3600) / 60);
      document.getElementById('timeRemaining').textContent = `Time Remaining: ${hours}h ${minutes}m`;

      // Update energy used and cost
      energyUsed += chargingSpeed / 3600; // Convert kW to kWh per second
      document.getElementById('energyUsed').textContent = energyUsed.toFixed(2);

      let cost = energyUsed * costPerKWh;
      document.getElementById('cost').textContent = cost.toFixed(2);
    }
  </script>
</body>
</html>
