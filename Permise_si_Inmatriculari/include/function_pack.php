<?php

//#################################################	
//############## Functii validare #################
//#################################################	

	// verifica ca textele sa nu fie harmful
	function validate_string($string)
	{
		return htmlspecialchars(trim($string));
	}

	//formular_inmatriculare.php + formular_permise.php -> validare serie C.I
	function CI_code_validation($CI_code)
	{
		$CI_code = strtoupper($CI_code);
		if(strlen($CI_code) == 8) // daca are dimensiunea 8 XT123123
		{
			if($CI_code[0]>="A" && $CI_code[0]<="Z" && $CI_code[1]>="A" && $CI_code[1]<="Z")
			{
				for($i=2; $i<8; $i++)// verificam caracterele de la pozitia 2 la 8 daca sunt cifre
				{
					if(!($CI_code[$i] >= '0' && $CI_code[$i] <= '9')) // nu e cifra
					{
						return 0;
					}
				}
			}
			else{
				return 0;
			}
		}
		else
		{
			return 0;
		}
		return 1;
	}

	//formular_inmatriculare.php -> validare C.U.I
	function CUI_validation($CUI_code)
	{
		// Daca este string, elimina atributul fiscal si spatiile
		if(!is_int($CUI_code)){
				$CUI_code = strtoupper($CUI_code);
				if(strpos($CUI_code, 'RO') === 0){
					$CUI_code = substr($CUI_code, 2);
				}
				$CUI_code = (int) trim($CUI_code);
		}
			
		// daca are mai mult de 10 cifre sau mai putin de 6, nu-i valid
		if(strlen($CUI_code) > 10 || strlen($CUI_code) < 6){
				return false;
		}
		// numarul de control
		$v = 753217532;
			
		// extrage cifra de control
		$c1 = $CUI_code % 10;
		$CUI_code = (int) ($CUI_code / 10);
			
		// executa operatiile pe cifre
		$t = 0;
		while($CUI_code > 0){
				$t += ($CUI_code % 10) * ($v % 10);
				$CUI_code = (int) ($CUI_code / 10);
				$v = (int) ($v / 10);
			}
			
		// aplica inmultirea cu 10 si afla modulo 11
		$c2 = $t * 10 % 11;
			
		// daca modulo 11 este 10, atunci cifra de control este 0
		if($c2 == 10){
			$c2 = 0;
		}
		return $c1 === $c2;
	}

//#########################################
//####### Functii asociate datelor ########
//#########################################

	// Functie pentru adaugarea a k luni unei date
	function Add_k_Months($date, $format, $k)
	{
		$new_date = date($format, strtotime($date));
		if($k == -1){
			$new_date = date($format, strtotime("-1 month", strtotime($date)));
		}
		else{
			if($k < 0){
				$new_date = date($format, strtotime("-$k months", strtotime($date)));
			}
			else{
				if($k == 1){
					$new_date = date($format, strtotime("+1 month", strtotime($date)));
				}
				else{
					$new_date = date($format, strtotime("+$k months", strtotime($date)));
				}
			}
		}
		return $new_date;
	}


	// Functie pentru adaugarea a k zile unei date
	function Add_k_Days($date, $format, $k)
	{
		$new_date = date($format, strtotime($date));
		if($k == -1){
			$new_date = date($format, strtotime("-1 day", strtotime($date)));
		}
		else{
			if($k < 0){
				$new_date = date($format, strtotime("-$k days", strtotime($date)));
			}
			else{
				if($k == 1){
					$new_date = date($format, strtotime("+1 day", strtotime($date)));
				}
				else{
					$new_date = date($format, strtotime("+$k days", strtotime($date)));
				}
			}
		}
		
		return $new_date;
	}

	function Get_Month($date)
	{
		return date("m", strtotime($date));
	}
	
//###############################################################################################
//############ Functii de redirectionare in cazul in care nu exista anumite variabile ###########
//###############################################################################################

	//pentru pagina formular_pasul2.php redirectionare in cazul in care anumite variabile setate prin session nu se regasesc
	function Verify_POST_SESSION_formular_pasul2()
	{
		$ExistsSESSION = 1; // initializam variabila care ne spune daca exista sesiunea
		
		if(!isset($_SESSION['date_programare'])) // daca nu e declarata, atunci nu exista
		{
			$ExistsSESSION = 0;
		}
		if(!(isset($_SESSION['date_programare']['nume_prenume']) && isset($_SESSION['date_programare']['tip_persoana']) && isset($_SESSION['date_programare']['cod_unic']) && isset($_SESSION['date_programare']['email']) && isset($_SESSION['date_programare']['procedura'])))
		{ 
			$ExistsSESSION = 0;
		}

		//daca nu exista redirectionam spre pagina principala
		if(!$ExistsSESSION)
		{	
			header("location:index.php");
		}
	}

	//pentru toate paginile de administrator, redirectionare spre pagina principala in cazul in care administratorul nu este inregistrat
	function Verify_admin_registration(mysqli $conn)
	{
		$ExistsSESSION = 1; // initializam variabila care ne spune daca exista sesiunea
		
		if(!isset($_SESSION['admin']) || !isset($_SESSION['admin']['username_admin']) || !isset($_SESSION['admin']['parola_admin']) || !isset($_SESSION['admin']['id_admin'])) // daca nu e declarata, atunci nu exista
		{
			$ExistsSESSION = 0;
			//echo "<script>alert('".$_SESSION['admin']['id_admin']."');</script>";
		}
		else
		{
			//verificam daca exista acest administrator in baza de date

			//echo "<script>alert('".$_SESSION['admin']['id_admin']."');</script>";
			$sql = "SELECT username_admin FROM administratori WHERE id_admin = '".$_SESSION['admin']['id_admin']."'";
			$query = mysqli_query($conn, $sql);
			if(mysqli_num_rows($query) == 0) //nu exista in baza de date acest administrator
			{
				$ExistsSESSION = 0;
			}
		}

		//daca nu exista redirectionam spre pagina principala
		if(!$ExistsSESSION)
		{	
			header("location:../../index.php");
		}
	}

	//pentru paginile administratorilor care necesita acces special, numai administratorul suprem poate intra
	function Special_admin_access()
	{
		if($_SESSION['admin']['rol_admin'] != 'suprem')
		{
			header("location: index.php");

		}
	}


//###############################################################################################
//########## Functii legate de prelucrarea timpului din minute in format ora si invers ##########
//###############################################################################################

	//primeste un numar, de exemplu 480 si returneaza un string de ex 08:00
	function Mins_to_time($min)
	{
		$hour_indicator = (int)($min / 60);
		$min_indicator = $min % 60;
		if($hour_indicator < 10)
			$hour_indicator = "0".$hour_indicator;
		if($min_indicator < 10)
			$min_indicator = "0".$min_indicator;
		$time = $hour_indicator.":".$min_indicator;
		return $time;
	}

//#################################################################################################################################
//######### Functii legate de criptare/encode/decode/hash pentru protejarea parolelor si a datelor cu caracter personal ###########
//#################################################################################################################################

	//functia de generare a unei chei sau a unui salt
	function KeyGenerator()
	{
		$chars = "abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		srand((double)microtime()*1000000);
		$str = "";
		$i = 0;
		while($i <= 10){
			$num = rand() % strlen($chars);
			$tmp = substr($chars, $num, 1);
			$str = $str . $tmp;
			$i++;
		}
		$key = md5(md5($str));
		return $key;
	}

	//criptarea unui cuvant, avand o cheie data
	function encrypt($string, $key)
	{
		$string = rtrim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $string, MCRYPT_MODE_ECB)));
		return $string;
	}
	
	//decriptarea unui cuvant pe baza unei chei
	function decrypt($string, $key)
	{
		$string = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, base64_decode($string), MCRYPT_MODE_ECB));
		return $string;
	}
	
	//hash-uirea unui cuvand, fara posibilitate de dehash-uire
	function hashword($string, $salt)
	{
		$string = crypt($string, '$1$'.$salt.'$');
		return $string;
	}

//#################################################################################################################################
//################ Crearea de tokenuri pentru depistarea cazurilor de csrf care sunt folosite la fiecare form #####################
//#################################################################################################################################

	class Token{
		public static function generate()
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789+=-";
			$token = '';
			for($i = 1; $i<=32; $i++)
			{
				$index = rand() % strlen($chars);
				$token .= $chars[$index];
			}
			return $_SESSION['token'] = $token;
		}

		public static function check($token)
		{
			if(isset($_SESSION['token']) && $token === $_SESSION['token'])
			{
				unset($_SESSION['token']);
				return true;
			}
			return false;
		}
	};

?>