<?php
    session_start();
            
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once __DIR__ . '/../classes/controller/LogController.php';
    require_once __DIR__ . '/../config/db_connection.php';

    $logController = new LogController($mysqli);
    $logController->trackVisit(); 
?>