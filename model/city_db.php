<?php
class CityDB {
    public static function getCities() {
        $db = Database::getDB();
        $query = 'SELECT * FROM cities
                  ORDER BY cityID';
        try {
            $statement = $db->prepare($query);
            $statement->execute();
            
            $cities = array();
            foreach ($statement as $row) {
                $city = new City($row['cityID'],
                                        $row['cityName']);
                $cities[] = $city;
            }
            return $cities;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function getCity($city_id) {
        $db = Database::getDB();
        $query = 'SELECT * FROM cities
                  WHERE cityID = :city_id';    
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':city_id', $city_id);
            $statement->execute();    
            $row = $statement->fetch();
            $statement->closeCursor();    
            $city = new City($row['cityID'] ?? 'dv',
                                    $row['cityName'] ?? 'dv');
            return $city;
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function deleteCity($city_id) {
        $db = Database::getDB();
        $query = 'DELETE FROM cities
                  WHERE cityID = :city_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':city_id', $city_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }

    public static function addCity($city) {
        $db = Database::getDB();

        $name = $city->getName();

        $query = 'INSERT INTO cities
                     (cityName)
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

    public static function updateCity($city) {
        $db = Database::getDB();

        $city_id = $city->getID();
        $name = $city->getName();

        $query = 'UPDATE cities
                    SET cityName = :name
                    WHERE cityID = :city_id';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':name', $name);
            $statement->bindValue(':city_id', $city_id);
            $statement->execute();
            $statement->closeCursor();
        }catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
}
?>