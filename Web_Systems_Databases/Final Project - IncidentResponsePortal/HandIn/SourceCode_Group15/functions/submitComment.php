<?php
session_start();
require_once __DIR__ . '/../classes/controller/CommentController.php';    
require_once __DIR__ . '/../config/db_connection.php'; 

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

$commentController = new CommentController($mysqli);

if(isset($_POST['incident_id'], $_POST['author_id'], $_POST['comment'])) {
    $incidentId = (int)$_POST['incident_id'];
    $authorId = (int)$_POST['author_id'];
    $comment = trim($_POST['comment']);
    
    $isInserted = $commentController->insertComment($incidentId, $comment, $authorId);
    
    if($isInserted) {
        $response = [
            'success' => true,
            'message' => 'Comment inserted successfully'
        ];
    } else {
        $response['message'] = 'Failed to insert comment';
    }

} else {
    $response['message'] = 'Missing required parameters';
}

echo json_encode($response);
exit;