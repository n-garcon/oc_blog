<?php 

	try {
		$bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8;', 'root','', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	} catch (Exception $e) {
		echo "Error : ".$e->getMessage();
	}

	// Adding a new user 
		//check pseudo 
		//check email 
		//check password 

	// Secure the given values
	$pseudo = htmlspecialchars($_POST['pseudo']);
	$email = htmlspecialchars($_POST['email']);
	$chosenPassword = htmlspecialchars($_POST['chosenPassword']);
	$retypedPassword = htmlspecialchars($_POST['retypedPassword']);

	// Check the values
	$pseudoCheck = preg_match("#^[a-zA-Z][a-zA-Z0-9@_-]{7,19}$#", $pseudo);
	$emailCheck = preg_match("#^[a-z0-9._-]+@[a-z0-9]{2,}\.[a-z]{2,4}$#", $email);
	$passwordCharCheck = preg_match("#^[a-zA-Z0-9!?+*@_-]{8,30}$#", $chosenPassword);
	$passwordTwinCheck = strcmp($chosenPassword, $retypedPassword);
	$passwordCheck = $passwordCharCheck AND $passwordTwinCheck == 0;
	
	// potential errors
	if (!$pseudoCheck) echo "<p>Ce pseudo ne respecte pas les règles de saisie</p>";

	if (!$emailCheck) echo "<p>L'adresse email n'est pas au bon format</p>";

	if (!$passwordCharCheck) echo "<p>Le mot de passe n'est pas au bon format</p>";

	if($passwordCheck) {$hashword = sha1($chosenPassword."zn");}


	$signInValid = $passwordCheck AND $emailCheck AND $pseudoCheck;

	if ($signInValid) {
		// Check if user exists already  !!!!! 
		$requestExisting = $bdd->prepare("SELECT pseudo, email FROM blog_users WHERE pseudo=:pseudo AND email=:email");

		$requestExisting->execute(array(
			"pseudo"	=> $pseudo,
			"email" 	=> $email
		));

		if (empty($requestExisting->fetch())) {
			$requestSignIn = $bdd->prepare("
				INSERT INTO blog_users (pseudo, email, password, sign_in_date) 
				VALUES (:pseudo, :email, :password, NOW())"
			); 

			$requestSignIn -> execute(array(
				'pseudo'	=> $pseudo, 
				'email'		=> $email, 
				'password'	=> $hashword 
			));

			$requestSignIn->closeCursor();
			echo "Nouvel utilisateur ajouté";
		} else {
			echo "Le mail ou/et le pseudo existe(ent) déjà !";
		}
	}
	
	echo "<p><a href='new_user.php'>Retour à la page d'inscription</a></p>";

?>