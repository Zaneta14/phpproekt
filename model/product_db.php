<?php
class ProductDB {
    public function getProductsByCategory($category_id) {
        $db = Database::getDB();

        $category = CategoryDB::getCategory($category_id);

        $query = 'SELECT * FROM products p
           INNER JOIN categories c
           ON p.categoryID = c.categoryID
        WHERE p.categoryID = :category_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":category_id", $category_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
            $products=array();
            
            foreach ($rows as $row) {
                                $user=UserDB::getUser($row['userID'] ?? 'dv');
                                $product = new Product($category,
                                    $user,
                                    $row['productViews'],
                                    $row['productName'],
                                    $row['productDescription'],
                                    $row['productCode'],
                                    $row['productPrice'],
                                    $row['startDate'],
                                    $row['finishDate'],
                                    $row['shipAmount'],
                                    $row['shipDays']);
                $product->setId($row['productID']);
                $products[] = $product;
            }
            return $products;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public  function getProductsByUser($user_id) {
        $db = Database::getDB();

        $user = UserDB::getUser($user_id);

        $query = 'SELECT * FROM products p
           INNER JOIN users u
           ON p.userID = u.userID
        WHERE p.userID = :user_id';
                  
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":user_id", $user_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
        
            $products=array();
            foreach ($rows as $row) {
                                $category=CategoryDB::getCategory($row['categoryID'] ?? 'dv');
                                $product = new Product($category,
                                    $user,
                                    $row['productViews'],
                                    $row['productName'],
                                    $row['productDescription'],
                                    $row['productCode'],
                                    $row['productPrice'],
                                    $row['startDate'],
                                    $row['finishDate'],
                                    $row['shipAmount'],
                                    $row['shipDays']);
                $product->setId($row['productID']);
                $products[] = $product;
            }
            return $products;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public  function getProductsByCity($city_id) {
        $db = Database::getDB();

        $users = UserDB::getUsersByCity($city_id);

        $products=array();
        foreach ($users as $user) {
                $productsByUser = ProductDB::getProductsByUser($user->getID());
                foreach ($productsByUser as $productByUser) {
                        $product = new Product($productByUser->getCategory(),
                            $productByUser->getUser(),
                            $productByUser->getViews(),
                            $productByUser->getName(),
                            $productByUser->getDescription(),
                            $productByUser->getCode(),
                            $productByUser->getPrice(),
                            $productByUser->getStartDate(),
                            $productByUser->getFinishDate(),
                            $productByUser->getShipAmount(),
                            $productByUser->getShipDays());
                    $product->setId($productByUser->getID());
                    $products[] = $product;
                }
            }
            return $products;    
    }
    
    public function getProductsByCategoryAndCity($category_id, $city_id) {
        $productsByCategory=ProductDB::getProductsByCategory($category_id);
        $productsByCity=ProductDB::getProductsByCity($city_id);
        $products=array();
        foreach($productsByCategory as $productByCategory) {
            if ($productByCategory->getCity()->getID == $city_id)
                $products[]=$productByCategory;
        }
        return $products;
    }

    public  function getProduct($product_id) {
        $db = Database::getDB();
        $query = 'SELECT * 
                    FROM products p
                    INNER JOIN categories c
                        ON p.categoryID = c.categoryID
                    WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":product_id", $product_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
        
            $category = CategoryDB::getCategory($row['categoryID'] ?? '');
            $user=UserDB::getUser($row['userID'] ?? '');
            $product = new Product($category ?? '',
                $user ?? '',
                $row['productViews'] ?? '',
                $row['productName'] ?? '',
                $row['productDescription'] ?? '',
                $row['productCode'] ?? '',
                $row['productPrice'] ?? '',
                $row['startDate'] ?? '',
                $row['finishDate'] ?? '',
                $row['shipAmount'] ?? '',
                $row['shipDays'] ?? '');
            $product->setID($row['productID'] ?? '');
            return $product;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public  function deleteProduct($product_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM products
                  WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':product_id', $product_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public  function addProduct($product) {
        $db = Database::getDB();

        $category_id = $product->getCategory()->getID();
        $user_id =  $product->getUser()->getID();
        $code = $product->getCode();
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $views = $product->getViews();
        $startDate = $product->getStartDate();
        $finishDate = $product->getFinishDate();
        $shipAmount=$product->getShipAmount();
        $shipDays=$product->getShipDays();

        $query = 'INSERT INTO products
                     (categoryID, userID, productViews, productName, productDescription, productCode, productPrice, startDate, finishDate, shipAmount, shipDays)
                  VALUES
                     (:category_id, :user_id, :views, :name, :description, :code, :price, :startdate, :finishdate, :shipamount, :shipdays)';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':code', $code);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':views', $views);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':startdate', $startDate);
            $statement->bindValue(':finishdate', $finishDate);
            $statement->bindValue(':shipamount', $shipAmount);
            $statement->bindValue(':shipdays', $shipDays);
            $statement->execute();
            $product_id = $db->lastInsertId();

            $statement->closeCursor();
            return $product_id;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public function updateProduct($product) {
        $db = Database::getDB();

        $product_id = $product->getID();
        $category_id = $product->getCategory()->getID();
        $user_id = $product->getUser()->getID();
        $code = $product->getCode();
        $name = $product->getName();
        $price = $product->getPrice();
        $description = $product->getDescription();
        $views = $product->getViews();
        $startDate = $product->getStartDate();
        $finishDate = $product->getFinishDate();
        $shipAmount=$product->getShipAmount();
        $shipDays=$product->getShipDays();

        $query = 'UPDATE products
                    SET productName = :name,
                    productCode = :code,
                    productDescription = :description,
                    productPrice = :price,
                    categoryID = :category_id,
                    userID=:user_id,
                    productViews=:views,
                    startDate=:startdate,
                    finishDate=:finishdate,
                    shipAmount=:shipamount,
                    shipDays=:shipdays
                    WHERE productID = :product_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':category_id', $category_id);
            $statement->bindValue(':product_id', $product_id);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':code', $code);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':price', $price);
            $statement->bindValue(':views', $views);
            $statement->bindValue(':description', $description);
            $statement->bindValue(':startdate', $startDate);
            $statement->bindValue(':finishdate', $finishDate);
            $statement->bindValue(':shipamount', $shipAmount);
            $statement->bindValue(':shipdays', $shipDays);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>