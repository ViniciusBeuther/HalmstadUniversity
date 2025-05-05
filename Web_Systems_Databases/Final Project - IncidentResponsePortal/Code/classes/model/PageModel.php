<?php
class PageModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getOrInsert($pageName)
    {
        $pageId = null;

        // Try to get the page_id from database
        $stmt = $this->db->prepare("SELECT page_id FROM Page WHERE page_name = ?");
        $stmt->bind_param("s", $pageName);
        $stmt->execute();
        $stmt->bind_result($pageId);

        if ($stmt->fetch()) {
            return $pageId;
        }
        $stmt->close();

        // Insert a new record in the database if the page doesn't exist yet
        $insert = $this->db->prepare("INSERT INTO Page (page_name) VALUES (?)");
        $insert->bind_param("s", $pageName);
        $insert->execute();
        $insertedId = $insert->insert_id;
        $insert->close();

        return $insertedId;
    }
}
