<?php 
    class IncidentModel{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        /**
         * It fetches all the information necessary to display into the modal, info such as severity, status, affected assets etc...
         * @param int incident_id: incident_id to fetch information for.
         * @return Object: it returns a single object containing the information for the expected incident reported
         */
        public function getIncidentDetails($incident_id){
            $stmt = $this->db->prepare("
                SELECT 
                    i.incident_report_id, 
                    i.incident_date, 
                    i.description,
                    it.incident_name, 
                    se.severity_name, 
                    s.incident_status, 
                    aa.affected_asset_name, 
                    u.username, 
                    e.file_path
                FROM Incident_Reported AS i
                    JOIN Incident_Type AS it ON it.incident_type_id = i.incident_type_id
                    JOIN Severity AS se ON se.severity_id = i.severity_id
                    JOIN Incident_Status AS s ON s.incident_status_id = i.incident_status_id
                    JOIN Affected_Asset_Reported AS aar ON aar.incident_report_id = i.incident_report_id
                    JOIN Affected_Asset AS aa ON aar.affected_asset_id = aa.affected_asset_id
                    JOIN Portal_Users AS u ON u.user_id = i.reported_by_id 
                    LEFT JOIN Evidence AS e ON e.incident_report_id = i.incident_report_id
                WHERE i.incident_report_id = ?
                ORDER BY i.incident_date DESC;
            ");

            $stmt->bind_param('i', $incident_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $stmt->close();

            if($result->num_rows == 0) return null;

            $incidentObj = $result->fetch_object();
            return $incidentObj;
        }

        public function getAffectedAssets($incident_id){
            $stmt = $this->db->prepare("
            SELECT 
                a.affected_asset_name
            FROM Incident_Reported as i
            JOIN Affected_Asset_Reported AS aa ON aa.incident_report_id = i.incident_report_id
            JOIN Affected_Asset AS a ON a.affected_asset_id = aa.affected_asset_id 
            WHERE i.incident_report_id = ?;
            ");

            $stmt->bind_param('i', $incident_id);
            $stmt->execute();

            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);

            return $data;
        }
    }
?>