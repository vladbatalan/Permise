<?php


	//##############################################################################################################################
	//######### formularul de pe formular_inmatriculari.php pentru rezervare imnatriculare/radiere/duplicat/placute pierdute #######
	//##############################################################################################################################
	if(isset($_POST['submit_inmatriculare']))
	{
		$IsOKForInsert = 1;

		//vom valida stringurile primite prin intermediul POST cu functia validate_string
		$tip_persoana = validate_string($_POST['tip_persoana']);
		$nume_prenume = validate_string($_POST['nume_prenume']);
		$cod_unic = strtoupper(validate_string($_POST['serie_CI']));
		$email = validate_string($_POST['email']);
		$serie_sasiu = validate_string($_POST['serie_sasiu']);
		$rd_inmatriculare = validate_string($_POST['rd_inmatriculare']);

		//verificam daca campurile cerute nu sunt goale
		if(!empty($_POST['nume_prenume']) && !empty($_POST["serie_CI"]) && !empty($_POST["serie_sasiu"]))
		{
			
			//aplicam upper case la codul unic
			$cod_unic = strtoupper($cod_unic);

			//verificare data

			// validarea codului unic -> persoana fizica
			if($tip_persoana == "fizica" && !CI_code_validation($cod_unic))
			{
				$IsOKForInsert = 0;
				$cod_unic_Err = "Formatul seriei de buletin nu este bun! Incercați [numele seriei, ex: XT][numar serie, ex:123123] fara spații libere";

			}

			// validarea codului unic -> persoana juridica
			if($tip_persoana == "juridica" && !CUI_validation($cod_unic))
			{
				$IsOKForInsert = 0;
				$cod_unic_Err = "Formatul CUI al firmei nu este bun! Incercați [cod țară, ex: RO][numar CUI, ex:18996892] fara spații libere";
			}

			//selectam tipul procedurii
			$sql = "SELECT id_procedura, timp_procedura, tip_procedura FROM proceduri WHERE id_procedura = '".$rd_inmatriculare."'";
			$query = mysqli_query($conn, $sql);
			$info_procedura = mysqli_fetch_assoc($query);

			//daca este procedeu pentru inmatriculare/radiere etc, seria de sasiu trebuie sa fie unica
			//daca este procedeu care necesita serie de sasiu, verifica sa nu existe aceeasi serie de sasiu in baza de date
			$sql = "SELECT serie_sasiu FROM programari WHERE serie_sasiu = '".$serie_sasiu."' AND tip_procedura = '1'";
			$query = mysqli_query($conn, $sql);
			if(mysqli_num_rows($query) > 0)
			{
				//inseamna ca deja exista in baza de date o programare cu seria de sasiu data
				$IsOKForInsert = 0;
				$ErrMessage  = "Exista deja in baza de date o programare pentru această serie de șasiu! Pentru a o viziona, <a href='index.php'>accesați pagina principală</a>";
			}

			//Este vorba de un csrf? 
			if(!Token::check($_POST['token']))
			{
				$IsOKForInsert = 0;
				$ErrMessage = "Eroare! Va rugam completati din nou formularul!";
			}

			if($IsOKForInsert)
			{
				//initializez un SESSION pentru a putea trece informatiile date de post prin intermediul redirectului
				$_SESSION['date_programare']=array(
					"nume_prenume"=>$nume_prenume, 
					"tip_persoana"=>$tip_persoana, 
					"cod_unic"=>$cod_unic,
					"email"=>$email,
					"serie_sasiu"=>$serie_sasiu,
					"procedura"=>$rd_inmatriculare

				);
				//vom transfera utilizatorul la pasul al doilea
				header("location: formular_pasul2.php");
				/*
				$sql = "INSERT INTO `programari` (`id_programare`, `tip_persoana`, `nume_realizator`, `cod_unic`, `email_realizator`, `serie_sasiu`, `data_programare`, `ora_programare`, `id_pocedura`) VALUES (NULL, '$tip_persoana', 'asda', '$nume_prenume', 'asda', 'asda', '2018-05-11', '12321', '1');";
				$query = mysqli_query($conn, $sql);

				$DoneMessage = "Programarea a fost realizata cu succes!";
				*/
			}
		}
		
		//daca nu, vom afisa mesaj de eroare
		else
		{
			$ErrMessage .= "Toate campurile obligatorii trebuie completate!<br>";
		}
	}






	//########################################################################################################################
	//##### formularul de pe formular_permise.php pentru rezervare Preschimbare permise/ Dosar examinare #####################
	//########################################################################################################################

	if(isset($_POST['submit_permise']))
	{
		$IsOKForInsert = 1;

		//vom valida stringurile primite prin intermediul POST cu functia validate_string
		$tip_persoana = "fizica";
		$nume_prenume = validate_string($_POST['nume_prenume']);
		$cod_unic = strtoupper(validate_string($_POST['serie_CI']));
		$email = validate_string($_POST['email']);
		$rd_preschimbare = validate_string($_POST['rd_preschimbare']);

		//verificam daca campurile cerute nu sunt goale
		if(!empty($_POST['nume_prenume']) && !empty($_POST["serie_CI"]))
		{

			//aplicam upper case la codul unic
			$cod_unic = strtoupper($cod_unic);

			// validarea codului unic -> persoana fizica
			if(!CI_code_validation($cod_unic))
			{
				$IsOKForInsert = 0;
				$cod_unic_Err = "Formatul seriei de buletin nu este bun! Incercați [numele seriei, ex: XT][numar serie, ex:123123] fara spații libere";
			}

			//verificare pentru existenta unei persoane cu un CI care deja exista 
			//selectam tipul procedurii
			$sql = "SELECT id_procedura, timp_procedura, tip_procedura FROM proceduri WHERE id_procedura = '".$rd_preschimbare."'";
			$query = mysqli_query($conn, $sql);
			$info_procedura = mysqli_fetch_assoc($query);

			//daca este procedeu pentru obtinere permis/ dosar examinare, CI trebuie sa fie unic

			$sql = "SELECT cod_unic FROM programari WHERE cod_unic = '".$cod_unic."' AND tip_procedura = '".$info_procedura['tip_procedura']."'";
			$query = mysqli_query($conn, $sql);

			if(mysqli_num_rows($query) > 0)
			{
				//inseamna ca deja exista in baza de date o programare cu codul unic dat
				$IsOKForInsert = 0;
				$ErrMessage  = "Exista deja in baza de date o programare pentru această serie a cardului de identitate! Pentru a o viziona, <a href='index.php'>accesați pagina principală</a>";
			}

			//Este vorba de un csrf? 
			if(!Token::check($_POST['token']))
			{
				$IsOKForInsert = 0;
				$ErrMessage = "Eroare! Va rugam completati din nou formularul!";
			}


			if($IsOKForInsert)
			{	
				//initializez un SESSION pentru a putea trece informatiile date de post prin intermediul redirectului
				$_SESSION['date_programare']=array(
					"nume_prenume"=>$nume_prenume, 
					"tip_persoana"=>$tip_persoana, 
					"cod_unic"=>$cod_unic,
					"email"=>$email,
					"procedura"=>$rd_preschimbare
				);
				//vom transfera utilizatorul la pasul al doilea
				header("location: formular_pasul2.php");
				/*
				$sql = "INSERT INTO `programari` (`id_programare`, `tip_persoana`, `nume_realizator`, `cod_unic`, `email_realizator`, `serie_sasiu`, `data_programare`, `ora_programare`, `id_pocedura`) VALUES (NULL, '$tip_persoana', 'asda', '$nume_prenume', 'asda', 'asda', '2018-05-11', '12321', '1');";
				$query = mysqli_query($conn, $sql);

				$DoneMessage = "Programarea a fost realizata cu succes!";
				*/
			}
		}
		
		//daca nu, vom afisa mesaj de eroare
		else
		{
			$ErrMessage = "Toate campurile obligatorii trebuie completate!<br>";
		}
	}



	//####################################################################################################################
	//####### formular_pasul2.php testeaza data primita si ora si captcha si daca sunt bune realizeaza programarea #######
	//####################################################################################################################

	if(isset($_POST['submit_pasul2']))
	{
		$IsOKForInsert = 1;

		//vom valida stringurile primite prin intermediul POST cu functia validate_string
		$tip_persoana = "fizica";
		if (isset($_POST['tip_persoana'])) {
			$tip_persoana = validate_string($_POST['tip_persoana']);
		}
		$nume_prenume = validate_string($_SESSION['date_programare']['nume_prenume']);
		$cod_unic = strtoupper(validate_string($_SESSION['date_programare']['cod_unic']));
		$email = validate_string($_SESSION['date_programare']['email']);
		$procedura = validate_string($_SESSION['date_programare']['procedura']);
		if(isset($_SESSION['date_programare']['serie_sasiu']))
			$serie_sasiu = validate_string($_SESSION['date_programare']['serie_sasiu']);
		else
			$serie_sasiu = "";
		$captcha_value = validate_string($_POST["captcha_value"]);
		if(isset($_POST['calendar'])){
			$data_programare = validate_string($_POST['calendar']);
		}

		//verificam daca campurile cerute nu sunt goale
		if(isset($data_programare) && !empty($data_programare) && !empty($captcha_value))
		{

			//verificam potrivirea captcha
			if(strtoupper($captcha_value) !== strtoupper($_SESSION['captcha_response']))
			{
				$ErrCaptcha = "Codul Captcha nu a fost completat corect!";
				$IsOKForInsert = 0;
			}

			//Este vorba de un csrf? 
			if(!Token::check($_POST['token']))
			{
				$IsOKForInsert = 0;
				$ErrMessage = "Eroare! Va rugam completati din nou formularul!";
			}

			if($IsOKForInsert)
			{	

				//selectam procedura pentru a i afla tipul programarii
				$sql = "SELECT tip_procedura FROM proceduri WHERE id_procedura = '".$procedura."'";
				$query = mysqli_query($conn, $sql);
				$tip_procedura = mysqli_fetch_assoc($query);

				//vom calcula inca data ora de la care se va realiza programarea

				// verificam daca exista ziua respectivă in program, in caz contrar o dezactivam
                $sql = "SELECT * FROM program_zilnic WHERE indice_zi = '".date("w", strtotime($data_programare))."' AND tip_procedura = '".$tip_procedura['tip_procedura']."'";
                $query = mysqli_query($conn, $sql);

                if(mysqli_num_rows($query) != 0) // am mai verificat odata asta deci nu are rost sa vad si cazul cu 0
                {
                	//am gasit, verific daca mai este timp de o programare aici
                        //initializez variabile necesare
               	    $program_astazi = mysqli_fetch_assoc($query);
               	    $de_la_ora = $program_astazi['de_la_ora'];
               	    $pana_la_ora = $program_astazi['pana_la_ora'];

                        //selectam programarea din data respectiva cu timpul de programare cel mai mare daca exista

                    $sql = "SELECT `ora_programare`, `id_procedura` FROM `programari` WHERE `data_programare` = '".date("Y-m-d", strtotime($data_programare))."' AND `tip_procedura` = '".$tip_procedura['tip_procedura']."'";
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
                    }
                    else{
                      $timp_max_procedura = array("timp_procedura" => 0);
                    }
                           
                    //upgradam $de_la_ora
                    $de_la_ora = $max_time['ora_programare'] + $timp_max_procedura['timp_procedura'];
                    //am mai calculat odata daca se poate programa in intervalul orar de functionare in ziua respectiva
                }

                //creem o cheie de cryptare si vom crypta datele de uz personal
                $key = KeyGenerator();
                $cod_unic = encrypt($cod_unic, $key);
                $serie_sasiu = encrypt($serie_sasiu, $key);

                //adaugam in baza de date
				$sql = "INSERT INTO `programari` (`id_programare`, `tip_persoana`, `nume_realizator`, `cod_unic`, `email_realizator`, `serie_sasiu`, `data_programare`, `ora_programare`, `tip_procedura`, `id_procedura`, `cheie_cryptare`) VALUES (NULL, '$tip_persoana', '$nume_prenume', '$cod_unic', '$email', '$serie_sasiu', '".date("Y-m-d",strtotime($data_programare))."', '$de_la_ora', '".$tip_procedura['tip_procedura']."', '$procedura', '$key');";

				$query = mysqli_query($conn, $sql);

				$DoneMessage = "Programarea a fost realizata.";

			}
		}
		
		//daca nu, vom afisa mesaj de eroare
		else
		{
			$ErrMessage = "Toate campurile obligatorii trebuie completate, inclusiv să alegeți data progrămarii";
		}

	}



?>