<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../classes/controller/LogController.php';
require_once __DIR__ . '/../config/db_connection.php';

// Log visit
$logController = new LogController($mysqli);
$logController->trackVisit();

// get all accesses per page (query already have filtered/grouped the data)
$accesses_per_page_raw = $logController->getAccessesPerPage();
$accesses_per_page = array_filter($accesses_per_page_raw, function ($access) {
    $page = strtolower($access['page_name']);
    return !str_contains($page, 'success') && 
           !str_contains($page, 'submit');
});

// Prepare data in an array to display in the chart.js
$access_chart_data = [];
foreach ($accesses_per_page as $access) {
    array_push($access_chart_data, ['page_name' => formatPageName($access['page_name']), 'percentage' => $access['access_percentage']]);
}
$labels = array_column($access_chart_data, 'page_name');
$values = array_column($access_chart_data, 'percentage');


// Get info about how many visits the website had in the last 14 days
$lastDays = 7;
$visits = $logController->getVisualizationStats($lastDays);
$dates = array_column($visits, 'access_date');
$totals = array_column($visits, 'total_access'); 

/** Format the page name */
function formatPageName($page_name){
    if (str_contains($page_name, '-')) {
        $temp = explode('-', $page_name);
        return ucfirst($temp[1]);
    } else if(str_contains(strtolower($page_name), 'index')) {
        return 'Login';
    } else if(str_contains(strtolower($page_name), 'initial')){
        return 'Dashboard';
    } 
    else if (str_contains($page_name, '.php')) {
        $temp = explode(".", $page_name);
        return ucfirst($temp[0]);
    } 
    else {
        return "Error";
    }
}

?>
<style>
    /** STYLE FOR PARENTS */
    .statistics_parent_container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        grid-template-rows: repeat(4, 1fr);
        grid-column-gap: 0px;
        grid-row-gap: 0px;
        height: 100%;
        box-sizing: border-box;
        background-color: white;
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        padding: 15px;
        border-radius: 7px;
        row-gap: 15px;
        column-gap: 15px;
    }

    .statistics_info_background {
        background-color: rgb(240, 240, 240);
        border-radius: 7px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        padding: .5rem;
    }

    .statistics_accesses_table_container {
        grid-area: 1 / 1 / 3 / 4;
    }

    .statistics_accesses_chart_container {
        grid-area: 1 / 4 / 3 / 6;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    
    .statistics_access_per_page_chart{
        max-width: 200px;
        max-height: 200px;
        width: 100%;
        height: 100%;
    }

    .statistics_total_access_container {
        grid-area: 3 / 1 / 5 / 3;
        
    }

    .statistics_total_access_chart_container {
        grid-area: 3 / 3 / 5 / 6;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    /** TABLE STYLING */
    table {
        border-collapse: collapse;
        width: 98%;
        margin: 20px auto;
    }

    th,
    td {
        padding: 5px;
        text-align: left;
    }

    tr:nth-child(odd) {
        background-color:#fff;
    }

    tr:nth-child(even) {
        background-color: #eaeaea;
    }

    th {
        background-color: var(--primary);
    }

    h1,
    p {
        margin-left: 10px;
    }

    /** Line chart */
    #statistics_accesses_chart {
    max-width: 44rem;
    max-height: 22rem;
    width: 100%;
    height: auto;
}

@media (max-width: 80rem) {
    .lastAccessColumn {
        display: none;
    }
}

</style>
<article class="statistics_parent_container">
    <div class="statistics_accesses_chart_container statistics_info_background">
        <canvas id="statistics_access_per_page_chart" width="300" height="300"></canvas>
    </div>
    <div class="statistics_accesses_table_container statistics_info_background">
        <h1>Accesses per Page</h1>
        <p>What are the pages most visited in the whole website.</p>
        <table>
            <tr>
                <th>Page Name</th>
                <th style="text-align: center;">Number of Accesses</th>
                <th class="lastAccessColumn">Last Access at</th>
                <th style="text-align: center;">Access %</th>
            </tr>
            <?php foreach ($accesses_per_page as $access): ?>
                <tr>
                    <td><?= formatPageName($access['page_name']) ?? 'error' ?></td>
                    <td style="text-align: center;"><?= $access['num_occurrences'] ?? 'error' ?></td>
                    <td class="lastAccessColumn"><?= $access['last_access'] ?? 'error' ?></td>
                    <td style="text-align: center;"><?= $access['access_percentage'] ?? 'error' ?>%</td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="statistics_total_access_container statistics_info_background">
        <h1>
            Accesses in last <?= $lastDays ?> days
        </h1>
        <table>
            <tr>
                <th>Access Date</th>
                <th style="text-align: center;">Total Visits</th>
            </tr>
            <?php foreach (array_reverse($visits) as $visit): ?>
                <tr>
                    <td><?= $visit['access_date'] ?? 'error' ?></td>
                    <td style="text-align: center;"><?= $visit['total_access'] ?? 'error' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
    <div class="statistics_total_access_chart_container statistics_info_background">
    <h1>
        Access in last <?= $lastDays ?> days
    </h1>
      <canvas id="statistics_accesses_chart"></canvas>
    </div>
    </div>

</article>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script to plot the pie chart, using chart.js -->
<script>
    const ctx = document.getElementById('statistics_access_per_page_chart').getContext('2d');

    const data = {
        labels: <?= json_encode($labels) ?>,
        datasets: [{
            data: <?= json_encode($values) ?>,
            borderWidth: 1
        }]
    };

    const config = {
        type: 'pie',
        maintainAspectRatio: false,
        responsive: true,
        data: data,
        options: {
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    };

    new Chart(ctx, config);
    // console.log("Labels:", <?= json_encode($labels) ?>);
    // console.log("Values:", <?= json_encode($values) ?>);
</script>

<!-- Script to plot the line chart, using chart.js -->
<script>
    const lineCtx = document.getElementById("statistics_accesses_chart").getContext('2d');

    const lineChartData = {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
            label: 'Total Accesses',
            data: <?= json_encode($totals) ?>,
            borderColor:'rgb(190, 183, 164, 1)',
            backgroundColor: 'rgba(190, 183, 164, 0.2)',
            tension: 0.3,
            fill: true,
            pointRadius: 3
    }]};

    const lineChartConfig = {
    type: 'line',
    data: lineChartData,
    options: {
        responsive: true,
        scales: {
            x: {
                title: { display: true, text: 'Date' }
            },
            y: {
                title: { display: true, text: 'Accesses' },
                beginAtZero: true
            }
        }
    }
    }

    new Chart(lineCtx, lineChartConfig);
</script>