<?php 
include_once('template.php'); 
if (isset($_POST['name'])) { 
  $query = <<<END
    INSERT INTO products(name, price, description)
    VALUES ('{$mysqli->real_escape_string($_POST['name'])}', '{$mysqli->real_escape_string($_POST['price'])}', '{$mysqli->real_escape_string($_POST['description'])}')
END;
$mysqli->query($query); 
echo 'Product added to the database!'; 
}
$content = <<<END
<h1>Add product</h1>
<form method="post" action="add_product.php">
    <input type="text" name="name" placeholder="Productname"><br>
    <input type="text" name="price" placeholder="Price"><br>
    <textarea name="description" placeholder="Description"></textarea><br>
    <input type="submit" value="Add product">
    <input type="reset" value="reset">
</form>
END;
echo $navigation; 
echo $content;
?>