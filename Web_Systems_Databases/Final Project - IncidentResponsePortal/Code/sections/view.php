<?php

session_start();
error_reporting(E_ALL); ini_set('display_errors', 1);    ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../classes/controller/LogController.php';
require_once __DIR__ . '/../classes/controller/StatusController.php';
require_once __DIR__ . '/../classes/controller/PortalUserController.php';

require_once  __DIR__ . '/../config/db_connection.php';

$logController = new LogController($mysqli);    
$logController->trackVisit();

$portalUserController = new PortalUserController($mysqli);
$statusController = new StatusController($mysqli);


$role_id = $portalUserController->getPermission($_SESSION['username']);
$role = $portalUserController->getRoleName($role_id);
$statusAvailable = $statusController->getStatusTypes();

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="styles.css">


<style>
body {margin: 0; overflow-x:hidden;}

.rep {
width: 100%;
background-color: #F0F0F0;
border-radius:20px;
height: 85vh;
padding: 20px;
box-sizing:border-box;
overflow-y: auto;
}

.incident {
background-color: #fff;
border:1px solid #ddd;
padding: 15px;
margin-bottom:10px;
border-radius:10px;
display: flex;
justify-content: space-between;
box-sizing:border-box;
}

.incident:hover{
    cursor: pointer;
    scale: 1.005;
    transition-delay: .05s;
}

.incident .left,
.incident .right {
width: 45%;
padding:10px;
}

.incident h3 {
margin: 0;
color:#333;
}

.incident p {
margin: 5px 0;
}

.incident .incident-details {
margin-top:10px;
font-size: 14px;
}
</style>

</head>

<body>



<div class="rep">
    <div style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
        <label for="statusFilter">Filter by Status:</label>
        <select id="statusFilter" style="padding: 5px; border-radius: 5px; border: 1px solid #ddd;">
            <option value="all">All Statuses</option>
            <?php 
            foreach($statusAvailable as $status) {
                echo '<option value="'.htmlspecialchars($status['incident_status']).'">'.htmlspecialchars($status['incident_status']).'</option>';
            }
            ?>
        </select>
    </div>
<?php


$sql = "SELECT 
ir.incident_report_id,
ir.incident_date,
it.incident_name AS incident_type,
us.username AS reported_by,
istn.incident_status AS status,
sev.severity_name AS severity,
ir.description
FROM Incident_Reported ir
JOIN Incident_Type it ON ir.incident_type_id = it.incident_type_id
JOIN Portal_Users us ON ir.reported_by_id = us.user_id
JOIN Incident_Status istn ON ir.incident_status_id = istn.incident_status_id
JOIN Severity sev ON ir.severity_id = sev.severity_id
 ORDER BY ir.incident_report_id DESC";

$sqlReporter = "
SELECT 
    ir.incident_report_id,
    ir.incident_date,
    it.incident_name AS incident_type,
    us.username AS reported_by,
    istn.incident_status AS status,
    sev.severity_name AS severity,
    ir.description
FROM Incident_Reported ir
JOIN Incident_Type it ON ir.incident_type_id = it.incident_type_id
JOIN Portal_Users us ON ir.reported_by_id = us.user_id
JOIN Incident_Status istn ON ir.incident_status_id = istn.incident_status_id
JOIN Severity sev ON ir.severity_id = sev.severity_id
WHERE us.user_id = '" . $_SESSION['user_id'] . "' ORDER BY ir.incident_report_id DESC;";

if(str_contains(strtolower($role), 'administrator') || str_contains(strtolower($role), 'responder')){
    $result = $mysqli->query($sql);
} else {
    $result = $mysqli->query($sqlReporter);
}


if ($result->num_rows > 0) {
    
while($row = $result->fetch_assoc()) {
$incidentId = $row["incident_report_id"];

echo '<div class="incident" onclick="openModal(`' . addslashes($row["description"]) . '`, `' . $incidentId . '`)">';

echo '<div class="left">';

echo '<h3>Incident ID: ' . $row["incident_report_id"] . '</h3>';
echo '<p><strong>Incident Type:</strong> ' . $row["incident_type"] . '</p>';

echo '<p><strong>Reported By:</strong> ' . $row["reported_by"] . '</p>';

echo '<p><strong>Incident Date:</strong> ' . $row["incident_date"] . '</p>';

echo '<p><strong>Status:</strong> ' . $row["status"] . '</p>';

echo '</div>';

echo '<div class="right">';
echo '<p><strong>Severity:</strong> ' . $row["severity"] . '</p>';

echo '<p><strong>Description:</strong> ' . nl2br($row["description"]) . '</p>';


echo '</div>';

echo '</div>';
}

} else {
echo '<p>No incidents found.</p>';
}

?>

</div>


<!-- VINICIUS -->
<style>
    @import url('../css/global.css');
    #incidentModal{
        display:none; 
        position:fixed; 
        top:0; 
        left:0; 
        width:100%; 
        height:100%; 
        background:rgba(0,0,0,0.6); 
        z-index:1000; 
        justify-content:center; 
        align-items:center;
    }

    #incidentModalContainer{
        background:#fff; 
        padding:20px; 
        border-radius:10px; 
        max-width:600px; 
        width:90%; 
        position:relative;
    }

    #commentBox{
        width:100%; 
        height:100px; 
        margin-top:15px;
    }

    #submitCommentBtn{
        margin-top:10px; 
        padding:8px 16px;
    }

    #modalCloseBtn{
        position:absolute; 
        top:10px; 
        right:15px; 
        cursor:pointer; 
        font-size:18px;
    }

    .commentCard{
        padding: 10px 15px;
        background-color: #F0F0F0;
        border-radius: 7px;
        margin-top: 15px;
        box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    }

    #incidentDescriptionContainer{
        background-color: white;
    }

    .incident-details {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin: 20px auto;
        max-width: 600px;
        color: #333;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

    .incident-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
        color: #2c3e50;
        text-align: center;
    }

    .incident-info p {
        margin: 5px 0;
        font-size: 0.95rem;
    }

    .incident-description {
        margin-top: 15px;
        font-style: italic;
        color: #555;
    }

    .incident-evidence {
        margin-top: 20px;
        max-width: 100%;
        border-radius: 8px;
        border: 1px solid #ddd;
    }
    
    #submitCommentBtn, #updateStatusBtn{
        background-color: var(--primary);
        border-radius: 7px;
        outline: none;
        border: none;
        margin-bottom: 3px;
    }
    #submitCommentBtn:hover, #updateStatusBtn:hover{
        background-color: var(--primary_hover);
        cursor: pointer;
    }

    #commentBox{
        border: solid 1px gray;
        border-radius: 7px;
        width: 98%;
        padding: 5px;
        background-color: white;
    }
    #statusFilter {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: white;
}

#applyFilter {
    background-color: var(--primary);
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
}

#applyFilter:hover {
    background-color: var(--primary_hover);
}

#updateStatusBtn{
    padding: 10px 15px;
}

</style>
<div id="incidentModal">
    <div id="incidentModalContainer">
        <div id="incidentDescriptionContainer"></div>
        <div id="statusUpdateContainer" style="margin-top: 20px;">
    <?php if(str_contains(strtolower($role), 'administrator') || str_contains(strtolower($role), 'responder')): ?>
        <form id="changeStatusForm">
            <label for="statusSelect">Change Status:</label>
            <select id="statusSelect" style="padding: 5px; margin-right: 10px;"></select>
            <button id="updateStatusBtn" type="submit">Update</button>
        </form>
    <?php endif; ?>

    </div>
    <span onclick="closeModal()" id="modalCloseBtn">&times;</span>

    <form id="submitCommentForm">
        <input type="hidden" name="incident_id" id="incidentIdField">
        <textarea id="commentBox" placeholder="Add your comment..."></textarea>
        <button type="submit" id="submitCommentBtn">Submit comment</button>
    </form>

    <div id="commentsContainer"></div>
  </div>
</div>
</body>


<!-- VINICIUS - Filter -->
 <script>
    document.getElementById('statusFilter').addEventListener('change', filterIncidents);

function filterIncidents() {
    const selectedStatus = document.getElementById('statusFilter').value;
    const incidents = document.querySelectorAll('.incident');

    incidents.forEach(incident => {
        const strongElements = incident.querySelectorAll('p strong');
        let statusText = '';

        strongElements.forEach(strong => {
            if (strong.textContent.trim() === 'Status:') {
                const statusElement = strong.parentNode;
                statusText = statusElement.textContent.replace('Status:', '').trim();
            }
        });

        if (selectedStatus === 'all' || statusText === selectedStatus) {
            incident.style.display = 'flex';
        } else {
            incident.style.display = 'none';
        }
    });
}

 </script>

<!-- VINICIUS - Handle modal / display incident info -->
<script>
function openModal(description, incidentId) {
    document.getElementById('incidentIdField').value = incidentId;
    document.getElementById('incidentModal').style.display = 'flex';
    presentIncidentInfo(incidentId);
    
    const commentsDiv = document.getElementById('commentsContainer');
    commentsDiv.innerHTML = '<p>Loading comments...<p>';

    fetch('/project/functions/getComments.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'incident_id=' + encodeURIComponent(incidentId)
    })
    .then((res) => res.json())
    .then(data => {
        commentsDiv.innerHTML = '';

        if(data.length >= 1){
            data.forEach((comment) => {
                const p = document.createElement('p');
                const article = document.createElement('article');
                const h4 = document.createElement('h4');
                const roleName = document.createElement('p');

                h4.textContent = comment.username;
                roleName.textContent = `(${comment.role_name}): ${comment.comment_date }`;

                article.className = 'commentCard';
                roleName.style.color = '#303030';
                roleName.style.fontWeight = 'light';
                roleName.style.fontSize = '12px';
                roleName.style.marginBottom = '7px';

                p.textContent = `${comment.comments}`;

                article.append(h4, roleName, p);
                commentsDiv.appendChild(article);
                commentsDiv.style.overflowY = 'scroll';
                commentsDiv.style.maxHeight = '300px';

                console.log(comment);
            });
        } else {
            commentsDiv.innerHTML = '<p>No comments found.<p>'
        }

    })
    .catch(error => {
        commentsDiv.innerHTML = '<p>Error loading comments...</p>';
        console.log(error);
    })
}

function closeModal() {
    document.getElementById('incidentModal').style.display = 'none';
}

function presentIncidentInfo(incidentId){
    const descriptionContainer = document.getElementById('incidentDescriptionContainer');
    descriptionContainer.innerHTML = '';

    fetch('/project/functions/getIncidentInfo.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'incident_id=' + encodeURIComponent(incidentId)
    })
    .then((res) => res.json())
    .then((data) => {
        const article = document.createElement('article');
        article.className = 'incident-details shadow';

        const title = document.createElement('h2');
        title.textContent = `Incident #${data.incident.incident_report_id}`;
        title.className = 'incident-title';

        const infoContainer = document.createElement('div');
        infoContainer.className = 'incident-info';

        const infoFields = [
        { label: 'Reported by', value: data.incident.username },
        { label: 'Reported date', value: data.incident.incident_date },
        { label: 'Category', value: data.incident.incident_name },
        { label: 'Status', value: data.incident.incident_status },
        { label: 'Severity', value: data.incident.severity_name },
        ];

        infoFields.forEach(({ label, value }) => {
        const p = document.createElement('p');
        p.innerHTML = `<strong>${label}:</strong> ${value}`;
        infoContainer.appendChild(p);
        });

        const description = document.createElement('p');
        description.innerHTML = `<strong>Description:</strong> ${data.incident.description || 'No description.'}`;
        description.className = 'incident-description';

        const evidence = document.createElement('img');
        evidence.src = `/project/uploads/${data.incident.file_path || ""}`;
        evidence.alt = 'Evidence';
        evidence.className = 'incident-evidence';

        let affectedAssets = document.createElement('p');
        affectedAssets.innerHTML = '<strong>Affected Assets: </strong>'
        data.affected_assets.forEach(asset => {
            affectedAssets.innerHTML += `<br>&nbsp;&nbsp;${asset.affected_asset_name}`;
            console.log(asset.affected_asset_name)
        })
        

        article.append(title, infoContainer, affectedAssets, description, evidence);
        descriptionContainer.appendChild(article);

    })
    .catch((error) => console.log('Error: ', error));

}
</script>

<!-- VINICIUS - Handle comment Insertion -->
 <script>
    document.getElementById('submitCommentForm').addEventListener('submit', e => {
    e.preventDefault();

    const incidentId = document.getElementById('incidentIdField').value;
    const comment = document.getElementById('commentBox').value;
    const authorId = <?= $_SESSION['user_id']; ?>;

    if (!comment.trim()) {
        alert('Please enter a comment');
        return;
    }

    fetch('/project/functions/submitComment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `incident_id=${encodeURIComponent(incidentId)}&author_id=${encodeURIComponent(authorId)}&comment=${encodeURIComponent(comment)}`
    })
    .then(res => res.json())
    .then(data => {
            alert(data.message);
            document.getElementById('commentBox').value = '';
            openModal('', incidentId); 
    })
    .catch(err => {
        console.error('Error submitting comment:', err);
        alert('Failed to submit comment. Please try again.');
    });
});
 </script>

<!-- VINICIUS - Handle incident status change/ input -->
 <script>
    const statusSelector = document.getElementById('statusSelect');
    const statusAvailable = <?= json_encode($statusAvailable) ?>;

    statusAvailable.forEach(row => {
        let option = document.createElement('option');
        option.value = row.incident_status_id;
        option.textContent = row.incident_status;
        statusSelector.appendChild(option);        
    });

    document.getElementById('changeStatusForm').addEventListener('submit', e => {
        e.preventDefault();
        const incidentId = document.getElementById('incidentIdField').value;
        const select = document.getElementById('statusSelect');
        const updatedStatusId = select.value;
        const authorId = <?= $_SESSION['user_id']; ?>;

        
        fetch('/project/functions/updateIncidentStatus.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `incident_id=${encodeURIComponent(incidentId)}&author_id=${encodeURIComponent(authorId)}&updated_status_id=${encodeURIComponent(updatedStatusId)}`
        })
        .then(res => res.json())
        .then(data => {
                alert('Successfully updated the status for this incident.')
                presentIncidentInfo(incidentId);
        })
        .catch(err => {
            alert('Error updating the status.');
            console.error('Error updating status:', err);
        });
    });
 </script>
</html>
