<?php 
// This is a code to display the error if it exists.
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//

include('template.php');
if (isset($_POST)) {
  $content = <<<END
  <h3>Message was sent: </h3>
      Name: {$_POST["name"]}
      <br>
      Message: {$_POST["msg"]}
      <br>
  END;
}
echo $navigation;
echo $content;
?>
{/* these statements below are equivalent */}
<?php 
  $name = "vinicius";
?>

<?= $name ?>