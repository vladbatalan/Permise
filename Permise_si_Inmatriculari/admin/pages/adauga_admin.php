<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <?php
        include "../../database/connection.php";
        include "../../include/function_pack.php";
        Verify_admin_registration($conn); // verifica daca sesiunea pentru administrator este activata
        Special_admin_access(); // numai administratorul suprem poate accesa pagina asta
        include "../include/admin_forms.php";
    ?>

</head>

<body>

    <div id="wrapper">

         <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php
                include "../include/components/up_nav_bar.php";
                include "../include./components/side_nav_bar.php";

            ?>
        </nav>
        

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Adăugare Administrator</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <?php
                    //daca o operatie a fost realizata cu succes
                    if(isset($DoneMessage)){
                        echo "
                            <div class='alert alert-success'>
                                $DoneMessage
                            </div>
                        ";
                    }
                ?>
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading"></div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <form role="form" action="adauga_admin.php" method="post">
                                            <div class="form-group">
                                                <label>Username<span class="text-danger">*</span>:</label>
                                                <input class="form-control" name="username" placeholder="Username Administrator">
                                                <?php
                                                    //daca a aparut vreo eroare in legatura cu username ul
                                                    if(isset($ErrUsername)){
                                                        echo "
                                                            <p class='help-block'>
                                                                <span class='text-danger'>$ErrUsername</span>
                                                            </p>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Parolă<span class="text-danger">*</span>:</label>
                                                <input class="form-control" type="password" name="password1" placeholder="Parolă">
                                                <?php
                                                    //daca a aparut vreo eroare in legatura cu parola
                                                    if(isset($ErrPassword)){
                                                        echo "
                                                            <p class='help-block'>
                                                                <span class='text-danger'>$ErrPassword</span>
                                                            </p>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <label>Repetă parola<span class="text-danger">*</span>:</label>
                                                <input class="form-control" type="password" name="password2" placeholder="Repată parola">
                                                <?php
                                                    //daca a aparut vreo eroare in legatura cu parola
                                                    if(isset($ErrPassword)){
                                                        echo "
                                                            <p class='help-block'>
                                                                <span class='text-danger'>$ErrPassword</span>
                                                            </p>
                                                        ";
                                                    }
                                                ?>
                                            </div>
                                            <div class="form-group">
                                                <?php

                                                    // afisam captcha
                                                    echo "
                                                      Captcha<span class='text-danger'>*</span>:<br>
                                                      <image src='../../include/captcha/captcha_image.php' id='captcha_image'>
                                                      <img src='../../include/captcha/refresh.ico'
                                                         onclick='refresh()' 
                                                      style='width:40px; height:40px;' alt='Alt text'><br>
                                                      Introduce textul din imaginea captcha<span class='text-danger'>*</span>:<input type='text' class='form-control' name='captcha_value'>";

                                                    //daca nu s a completat Captcha corect
                                                    if(isset($ErrCaptcha)){
                                                        echo "
                                                            <p class='help-block'>
                                                                <span class='text-danger'>$ErrCaptcha</span>
                                                            </p>
                                                        ";
                                                    }

                                                    /*if(isset($_SESSION['captcha_response']))
                                                      echo "<script>alert('Captcha is here ".$_SESSION['captcha_response']."');</script>";
                                                    else
                                                      echo "<script>alert('Captcha offline!');</script>";*/

                                                ?>
                                            </div>

                                            <!-- Vom folosi comanda de Token::generate() pentru a creea un token care va verifica daca formularul apartine site ului nostru -->
                                            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>

                                            <button type="submit" class="btn btn-primary" name="new_admin_submit">Creează cont</button>
                                        </form>
                                    </div>
                                </div>
                                <!-- /.row -->

                            </div>
                            <!-- /.panel-body -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->


    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

     <script type = "text/javascript">

      // scriptul atasat pentru ca refresh sa functioneze
      function refresh()
      {
        document.getElementById('captcha_image').src = '../../include/captcha/captcha_image.php';
      }

    </script>

</body>

</html>
