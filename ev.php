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
          <h4>Battery: 60%</h4>
          
          <!-- Progress Bar -->
          <div class="progress my-4">
            <div class="progress-bar" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
          </div>

          <!-- Time Remaining -->
          <h5>Time Remaining: 2h 30m</h5>

          <!-- Stop Button -->
          <button class="btn btn-custom mt-3">
            <i class="fas fa-stop-circle"></i> Stop Charging
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
            <p><strong>Charging Speed:</strong> 22 kW</p>
            <p><strong>Total Energy Used:</strong> 10 kWh</p>
            <p><strong>Cost:</strong> ₹232.50</p>
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
</body>
</html>
