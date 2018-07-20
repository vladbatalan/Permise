<?php
	
	// vom verifica datele primite de la logarea administratorului si vom activa session in cazul in care exista in baza de date
	if(isset($_POST['login_submit'])) // a fost trimis formularul
	{
		$username = validate_string($_POST['username']);
		$parola = validate_string($_POST['parola']);

		if (!empty($username) && !empty($parola)) {
			//cautam in baza de date 
			$sql = "SELECT a.*, b.rol_admin FROM administratori AS a, rol_administrator AS b WHERE username_admin = '$username' AND a.id_rol = b.id_rol";
			$query = mysqli_query($conn, $sql);

			//verificam daca exista
			if(mysqli_num_rows($query))
			{
				//exista, asa ca verificam parola
				$admin = mysqli_fetch_assoc($query);
				if(hashword($parola, $admin['salt_parola']) == $admin['parola_admin']) // daca hashul parolei introduse corespunde cu parola din baza de date
				{
					if(Token::check($_POST['token']))
					{
						//exista, asa ca il bagam in SESSION si redirectionam la pagina principala de pe dashboard
						$_SESSION['admin'] = $admin;
						header("location: index.php");
					}
				}
				else
				{
					//parola este gresita
					$ErrMessage = "Nume sau parola este greșit!";
				}
			}
			else
			{
				//nu exista in baza de date
				$ErrMessage = "Nume sau parola este greșit!";
			}
		} else {
			$ErrMessage = "Toate câmpurile trebuie completate!";
		}
		
		
	}




?>