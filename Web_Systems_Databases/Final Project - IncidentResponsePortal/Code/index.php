<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/Login/style.scss">
  <title>Log In</title>
</head>
<body>
  <?php 
    $form = <<<END
    <article id="login__form_container">
      <h1>Log In</h1>
      <p>Insert your username and password.</p>
      <form action="/functions/handleLogin.php" method="post" id="login__form">
      <input type="text" name="username" placeholder="username">
      <input type="password" name="password" placeholder="password">
      <input type="submit" value="Login" id="login__loginBtn">
      </form>
      
      <p>Don't have an account? Click <a href="register.php">Here</a></p>
      </article>
    END;
    echo $form;
    ?>
</body>
</html>