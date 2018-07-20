<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Permise și Înmatriculări</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template -->
  <link href="css/landing-page.min.css" rel="stylesheet">

  <!-- Database connection -->
  <?php
    include "database/connection.php";
    include "include/function_pack.php";
    include "include/formulare.php";
  ?>

</head>

<body>

  <!-- Navigation -->
  <?php
    include "include/components/main_nav.php";
  ?>

  <!-- formular -->
  <div class="main-container">
    <div class="centered-container">

      <!-- Modal Preschimbare permise + Dosare Examinare -->
      <div class="modal-header">
        <h4 class="modal-title">Dorești să faci o programare?</h4>
      </div>
      <div class="modal-body">
        <h5>Preschimbare permise/Dosar examinare</h5>
        <h6>Pasul 1: Completează câmpurile cu datele cerute!</h6>
        <?php
          //daca campurile nu au fost completate
          if(isset($ErrMessage))
            echo "<span class='text-danger'>$ErrMessage</span>";
        ?>
        <p>
          <button class="btn-xs btn-info" data-toggle="collapse" data-target="#info1">Informații</button>
          <div id="info1" class="collapse">
            Lorem ipsum dolor text....
          </div>
        </p>
        <form action="" method="post"> 
          <div class="form-group">
            <label for="nume_prenume">Nume prenume<span class="text-danger">*</span>:</label>
            <input type="text" class="form-control" id="nume_prenume" name="nume_prenume" placeholder="Nume Prenume" <?php if(isset($nume_prenume)) echo "value = '$nume_prenume'"; ?>>
          </div> 
          <div class="form-group">
            <label for="email">E-mail (pentru trimiterea fișei de programare):</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="E-mail" <?php if(isset($email)) echo"value = '$email'"; ?>>
          </div> 
          <div class="form-group">
            <label for="serie_CI">Număr C.I (ex. XT312134)<span class="text-danger">*</span>:
              <?php
                // in cazul in care campul nu a fost bine completat se va afisa un mesaj de eroare
                if(isset($cod_unic_Err))
                  echo "<br><span class='text-danger' >$cod_unic_Err</span>";
              ?>
            </label>
            <input type="text" class="form-control" id="serie_CI" name="serie_CI" placeholder="Serie C.I." 
              <?php 
                if(isset($cod_unic)) echo"value = '$cod_unic'";
              ?>
            >
          </div> 

          <!-- vom lua procedurile direct din baza de date si le vom aloca dinamic -->
          <?php

            //selectam din baza de date campurile care ne intereseaza
            $sql = "SELECT id_procedura, descriere_procedura FROM proceduri WHERE tip_procedura = '2'"; 
            // tip procedura 2 e asociat celor care nu necesita serie de sasiu

            //executam
            $query = mysqli_query($conn, $sql);

            $IndexProceduri = 0; // imi numara a cata prcedura o afisez pentru a afisa un if
            while($procedura = mysqli_fetch_assoc($query))
            {
              $IndexProceduri ++;
              echo "
                <div class='form-group'>
                  <label class='radio-inline'><input type='radio' name='rd_preschimbare' value='".$procedura['id_procedura']."'";
                      if(isset($rd_preschimbare) && $rd_preschimbare == $procedura['id_procedura']) 
                        echo "checked"; 
                      else if(!isset($rd_preschimbare) && $IndexProceduri == 1) 
                        echo "checked"; 
              echo "
                  >".$procedura['descriere_procedura']."</label>
                </div>
              ";
            }

          ?>

          <!-- Vom folosi comanda de Token::generate() pentru a creea un token care va verifica daca formularul apartine site ului nostru -->
          <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>

          <div class="form-group">
            <button type="submit" class="btn-primary btn-md" name="submit_permise">Pasul următor</button>
          </div> 
        </form>
      </div>
    </div>
  </div>




    <!-- Footer -->
    <?php
      include "include/components/footer.php";
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>
