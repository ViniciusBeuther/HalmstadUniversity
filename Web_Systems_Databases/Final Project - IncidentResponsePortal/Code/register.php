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
  if( isset($_POST['username']) and isset($_POST['password']) and isset($_PSOT['email']) and isset($_POST['register__select']) ){
    $name   = $mysqli->real_escape_string($_POST['username']); 
    $pwd    = $mysqli->real_escape_string($_POST['password']); 
    $email    = $mysqli->real_escape_string($_POST['email']); 
    $role_id    = $mysqli->real_escape_string($_POST['register__select']); 

    $query = <<<END
      INSERT INTO Users(name, password, email, role_id) VALUES('{$name}', '${$pwd}', '{$email}', '{$role_id}');
    END;

      if( $mysqli->query($query) != TRUE){
        die("Could not query database" . $mysqli->errorno . " : " . $mysqli->error);
        header('Location:index.php');
      }
  }
    $form = <<<END
    <article id="login__form_container">
      <h1>Register</h1>
      <p>Insert the information to create an account.</p>
      <form action="register.php" method="post" id="login__register_form">
        <input type="text" name="username" placeholder="username">
        <input type="password" name="password" placeholder="password">
        <input type="text" name="email" placeholder="email">
        <select name="register__select" id="register__select">
          <option value="1">Incident Reporter</option>
          <option value="2">Incident Responder</option>
          <option value="3">Administrator</option>
        </select>
        <input type="submit" value="Register" id="login__registerBtn">
      </form>
      <p>Already have an account? Back to <a href="index.php">login</a></p>
    </article>
    <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.getElementById("login__register_form").addEventListener("submit", () => {
        alert("Form submitted!");
      });
    });
    </script>
    END;
    echo $form;
    ?>
</body>
</html>