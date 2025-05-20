<?php
session_start();
require_once __DIR__ . '/../classes/controller/StatusController.php';    
require_once __DIR__ . '/../config/db_connection.php'; 

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

$statusController = new StatusController($mysqli);

if(isset($_POST['incident_id'], $_POST['author_id'], $_POST['updated_status_id'])) {
    $incidentId = (int)$_POST['incident_id'];
    $authorId = (int)$_POST['author_id'];
    $updated_status_id = trim($_POST['updated_status_id']);
    
    $isInserted = $statusController->updatedStatus($incidentId, $authorId, $updated_status_id);
    
    if($isInserted) {
        $response = [
            'success' => true,
            'message' => 'Status updated successfully'
        ];
    } else {
        $response['message'] = 'Failed to update status';
    }

} else {
    $response['message'] = 'Missing required parameters';
}

echo json_encode($response);
exit;