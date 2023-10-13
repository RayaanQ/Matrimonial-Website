<?php

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password_hash"])) {
            header("Location: matrimoni.html");
            exit;
        }
    }
    
    $is_invalid = true;
}

?>


<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../static/login.css">
<link rel="icon" href="https://uxwing.com/wp-content/themes/uxwing/download/relationship-love/finding-love-icon.svg" type="image/png">
<title>Login Form</title>
</head>
<body>
  <body>
    <div class="login-page">
      <div class="form">
        <div class="login">
          <div class="login-header">
            <h3>LOGIN</h3>
            <?php if($is_invalid): ?>
                <em>Invalid Login</em>
            <?php endif; ?>
            <p>Please enter your credentials to login.</p>
          </div>
        </div>
        <form class="login-form" method="post">
          <label for="email"></label>
          <input type="email" name="email" placeholder="email" id="email" value="<?=htmlspecialchars($_POST["email"] ?? "") ?>"/>
          <label for="password"></label>
          <input type="password" name="password" placeholder="password" id="password"/>
          <button>login</button>
          <p class="message">Not registered? <a href="register.html">Create an account</a></p>
        </form>
      </div>
    </div>
  </body>  
</body>
</html>