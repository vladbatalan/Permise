<?php

	//Formular pentru adauga_admin.php la adaugarea unui nou administrator
	if(isset($_POST['new_admin_submit']))
	{
		if(isset($_POST['username']) && isset($_POST['password1']) && isset($_POST['password2']) && isset($_POST['captcha_value']))
		{
			$IsOkToInsert = 1;

			//setam variabile sigure
			$username = validate_string($_POST['username']);
			$password1 = validate_string($_POST['password1']);
			$password2 = validate_string($_POST['password2']);

			//verificam daca exista un admin cu acelasi username
			$sql = "SELECT * FROM administratori WHERE username_admin = '$username'";
			$query = mysqli_query($conn, $sql);
			if(mysqli_num_rows($query))
			{
				$IsOkToInsert = 0;
				$ErrUsername = "Există deja un administrator cu acest nume!";
			}

			//verificam daca cele doua parole corespund
			if($password1 !== $password2)
			{
				$IsOkToInsert = 0;
				$ErrPassword = "Cele doua parole nu corespund!";
			}

			//verificam daca parola este destul de puternica
			else
			{
				$Err_number = 0; // imi arata cate erori sunt

				//daca parola nu este destul de mare
				if(strlen($password1) < 6)
				{
					$IsOkToInsert = 0;
					$Err_number ++;
					if($Err_number == 1) $ErrPassword = "Parola nu este destul de puternică:";
					$ErrPassword .= "<li>Parola nu este destul de mare! (min. 6 caractere)</li>";
				}

				//daca nu contine cel putin un numar
				if(1 !== preg_match('~[0-9]~', $password1))
				{
					$IsOkToInsert = 0;
					$Err_number ++;
					if($Err_number == 1) $ErrPassword = "Parola nu este destul de puternică:";
					$ErrPassword .= "<li>Trebuie să conțină cel puțin un număr!</li>";
				}

				//daca nu contine cel putin o litera mare
				if(1 !== preg_match('~[A-Z]~', $password1))
				{
					$IsOkToInsert = 0;
					$Err_number ++;
					if($Err_number == 1) $ErrPassword = "Parola nu este destul de puternică:";
					$ErrPassword .= "<li>Trebuie să conțină cel puțin o litera mare!</li>";
				}
			}

			//verificam daca captcha a fost bine completata
			if(strtoupper($_POST['captcha_value']) != $_SESSION['captcha_response'])
			{
				$IsOkToInsert = 0;
				$ErrCaptcha = "Codul Captcha nu a fost completat corect!";
			}

			//verificam daca nu se incearca un csrf
			if(!Token::check($_POST['token']))
			{
				$IsOkToInsert = 0;
			}

			//daca canmpurile nu sunt goale
			if(empty($username) || empty($password1) || empty($password2) || empty($_POST['captcha_value']))
			{
				$IsOkToInsert = 0;
				$ErrPassword = "Toate campurile trebuie completate!";
				$ErrUsername = "Toate campurile trebuie completate!";
				$ErrCaptcha = "Toate campurile trebuie completate!";
			}

			//daca totul este ok
			if($IsOkToInsert)
			{
				//pregatim cheia pentru criptarea parolei
				$salt = KeyGenerator();
				$password = hashword($password1, $salt);

				//rolul administratorului va fi cel de vizitator
				$sql = "SELECT id_rol FROM rol_administrator WHERE rol_admin = 'vizitator'";
				$query = mysqli_query($conn, $sql);
				$rol = mysqli_fetch_assoc($query);
				$id_rol = $rol['id_rol'];

				//introducem noul administrator in baza de date
				$sql = "INSERT INTO `administratori` (`id_admin`, `username_admin`, `parola_admin`, `id_rol`, `salt_parola`) VALUES (NULL, '$username', '$password', '$id_rol', '$salt')";
				$query = mysqli_query($conn, $sql);

				//mesaj care se afisaza cand s a realizat inregistrarea
				$DoneMessage = "Contul de administrator a fost înregistrat cu succes!";

			}

		}
	}

	//Formular pentru lista_admini.php pentru stergerea de admini sau modificarea rolului acestora
	if(isset($_POST['modifica_admini']))
	{
		//vom trece prin toti adminii din pagina si vom verifica daca s a produs vreo modificare in drepul acestuia si daca da, o vom trata ca atare
		//################################ sistem de verificare Email pentru a confirma schimbarile facute ##########################
		$sql = "SELECT a.*, b.rol_admin FROM administratori AS a, rol_administrator AS b WHERE a.id_rol = b.id_rol";
		$query = mysqli_query($conn, $sql);
		while($admin = mysqli_fetch_assoc($query))
		{
			// verificam daca s a produs o schimbare de rol
			// setam stringul campului
			$role_changed = "change_role_".$admin["id_admin"];
			if(isset($_POST[$role_changed]) && $_POST[$role_changed] != $admin["id_rol"]) //daca apare o schimbare
			{
				$sql = "UPDATE `administratori` SET `id_rol` = '".$_POST[$role_changed]."' WHERE `id_admin` = '".$admin['id_admin']."'";
				$sql_result = mysqli_query($conn, $sql);
				$DoneMessage = "Modificările au fost realizate cu succes!";
			}

			// verificam daca se va sterge vreun administrator
			// setam stringul campului
			$deleted_admin = "delete_admin".$admin['id_admin'];
			if(isset($_POST[$deleted_admin])) //daca apare o schimbare
			{
				$sql = "DELETE FROM `administratori` WHERE `id_admin` = '".$admin['id_admin']."'";
				$sql_result = mysqli_query($conn, $sql);
				$DoneMessage = "Modificările au fost realizate cu succes!";
			}
		}

	}

?>