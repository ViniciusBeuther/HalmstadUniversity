<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login/style.css">
    <title>Log In</title>
    
    <style>
        .error-message{
            color: red;
            margin-top: 2px;
            font-size: x-small;
        }
    </style>
</head>

<body>
    <?php
    session_start();
                
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once 'config/db_connection.php';
    require_once 'classes/controller/PortalUserController.php';
    require_once 'classes/controller/LogController.php';
    
    $logController = new LogController($mysqli);
    $logController->trackVisit(); 

    $userController = new PortalUserController($mysqli);
    $loginErrorMessage = '';

    if (isset($_POST['username']) && isset($_POST['password'])) {
        try {
            $username = $mysqli->real_escape_string($_POST['username']);
            $pwd = $mysqli->real_escape_string($_POST['password']);
            $loginResult = $userController->login($username, $pwd);

            if ($loginResult['isValid']) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $loginResult['user_id'];
                header('Location: classes/view/dashboard.php');
                die();
            } else {
                $loginErrorMessage = 'Username or password incorrect, try again.';
            }
        } catch (Exception $e) {
            echo 'Error logging in';
        }
        if ($loginErrorMessage != '') {
            $loginError = <<<END
            <p class="error-message">Username or password incorrect, try again.</p>
        END;
        }
    }

    $form = <<<END
    <article id="login__form_container">
      <h1>Log In</h1>
      <p>Insert your username and password.</p>
      <form action="index.php" method="post" id="login__form">
      <input type="text" name="username" placeholder="username" required>
      <input type="password" name="password" placeholder="password" required>
    END;
      
      if ($loginErrorMessage != '') {
          $form .= <<<END
          {$loginError}
          END;
        }
        
        $form .= <<<END
        <input type="submit" value="Login" id="login__loginBtn">
        </form>
        </article>
    END;

    echo $form;
    ?>
</body>

</html>