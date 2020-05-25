<?php

class OrderDB {
    function addOrder($order) {
        $db = Database::getDB();

        $user=$order->getUser()->getID();
        $order_date =$order->getOrderDate();

        $query = '
            INSERT INTO orders (userID, orderDate)
            VALUES (:user, :order_date)';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $customer_id);
            $statement->bindValue(':order_date', $order_date);
            $statement->execute();
            $order_id = $db->lastInsertId();
            $statement->closeCursor();
            return $order_id;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    function addOrderItem($order_item) {
        $db = Database::getDB();

        $order_id=$order_item->getOrder()->getID();
        $product_id=$order_item->getProduct()->getID();

        $query = '
            INSERT INTO orderItems (orderID, productID)
            VALUES (:order_id, :product_id)';
        $statement = $db->prepare($query);
        try {
            $statement->bindValue(':order_id', $order_id);
            $statement->bindValue(':product_id', $product_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    function getOrder($order_id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM orders WHERE orderID = :order_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':order_id', $order_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();

            $user=UserDB::getUser($row['userID'] ?? '');
            $order = new Order($user ?? '',
                $row['orderDate'] ?? '');
            $order->setID($row['orderID'] ?? '');

            return $order;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    function getOrderItems($order_id) {
        $db = Database::getDB();
        $order=OrderDB::getOrder($order_id);

        $query = 'SELECT * FROM orderItems WHERE orderID = :order_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':order_id', $order_id);
            $statement->execute();
            $order_items = $statement->fetchAll();
            $statement->closeCursor();

            $orderItems=array();
            foreach($order_items as $order_item) {
                $product_id=$order_item['productID'];
                $product=ProductDB::getProduct($product_id);
                $item=new OrderItem($order, $product, $order_item['shipDate']);
                $item->setID($order_item['orderItemID']);
                $orderItems[]=$item;
            }
            return $orderItems;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    function getOrdersByUser($user_id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM orders WHERE userID = :user_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
            $user=UserDB::getUser($row['userID'] ?? '');

            $orders=array();
            foreach ($rows as $row) {
                $order = new Order($user ?? '', $row['orderDate'] ?? '');
                $order->setID($row['orderID'] ?? '');
                $orders[]=$order;
            }
            return $orders;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    

    //slicna funkcija ke treba vo product_db
    /*function set_ship_date($order_id) {
        global $db;
        $ship_date = date("Y-m-d H:i:s");
        $query = '
            UPDATE orders
            SET shipDate = :ship_date
            WHERE orderID = :order_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':ship_date', $ship_date);
        $statement->bindValue(':order_id', $order_id);
        $statement->execute();
        $statement->closeCursor();
    }*/

    function deleteOrder($order_id) {
        $db = Database::getDB();

        $query = 'DELETE FROM orders WHERE orderID = :order_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':order_id', $order_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>