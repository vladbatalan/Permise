<!-- Navigation -->
  <nav class="navbar navbar-dark bg-dark static-top">
    <div class="container">
      <a class="navbar-brand" href="index.php">Permise și înmatriculări</a>
      <?php

      	$href = "admin/pages/login.php";
      	$text = "Loghează-te ca Administrator";
      	if(isset($_SESSION['admin'])) // daca este deja logat un admin
      		// il trimitem pe pagina principala de la dashboard
      	{
      		$href = "admin/index.php";
      		$text = "Dashboard";
      	}
      	echo "<a class='btn btn-primary btn-sm' href='$href'>$text</a>";
      ?>
      
    </div>
  </nav>