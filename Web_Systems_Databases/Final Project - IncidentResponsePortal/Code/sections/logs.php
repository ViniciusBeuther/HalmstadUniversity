<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../classes/controller/LogController.php';
require_once __DIR__ . '/../config/db_connection.php';

$logController = new LogController($mysqli);
$logController->trackVisit();

// Load all logs at the same time
$logs = $logController->showAllLogs() ?? [];

// Handle filtering and pagination
$usernameFilter = $_GET['username'] ?? '';

// Ternary if to check the current page, if it doesn't exist return page 1
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 15;

// Filter logs based on username provided in search bar
if ($usernameFilter) {
    $filteredLogs = [];

    foreach ($logs as $log) {
        $username = isset($log['username']) ? $log['username'] : '';
        
        if (stripos($username, $usernameFilter) !== false) {
            $filteredLogs[] = $log;
        }
    }
    
    $logs = $filteredLogs;
}

// Get total after filtering
$totalLogs = count($logs);
$totalPages = max(1, ceil($totalLogs / $perPage));
$currentPage = max(1, min($currentPage, $totalPages));

// Slice array for pagination
$offset = ($currentPage - 1) * $perPage;
$pagedLogs = array_slice($logs, $offset, $perPage);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Access Log</title>
    <style>
        @import url("../css/global.css");
        
        .logs_pagination_container{
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 15px;
        }

        .pagination_not_selected{
            background-color: var(--primary);
            padding: 5px;
            border-radius: 5px;
        }
        
        .pagination_selected{
            background-color: var(--primary_hover);
            padding: 5px;
            border-radius: 5px;
        }
        .log_pagination_li{
            text-align: center;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <h2>Access report</h2>

    <form method="get" action="">
    <input type="hidden" name="section" value="logs">
    <input type="text" name="username" placeholder="Filter by username" value="<?= htmlspecialchars($usernameFilter) ?>">
    <button type="submit">Filter</button>
</form>

    <table border="1">
        <tr>
            <th>Username</th>
            <th>IP address</th>
            <th>Browser</th>
            <th>Page</th>
            <th>Timestamp</th>
        </tr>
        <?php foreach ($pagedLogs as $log): ?>
            <tr>
                <td><?= $log['username'] ?? 'Anonymous' ?></td>
                <td><?= $log['ip_address'] ?></td>
                <td><?= $log['web_browser'] ?></td>
                <td><?= $log['page_name'] ?></td>
                <td><?= $log['access_timestamp'] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <!-- Pagination -->
    <div>
        <ul class="logs_pagination_container">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="log_pagination_li">
                <a href="?section=logs&page=<?= $i ?>&username=<?= urlencode($usernameFilter) ?>"
                    class="<?= $i == $currentPage ? 'pagination_selected' : 'pagination_not_selected' ?>">
                    <?= $i ?>
                </a>
            </li>
            
            <?php endfor; ?>
        </ul>
    </div>

</body>

</html>