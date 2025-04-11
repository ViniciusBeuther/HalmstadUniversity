<head>
    <link rel="stylesheet" href="../css/Dashboard/style.css">

    <style>
        @import url('../css/global.css');
        .dashboardElementsContainer{
            height: 100%;
        }
        .dashboard__info_container{
            display: flex;
            justify-content: center;
            padding-left: 15px;
            align-items: start;
            flex-direction: column;
            gap: 5px;
        }

        p.dashboard__h1{
            font-size: large;
            text-align: left;
            color:#7b7b7b;
        }
        h1.dashboard__info{
            font-size: 2.75rem;
        }

    </style>
</head>

<article class="dashboardElementsContainer">
    <section class="dashboardElement_01 dashboard__info_container">
        <p class="dashboard__h1">Incidents Reported</p>
        <h1 class="dashboard__info">1000</h1>
    </section>
    <section class="dashboardElement_02 dashboard__info_container">
        <p class="dashboard__h1">Incidents Solved</p>
        <h1 class="dashboard__info">750</h1>    
    </section>
    <section class="dashboardElement_03 dashboard__info_container">
        <p class="dashboard__h1">Incidents Pending</p>
        <h1 class="dashboard__info">250</h1>    
    </section>
    <section class="dashboardElement_04 dashboard__info_container">
        <p class="dashboard__h1">Last Incident</p>
        <h1 class="dashboard__info">10:00:00</h1>    
    </section>
    <section class="dashboardElement_05">User data 5</section>
    <section class="dashboardElement_06">User data 6</section>
    <section class="dashboardElement_07">User data 7</section>
</article>