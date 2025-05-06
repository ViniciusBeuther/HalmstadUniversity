<?php
require_once __DIR__ . '/../model/LogModel.php';
require_once __DIR__ . '/../model/BrowserModel.php';
require_once __DIR__ . '/../model/PageModel.php';
require_once __DIR__ . '/../model/UserLogModel.php';

class LogController {
    private $logModel;
    private $userLogModel;
    private $browserModel;
    private $pageModel;


    /**
     * Constructor for the controller
     * @param db: mysqli 
     */
    public function __construct($db) {
        $this->logModel = new LogModel($db);
        $this->userLogModel = new UserLogModel($db);
        $this->browserModel = new BrowserModel($db);
        $this->pageModel = new PageModel($db);
    }

    /**
     * Function responsible for instantiate and insert data in all tables related to
     * the user logs, it executes for each page opened
     */
    public function trackVisit() {
        $ip = $_SERVER['REMOTE_ADDR'];
        $browser = $this->getBrowserName();
        
        // Get the page name, if it has sections like logs, insert like: dashboard-logs
        $pageName = basename($_SERVER['PHP_SELF']);
        if (isset($_GET['section'])) {
            $pageName .= '-' . $_GET['section'];
        }

        $timestamp = date('Y-m-d H:i:s');

        $browserId = $this->browserModel->getOrInsert($browser);
        $pageId = $this->pageModel->getOrInsert($pageName);
        $logId = $this->logModel->insertLog($ip, $browserId, $pageId, $timestamp);

        // echo isset($_SESSION['user_id']);
        
        if (isset($_SESSION['user_id'])) {
            $this->userLogModel->insertUserLog($_SESSION['user_id'], $logId);
        } 
    }

    /**
     * Return all the logs stored in database
     * @return Logs[]
     */
    public function showAllLogs() {
        return $this->logModel->getAllLogs();
    }


    public function getAccessesPerPage(){
        return $this->logModel->getAccessesPerPage();
    }

    public function getVisualizationStats($lastDays){
        return $this->logModel->getVisualizationStats($lastDays);
    }

    /**
     * Get the HTTP_USER_AGENT and check what is the browser, it uses the method stripos
     * to find the first occurrence in the string for the main browsers
     * @return browsername:string
     */
    public function getBrowserName(){
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (stripos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (stripos($userAgent, 'Edg') !== false) {
            return 'Edge';
        } elseif (stripos($userAgent, 'Chrome') !== false && stripos($userAgent, 'Edg') === false) {
            return 'Chrome';
        } elseif (stripos($userAgent, 'Safari') !== false && stripos($userAgent, 'Chrome') === false) {
            return 'Safari';
        } elseif (stripos($userAgent, 'Opera') !== false || stripos($userAgent, 'OPR') !== false) {
            return 'Opera';
        } else {
            return 'Other';
        }
    }
}
