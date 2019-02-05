<?php 
    try {
        $bdd = new PDO("mysql:host=localhost;dbname=test;charset=utf8", "root", "", array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (Exception $e) {
        echo "Error : ".$e->getMessage();
    }
    
    $post_id = (isset($_POST['post_id'])) ? htmlspecialchars($_POST['post_id']) :  die();
    $commentAuthor = (isset($_POST['author_name'])) ? htmlspecialchars($_POST['author_name']) : die(); 
    $comment = (isset($_POST['comment'])) ? htmlspecialchars($_POST['comment']) : die();
    $avatar = "";
    

    $checkPostId = preg_match("#[0-9]{1,5}#", $post_id);
    print_r($checkPostId);
    $checkCommentAuthor = preg_match("#[a-zA-Z0-9@_-]{3,30}#", $commentAuthor);
    print_r($checkCommentAuthor);
    $checkComment = preg_match("#.{3,300}#", $comment);
    print_r($checkComment);



    $formCheck = $checkPostId && $checkCommentAuthor && $checkComment;

    if ($formCheck) {
        $addCommentRequest = $bdd->prepare("INSERT INTO blog_comments (id_post, comment_author, comment, avatar_path, time_stamp) VALUES (:id_post, :comment_author, :comment, :avatar_path, NOW())"); 
    
        $addCommentRequest->execute(array(
            "id_post" => $post_id,
            "comment_author" => $commentAuthor ,
            "comment" => $comment ,
            "avatar_path" => $avatar 
        ));

        header ("Location:comments.php?post_id=".$post_id);
    } else {echo "<p>Il manque sûrement des éléments</p>";}

    
 


?>

