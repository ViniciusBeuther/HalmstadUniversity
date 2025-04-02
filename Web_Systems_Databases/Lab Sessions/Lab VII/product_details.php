<?php 
include_once('template.php'); 
$content = '<h1>Product Details</h1>'; 
if (isset($_GET['id'])) { 
$query = <<<END
SELECT * FROM products
WHERE id = '{$_GET['id']}' 
END; 
$res = $mysqli->query($query) or die("Could not query database" . $mysqli->errno . " : " . $mysqli->error); 
if ($res->num_rows > 0) { 
$row     
= $res->fetch_object(); 
$content = <<<END
Product id: {$row->id}<br>
Title: {$row->name}<br>
Price: {$row->price}<br>
Description: {$row->description}<br>
Date: {$row->created_at}
END; 
} 
} 
echo $navigation; 
echo $content; 
?> 