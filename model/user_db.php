<?php
class UserDB {

    function is_valid_user_email($email) {
        $db = Database::getDB();
        $query = '
            SELECT userID FROM users
            WHERE userEmail = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    }
    
    function is_valid_user_login($email, $password) {
        $db = Database::getDB();
        $password = sha1($email . $password);
        $query = '
            SELECT * FROM users
            WHERE userEmail = :email AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    }

    public function getUsersByCity($city_id) {
        $db = Database::getDB();

        $city = CityDB::getCity($city_id);

        $query = 'SELECT * FROM users u
           INNER JOIN cities c
           ON u.cityID = c.cityID
        WHERE u.cityID = :city_id';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":city_id", $city_id);
            $statement->execute();
            $rows = $statement->fetchAll();
            $statement->closeCursor();
        
            $users=array();
            foreach ($rows as $row) {
                                $user = new User($city,
                                    $row['userEmail'],
                                    $row['password'],
                                    $row['firstName'],
                                    $row['lastName'],
                                    $row['telNumber'],
                                    $row['userAddress']);
                $user->setId($row['userID']);
                $users[] = $user;
            }
            return $users;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function getUserByEmail($email) {
        $db = Database::getDB();

        $query = 'SELECT * FROM users
        WHERE userEmail = :email';

        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":email", $email);
            $statement->execute();
            $rows = $statement->fetch();
            $statement->closeCursor();

            $city=CityDB::getCity($row['cityID']);
            $user = new User($city,
                                    $row['userEmail'],
                                    $row['password'],
                                    $row['firstName'],
                                    $row['lastName'],
                                    $row['telNumber'],
                                    $row['userAddress']);
            $user->setID($row['userID']);
            return $user;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
    
    public static function getUser($user_id) {
        $db = Database::getDB();
        $query = 'SELECT * 
                    FROM users u
                    INNER JOIN cities c
                        ON u.cityID = c.cityID
                    WHERE userID = :user_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(":user_id", $user_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();
        
            $city = CityDB::getCity($row['cityID'] ?? 'dv');
            $user = new User($city,
                                    $row['userEmail'] ?? 'dv',
                                    $row['password'] ?? 'dv',
                                    $row['firstName'] ?? 'dv',
                                    $row['lastName'] ?? 'dv',
                                    $row['telNumber'] ?? 'dv',
                                    $row['userAddress'] ?? 'dv');
            $user->setID($row['userID'] ?? 'dv');
            return $user;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function deleteUser($user_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM users
                  WHERE userID = :user_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function addUser($user) {
        $db = Database::getDB();

        $city_id = $user->getCity()->getID();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $telNumber = $user->getTelNumber();
        $address = $user->getUserAddress();

        $password1 = sha1($email . $password);

        $query = 'INSERT INTO users
                     (cityID, userEmail, password, firstName, lastName, telNumber, userAddress)
                  VALUES
                     (:city_id, :email, :password, :firstName, :lastName, :telNumber, :userAddress)';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':city_id', $city_id);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':password', $password1);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':telNumber', $telNumber);
            $statement->bindValue(':userAddress', $address);
            $statement->execute();
            
            $user_id = $db->lastInsertId();
            $statement->closeCursor();
            return $user_id;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function updateUser($user_id, $user, $password_1, $password_2) {
        $db = Database::getDB();

        $city_id = $user->getCity()->getID();
        $email = $user->getEmail();
        $firstName = $user->getFirstName();
        $lastName = $user->getLastName();
        $telNumber = $user->getTelNumber();
        $address = $user->getUserAddress();

        $query = 'UPDATE users
                    SET cityID = :city_id,
                    userEmail = :email,
                    firstName = :firstName,
                    lastName = :lastName,
                    telNumber=:telNumber,
                    userAddress=:userAddress
                    WHERE userID = :user_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':user_id', $user_id);
            $statement->bindValue(':city_id', $city_id);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':firstName', $firstName);
            $statement->bindValue(':lastName', $lastName);
            $statement->bindValue(':telNumber', $telNumber);
            $statement->bindValue(':userAddress', $address);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
        try {
            if (!empty($password_1) && !empty($password_2)) {
                $password = sha1($email . $password_1);
                $query = '
                    UPDATE users
                    SET password = :password
                    WHERE userID = :user_id';
                $statement = $db->prepare($query);
                $statement->bindValue(':password', $password);
                $statement->bindValue(':user_id', $user_id);
                $statement->execute();
                $statement->closeCursor();
            }
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>