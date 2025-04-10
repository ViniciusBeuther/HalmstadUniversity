<?php 

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'vinbeu25');
define('DB_PASSWORD', '#####');
define('DB_NAME', 'vinbeu25');

try{
    $mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
} catch(Exception $e){
    echo "<p>Error connection to the database</p>";
    die("Error connection the database, try again.");
}

function close_connection(){
    global $mysqli;
    if(isset($mysqli)){
        $mysqli->close();
    }
}

register_shutdown_function('close_connection');

?>
