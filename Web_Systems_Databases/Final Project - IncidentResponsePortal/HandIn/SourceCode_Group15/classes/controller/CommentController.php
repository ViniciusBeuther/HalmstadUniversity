<?php 
    require_once __DIR__ . '/../model/CommentModel.php';

    class CommentController{
        private $commentModel;

        public function __construct($db)
        {
            $this->commentModel = new CommentModel($db);
        }

        public function getComments($incident_id){
            if(!is_numeric($incident_id) || !isset($incident_id)) return null;

            $comments = $this->commentModel->getComments($incident_id);

            return $comments;
        }

        public function insertComment($incident_id, $comment, $author_id){
            $insertedWithSuccess = $this->commentModel->insertComment($incident_id, $comment, $author_id);

            return $insertedWithSuccess;
        }
    }
?>