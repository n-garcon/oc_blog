<?php 
	session_start();

	if (isset($_SESSION['id']) AND $_SESSION['id'] != "") {
		header("Location:login.php");
	} else {
		if (isset($_COOKIE['login']) AND $_COOKIE['login'] != "") {
			if (isset($_COOKIE['password']) AND $_COOKIE['password'] != "") {
				$_POST['loginId'] = $_COOKIE['login'];
				$_POST['loginPassword'] = $_COOKIE['password']; 
				header("Location:login.php");
			}
		}
	}	


?>



<!DOCTYPE html>
<html>
<head>
	<title>Nouvel utilisateur</title>
	<link rel="stylesheet" type="text/css" href="styles/main.css">
	<link rel="stylesheet" type="text/css" href="styles/access_form.css">
</head>
<body>
	<div class="access-background">
		<div class="access-frame">
			<form id="registration" action="login_back.php" method="post">
				<fieldset>
					<legend>Connectez-vous</legend>
					<table>
						<tr>
							<td>
								<label for="loginId">Pseudo ou email</label>
								<input type="text" id="loginId" name="loginId">
							</td>
							<td>
								<label for="loginPassword">Mot de passe</label>
								<input type="password" id="password1" name="loginPassword">
							</td>
						</tr>
					</table>
					<input type="submit" value="Se connecter"/>
				</fieldset>
			</form>
			<p style="text-align:center;">OU</p>
			<form id="registration" action="register_back.php" method=post>
				<fieldset>
					<legend>Nouvel utilisateur</legend>
					<table>
						<tr>
							<th><label for="pseudo">Pseudo</label></th>
							<td><input type="text" id="pseudo" name="pseudo"></td>
						</tr>
						<tr>
							<th><label for="email">Email</label></th>
							<td><input type="email" id="email" name="email"></td>
						</tr>
						<tr>
							<th><label for="pseudo">Mot de passe</label></th>
							<td><input type="password" id="password1" name="chosenPassword"></td>
						</tr>
						<tr>
							<th><label for="pseudo">Retaper votre mot de passe</label></th>
							<td><input type="password" id="password2" name="retypedPassword"></td>
						</tr>
					</table>
					<input type="submit" value="S'inscrire"/>

				</fieldset>
			</form>
		</div>
	</div>
</body>
</html>