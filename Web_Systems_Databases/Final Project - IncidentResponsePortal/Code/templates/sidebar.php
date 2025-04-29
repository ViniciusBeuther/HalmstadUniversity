<?php
$current_section = isset($_GET['section']) ? $_GET['section'] : 'initial';
$username = $_SESSION['username'];

error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);


    require_once __DIR__ . '../../config/db_connection.php';
    require_once __DIR__ . '../../classes/controller/PortalUserController.php';

    $userController = new PortalUserController($mysqli);
    $permissions = $userController->getPermission($_SESSION['username']);
    $adminSidebar = '';

    if ($permissions == 1) {
        $adminSidebar .= '
            <li>
                <a href="?section=statistics" class="' . ($current_section === 'statistics' ? 'active' : '') . '">
                    <img src="/project/assets/sidebar_stats_icon.svg" alt="statistics_icon" class="icon">
                    Website Statistics
                </a>
            </li>
            <li>
                <a href="?section=logs" class="' . ($current_section === 'logs' ? 'active' : '') . '">
                    <img src="/project/assets/sidebar_logs_icon.svg" alt="logs_icon" class="icon">
                    Logs
                </a>
            </li>
            <hr class="sidebar__hr">
            <li>
                <a href="?section=users" class="' . ($current_section === 'users' ? 'active' : '') . '">
                <img src="/project/assets/sidebar_user_icon.svg"      alt="user_icon" class="icon">
                    Users
                </a>
            </li>';
            ;
    }

?>
<head>
    <link rel="stylesheet" href="../css/Dashboard/style.css">
    <style>
        @import url('../css/global.css');
        ul li{
            list-style-type: none;
            margin-bottom: 1rem;
        }
        
        a{
            padding: 5px 10px;
            text-decoration: none;
            color: var(--secondary);
            display: flex;
            align-items: center;
            justify-content: start;
            gap: 5px;
            width: 80%;
            white-space: nowrap;
        }
        
        a:visited{
            color: var(--secondary);
        }

        a:hover{
            text-decoration: underline;
        }

        .active{
            background-color: var(--primary);
            border-radius: .25rem;
            text-decoration: underline;
            font-weight: bold;
        }

        h2{
            margin-bottom: 1rem;
        }

        aside.asideBar{
            border: none;
        }

        hr.sidebar__hr{
            margin-bottom: 1rem;
        }

        img.icon{
            width: 1.5rem;
            height: 1.5rem;
        }
    </style>
</head>

<aside class="asideBar">
    <h2>Dashboard</h2>
    <nav>
        <ul>
            <li> 
                <a href="?section=initial" class="<?= $current_section === 'initial' ? 'active' : '' ?>">
                    <img src="/project/assets/sidebar_home_icon.svg" alt="home_icon" class="icon" />
                    Home
                </a>
            </li>
            <li>
                <a href="?section=report" class="<?= $current_section === 'report' ? 'active' : '' ?>">
                    <img src="/project/assets/sidebar_report_icon.svg" alt="report_icon" class="icon">
                    Report Incident
                </a>
            </li>
            <li>
                <a href="?section=view" class="<?= $current_section === 'view' ? 'active' : '' ?>">
                    <img src="/project/assets/sidebar_view_icon.svg" alt="view_icon" class="icon">
                    View Incident
                </a>
            </li>
            <li>
                <a href="?section=settings" class="<?= $current_section === 'settings' ? 'active' : '' ?>">
                    <img src="/project/assets/sidebar_settings_icon.svg"      alt="settings_icon" class="icon">
                    Settings
                </a>
            </li>
            <?php 
                echo $adminSidebar;
            ?>
        </ul>
    </nav>
</aside>