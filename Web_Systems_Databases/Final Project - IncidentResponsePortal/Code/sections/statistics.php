<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    
    require_once __DIR__ . '/../classes/controller/LogController.php';
    require_once __DIR__ . '/../config/db_connection.php';
    
    $logController = new LogController($mysqli);
    $logController->trackVisit();

    $accesses_per_page = $logController->getAccessesPerPage();

    function formatPageName($page_name){
        if(str_contains($page_name, '-')){
            $temp = explode('-', $page_name);
            return ucfirst($temp[1]);

        } else if(str_contains($page_name, '.php')){
            $temp = explode(".", $page_name);
            return ucfirst($temp[0]);

        } else {
            return "Error";
        }
    }
?>
<article>
    <h1>Website statistics</h1>
        <table>
            <tr>
                <th>Page Name</th>
                <th>Number of Accesses</th>
                <th>Last Access at</th>
                <th>Access Percentage</th>
            </tr>
            <?php foreach ($accesses_per_page as $access): ?>
                <tr>
                    <td><?= formatPageName($access['page_name']) ?? 'unidentified' ?></td>
                    <td><?= $access['num_occurrences'] ?? '-' ?></td>
                    <td><?= $access['last_access'] ?? '-' ?></td>
                    <td><?= $access['access_percentage'] ?? '-' ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
</article>