<?php 
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once __DIR__ . '/../classes/controller/IncidentController.php';    
    require_once __DIR__ . '/../config/db_connection.php'; 
    
    $incidentController = new IncidentController($mysqli);
    header('Content-Type: application/json');
    
    if(isset($_POST['incident_id'])){
        $incidentId = $_POST['incident_id'];
        $incidentObj = $incidentController->getIncidentDetails($incidentId);
        $affectedAssets = $incidentController->getAffectedAssets($incidentId);

        if ($incidentObj === null || $affectedAssets == null) {
            echo json_encode(['error' => 'Incident not found or duplicate rows']);
        } else {
            echo json_encode([
                'incident' => $incidentObj,
                'affected_assets' => $affectedAssets
            ]);
        }

        exit;
    } else {
        echo json_encode(['error' => 'No incident ID']);
    }
?>