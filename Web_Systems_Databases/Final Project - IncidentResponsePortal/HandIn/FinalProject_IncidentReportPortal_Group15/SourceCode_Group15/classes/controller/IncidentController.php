<?php   
    require_once __DIR__ . '/../model/IncidentModel.php';
    

    class IncidentController{
        private $incidentModel;

        public function __construct($db)
        {
            $this->incidentModel = new IncidentModel($db);
        }

        public function getIncidentDetails($incident_id){
            if(!is_numeric($incident_id) || !isset($incident_id)) return null;

            $incidentObj = $this->incidentModel->getIncidentDetails($incident_id);

            return $incidentObj;
        }

        public function getAffectedAssets($incident_id){
            if(!is_numeric($incident_id) || !isset($incident_id)) return null;

            $assetsAffectedArr = $this->incidentModel->getAffectedAssets($incident_id);

            return $assetsAffectedArr;
        }
    }
?>