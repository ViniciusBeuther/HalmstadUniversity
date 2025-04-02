<?php 
include_once('template.php'); 
if (isset($_GET['id']) and isset($_SESSION['userId'])) { 
$query = <<<END
DELETE FROM products
WHERE id = '{$_GET['id']}'
END; 
$mysqli->query($query); 
header('Location:products.php'); 
}
echo $navigation; 
?>