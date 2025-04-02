<link rel="stylesheet" href="/css/stylesheet.css">
<?php 
include('head.php');
session_name('Website');
session_start();
$host = "localhost";
$user = "vinbeu25";
$pwd = "dmWG4RltMW";
$db = "vinbeu25";
// $mysqli = new mysqli('localhost', 'vinbeu25', 'dmWG4RltMW', 'vinbeu25');
$mysqli = new mysqli($host, $user, $pwd, $db);
$navigation = <<<END
      <nav>
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="login.php">Log In</a>
      END;
      if(!isset($_SESSION['userId'])){
        $navigation .= <<<END
        <a href="register.php">Register</a>
        END;
      }

  if(isset($_SESSION['userId'])){
    $navigation .= <<<END
    <a href="products.php">Products</a>
    <a href="add_product.php">Add product</a>
    <a href="logout.php">Logout</a>
    Logged in as {$_SESSION['username']}
    END;
  }
  $navigation .= '</nav>';
?>