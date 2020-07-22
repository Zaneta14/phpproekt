<?php
class AdminDB {
    function is_valid_admin_login($email, $password) {
        $db = Database::getDB();
        $password = sha1($email . $password);
        $query = 'SELECT * FROM administrators
                WHERE adminEmail = :email AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    }

    function admin_count() {
        $db = Database::getDB();
        $query = 'SELECT count(*) AS adminCount FROM administrators';
        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result['adminCount'];
    }

    function get_all_admins() {
        $db = Database::getDB();
        $query = 'SELECT * FROM administrators ORDER BY lastName, firstName';
       
       try{
        $statement = $db->prepare($query);
        $statement->execute();
        $rows = $statement->fetchAll();
        $statement->closeCursor();

        $admins = array();
        foreach($rows as $row){
            $admin = new Administrator($row['adminEmail'],
                                        $row['password'],
                                        $row['firstName'],
                                        $row['lastName']);
            $admin->setID($row['adminID']);
            $admins[]=$admin;
        }
        return $admins;

       }catch(PDOException $e){
        $error_message = $e->getMessage();
        display_db_error($error_message);
       }
        
    }

    function get_admin ($admin_id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM administrators 
                    WHERE adminID = :admin_id';
        

        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_id', $admin_id);
            $statement->execute();
            $row = $statement->fetch();
            $statement->closeCursor();

            $admin = new Administrator($row['adminEmail'] ?? 'null',
            $row['password'] ?? 'null',
            $row['firstName'] ?? 'null',
            $row['lastName'] ?? 'null');
            $admin->setID($row['adminID'] ?? 'null');

            return $admin;

        }catch(PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
        
    }

    function get_admin_by_email($email) {
        $db = Database::getDB();
        $query = 'SELECT * FROM administrators
                 WHERE adminEmail = :email';

        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $admin = $statement->fetch();
            $statement->closeCursor();

            $admin = new Administrator($row['adminEmail'],
            $row['password'],
            $row['firstName'],
            $row['lastName']);
            $admin->setID($row['adminID']);


            return $admin;

        }catch(PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    function is_valid_admin_email($email) {
        $db = Database::getDB();
        $query = '
            SELECT * FROM administrators
            WHERE adminEmail = :email';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->execute();
        $valid = ($statement->rowCount() == 1);
        $statement->closeCursor();
        return $valid;
    }

    function add_admin($email,$first_name, $last_name, $password_1) {
        $db = Database::getDB();
        $password = sha1($email . $password_1);
        // $email=$admin->getEmail();
        // $first_name=$admin->getFirstName();
        // $last_name=$admin->getLastName();


        $query = 'INSERT INTO administrators (adminEmail, password, firstName, lastName)
            VALUES (:email, :password, :first_name, :last_name)';
       
       try{

        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':first_name', $first_name);
        $statement->bindValue(':last_name', $last_name);
        $statement->execute();
        $admin_id = $db->lastInsertId();
        $statement->closeCursor();
        return $admin_id;
       }catch(PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);

       }
       
    
        
    }

    function update_admin($admin_id, $email,$first_name, $last_name, $password_1, $password_2) {
        $db = Database::getDB();

        // $admin = Database::get_admin($admin_id);
        // // $email = $admin->getEmail();
        // $first_name = $admin->getFirstName();
        // $last_name = $admin->getLastName();


        $query = 'UPDATE administrators SET adminEmail = :email,
                firstName = :first_name,
                lastName = :last_name
            WHERE adminID = :admin_id';

        try{

            $statement = $db->prepare($query);
            $statement->bindValue(':admin_id', $admin_id);
            $statement->bindValue(':email', $email);
            $statement->bindValue(':first_name', $first_name);
            $statement->bindValue(':last_name', $last_name);
            
            $statement->execute();
            $statement->closeCursor();

        }catch(PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);

        }

       try{

        if (!empty($password_1) && !empty ($password_2)) {
            if ($password_1 !== $password_2) {
                display_error('Passwords do not match.');
            } elseif (strlen($password_1) < 6) {
                display_error('Password must be at least six characters.');
            }
            $password = sha1($email . $password_1);
            $query = '
                UPDATE administrators
                SET password = :password
                WHERE adminID = :admin_id';
            $statement = $db->prepare($query);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':admin_id', $admin_id);
            $statement->execute();
            $statement->closeCursor();
        }

       }catch(PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
        }   
    }

    function delete_admin($admin_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM administrators
                 WHERE adminID = :admin_id';
        try{
            $statement = $db->prepare($query);
            $statement->bindValue(':admin_id', $admin_id);
            $statement->execute();
            $statement->closeCursor();

        }
        catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
       
    }
}
?>