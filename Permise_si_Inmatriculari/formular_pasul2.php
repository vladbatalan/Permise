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
    Verify_POST_SESSION_formular_pasul2(); // functia verifica daca variabilele tip session au fost trimise, in caz contrar redirectioneaza la index.php
  ?>
</head>

<body>

  <!-- Navigation -->
  <?php
    include "include/components/main_nav.php";
  ?>

  <!-- formular -->
  <div class="main-container">
    <?php
      // daca a fost introdusa inregistrarea in baza de date afiseaza mesajul de terminare
      if(isset($DoneMessage))
      {
        echo "
          <div class='alert alert-success'>
            <strong>Success!</strong> $DoneMessage
          </div>
          <div class='empty-container'></div>
        ";
      }
    ?>
    <div class="centered-container">
      <div class="modal-header">
        <h4 class="modal-title">Dorești să faci o programare?</h4>
      </div>
      <div class="modal-body">
        <?php

          //metoda de securitate
          $_SESSION['date_programare']['procedura'] = validate_string($_SESSION['date_programare']['procedura']);

          //selectam procedura pe care o avem din baza de date
          $sql = "SELECT id_procedura, descriere_procedura, timp_procedura, tip_procedura FROM proceduri WHERE id_procedura = '".$_SESSION['date_programare']['procedura']."'";
          //executam
          $query = mysqli_query($conn, $sql);
          //atasam procedura de variabila $procedura_value
          $procedura_value = mysqli_fetch_assoc($query);
          //in functie de procedura se va afisa text


          //afisam titlul
          echo "<h5>".$procedura_value['descriere_procedura']."</h5>";

        ?>
        <h6>Pasul 2: Fixeaza data cand doresti sa faci rezervarea!</h6>
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

        <p>Data in care se realizează rezervarea<span class="text-danger">*</span>:</p>

        <!-- un meniu care contine tab uri care directioneaza la cate un tabel cu fiecare luna -->
        <?php
           $today = date("Y-m-d");//fixez in today data actuala

          //initializam un vector care precizeaza numele luniilor
          $MonthNames = array("Ianuarie", "Februarie", "Martie", "Aprilie", "Mai", "Iunie", "Iulie", "August", "Septembrie", "Octombrie", "Noiembrie", "Decembrie");
          
          // meniu tip tab care afiseaza 3 luni pe care le poti vizualiza pe calendar
          echo "
          <div class='tab-style'>
            <ul class='nav nav-tabs'>
              <li class='active'><a data-toggle='tab' href='#menu1'>".$MonthNames[intval(date("m"))-1]."</a></li>
              ";

          //afisam si restul luniilor prin intermediul unui for
          for($index = 1; $index <= 4; $index++)
          {
            echo "<li><a data-toggle='tab' href='#menu".($index + 1)."'>".$MonthNames[intval(Add_k_Months($today,"m",+$index))-1]."</a></li>";
          }

          echo "
            </ul>
          </div>";
        ?>

        <form action="formular_pasul2.php" method="post">

          <div class="tab-content">
          <!-- Tabel in care putem alege direct data in care vrem sa facem rezervare -->
            
                <?php

                  //vom genera datele disponibile pentru urmatoarele 3 luni
                  //setam punctul de start pe care il ducem in prima zi a lunii curente
                  $MonthStart = date("Y-m-d", strtotime($today));

                  // setam o data pe care o ducem cu un while pana in prima zi
                  $StartDate = date("Y-m-d", strtotime($MonthStart)); 
                  while(Get_Month($StartDate) === Get_Month($MonthStart))
                  {
                    $StartDate = Add_k_Days($StartDate, "Y-m-d", -1);
                  }
                  $MonthStart = Add_k_Days($StartDate, "Y-m-d", 1);

                  //fixam data cand sa se termine 
                  $MonthEnd = Add_k_Months($MonthStart, "Y-m-d", 5);
                  $MonthEnd = Add_k_Days($MonthEnd, "Y-m-d", -1);

                  // pnetru fiecare luna din acest interval, vom afisa calendar
                  for($CurrentMonth = date("Y-m-d", strtotime($MonthStart)), $MonthIndex = 1; $CurrentMonth < $MonthEnd; $CurrentMonth = Add_k_Months($CurrentMonth,"Y-m-d", 1), $MonthIndex++)
                  {
                    // $MonthIndex o folosesc pentru a imi arata a cata luna sunt, pentru a denumi meniurile
                    // afisam numele lunii
                    echo "
                      <div id='menu$MonthIndex' class='tab-pane fade'>
                        <div class='table-responsive'>
                        <table class='table table-bordered date-table'>
                        <tr>
                          <th colspan=7> ".($MonthNames[intval(date("m", strtotime($CurrentMonth)))-1])." 
                          </th>
                        </tr>";

                    echo "
                        <tr>  
                          <th>Du</th>
                          <th>Lu</th>
                          <th>Ma</th>
                          <th>Mi</th>
                          <th>Jo</th>
                          <th>Vi</th>
                          <th>Sa</th>
                        </tr>
                      "
                    ;

                    //generam zilele din calendar in functie de prima zi unde se afla
                    $CurrentWeekDay = date("w", strtotime($CurrentMonth));
                    $CurrentIndexDate = date("Y-m-d", strtotime($CurrentMonth));
                    $IndexDay = 0; //index day tine pasul si pune <tr> si </tr> cand se termina un rand

                    for($i = 0; $i < $CurrentWeekDay; $i++) // mergem pana la prima aparitie a zilei de 1 din luna current month
                    {
                      echo "<td></td>";
                      $IndexDay ++;
                    }

                    // cat timp inca sunt in aceeasi luna, scrie date
                    while(Get_Month($CurrentIndexDate) == Get_Month($CurrentMonth))
                    {
                      
                      if($IndexDay == 7) //daca am ajuns la capatul saptamanii
                      {
                        $IndexDay = 0;
                        echo "</tr><tr>";
                      }

                      $avanable_state = ""; // memoreaza daca trebuie pus clasa not-avanable-date
                      $de_la_ora = 0; //notam de la ora cu o valoare default
                      
                     
                      // verificam daca exista ziua respectivă in program, in caz contrar o dezactivam
                      $sql = "SELECT * FROM program_zilnic WHERE indice_zi = '".$IndexDay."' AND tip_procedura = '".$procedura_value['tip_procedura']."'";
                      $query = mysqli_query($conn, $sql);

                      if(mysqli_num_rows($query) == 0) //nu am gasit ziua
                        $avanable_state = "class='not-avanable-date'";
                      else
                      {
                        //am gasit, verific daca mai este timp de o programare aici
                        //initializez variabile necesare
                        $program_astazi = mysqli_fetch_assoc($query);
                        $de_la_ora = $program_astazi['de_la_ora'];
                        $pana_la_ora = $program_astazi['pana_la_ora'];

                        //selectam programarea din data respectiva cu timpul de programare cel mai mare daca exista

                        $sql = "SELECT `ora_programare`, `id_procedura` FROM `programari` WHERE `data_programare` = '".date("Y-m-d", strtotime($CurrentIndexDate))."' AND `tip_procedura` = '".$procedura_value['tip_procedura']."'";
                        $query = mysqli_query($conn, $sql);  

                        //setez $max_time ca fiind elementul gasit cu cel mai mare timp
                        $max_time = array(); 
                        $max_time['ora_programare'] = $de_la_ora;
                        //caut manual elementul pt ca m am complicat cu MAX(ora_programare) si mi a facut 2 ore fite, si asa ma grabesc ca am maine deadline si csf
                        while($row = mysqli_fetch_assoc($query))
                        {
                          if($row['ora_programare'] >= $max_time['ora_programare'])
                          {
                            $max_time['ora_programare'] = $row['ora_programare'];
                            $max_time['id_procedura'] = $row['id_procedura'];
                          }
                        }

                        //daca exista programare
                        if(isset($max_time['id_procedura'])) 
                        // daca am gasit cel putin o programare ii voi cauta data de terminare
                        //adaug la ora maxima timpul terminarii procedurii
                        {
                          $sql = "SELECT timp_procedura FROM proceduri WHERE id_procedura = '".$max_time['id_procedura']."'";
                          $query = mysqli_query($conn, $sql);
                          $timp_max_procedura = mysqli_fetch_assoc($query);
                          //echo "<script>alert('data: ".$CurrentIndexDate."; de la ora: ".$timp_max_procedura['timp_procedura']."');</script>";
                        }
                        else{
                          $timp_max_procedura = array("timp_procedura" => 0);
                        }
                          
                        //upgradam $de_la_ora
                        $de_la_ora = $max_time['ora_programare'] + $timp_max_procedura['timp_procedura'];

                        //calculam daca pote fi incadrata in interval timpul realizarii procedurii
                        if($de_la_ora + $procedura_value['timp_procedura'] > $pana_la_ora)
                        {
                          //echo "<script>alert('Gasit inregistrare! Data: $CurrentIndexDate');</script>";
                          //nu se poate incadra, deci anulam rezervarea
                          $avanable_state = "class='not-avanable-date'";
                        }
                      }

                      //daca este o data mai devreme de ziua de astazi, nu luam in considerare
                      if($CurrentIndexDate < $today)
                      {
                        //nu se mai poate face rezervare
                        $avanable_state = "class='not-avanable-date'";
                      }

                      //daca este o sarbatoare nu se vor face programari in ziua respectiva
                      $sql = "SELECT * FROM sarbatori_legale WHERE data_sarbatoare = '".date("Y-m-d", strtotime($CurrentIndexDate))."'";
                      $query = mysqli_query($conn, $sql);
                      //daca am gasit o data in baza de date, atunci nu se vor mai face programari
                      if(mysqli_num_rows($query) > 0)
                        $avanable_state = "class='not-avanable-date'";
                      
                      //valoarea returnata de catre radio va avea atat data programarii, cat si ora la care se face aceasta in formatul:
                      // [data programarii]#[ora programarii] 
                      echo "
                        <td $avanable_state>
                          ".date("d", strtotime($CurrentIndexDate))."
                          <br>
                          <input type='radio' name='calendar' value='".date("Y-m-d", strtotime($CurrentIndexDate))."' onchange='Change_Hour(\"$CurrentIndexDate\", \"".Mins_to_time($de_la_ora)."\");'>
                        </td>";
                      
                      $CurrentIndexDate = Add_k_Days($CurrentIndexDate, "Y-m-d", 1);
                      $IndexDay++;
                    }

                    // umplem tabelul cu restul zilelor care lipsesc
                    while($IndexDay < 7)
                    {
                      echo "<td></td>";
                      $IndexDay ++;
                    }
                    echo "
                              </tr>
                            </div>
                          </table>
                        </div>
                      </div>
                    ";
                  }
                ?>
            </div>

            <br>
            <div class="form-group">
              <p id="ora_aleasa"><span class="text-danger font-weight-bold">Selectați o dată pentru a se alege ora...</span></p>
            </div>

            <div class="form-group">
              <p> Apăsați pe butonul terminat pentru a confirma programarea pentru următoarele date: </p>
                <?php

                  // vom stabili textele afisate in cazul in care persoana este fizica
                  if($_SESSION['date_programare']['tip_persoana'] == "fizica")
                  {
                    $label_nume_prenume = "Numele si prenumele"; 
                    $label_cod_unic = "Seria C.I.";
                  }
                  // vom stabili textele afisate in cazul in care persoana este juridica
                  else
                  {
                    $label_nume_prenume = "Denumirea societății";
                    $label_cod_unic = "Seria C.U.I.";
                  }

                  //afisam pe site datele programarii pentru a fi inspectate inca odata de catre utilizator
                  echo "
                  <div class='well well-sm'>
                    <p> Nume procedură: <b> ".$procedura_value['descriere_procedura']." </b></p>
                    <p> $label_nume_prenume: <i>". validate_string($_SESSION['date_programare']['nume_prenume']) ."</i></p>
                    <p> $label_cod_unic: <i>". validate_string($_SESSION['date_programare']['cod_unic']) ."</i></p>
                    <p> E-mail: <i>". validate_string($_SESSION['date_programare']['email']) ."</i></p>
                  ";

                  if(isset($_SESSION['date_programare']['serie_sasiu']))
                  {
                    echo "<p>Serie șasiu: <i>".$_SESSION['date_programare']['serie_sasiu']."</i></p>";
                  }

                ?>
              </div>
            </div>

            <div class="form-group">
              <?php
                //daca nu a fost codul captcha completat corect
                if(isset($ErrCaptcha))
                {
                  //afisam eroare
                  echo "<span class='text-danger'>$ErrCaptcha</span><br>";
                }

                // afisam captcha
                echo "
                  Captcha<span class='text-danger'>*</span>:<br>
                  <image src='include/captcha/captcha_image.php' id='captcha_image'>
                  <img src='include/captcha/refresh.ico'
                     onclick='refresh()' 
                  style='width:40px; height:40px;' alt='Alt text'><br>
                  Introduce textul din imaginea captcha<span class='text-danger'>*</span>:<input type='text' class='form-control' name='captcha_value'><br>";

                /*if(isset($_SESSION['captcha_response']))
                  echo "<script>alert('Captcha is here ".$_SESSION['captcha_response']."');</script>";
                else
                  echo "<script>alert('Captcha offline!');</script>";*/


                // daca a fost realizat deja formularul, vom desfiinta $_SESSION['date_programare']
                if(isset($DoneMessage) && isset($_SESSION['date_programare']))
                  unset($_SESSION['date_programare']);
              ?>
            </div>

            <!-- Vom folosi comanda de Token::generate() pentru a creea un token care va verifica daca formularul apartine site ului nostru -->
            <input type='hidden' name='token' value='<?php echo Token::generate(); ?>'>

            <div class="form-group">
              <button type="submit" class="btn-primary btn-md" name="submit_pasul2">Terminat</button>
            </div>


          </form>
          </div>
      </div>
    </div>

    <script type = "text/javascript">
      // functia afiseaza ora in functie de ziua aleasa
      function Change_Hour(data, ora)
      {
        var Hour = document.getElementById("ora_aleasa");
        Hour.innerHTML = "Ora la care trebuie să veniți pentru data de " + data + " este <b> "+ ora +" </b>";
      }
      
      // scriptul atasat pentru ca refresh sa functioneze
      function refresh()
      {
        document.getElementById('captcha_image').src = 'include/captcha/captcha_image.php';
      }

    </script>

    <!-- Footer -->
    <?php
      include "include/components/footer.php";
    ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

  </html>
