<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator</title>

     <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        html, body, head{
            margin: 0px;
            padding: 0px;
        }
        table{
            font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
            font-size: 13px;
            border-collapse: collapse;
            width: 100%;
        }
        td, tr, th{
            border: 1px solid #e6e6e6;
            padding: 7px;
        }
        button{
            padding: 5px;
            padding-left: 10px;
            padding-right: 10px;
            margin-bottom: 5px;
        }

        @media print{
            button{
                display: none;
            }
        }

    </style>

    <?php
        include "../../database/connection.php";
        include "../../include/function_pack.php";
        Verify_admin_registration($conn); // verifica daca sesiunea pentru administrator este activata

        //vom prelua aici datede din search si vom compune un text sql care va cauta dupa toate criteriile
        $sql_command = "SELECT a.*, b.descriere_procedura FROM programari AS a, proceduri AS b WHERE a.id_procedura LIKE b.id_procedura"; // a. = programari, b. = proceduri


        // cautare dupa proceduri
        if(isset($_GET['proceduri_search']) && !empty($_GET['proceduri_search']))
        {
            $proceduri_search = validate_string($_GET['proceduri_search']);
            $sql_command .= " AND a.id_procedura LIKE '$proceduri_search'";
        }

        //cautare dupa tip procedura
        if(isset($_GET['tip_proceduri_search']) && !empty($_GET['tip_proceduri_search']))
        {
            $tip_proceduri_search = validate_string($_GET['tip_proceduri_search']);
            $sql_command .= " AND a.tip_procedura LIKE '$tip_proceduri_search'";
        }

        // cautare dupa data
        if(isset($_GET['date_search']) && !empty($_GET['date_search']))
        {
            $date_search = date("Y-m-d", strtotime(validate_string($_GET['date_search'])));
            $sql_command .= " AND a.data_programare LIKE '$date_search'";
        }
        

        // cautare dupa nume, cod unic, serie de sasiu
        if(isset($_GET['text_search']) && !empty($_GET['text_search']))
        {
            $text_search = validate_string($_GET['text_search']);
            $sql_command .= " AND (a.nume_realizator LIKE '%$text_search%' OR a.cod_unic LIKE '$text_search' OR a.serie_sasiu LIKE '$text_search')";
        }
        $sql_command .= " ORDER BY data_programare ASC, ora_programare ASC, id_procedura ASC, nume_realizator ASC";
    ?>

</head>

<body>
    <button onclick="window.print();">Printează tabelul</button>
    <table table>
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
                $index = 0; // numerotează randurile
                while($programare = mysqli_fetch_assoc($query))
                {
                    $index ++;
                    //afisam o inregistrare in tabel
                    echo "
                    <tr>
                        <td>$index.</td>
                        <td>".$programare['nume_realizator']."</td>
                        <td>".decrypt($programare['cod_unic'], $programare['cheie_cryptare'])."</td>";

                        //voi afisa coloana serie_sasiu doar atunci cand nu se cauta proceduri de tipul 2
                        if(!(isset($tip_proceduri_search) && $tip_proceduri_search == 2))
                            echo "<td>".decrypt($programare['serie_sasiu'], $programare['cheie_cryptare'])."</td>";

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

</body>

</html>