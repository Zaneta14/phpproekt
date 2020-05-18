


-- DROP DATABASE IF EXISTS sell_and_buy;
-- CREATE DATABASE sell_and_buy;
-- USE sell_and_buy;

DROP TABLE IF EXISTS categories;
CREATE TABLE categories(
    categoryID INT (11) NOT NULL AUTO_INCREMENT,
    categoryName VARCHAR (255) NOT NULL,
    PRIMARY KEY (categoryID)
);
DROP TABLE IF EXISTS cities;
CREATE TABLE cities(
    cityID INT (11) NOT NULL AUTO_INCREMENT,
    cityName VARCHAR (255) NOT NULL,
    PRIMARY KEY (cityID)
);
DROP TABLE IF EXISTS products;
CREATE TABLE products(
    productID INT           NOT NULL AUTO_INCREMENT,
    categoryID INT          NOT NULL,
    userID INT              NOT NULL,
    productViews INT(11)    NOT NULL,
    productName VARCHAR(255)NOT NULL,
    productDescription TEXT NOT NULL,
    productCode VARCHAR(255) NOT NULL UNIQUE,
    productPrice DECIMAL(10,2) NOT NULL,
    startDate DATETIME NOT NULL,
    finishDate DATETIME NOT NULL,
    PRIMARY KEY (productID),
    INDEX categoryID (categoryID),
    INDEX userID (userID)
);
DROP TABLE IF EXISTS users;
CREATE TABLE users(
    userID INT NOT NULL AUTO_INCREMENT,
    cityID INT NOT NULL,
    userEmail VARCHAR(255) NOT NULL,
    password VARCHAR(60) NOT NULL,
    firstName VARCHAR(60) NOT NULL,
    lastName VARCHAR(60) NOT NULL,
    telNumber CHAR(9) NOT NULL,
    userAddress VARCHAR(60),
    PRIMARY KEY (userID),
    INDEX cityID (cityID)

);
DROP TABLE IF EXISTS orders;
CREATE TABLE orders(
    orderID INT NOT NULL AUTO_INCREMENT,
    userID INT NOT NULL,
    shipAmount DECIMAL NOT NULL,
    orderDate DATETIME NOT NULL,
    shipDate DATETIME DEFAULT NULL,
    PRIMARY KEY (orderID),
    INDEX userID (userID)
);
DROP TABLE IF EXISTS orderItems;
CREATE TABLE orderItems(
    orderItemID INT NOT NULL AUTO_INCREMENT,
    orderID INT NOT NULL,
    productID INT NOT NULL,
    quantity INT NOT NULL,
    PRIMARY KEY (orderItemID),
    INDEX orderID (orderID), 
    INDEX productID (productID)

);
DROP TABLE IF EXISTS administrators;
CREATE TABLE administrators (
  adminID           INT            NOT NULL   AUTO_INCREMENT,
  adminEmail      VARCHAR(255)   NOT NULL,
  password          VARCHAR(255)   NOT NULL,
  firstName         VARCHAR(255)   NOT NULL,
  lastName          VARCHAR(255)   NOT NULL,
  PRIMARY KEY (adminID)
);

-- Insert data into the tables 
INSERT INTO categories(categoryID, categoryName) VALUES 
(1,'Home'),
(2, 'Vehicles');

INSERT INTO cities(cityID, cityName) VALUES 
(1, 'Skopje'),
(2,'Bitola'),
(3, 'Kavadarci'),
(4, 'Veles');

INSERT INTO products(productID, categoryID, userID, productName, productCode,productDescription, productPrice,productViews,startDate, finishDate) VALUES
(1,1,1,'Sofa','sofa1','Not much used green sofa', '399.00','12','2013-10-30 09:32:40','2013-10-30 09:32:40'),
(2,3,2,'Opel Corsa','car1','Red Opel Corsa', '2999.00','5','2013-10-30 09:32:40','2013-10-30 09:32:40');

INSERT INTO users (userID,cityID,userEmail, userAddress,firstName, lastName,telNumber) VALUES 
(1,1,'user1@mail.com',' Skopje', 'Marko','Markovski','123456789'),
(2,3,'user2@email.com', 'Kavadarci', 'Petar','Petrevski','987654321');

INSERT INTO orders (orderID, userID, shipAmount, orderDate, shipDate) VALUES
(1, 1, '5.00', '2014-05-30 09:40:28',  '2014-06-01 09:43:13'),
(2, 2, '5.00','2014-06-01 11:23:20',  '2014-06-01 09:43:13'),
(3, 1, '5.00','2014-06-03 09:44:58',  '2014-06-01 09:43:13');

INSERT INTO orderItems (orderItemID, orderID, productID, quantity) VALUES
(1, 1, 2, 1),
(2, 2, 1, 1),
(3, 3, 1, 1),
(4, 3, 1, 1);

INSERT INTO administrators (adminID, adminEmail, password, firstName, lastName) VALUES
(1, 'admin@myguitarshop.com', '6a718fbd768c2378b511f8249b54897f940e9022', 'Admin', 'User'),
(2, 'joel@murach.com', '971e95957d3b74d70d79c20c94e9cd91b85f7aae', 'Joel', 'Murach'),
(3, 'mike@murach.com', '3f2975c819cefc686282456aeae3a137bf896ee8', 'Mike', 'Murach');
