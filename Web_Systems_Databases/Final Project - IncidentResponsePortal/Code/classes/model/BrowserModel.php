<?php
class BrowserModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getOrInsert($browser) {
        $browserId = null;
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        /** get web browser id from database */
        $stmt = $this->db->prepare("SELECT web_browser_id FROM Web_Browser WHERE web_browser = ?");
        $stmt->bind_param("s", $browser);
        $stmt->execute();
        $stmt->bind_result($browserId);
        
        /** return the id if it exists */
        if ($stmt->fetch()) {
            $stmt->close();
            return $browserId;
        }
        $stmt->close();
    
        /** If the browser provided doesn't exit in the database, insert it */
        $insert = $this->db->prepare("INSERT INTO Web_Browser (web_browser) VALUES (?)");
        $insert->bind_param("s", $browser);
        $insert->execute();
        $insertedId = $insert->insert_id;
        $insert->close();
    
        return $insertedId;
    }
    
}
