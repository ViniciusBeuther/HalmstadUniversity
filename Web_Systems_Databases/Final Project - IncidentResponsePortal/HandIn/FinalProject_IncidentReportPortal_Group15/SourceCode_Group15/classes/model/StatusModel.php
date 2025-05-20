<?php 
    class StatusModel{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        /**
         * Get all the status available in database
         * @return array[string]
         */
        public function getStatusTypes(){
            $stmt = $this->db->prepare("SELECT * FROM Incident_Status");
            $stmt->execute();
            $result = $stmt->get_result();
            $statusArr = $result->fetch_all(MYSQLI_ASSOC);

            $stmt->close();

            return $statusArr;
        }

        public function updateStatus($incident_id, $author_id, $updatedStatusId) {
                $stmt = $this->db->prepare("INSERT INTO Incident_Solved(incident_report_id, solver_id, incident_status) VALUES(?, ?, ?)");
                $stmt->bind_param('iii', $incident_id, $author_id, $updatedStatusId);
                $insertSuccess = $stmt->execute();
                
                if (!$insertSuccess) {
                    throw new Exception("Failed to insert into Incident_Solved");
                }

                $updateStmt = $this->db->prepare("UPDATE Incident_Reported SET incident_status_id = ? WHERE incident_report_id = ?");
                $updateStmt->bind_param('ii', $updatedStatusId, $incident_id);
                $updateSuccess = $updateStmt->execute();
                
                if (!$updateSuccess) {
                    throw new Exception("Failed to update Incident_Reported");
                }

                
                return [
                    'success' => true,
                    'message' => 'Status updated successfully'
                ];
        }
    }
?>