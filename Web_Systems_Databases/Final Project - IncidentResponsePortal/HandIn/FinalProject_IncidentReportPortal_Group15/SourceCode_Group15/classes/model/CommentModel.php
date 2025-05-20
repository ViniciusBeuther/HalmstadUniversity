<?php 
    class CommentModel{
        private $db;

        public function __construct($db)
        {
            $this->db = $db;
        }

        /**
         * It will load all the comments for a provided incident id.
         * @param int $incident_id
         * @return array[] comments;
         */
        public function getComments($incident_id){
            if(!is_numeric($incident_id)) return null;
            
            $stmt = $this->db->prepare("
                SELECT 
                    u.username, 
                    r.role_name, 
                    c.comments, 
                    c.comment_date
                FROM Comment AS c
                JOIN Portal_Users u ON u.user_id = c.author_id
                JOIN Role r ON r.role_id = u.role_id
                WHERE c.incident_report_id = ?
                ORDER BY c.comment_date DESC;
            ");

            $stmt->bind_param('i', $incident_id);
            $stmt->execute();
            $result = $stmt->get_result();

            $comments = $result->fetch_all(MYSQLI_ASSOC);
            $stmt->close();

            return $comments;
        }

        public function insertComment($incident_id, $comment, $author_id){
            $stmt = $this->db->prepare("
                INSERT INTO Comment(author_id, incident_report_id, comments) VALUES(?, ?, ?);
            ");

            $stmt->bind_param('iis', $author_id, $incident_id, $comment);
            return $stmt->execute();

        }
    }
?>