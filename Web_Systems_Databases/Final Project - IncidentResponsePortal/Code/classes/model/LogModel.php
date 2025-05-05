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
                SELECT al.access_log_id, pu.username, al.ip_address, wb.web_browser, p.page_name, al.access_timestamp
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
    }
?>