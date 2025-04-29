<?php
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: /project/index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == 'POST' && isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: /project/index.php");
    exit;
}


$valid_sections = ['initial', 'report', 'view', 'settings', 'users', 'logs', 'statistics'];
$current_section = isset($_GET['section']) && in_array($_GET['section'], $valid_sections) 
    ? $_GET['section'] 
    : 'initial';


$section_file = "../../sections/{$current_section}.php";
if(file_exists($section_file)) {
    ob_start();
    include $section_file;
    $section_content = ob_get_clean();
} else {
    $section_content = "<p>Section not found</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/project/css/global.css">
    <link rel="stylesheet" href="/project/css/Dashboard/style.css">
    <title>Dashboard - <?= ucfirst($current_section) ?></title>
    <style>
        .header__signout_icon {
            width: 16px;
            height: 16px;
        }
        .primary_button {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }
        .sectionContainer {
            width: 100%;
            height: 100%;
            padding: 20px;
        }
        .sidebar-nav li.active {
            background-color: var(--primary);
        }
        .sidebar-nav li.active a {
            color: var(--tertiary);
            font-weight: bold;
        }
        .sidebar-nav a {
            display: block;
            padding: 10px;
            color: var(--secondary);
            text-decoration: none;
        }
        .sidebar-nav a:hover {
            background-color: var(--primary-light);
        }
    </style>
</head>
<body>
    <?php require_once('../../templates/header.php'); ?>
    
    <div class="dashboardContainer">
        <?php require_once('../../templates/sidebar.php'); ?>
        
        <article class="sectionContainer">        
            <?= $section_content ?>
        </article>
    </div>
</body>
</html>