<?php
session_start();


error_reporting(E_ALL);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require_once __DIR__ . '/../classes/controller/LogController.php';

require_once __DIR__ . '/../config/db_connection.php';

$logController = new LogController($mysqli);

$logController->trackVisit();

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="styles.css">
</head>
<body>

<div class="rep">

<div class="header">




<div class="report_div">



<h1 class="r1">Report an incident</h1>
<form action="/project/sections/submit.php" method="POST" enctype="multipart/form-data">

<div class="form-grid">






<div>
<label for="incidentType">Incident Type:</label><br>
<select id="incidentType" name="incidentType" required>
<option value="">Select type -</option>
<option value="1">Access Issue (Dashboard)</option>
<option value="2">Access Issue (Report)</option>
<option value="3">Access Issue (Incidents)</option>
<option value="4">Access Issue (Database)</option>
<option value="5">Database Issue (Missing Data)</option>
<option value="6">Database Issue (Corruption)</option>
<option value="7">Security Issue (Phishing)</option>
<option value="8">Security Issue (Data Breach)</option>
<option value="9">Security Issue (Malware)</option>
<option value="10">Security Issue (Denial-of-Service)</option>
</select>
</div>

<div>
<label for="severity">Severity:</label><br>
<select id="severity" name="severity" required>
<option value="">Select Severity -</option>
<option value="1">Low</option>
<option value="2">Medium</option>
<option value="3">High</option>
<option value="4">Critical</option>
</select>
</div>

<div>
<label for="description">Description:</label><br>
<textarea id="description" name="description" rows="5" required></textarea>
</div>

<div>
<label for="assets">Affected Assets:	(Hold Ctrl for multiple)</label><br>
<select id="assets" name="assets[]" multiple required size="6">
  <option value="1">Database</option>
  <option value="2">Server</option>
  <option value="3">Network</option>
  <option value="4">Application</option>
  <option value="5">Security</option>
  <option value="6">Hardware</option>
  <option value="7">Backup System</option>
  <option value="8">Software</option>
  <option value="9">User Interface</option>
  <option value="10">Cloud Infrastructure</option>
  <option value="11">Storage</option>
</select>

<br><br>



<label for="timestamp">Date and time:</label><br>
<input type="datetime-local" id="timestamp" name="timestamp" required>
</div>



<div class="evd">
  <label for="evidence">Attach files:</label><br>
<input type="file" id="evidence" name="evidence" style="background-color: white; color: black;">
</div>

</div>
<br>
<button type="submit" class="buttonR">Submit incident</button>
</form>
</div>

<img src="../../assets/report.jpg" class="repimg">
</div>
</div>

</body>
</html>

<style> 

.repimg {
  width: 35%;
  margin-left: 44%;
 position: fixed;
 margin-top: 105px;
  border-radius: 30px;
}
body {
  margin: 0;
  overflow-x: hidden;
}

.r1 {
  color: #333;
padding-top: 20px;
padding-bottom: 12px;

}










.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  max-width:800px;
  margin-left:0px;
  margin-right: 0px
}


.form-grid div {
display:flex;
flex-direction:column;
}

#assets {
  margin-bottom:-20px;
}






.evd {
 margin-top: -100px
}

.report_div {

display: block;
width: fit-content;
margin-left: 35px;

}





input,select, textarea {
  padding: 10px;
  border:1px solid #ccc;
  border-radius: 6px;
  font-size: 16px
  transition: border-color 0.2s, box-shadow 0.2s;
  width: 100%;
  box-sizing: border-box
}

input:focus, select:focus, textarea:focus {
  border-color:#beb7a4;
  box-shadow: 0 0 0 2px rgba(0,123,255,0.2);
  outline: none
}


@media (min-width: 1024px) {
.repimg {
max-width: 500px;
}
}


.buttonR {
  padding: 10px 20px;
  background-color:#beb7a4;
  color: rgb(22, 20, 20);
  font-size: 16px;
  border: none;
  border-radius: 6px;
  cursor:pointer;
  transition: background-color 0.3s;
  margin-left: auto;
  margin-left: auto;
  margin-right: auto;
  display: block;
  width: fit-content;
  margin-top: 10px;




}

button:hover {
  background-color: #3e3f3f;
  color: white;
}





.rep {
  width: 100%;
  background-color: #F0F0F0;
  border-radius: 20px;
  height: 600px;
}


</style>
