<?php 
    session_start();
    if (empty($_SESSION['id'])){header("Location:index.php");}

    try {
        $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        echo "Error : ".$e->getMessage();
    }
    
    // Check the presence of given id for the post
        // Display the post if so 
        // else return to the main page
    if(isset($_GET['post_id'])){
        $post_id = htmlspecialchars($_GET['post_id']);    
    } else {
        header("Location:index.php");
    }
    
    // Post request only 
    $postRequest = $bdd->prepare("SELECT id, post_title, post_message, DATE_FORMAT(time_stamp, '%d.%m.%Y - %h:%i') AS time_stamp FROM blog_post WHERE id=?"); 

    $result = $postRequest->execute(array($post_id));

    if (empty($result)) {
        header("Location:blog.php"); 
    } else {
        session_start();
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="styles/main.css">
        <link rel="stylesheet" href="styles/post.css">
        <link rel="stylesheet" href="styles/comments.css">
        <link href="https://fonts.googleapis.com/css?family=Alegreya+Sans|Patua+One" rel="stylesheet"> 
    </head>
    <body>
        <header>
            <div class="header-footer-column">
                <h2 id="site-name-container" ><a href="index.php" id="site-name">Livre de Faces</a></h2>
                <p  id="back-home"><a href="index.php">On y retourne ?</a></p>
            </div>
        </header>
        <div class="header-padding"></div>
       
       
       
       
        <div class="main-column">

<?php
        // Display the post
        $post_data = $postRequest->fetch();
?>            
            <article class="post-frame">
                <div class="post-header"><?php echo $post_data['post_title']?>  <span class="post-time-stamp"> - <?php echo $post_data['time_stamp']?></span></div>
                <p class="post-message"><?php echo $post_data['post_message']?></p>
                <div class="post-footer">
                    
                </div> 
            </article>
<?php               
  
    // Display the comment related to the post       
    $commentRequest = $bdd->prepare("SELECT id_post, comment_author, comment, avatar_path, DATE_FORMAT(time_stamp, '%d.%m.%Y - %h:%i') AS time_stamp FROM blog_comments WHERE id_post=? ORDER BY time_stamp"); 
    
    $commentRequest->execute(array($post_id));     
    

    // 
    $comment_count=0;
    
    while($comment_data = $commentRequest->fetch()){
        if ($comment_data == NULL) {
            if($comment_count == 0){
                echo "Aucune donnée";
            }
        } else { 
        
        // Replace any blank avatar directory to a common reference    
        $avatar_path = ($comment_data['avatar_path'] != NULL) ? $comment_data['avatar_path'] : "uploads/avatars/avatar-lamba.jpg" ; 
?>            
            <article class="comment-frame">
                <div class="avatar-frame">
                   <img src="<?php echo $avatar_path;?>" class="author-avatar" alt="Avatar">
                </div>
                
                <div class="author-name"><?php echo $comment_data['comment_author'];?>      
                </div>
                <p class="comment-message"><?php echo $comment_data['comment'];?></p>
                <div class="comment-footer">
                    <span class="comment-time-stamp"><?php echo $comment_data['time_stamp'];?></span>
                </div> 
            </article>
           
<?php               
        } 
    }

            
$commentRequest->closeCursor();  


?>              
        </div>

        <div class="footer-padding"></div>
        <div id="bottom-line">
            <div class="main-column">
                <form action="add_comments_back.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $post_id;?>"/>
                    <label class="comment-label form-element">Votre pseudo :</label>
                    <input type="text" class="text-field form-element" name="author_name" placeholder="Tapez votre pseudo... ">
                    <label class="comment-label form-element">Votre message</label>
                    <textarea name="comment" class="text-field form-element" id="new-comment" placeholder="Tapez votre gentil message... "></textarea>
                    
                    <input type="submit" class="validation-btn form-element" value="Commenter">
                </form>
            </div>
        </div>
    </body>
</html>