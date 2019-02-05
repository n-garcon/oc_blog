<?php 
    session_start();
    if (empty($_SESSION['id'])){
        header("Location:index.php");
    }
    try{
        

        $bdd = new PDO('mysql:host=localhost;dbname=test;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {echo "Error : ".$e-> getMessage();}

    $request = $bdd->query("SELECT id, post_title, post_message, DATE_FORMAT(time_stamp, '%d.%m.%Y - %h:%i') AS time_stamp FROM blog_post ORDER BY time_stamp DESC");
?>
<!DOCTYPE html>
<html>
    <head>
    <meta charset="UTF-8"/>
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/post.css">
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Patua+One" rel="stylesheet"> 
    </head>
    <body>
        <header>
            <div class="header-footer-column">
                <h2 id="site-name-container" ><a href="index.php" id="site-name">Livre de Faces</a></h2>
                <a href="unlog.php">Déconnexion</a>
            </div>       
        </header>
        <div class="header-padding"></div>

        <div class="main-column">
<?php
        while($post_data = $request->fetch()){
?>            
            <article class="post-frame">
                <div class="post-header"><?php echo $post_data['post_title']?> <span class="post-time-stamp"> - <?php echo $post_data['time_stamp']?></span></div>
                <p class="post-message"><?php echo $post_data['post_message']?></p>
                <div class="post-footer">
                    <p class="post-comment-container">
                        <a href="comments.php?post_id=<?php echo $post_data['id'] ?>" class="post-comment-link">Commentaires</a>
                    </p>
                    
                    
                </div> 
            </article>
           
<?php               
}              
?>                
            
        </div>


<?php $request->closeCursor();?>
    <div class="footer-padding"></div>
    <div id="bottom-line">
        <div class="main-column">
            <p>Salut <?php echo $_SESSION['pseudo'];?> ! ça fait longtemps !</p>
        </div>
        
    </div>    
    </body>
</html>