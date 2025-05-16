<?php 
    require_once __DIR__ . '/../model/StatusModel.php';

    class StatusController{
        private $statusModel;

        public function __construct($db)
        {
            $this->statusModel = new StatusModel($db);
        }

        public function getStatusTypes(){
            return $this->statusModel->getStatusTypes();
        }

        public function updatedStatus($incident_id, $author_id, $updatedStatusId){
            $result = $this->statusModel->updateStatus($incident_id, $author_id, $updatedStatusId);
            return $result['success'];
        }
    }
?>