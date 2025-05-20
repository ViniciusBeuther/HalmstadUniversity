<?php 
    session_start();
    require_once __DIR__ . '/../classes/controller/CommentController.php';    
    require_once __DIR__ . '/../config/db_connection.php'; 
    
    $commentController = new CommentController($mysqli);
    
    
if(isset($_POST['incident_id'])){
    
    $incidentId = $_POST['incident_id'];
    $commentsArr = $commentController->getComments($incidentId);

    echo json_encode($commentsArr);
    exit;
} else {
    echo json_encode(['error' => 'No incident ID']);
}
?>