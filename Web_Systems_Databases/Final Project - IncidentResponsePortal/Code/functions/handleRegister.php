<?php 
$onSubmit = <<<END
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("login__register_form").addEventListener("submit", function(event) {
      event.preventDefault(); // Impede o redirecionamento
      alert('Submitted'); // Exibe o alerta
    });
  });
</script>
END;
?>