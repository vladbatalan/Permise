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

    <!-- DataTables CSS -->
    <link href="../vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="../vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <style>
        .search-form a{
            margin-bottom: 10px;
        }
        .search-form input[type="text"], .search-form input[type="date"], .search-form select{
            width: 200px;
            float: left;
            margin-right: 10px;
            margin-bottom: 10px;
        }
        .clear{
            clear: both;
        }

    </style>

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
                <div class="row unprintable">
                    <div class="col-lg-12">
                        <h1 class="page-header">Vezi administratori</h1>
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
                        <div class="search-form">

                            <form role="form" action="lista_admini.php" method="get">

                                <!-- Cauta dupa procedura -->
                                <div class="form-group">
                                    <select class="form-control input-md" name="role_search">
                                        <option value> -- cauta după rol -- </option>
                                        <?php
                                            $sql = "SELECT * FROM `rol_administrator`";
                                            $query = mysqli_query($conn, $sql);
                                            while($rol = mysqli_fetch_assoc($query))
                                            {
                                                echo "<option value='".$rol['id_rol']."'";
                                                if(isset($proceduri_search) && $proceduri_search == $procedura['id_procedura']) // daca a fost trimis un get il punem aici
                                                    echo "selected";
                                                echo ">".$rol['rol_admin']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!-- buton de submit -->
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="submit_search" value="Caută">
                                </div>

                                <!-- Cauta dupa anumite cuvinte -->
                                <div class="form-group">
                                    <input class="form-control input-md" placeholder="Caută" name="text_search" <?php if(isset($text_search)) echo "value='$text_search'"; ?>>
                                </div>

                            </form>
                        </div>
                        <div class="clear"></div>
                        <form role="form" action="lista_admini.php" method="post">

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    Tabel programări
                                </div>
                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Username admin</th>
                                                <th>Nivel de acces</th>
                                                <th>Vezi activitate</th>
                                                <th>Șterge</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                //selectez toti administratorii
                                                $sql = "SELECT a.id_admin, a.username_admin, a.id_rol, b.rol_admin FROM administratori AS a, rol_administrator AS b WHERE a.id_rol = b.id_rol";
                                                $query = mysqli_query($conn, $sql);
                                                while($admin = mysqli_fetch_assoc($query))
                                                {

                                                    //afisam o inregistrare in tabel
                                                    echo "
                                                    <tr>
                                                        <td></td>
                                                        <td>".$admin['username_admin']."</td>
                                                        <td>";

                                                    //daca adminul este unul cu rol suprem nu i putem schimba datele
                                                    //doar adminul suprem poate schimba date
                                                    if($admin['rol_admin'] != 'suprem' || $_SESSION['admin']['rol_admin'] != "suprem")
                                                    {
                                                        //facem un select de unde putem schimba rolul daca e nevoie
                                                        echo "
                                                            <select class='form-control input-sm' name='change_role_".$admin['id_admin']."'>
                                                                <option value='".$admin['id_rol']."'>".$admin['rol_admin']."</option>";

                                                            //afisam optiuni pentru schimbarea rolului de administrator
                                                            $sql2 = "SELECT * FROM rol_administrator WHERE id_rol NOT LIKE '".$admin['id_rol']."'";
                                                            $response = mysqli_query($conn, $sql2);
                                                            while($rol = mysqli_fetch_assoc($response))
                                                            {
                                                                echo "<option value='".$rol['id_rol']."'>".$rol['rol_admin']."</option>";
                                                            }
                                                        echo "</select>";
                                                    }
                                                    else
                                                    {
                                                        //este admin suprem, afisam normal rolul lui fara posibilitate de schimbare
                                                        echo $admin['rol_admin'];
                                                    }

                                                    //activitatea va declansa un modulo care va afisa acrivitatea recenta a administratorului
                                                    echo "        
                                                        </td>
                                                        <td><a href='#' class='btn btn-sm btn-default'> Activitate </a></td>
                                                        <td>";

                                                    //ii putem sterge doar daca sunt admini supremi
                                                    if($admin['rol_admin'] != 'suprem')
                                                        echo "<input type='checkbox' name='delete_admin".$admin['id_admin']."'>";

                                                    echo 
                                                        "
                                                        </td>
                                                    </tr>";
                                                }
                                            ?>

                                        </tbody>
                                    </table>
                                    <!-- /.table-responsive -->
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary" name="modifica_admini">Produce modificări</button>
                                    </div>
                                </div>
                                <!-- /.panel-body -->
                            </form>
                            <!-- /.form -->
                        </div>
                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>
    


    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

     <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true, 
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]], 
            searching: false, 
            //paging: false
        });
    });
    </script>

</body>

</html>
