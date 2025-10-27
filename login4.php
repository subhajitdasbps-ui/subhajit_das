<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Battery Health Monitoring System</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@700&family=Poppins:wght@400;500;600&display=swap');
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }
    body {
      margin: 0;
      padding: 0;
      background: #ffffff;
      height: 100vh;
      overflow: hidden;
    }
    .center {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      width: 400px;
      background: white;
      border-radius: 10px;
	  border: 1px solid #000;
      box-shadow: 15px 15px 15px rgba(0,0,0,0.5);
      padding: 20px;
      text-align: center;
    }
    .center img.logo {
      width: 120px;
      height: auto;
      margin-bottom: 5px;
    }
    .center h2 {
      margin: 10px 0;
    }
    form {
      padding: 0 20px;
      box-sizing: border-box;
    }
    .txt_field {
      position: relative;
      border-bottom: 2px solid #adadad;
      margin: 30px 0;
    }
    .txt_field input {
      width: 100%;
      padding: 0 5px;
      height: 40px;
      font-size: 16px;
      border: none;
      background: none;
      outline: none;
    }
    .txt_field label {
      position: absolute;
      top: 50%;
      left: 5px;
      color: #adadad;
      transform: translateY(-50%);
      font-size: 16px;
      pointer-events: none;
      transition: .5s;
    }
    .txt_field span::before {
      content: '';
      position: absolute;
      top: 40px;
      left: 0;
      width: 0%;
      height: 2px;
      background: #2691d9;
      transition: .5s;
    }
    .txt_field input:focus ~ label,
    .txt_field input:valid ~ label {
      top: -5px;
      color: #2691d9;
    }
    .txt_field input:focus ~ span::before,
    .txt_field input:valid ~ span::before {
      width: 100%;
    }
    .txt_field .eye-icon {
      position: absolute;
      right: 0;
      top: 50%;
      transform: translateY(-50%);
      padding: 0 10px;
      cursor: pointer;
      color: #adadad;
    }
    .txt_field .eye-icon:hover {
      color: #2691d9;
    }
    .pass {
      margin: -5px 0 20px 5px;
      color: #a6a6a6;
      cursor: pointer;
    }
    .pass:hover {
      text-decoration: underline;
    }
    input[type="submit"] {
      width: 100%;
      height: 50px;
      border: 1px solid;
      background: #2691d9;
      border-radius: 25px;
      font-size: 18px;
      color: #e9f4fb;
      font-weight: 700;
      cursor: pointer;
      outline: none;
    }
    input[type="submit"]:hover {
      border-color: #2691d9;
      transition: .5s;
    }
    .signup_link {
      margin: 30px 0;
      text-align: center;
      font-size: 16px;
      color: #666666;
    }
    .signup_link a {
      color: #2691d9;
      text-decoration: none;
    }
    .signup_link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="center">
    <img src="/calculator/images_baid.png" alt="Logo" class="logo">
    <h2>Welcome to Battery Health Monitoring System</h2>
    <form method="post">
      <div class="txt_field">
        <input type="text" required>
        <span></span>
        <label>Username</label>
      </div>
      <div class="txt_field">
        <input type="password" id="password" required>
        <span></span>
        <label>Password</label>
        <i class="fas fa-eye eye-icon" id="togglePassword"></i>
      </div>
      <div class="pass">Forgot Password?</div>
      <input type="submit" value="Login">
      <div class="signup_link">
        Not a member? <a href="#">Signup</a>
      </div>
    </form>
  </div>
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');
    
    togglePassword.addEventListener('click', function () {
      const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
      password.setAttribute('type', type);
      this.classList.toggle('fa-eye-slash');
    });
  </script>
</body>
</html>
