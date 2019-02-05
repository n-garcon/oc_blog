<?php
    session_start();

    try {
        $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {echo "Error :".$e->getMessage();}

    // If session is running get straight to the blog page
    // else question data for log in
    
    var_dump($_POST);
    if (isset($_SESSION['id']) AND $_SESSION['id'] != "") {
        header("Location:blog.php");
    } else {
        // SQL request for users with matching IDs and password
        // filter the received data
        $loginId = htmlspecialchars($_POST["loginId"]);
        $hashLoginPassword = htmlspecialchars($_POST["loginPassword"]);
        $hashLoginPassword = sha1($hashLoginPassword."zn");

        // Identify type of id (email or pseudo)
            // Search for match in the db
                // if match, lead to blog page
                // if dismatch display error and return to login page

        $emailCheck = preg_match("#^[a-z0-9._-]+@[a-z0-9]{2,}\.[a-z]{2,4}$#", $loginId);    

        if ($emailCheck) {
            $loginRequest = $bdd->prepare("
                SELECT * 
                FROM blog_users 
                WHERE email=:loginId AND password=:loginPassword");
        } else {
            $loginRequest = $bdd->prepare("
                SELECT * 
                FROM blog_users 
                WHERE pseudo=:loginId AND password=:loginPassword");
        }
        unset($result);

        $loginRequest->execute(array(
            "loginId"  => $loginId ,
            "loginPassword"  => $hashLoginPassword 
        ));

        $result = $loginRequest->fetch();

        if (!empty($result)) {
            session_start(); 
            $_SESSION['id'] = $result['id'];
            $_SESSION['pseudo'] = $result['pseudo'];
            setcookie("login", $result['login'], time()+365*24*3600, null, null, false, true);
            setcookie("password", $hashLoginPassword, time()+365*24*3600, null, null, false, true);
            echo "connecté<br>";
            header("Location:blog.php");
        } else {
            echo "Erreur(s)";
            header("Location:index.php");
        }
    }





?>