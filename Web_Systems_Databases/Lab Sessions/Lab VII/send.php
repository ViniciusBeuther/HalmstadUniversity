<?php 
// This is a code to display the error if it exists.
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//
include('template.php'); 
if (isset($_POST)) { 
$name    
= htmlspecialchars($_POST["name"]); 
$msg     
= htmlspecialchars($_POST["msg"]); 
$content = <<<END
<h3>Message was sent:</h3>
Name: {$name}
<br>
Message: {$msg}
END;
$to = "vinbeu25@student.hh.se"; 
$subject = "Test-mail"; 
$msg = $_POST["msg"]; 
$headers = "From: " . $_POST["name"]; 
mail($to, $subject, $msg, $headers); 
} 
echo $navigation; 
echo $content; 
?> 