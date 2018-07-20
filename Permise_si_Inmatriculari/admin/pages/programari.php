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

        //vom prelua aici datede din search si vom compune un text sql care va cauta dupa toate criteriile
        $sql_command = "SELECT a.*, b.descriere_procedura FROM programari AS a, proceduri AS b WHERE a.id_procedura LIKE b.id_procedura"; // a. = programari, b. = proceduri

        //in paralel construim un link prin care sa trimitem toate variabilele pentru a genera pe alta pagina cautarea noastra
        $print_link = "printeaza_programari.php";
        $indexlink = 0; // arata a cata componenta adaug

        if(isset($_GET['submit_search'])) // a fost trimisa o cautare
        {
            // cautare dupa proceduri
            if(isset($_GET['proceduri_search']) && !empty($_GET['proceduri_search']))
            {
                $proceduri_search = validate_string($_GET['proceduri_search']);
                $sql_command .= " AND a.id_procedura LIKE '$proceduri_search'";
                $indexlink ++;
                if($indexlink != 1)
                    $print_link .= "&";
                else
                    $print_link .= "?";
                $print_link .= "proceduri_search=$proceduri_search";
            }

            //cautare dupa tip procedura
            if(isset($_GET['tip_proceduri_search']) && !empty($_GET['tip_proceduri_search']))
            {
                $tip_proceduri_search = validate_string($_GET['tip_proceduri_search']);
                $sql_command .= " AND a.tip_procedura LIKE '$tip_proceduri_search'";
                $indexlink ++;
                if($indexlink != 1)
                    $print_link .= "&";
                else
                    $print_link .= "?";
                $print_link .= "tip_proceduri_search=$tip_proceduri_search";
            }

            // cautare dupa data
            if(isset($_GET['date_search']) && !empty($_GET['date_search']))
            {
                $date_search = date("Y-m-d", strtotime(validate_string($_GET['date_search'])));
                $sql_command .= " AND a.data_programare LIKE '$date_search'";
                $indexlink ++;
                if($indexlink != 1)
                    $print_link .= "&";
                else
                    $print_link .= "?";
                $print_link .= "date_search=$date_search";
            }
            

            // cautare dupa nume, cod unic, serie de sasiu
            if(isset($_GET['text_search']) && !empty($_GET['text_search']))
            {
                $text_search = validate_string($_GET['text_search']);
                $sql_command .= " AND (a.nume_realizator LIKE '%$text_search%' OR a.cod_unic LIKE '$text_search' OR a.serie_sasiu LIKE '$text_search')";
                $indexlink ++;
                if($indexlink != 1)
                    $print_link .= "&";
                else
                    $print_link .= "?";
                $print_link .= "text_search=$text_search";
            }
        }
        $sql_command .= " ORDER BY data_programare ASC, ora_programare ASC, id_procedura ASC, nume_realizator ASC";
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
                        <h1 class="page-header">Vezi programări</h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="search-form">

                            <!-- vom insera un buton de Print care deschide o pagina noua de unde se poate printa pagina -->
                            <a href="<?php echo $print_link; ?>" class="btn btn-primary btn-md" target="_blank">Printează tabelul </a>

                            <form role="form" action="programari.php" method="get" class='unprintable'>

                                <!-- Cauta dupa procedura -->
                                <div class="form-group">
                                    <select class="form-control input-md" name="proceduri_search">
                                        <option value> -- cauta proceduri -- </option>
                                        <?php
                                            $sql = "SELECT * FROM `proceduri`";
                                            $query = mysqli_query($conn, $sql);
                                            while($procedura = mysqli_fetch_assoc($query))
                                            {
                                                echo "<option value='".$procedura['id_procedura']."'";
                                                if(isset($proceduri_search) && $proceduri_search == $procedura['id_procedura']) // daca a fost trimis un get il punem aici
                                                    echo "selected";
                                                echo ">".$procedura['descriere_procedura']."</option>";
                                            }
                                        ?>
                                    </select>
                                </div>

                                <!-- cauta dupa tipul procedurii -->
                                <div class="form-group">
                                    <select class="form-control input-md" name="tip_proceduri_search">
                                        <option value> -- cauta grup proceduri -- </option>
                                        <option value="1" <?php if(isset($tip_proceduri_search) && $tip_proceduri_search == 1) echo "selected"; ?>> Definitivă /Provizorie /Radiere /Duplicare </option>
                                        <option value="2" <?php if(isset($tip_proceduri_search) && $tip_proceduri_search == 2) echo "selected"; ?>> Preschimbare /Dosar </option>
                                    </select>
                                </div>

                                <!-- cauta dupa data programarii -->
                                <div class="form-group">
                                    <input type='date' class="form-control input-md" placeholder="Data programării" name="date_search">
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
                                            <th>Nume realizator</th>
                                            <th>Cod Unic</th>
                                            <?php
                                                //voi afisa coloana serie_sasiu doar atunci cand nu se cauta proceduri de tipul 2
                                                if(!(isset($tip_proceduri_search) && $tip_proceduri_search == 2))
                                                    echo "<th>Serie șasiu</th>";
                                            ?>
                                            <th>Tip persoană</th>
                                            <th>Procedură</th>
                                            <th>Dată programare</th>
                                            <th>Ora programare</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            //selectez toate programarile din tabela programari
                                            //$sql = "SELECT a.*, b.descriere_procedura FROM programari AS a, proceduri AS b WHERE a.id_procedura = b.id_procedura";
                                            $query = mysqli_query($conn, $sql_command);
                                            while($programare = mysqli_fetch_assoc($query))
                                            {
                                                //######################### sa sterg if-ul #################################
                                                if(!empty($programare['cheie_cryptare'])) // momentan cat construim site ul
                                                {
                                                    //decryptam elementele de uz personal
                                                    $key = $programare['cheie_cryptare'];
                                                    $programare['cod_unic'] = decrypt($programare['cod_unic'], $key);
                                                    $programare['serie_sasiu'] = decrypt($programare['serie_sasiu'], $key);
                                                }

                                                //afisam o inregistrare in tabel
                                                echo "
                                                <tr>
                                                    <td></td>
                                                    <td>".$programare['nume_realizator']."</td>
                                                    <td>".$programare['cod_unic']."</td>";

                                                //voi afisa coloana serie_sasiu doar atunci cand nu se cauta proceduri de tipul 2
                                                if(!(isset($tip_proceduri_search) && $tip_proceduri_search == 2))
                                                    echo "<td>".$programare['serie_sasiu']."</td>";

                                                echo"
                                                    <td>".$programare['tip_persoana']."</td>
                                                    <td>".$programare['descriere_procedura']."</td>
                                                    <td>".$programare['data_programare']."</td>
                                                    <td>".Mins_to_time($programare['ora_programare'])."</td>
                                                </tr>
                                                ";
                                            }
                                        ?>
                                    </tbody>
                                </table>
                                <!-- /.table-responsive -->
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
