<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/global.css">
    <link rel="stylesheet" href="../../css/Dashboard/style.css">
    <title>Dashboard</title>
    <style>

    </style>
</head>

<body>
    <?php 
        $header = <<<END
            <header class="header">
                <span>
                    <h1>Incident Report Portal</h1>
                </span>
                <article class="header__article">
                    <button class="primary_button">Sign out</button>
                    <p>{$_SESSION['username']}</p>
                    <img src="../../assets/user_profile_icon.svg" alt="user_profile_icon" class="header__profile_icon">
                </article>
            </header>
        END;
        echo $header;
    ?>

    <div class="dashboardContainer">
        <aside class="asideBar">
            <h2>Dashboard</h2>
            <p>Report Incident</p>
            <p>View Incident</p>
            <p>Settings</p>
            <p>Users Management</p>
        </aside>
        <article class="dashboardElementsContainer">
            <section class="dashboardElement_01">Chart 01</section>
            <section class="dashboardElement_02">Chart 02</section>
            <section class="dashboardElement_03">Information 03</section>
            <section class="dashboardElement_04">User data</section>
        </article>
    </div>
</body>

</html>