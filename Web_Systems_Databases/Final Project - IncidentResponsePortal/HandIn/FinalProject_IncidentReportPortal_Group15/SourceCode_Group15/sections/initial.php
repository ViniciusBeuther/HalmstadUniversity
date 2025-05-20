<?php
    session_start();

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    require_once __DIR__ . '/../classes/controller/LogController.php';
    require_once __DIR__ . '/../config/db_connection.php';

    $logController = new LogController($mysqli);
    $logController->trackVisit();

	// Chart 1: Reports Per Day
	$reportsPerDay = [];
	$sql = "SELECT DATE(incident_date) AS report_date, COUNT(incident_report_id) AS count 
			FROM Incident_Reported 
			GROUP BY DATE(incident_date) 
			ORDER BY report_date ASC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$reportsPerDay[] = $row;
	}

    // Chart 2: Resolved/User;role 1 or 3
	$resolvedReports = [];
	$sql = "SELECT Portal_Users.username, COUNT(*) AS count
			FROM Incident_Solved
			JOIN Portal_Users ON Incident_Solved.solver_id = Portal_Users.user_id
			GROUP BY Portal_Users.username
			ORDER BY count DESC";
	$result = $mysqli->query($sql);
	while ($row = $result->fetch_assoc()) {
		$resolvedReports[] = $row;
	}

    // Chart 3: Total distribution
	$pieData = [];
	$sql = "SELECT incident_status_id, COUNT(*) as count 
			FROM Incident_Reported 
			GROUP BY incident_status_id";
		$result = $mysqli->query($sql);
    while ($row = $result->fetch_assoc()) {
        $pieData[(int)$row['incident_status_id']] = (int)$row['count'];
    }
	
		$statusLabels = [
		1 => 'Reported',
		2 => 'In Progress',
		3 => 'Resolved'
	];
?>

<head>
    <link rel="shortcut icon" href="/assets/sidebar_stats_icon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../css/Dashboard/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        @import url('../css/global.css');
        .dashboardElementsContainer {
            height: 100%;
        }
        .dashboard__info_container {
            display: flex;
            justify-content: center;
            padding-left: 15px;
            align-items: start;
            flex-direction: column;
            gap: 5px;
        }
        p.dashboard__h1 {
            font-size: large;
            text-align: left;
            color: #7b7b7b;
        }
        h1.dashboard__info {
            font-size: 2.75rem;
        }
        canvas {
            max-width: 100%;
            height: 300px;
        }
        @media (max-width: 80rem) {
            h1.dashboard__info {
                font-size: 2rem;
                }
        } 
        @media(max-width: 40rem){
            h1.dashboard__info{
                font-size: 1.5rem;
            }
        }

    </style>
</head>

<article class="dashboardElementsContainer">
    <section class="dashboardElement_01 dashboard__info_container">
        <p class="dashboard__h1">Incidents Reported</p>
        <h1 class="dashboard__info">
        <?php
            $sql = "SELECT COUNT(*) as total FROM Incident_Reported";
            $result = $mysqli->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo $row['total'];
            } else {
                echo "Error: 404" . $mysqli->error;
            }
        ?>
        </h1>
    </section>

    <section class="dashboardElement_02 dashboard__info_container">
        <p class="dashboard__h1">Incidents in Progress</p>
        <h1 class="dashboard__info">
		<?php
            $sql = "SELECT COUNT(*) as total FROM Incident_Reported WHERE incident_status_id IN (2)";
            $result = $mysqli->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo $row['total'];
            } else {
                echo "Error: 404" . $mysqli->error;
            }
        ?>

        </h1>
    </section>

    <section class="dashboardElement_03 dashboard__info_container">
        <p class="dashboard__h1">Incidents Solved</p>
        <h1 class="dashboard__info">
        <?php
            $sql = "SELECT COUNT(*) as total FROM Incident_Reported WHERE incident_status_id IN (3)";
            $result = $mysqli->query($sql);
            if ($result) {
                $row = $result->fetch_assoc();
                echo $row['total'];
            } else {
                echo "Error: 404" . $mysqli->error;
            }
        ?>
        </h1>
    </section>

    <section class="dashboardElement_04 dashboard__info_container">
        <p class="dashboard__h1">Last Incident</p>
        <h1 class="dashboard__info">
        <?php
            $sql = "SELECT incident_date FROM Incident_Reported ORDER BY incident_date DESC LIMIT 1";
            $result = $mysqli->query($sql);
            if ($result && $result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $latestIncident = new DateTime($row['incident_date']);
                echo $latestIncident->format('F j, Y, g:i a');
            } else {
                echo "Error: 404" . $mysqli->error;
            }
        ?>
        </h1>
    </section>

    <section class="dashboardElement_05">
        <canvas id="chartIncidentsReported"></canvas>
    </section>

    <section class="dashboardElement_06">
        <canvas id="chartIncidentsResolved"></canvas>
    </section>

    <section class="dashboardElement_07">
        <canvas id="chartIncidentStatus"></canvas>
    </section>
</article>

<script>
    // Chart 1: Reports Per Day
    const chartReportsPerDay = {
        labels: <?php echo json_encode(array_column($reportsPerDay, 'report_date')); ?>,
        datasets: [{
            label: 'Incidents Reported per Day',
            data: <?php echo json_encode(array_column($reportsPerDay, 'count')); ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.6)'
        }]
    };

    new Chart(document.getElementById('chartIncidentsReported'), {
        type: 'bar',
        data: chartReportsPerDay,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Incidents Reported per Day'
                }
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Date'
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Incident Count'
                    },
                    beginAtZero: true
                }
            }
        }
    });

    // Chart 2: Resolved/User; role 1 or 3
    const resolvedReports = {
        labels: <?php echo json_encode(array_column($resolvedReports, 'username')); ?>,
        datasets: [{
            label: 'Incidents Resolved',
            data: <?php echo json_encode(array_column($resolvedReports, 'count')); ?>,
            backgroundColor: 'rgba(75, 192, 192, 0.6)'
        }]
    };

    new Chart(document.getElementById('chartIncidentsResolved'), {
        type: 'bar',
        data: resolvedReports,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Incidents Resolved per Responder'
                }
            }
        }
    });

    // Chart 3: Total distribution
    const statusLabels = {
        1: 'Reported',
        2: 'In Progress',
        3: 'Resolved'
    };

    const pieData = {
        labels: <?php echo json_encode(array_values(array_map(fn($k) => $statusLabels[$k] ?? "Status $k", array_keys($pieData)))); ?>,
        datasets: [{
            data: <?php echo json_encode(array_values($pieData)); ?>,
            backgroundColor: ['#ba2514', '#f2b211', '#23872a']
        }]
    };

    new Chart(document.getElementById('chartIncidentStatus'), {
        type: 'pie',
        data: pieData,
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: "Total Status Overview"
                }
            }
        }
    });
</script>