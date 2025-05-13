<?php
    class LogModel{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }


        /**
         * Insert into the logs
         * @param ip: user ip address
         * @param browser_id: browser id
         * @param page_id: page visited id
         * @param timestamp: access timestamp
         * 
         * @return int: inserted id
         */
        public function insertLog($ip, $browser_id, $page_id, $timestamp){
            $stmt = $this->db->prepare("INSERT INTO Access_Log(ip_address, web_browser_id, page_id, access_timestamp) VALUES(?, ?, ?, ?);");
            $stmt->bind_param('siis', $ip, $browser_id, $page_id, $timestamp);
            $stmt->execute();

            return $this->db->insert_id;
        }

        /**
         * @param None
         * @return Logs[] 
         */
        public function getAllLogs() {
            $stmt = $this->db->prepare("
                SELECT al.access_log_id, pu.user_id, pu.username, al.ip_address, wb.web_browser, p.page_name, al.access_timestamp
                FROM Access_Log al
                LEFT JOIN Web_Browser wb ON al.web_browser_id = wb.web_browser_id
                LEFT JOIN Page p ON al.page_id = p.page_id
                LEFT JOIN User_Access_Log ual ON al.access_log_id = ual.access_log_id
                LEFT JOIN Portal_Users pu ON ual.user_id = pu.user_id
                ORDER BY al.access_timestamp DESC
            ");
            $stmt->execute();
            $result = $stmt->get_result();
            $logs = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();
            return $logs;
        }

        /**
         * Used to get the statistics from database and show it in website statistics for the most accessed pages
         * @param: none
         * @return array[]
         */
        public function getAccessesPerPage(){
            $stmt = $this->db->prepare("
                SELECT 
                    p.page_name, 
                    COUNT(1) as num_occurrences, 
                    MAX(al.access_timestamp) as last_access,
                    ROUND(COUNT(1) * 100 / total.total_count, 2) as access_percentage
                from Page p
                JOIN Access_Log al ON al.page_id = p.page_id
                JOIN(SELECT COUNT(1) as total_count FROM Access_Log ) AS total
                GROUP BY p.page_name, total.total_count
                ORDER BY num_occurrences DESC;
        ");
        $stmt->execute();

        $result = $stmt->get_result();
        $accesses = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        return $accesses;
        }

        public function getVisualizationStats($inTheLastDays){
            if(!is_numeric($inTheLastDays) || $inTheLastDays <= 0) return;
            
            $stmt = $this->db->prepare("
                SELECT
                    DATE(access_timestamp) AS access_date,
                    COUNT(*) AS total_access
                FROM Access_Log
                WHERE access_timestamp >= CURDATE() - INTERVAL {$inTheLastDays} DAY
                GROUP BY access_date
                ORDER BY access_date;
            ");

            $stmt->execute();

            $result = $stmt->get_result();
            $data = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $data;
        }
    }
?>