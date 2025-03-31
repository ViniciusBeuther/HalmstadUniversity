<!DOCTYPE html>
<hmtl>
  <head>
    <title>Webshop</title>
  </head>
  <body>
    <?php 
    include('template.php');
    $content = <<<END
      <h1>Welcome to this website! Hello World, PHP!</h1>
      <p>
        This is gonna be a webshop.
      </p>
  
      <form action="./send.php" method="post">
        <input type="text" name="name" placeholder="Name">
        <br>
        <input type="text" name="msg" placeholder="Message">
        <br>
        <input type="submit" value="Send">
      </form>
    END;
    Echo $navigation; 
    echo $content;
    ?>
  </body>
</hmtl>