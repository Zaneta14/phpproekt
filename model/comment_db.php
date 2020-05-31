<?php
class CommentDB {

    public static function addComment($comment) {
        $db = Database::getDB();

        $user_id=$comment->getUser()->getID();
        $product_id=$comment->getProduct()->getID();
        $comment_string=$comment->getCommentString();

        $query = 'INSERT INTO comments
                     (userID, productID, commentString)
                  VALUES
                     (:userID, :productID, :commentString)';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':userID', $user_id);
            $statement->bindValue(':productID', $product_id);
            $statement->bindValue(':commentString', $comment_string);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public  function deleteComment($comment_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM comments
                  WHERE commentID = :comment_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':comment_id', $comment_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }


    public static function getCommentsByProduct($product_id) {
        $db = Database::getDB();

        $product=ProductDB::getProduct($product_id);

        $query='SELECT * FROM comments 
                WHERE productID = :productID';
        
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":productID", $product_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();

            $comments=array();
            foreach ($rows as $row) {
                $user=UserDB::getUser($row['userID'] ?? 'dv');
                $comment = new Comment($user, $product, $row['commentString']);
                $comment->setId($row['commentID']);
                $comments[] = $comment;
            }
            return $comments;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>