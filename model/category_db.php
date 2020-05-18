<?php
class CategoryDB {
    public static function getCategories() {
        $db = Database::getDB();
        $query = 'SELECT *,
                    (SELECT COUNT(*)
                            FROM products
                            WHERE products.categoryID = categories.categoryID)
                            AS productCount
                  FROM categories
                  ORDER BY categoryID';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            
            $categories = array();
            foreach ($statement as $row) {
                $category = new Category($row['categoryID'],
                                        $row['categoryName']);
                $categories[] = $category;
            }
            return $categories;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function getCategory($category_id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM categories
                  WHERE categoryID = :category_id';    
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();    
            $row = $statement->fetch();
            $statement->closeCursor();    
            $category = new Category($row['categoryID'] ?? 'dv',
                                    $row['categoryName'] ?? 'dv');
            return $category;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function deleteCategory($category_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM categories
                  WHERE categoryID = :category_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function addCategory($category) {
        $db = Database::getDB();

        $name = $category->getName();

        $query = 'INSERT INTO categories
                     (categoryName)
                  VALUES
                     (:name)';
        try {
            $statement->bindValue(':name', $name);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function updateCategory($category) {
        $db = Database::getDB();

        $category_id = $category->getID();
        $name = $category->getName();

        $query = 'UPDATE categories
                    SET categoryName = :name
                    WHERE categoryID = :category_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':category_id', $category_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>