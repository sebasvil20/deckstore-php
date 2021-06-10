-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-06-2021 a las 20:33:59
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `deckstore`
--

DELIMITER $$
--
-- Procedimientos
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_category` (IN `categoryName` VARCHAR(500), IN `categoryDesc` VARCHAR(500))  NO SQL
BEGIN 
  INSERT INTO tcategory (categoryName, categoryDescription) VALUES (categoryName, categoryDesc);
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `remove_product` (IN `idProduct` int(11))  NO SQL
BEGIN 
  DELETE FROM `tproduct` WHERE tproduct.idProduct = idProduct;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `update_product` (IN `idProduct` int(11), IN `productName` VARCHAR(50), IN `productBrand` VARCHAR(100), IN `productPrice` INT(11), IN `productImg` VARCHAR(500), IN `quantity` INT(5), IN `productCategory` INT(11))  NO SQL
BEGIN 
  UPDATE `tproduct` SET tproduct.productName = productName, tproduct.productBrand = productBrand, tproduct.productPrice = productPrice,tproduct.productImg = productImg, tproduct.quantity = quantity, tproduct.productCategory = productCategory WHERE tproduct.idProduct = idProduct;
END$$



CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_detailed_sale` (IN `idSale` CHAR(36), `idProduct` INT(11))  NO SQL
BEGIN 
  INSERT INTO tdetailedsale (idSale, idProduct) VALUES (idSale, idProduct);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_product` (IN `productName` VARCHAR(50), IN `productBrand` VARCHAR(100), IN `productPrice` INT(11), IN `productImg` VARCHAR(500), IN `quantity` INT(5), IN `productCategory` INT(11))  NO SQL
BEGIN 
  INSERT INTO tproduct (productName, productBrand, productPrice, productImg, quantity, productCategory) 
  VALUES(productName, productBrand, productPrice, productImg, quantity, productCategory); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_sale` (IN `total` INT(10), IN `idUser` CHAR(36))  NO SQL
BEGIN 
  INSERT INTO tsale (tsale.total, tsale.idUser) VALUES (total, idUser);
  SELECT tsale.idSale FROM tsale ORDER BY tsale.time DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `create_new_user` (IN `name` VARCHAR(50), IN `gender` TINYINT(1), IN `email` VARCHAR(200), IN `password` VARCHAR(500), IN `userRole` TINYINT(1))  NO SQL
BEGIN 
  INSERT INTO tuser (name, gender, email, password, userRole) VALUES (name, gender, email, password, userRole); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `find_user_by_email` (IN `email` VARCHAR(200))  NO SQL
BEGIN 
  SELECT tuser.email from tuser where tuser.email = email; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_categories` ()  BEGIN
	SELECT idCategory, categoryName
    from tcategory;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_all_products` ()  BEGIN
	SELECT idProduct, productName, productBrand, productPrice, productImg, categoryName 
    from tproduct 
    INNER JOIN tcategory 
    ON tproduct.productCategory = tcategory.idCategory ORDER BY tproduct.idProduct DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_best_selling_product` ()  NO SQL
BEGIN 
  SELECT tproduct.productName, tproduct.productPrice, tproduct.productBrand, tproduct.productImg, tproduct.timesSold
  FROM `tproduct`
  ORDER BY timesSold DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_category_name` (IN `categoryId` INT(11))  BEGIN
	SELECT categoryName
    from tcategory WHERE idCategory = categoryId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_products_by_categoryId` (IN `categoryId` INT(11))  BEGIN
	SELECT idProduct, productName, productBrand, productPrice, productImg, categoryName 
    from tproduct 
    INNER JOIN tcategory 
    ON tproduct.productCategory = tcategory.idCategory 
    WHERE tcategory.idCategory = categoryId  ORDER BY tproduct.idProduct DESC;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_product_by_id` (IN `productId` INT(11))  NO SQL
BEGIN 
  SELECT * FROM tproduct WHERE idProduct = productId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sales_from_user` (IN `idUser` CHAR(36))  NO SQL
BEGIN 
  SELECT tsale.idSale, tsale.timestamp, tsale.total
  FROM `tsale`   
  WHERE tsale.idUser = idUser
  ORDER BY tsale.time DESC
  LIMIT 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sale_by_id` (IN `idSale` CHAR(36), IN `idUser` CHAR(36))  NO SQL
BEGIN 
  SELECT tsale.idSale, tsale.timestamp, tsale.total
  FROM `tsale`   
  WHERE tsale.idUser = idUser and tsale.idSale = idSale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sale_products_resume` (IN `idSale` CHAR(36))  NO SQL
BEGIN 
  SELECT tproduct.productName, tproduct.productPrice, tproduct.productImg
  FROM `tdetailedsale` 
  inner join tsale on tsale.idSale = tdetailedsale.idSale 
  INNER join tproduct on tdetailedsale.idProduct = tproduct.idProduct  
  WHERE tsale.idSale = idSale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sold_times` ()  NO SQL
BEGIN 
  SELECT COUNT(idSale)as timesSold
  FROM `tsale`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_products` ()  NO SQL
BEGIN 
  SELECT COUNT(idProduct) as totalProducts
  FROM `tproduct`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_products_per_sale` (IN `idSale` CHAR(36))  NO SQL
BEGIN 
  SELECT count(tdetailedsale.idDetailedSale) as totalProducts
  FROM `tdetailedsale`  
  WHERE tdetailedsale.idSale = idSale
  GROUP BY tdetailedsale.idSale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_sales` ()  NO SQL
BEGIN 
  SELECT SUM(tsale.total) as total
  FROM `tsale`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_users` ()  NO SQL
BEGIN 
  SELECT COUNT(iduser) as totalUsers
  FROM `tuser`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_user` (IN `email` VARCHAR(200), IN `password` VARCHAR(500))  NO SQL
BEGIN 
  SELECT tuser.idUser, tuser.name, tuser.email,tuser.gender, tuser.userRole as role from tuser WHERE tuser.email = email and tuser.password = password;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tcategory`
--

CREATE TABLE `tcategory` (
  `idCategory` int(2) NOT NULL,
  `categoryName` varchar(500) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tcategory`
--

INSERT INTO `tcategory` (`idCategory`, `categoryName`, `categoryDescription`) VALUES
(1, 'Cardistry', 'Las barajas enfocadas a cardistry son barajas prémium, con acabados impresionantes para que cualquier show de se vea simplemente impresionante. Son livianas y no se recomiendan para practicar lanzamientos.'),
(2, 'Throwable cards', 'Las cartas que tienen el objetivo de ser lanzadas, son cartas duras, pero finas, con la capacidad de penetrar cualquier objeto sin importar su dureza. Perfectas para practicar lanzamiento de cartas.'),
(3, 'Poker', 'Cartas enfocadas al juego, disfruta de una tarde de poker con las barajas mas premium.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tdetailedsale`
--

CREATE TABLE `tdetailedsale` (
  `idDetailedSale` char(36) NOT NULL DEFAULT uuid(),
  `idSale` char(36) NOT NULL,
  `idProduct` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tdetailedsale`
--

INSERT INTO `tdetailedsale` (`idDetailedSale`, `idSale`, `idProduct`) VALUES
('31d4918e-c6e9-11eb-8ad0-48ba4e4ee5de', '31d39025-c6e9-11eb-8ad0-48ba4e4ee5de', 16),
('33570505-c550-11eb-b9af-48ba4e4ee5de', '3352821e-c550-11eb-b9af-48ba4e4ee5de', 15),
('33577f19-c550-11eb-b9af-48ba4e4ee5de', '3352821e-c550-11eb-b9af-48ba4e4ee5de', 14),
('3357dcc9-c550-11eb-b9af-48ba4e4ee5de', '3352821e-c550-11eb-b9af-48ba4e4ee5de', 16),
('35f2bad9-c714-11eb-8ad0-48ba4e4ee5de', '35f1acc4-c714-11eb-8ad0-48ba4e4ee5de', 12),
('35f68874-c714-11eb-8ad0-48ba4e4ee5de', '35f1acc4-c714-11eb-8ad0-48ba4e4ee5de', 11),
('35f7855e-c714-11eb-8ad0-48ba4e4ee5de', '35f1acc4-c714-11eb-8ad0-48ba4e4ee5de', 2),
('37bb02b6-c550-11eb-b9af-48ba4e4ee5de', '37ba7ef3-c550-11eb-b9af-48ba4e4ee5de', 16),
('37bb67d1-c550-11eb-b9af-48ba4e4ee5de', '37ba7ef3-c550-11eb-b9af-48ba4e4ee5de', 13),
('38d741c5-c6e9-11eb-8ad0-48ba4e4ee5de', '38d6cd7c-c6e9-11eb-8ad0-48ba4e4ee5de', 16),
('38daa5a0-c6e9-11eb-8ad0-48ba4e4ee5de', '38d6cd7c-c6e9-11eb-8ad0-48ba4e4ee5de', 15),
('3f0b8cf7-c714-11eb-8ad0-48ba4e4ee5de', '3f0b0053-c714-11eb-8ad0-48ba4e4ee5de', 11),
('3f0f49dd-c714-11eb-8ad0-48ba4e4ee5de', '3f0b0053-c714-11eb-8ad0-48ba4e4ee5de', 12),
('49ca5e24-c714-11eb-8ad0-48ba4e4ee5de', '49c83880-c714-11eb-8ad0-48ba4e4ee5de', 11),
('4f9d3fe2-c58b-11eb-862e-48ba4e4ee5de', '4f9c44a9-c58b-11eb-862e-48ba4e4ee5de', 15),
('4fa183f2-c58b-11eb-862e-48ba4e4ee5de', '4f9c44a9-c58b-11eb-862e-48ba4e4ee5de', 14),
('4fa3db29-c58b-11eb-862e-48ba4e4ee5de', '4f9c44a9-c58b-11eb-862e-48ba4e4ee5de', 12),
('56834210-c54e-11eb-b9af-48ba4e4ee5de', '5682f0e7-c54e-11eb-b9af-48ba4e4ee5de', 15),
('5687316f-c54e-11eb-b9af-48ba4e4ee5de', '5682f0e7-c54e-11eb-b9af-48ba4e4ee5de', 14),
('59edb71d-c54e-11eb-b9af-48ba4e4ee5de', '59ea7550-c54e-11eb-b9af-48ba4e4ee5de', 16),
('5d5312cf-c58b-11eb-862e-48ba4e4ee5de', '5d50bc37-c58b-11eb-862e-48ba4e4ee5de', 16),
('5d538ab0-c58b-11eb-862e-48ba4e4ee5de', '5d50bc37-c58b-11eb-862e-48ba4e4ee5de', 15),
('5d53e487-c58b-11eb-862e-48ba4e4ee5de', '5d50bc37-c58b-11eb-862e-48ba4e4ee5de', 14),
('5d57d483-c58b-11eb-862e-48ba4e4ee5de', '5d50bc37-c58b-11eb-862e-48ba4e4ee5de', 13),
('5d59b195-c54e-11eb-b9af-48ba4e4ee5de', '5d556eb6-c54e-11eb-b9af-48ba4e4ee5de', 16),
('5d5a0a0d-c58b-11eb-862e-48ba4e4ee5de', '5d50bc37-c58b-11eb-862e-48ba4e4ee5de', 9),
('cdd013ae-c714-11eb-8ad0-48ba4e4ee5de', 'cdcdac47-c714-11eb-8ad0-48ba4e4ee5de', 8),
('cdd08514-c714-11eb-8ad0-48ba4e4ee5de', 'cdcdac47-c714-11eb-8ad0-48ba4e4ee5de', 12),
('d4e8c4f3-c714-11eb-8ad0-48ba4e4ee5de', 'd4e83f39-c714-11eb-8ad0-48ba4e4ee5de', 12),
('d69a42a5-c550-11eb-b9af-48ba4e4ee5de', 'd699608d-c550-11eb-b9af-48ba4e4ee5de', 14),
('d69c480b-c550-11eb-b9af-48ba4e4ee5de', 'd699608d-c550-11eb-b9af-48ba4e4ee5de', 15),
('d69e8bbb-c550-11eb-b9af-48ba4e4ee5de', 'd699608d-c550-11eb-b9af-48ba4e4ee5de', 16),
('e6dbba2c-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 11),
('e6dc107f-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 8),
('e6dc5bc7-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 10),
('e6dca3d3-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 6),
('e6dcf511-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 3),
('e6e11682-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 7),
('e6e18d42-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 1),
('e6e59a35-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 2),
('e6e80c30-c714-11eb-8ad0-48ba4e4ee5de', 'e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', 4),
('eaa978dc-c714-11eb-8ad0-48ba4e4ee5de', 'eaa4c301-c714-11eb-8ad0-48ba4e4ee5de', 11),
('f4e1f620-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 16),
('f4e61b25-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 15),
('f4e692a9-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 14),
('f4e70052-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 13),
('f4e758a4-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 12),
('f4e7b230-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 11),
('f4e8140e-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 10),
('f4e8677a-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 9),
('f4e8c032-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 8),
('f4e9151f-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 7),
('f4e9574e-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 6),
('f4e99d14-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 5),
('f4e9e17b-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 3),
('f4ed23e3-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 2),
('f4ed7972-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 1),
('f4edc406-c54f-11eb-b9af-48ba4e4ee5de', 'f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', 4);

--
-- Disparadores `tdetailedsale`
--
DELIMITER $$
CREATE TRIGGER `addTimesSold` BEFORE INSERT ON `tdetailedsale` FOR EACH ROW BEGIN
    UPDATE tproduct SET tproduct.timesSold = tproduct.timesSold + 1 WHERE tproduct.idProduct = NEW.idProduct;
  END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tproduct`
--

CREATE TABLE `tproduct` (
  `idProduct` int(11) NOT NULL,
  `productName` varchar(100) NOT NULL,
  `productBrand` varchar(100) NOT NULL,
  `productPrice` int(8) NOT NULL,
  `productImg` varchar(600) NOT NULL,
  `quantity` int(5) NOT NULL,
  `productCategory` int(2) DEFAULT NULL,
  `timesSold` int(6) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tproduct`
--

INSERT INTO `tproduct` (`idProduct`, `productName`, `productBrand`, `productPrice`, `productImg`, `quantity`, `productCategory`, `timesSold`) VALUES
(1, '007 Cardistry', 'Theory11', 450900, 'https://i.ibb.co/QDvN8hJ/jamesbond.png', 1, 1, 1),
(2, 'SolarMatrix', 'Bierdof', 178900, 'https://images-na.ssl-images-amazon.com/images/I/41Bl6PTLPWL.jpg', 1, 1, 2),
(3, 'Cardistry Green Edition', 'Biclycle', 190900, 'https://images.unsplash.com/photo-1562766879-ce73e9394f94?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=820&q=80', 1, 1, 1),
(4, 'Citizens Premium Edition', 'Pluribus & Unum', 322900, 'https://images.unsplash.com/photo-1615229337219-52fa96d6e9f9?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80', 1, 2, 1),
(5, 'Banshees', 'Banshees', 459900, 'https://images-na.ssl-images-amazon.com/images/I/51GF3Q2d4kL._AC_SX466_.jpg', 1, 2, 0),
(6, 'Bicycle Guardians - Black Edition', 'Bicycle', 90900, 'https://images.unsplash.com/photo-1577137026054-be825cb4b0c6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1574&q=80', 1, 3, 1),
(7, 'Hudson Premium Deck', 'Hudson', 390000, 'https://images.unsplash.com/photo-1559323516-be2f83ce450b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1317&q=80', 1, 3, 1),
(8, 'Monarchs Black Edition', 'Theory11', 192900, 'https://images.unsplash.com/photo-1530405018134-136fa7826184?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=700&q=80', 1, 3, 2),
(9, 'Violet Luna Moon', '52 Kards', 172900, 'https://cdn.shopify.com/s/files/1/0956/5418/products/63817-alt1_1024x1024.png?v=1557292165', 1, 3, 0),
(10, 'Stargazer new moon', 'Bicycle', 99900, 'https://pbs.twimg.com/media/EhedHzzX0AAFyvy.jpg:large', 1, 3, 1),
(11, 'Memento Mori', 'Chris ramsay', 139000, 'https://images-na.ssl-images-amazon.com/images/I/61KlUKF1tWL._AC_SL1125_.jpg', 1, 1, 5),
(12, 'Neon Cardistry Deck', 'Bicycle', 190000, 'https://spielkartenshop.com/media/image/product/2912/lg/bicycle-neon-cardistry-playing-cards.jpg', 1, 1, 4),
(13, 'Mandalorian Deck', 'Theory11', 56000, 'https://www.mundomagos.com/wp-content/uploads/2021/05/Baraja-Mandalorian.jpg', 1, 2, 0),
(14, 'Hops & Barley', 'Jocu', 145000, 'https://jocu.cards/wp-content/uploads/2020/10/IMG_9850.jpg', 1, 3, 0),
(15, 'Paperwave Venomous Edition', '52 Kards', 123500, 'https://spielkartenshop.com/media/image/product/5308/lg/paperwave-venomous-edition-playing-cards.jpg', 1, 1, 1),
(16, 'MINT 2', '52 Kards', 92900, 'https://cdn.shopify.com/s/files/1/0956/5418/products/Cucumber-Mint-full_1024x1024._1024x1024.jpg?v=1613787152', 10, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tsale`
--

CREATE TABLE `tsale` (
  `idSale` char(36) NOT NULL DEFAULT uuid(),
  `timestamp` date NOT NULL DEFAULT current_timestamp(),
  `total` int(10) NOT NULL,
  `idUser` char(36) NOT NULL,
  `time` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tsale`
--

INSERT INTO `tsale` (`idSale`, `timestamp`, `total`, `idUser`, `time`) VALUES
('31d39025-c6e9-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 92900, 'ac6f52b2-c3f6-11eb-b4f5-48ba4e4ee5de', '2021-06-06 12:04:03'),
('3352821e-c550-11eb-b9af-48ba4e4ee5de', '2021-06-04', 361400, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:16:21'),
('35f1acc4-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 507900, 'f1627be3-c713-11eb-8ad0-48ba4e4ee5de', '2021-06-06 17:12:00'),
('37ba7ef3-c550-11eb-b9af-48ba4e4ee5de', '2021-06-04', 148900, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:16:28'),
('38d6cd7c-c6e9-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 216400, 'ac6f52b2-c3f6-11eb-b4f5-48ba4e4ee5de', '2021-06-06 12:04:14'),
('3f0b0053-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 329000, 'f1627be3-c713-11eb-8ad0-48ba4e4ee5de', '2021-06-06 17:12:15'),
('49c83880-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 139000, 'f1627be3-c713-11eb-8ad0-48ba4e4ee5de', '2021-06-06 17:12:33'),
('4f9c44a9-c58b-11eb-862e-48ba4e4ee5de', '2021-06-04', 458500, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 18:19:29'),
('5682f0e7-c54e-11eb-b9af-48ba4e4ee5de', '2021-06-04', 268500, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:03:01'),
('59ea7550-c54e-11eb-b9af-48ba4e4ee5de', '2021-06-04', 92900, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:03:07'),
('5d50bc37-c58b-11eb-862e-48ba4e4ee5de', '2021-06-04', 590300, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 18:19:52'),
('5d556eb6-c54e-11eb-b9af-48ba4e4ee5de', '2021-06-04', 92900, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:03:12'),
('cdcdac47-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 382900, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-06 17:16:14'),
('d4e83f39-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 190000, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-06 17:16:26'),
('d699608d-c550-11eb-b9af-48ba4e4ee5de', '2021-06-04', 361400, 'c1a54825-c3f6-11eb-b4f5-48ba4e4ee5de', '2021-06-04 11:20:55'),
('e6db2f60-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 2056300, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-06 17:16:56'),
('eaa4c301-c714-11eb-8ad0-48ba4e4ee5de', '2021-06-06', 139000, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-06 17:17:03'),
('f4e199d0-c54f-11eb-b9af-48ba4e4ee5de', '2021-06-04', 3296500, 'a443cecc-c542-11eb-b9af-48ba4e4ee5de', '2021-06-04 11:14:36');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tuser`
--

CREATE TABLE `tuser` (
  `idUser` char(36) NOT NULL DEFAULT uuid(),
  `name` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `userRole` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tuser`
--

INSERT INTO `tuser` (`idUser`, `name`, `gender`, `email`, `password`, `userRole`) VALUES
('a443cecc-c542-11eb-b9af-48ba4e4ee5de', 'Julian Medrano', 0, 'juli@gmail.com', 'd3190b35eb1bbdf9c70bff4679cf21d86e7ec650', 0),
('ac6f52b2-c3f6-11eb-b4f5-48ba4e4ee5de', 'Sebastian Villegas', 0, 'sebasvil20@gmail.com', 'd3190b35eb1bbdf9c70bff4679cf21d86e7ec650', 1),
('c1a54825-c3f6-11eb-b4f5-48ba4e4ee5de', 'Alejandra Montoya', 1, 'user@user.com', 'd3190b35eb1bbdf9c70bff4679cf21d86e7ec650', 0),
('f1627be3-c713-11eb-8ad0-48ba4e4ee5de', 'Nancy Elena', 1, 'nancy@gmail.com', 'd3190b35eb1bbdf9c70bff4679cf21d86e7ec650', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `tcategory`
--
ALTER TABLE `tcategory`
  ADD PRIMARY KEY (`idCategory`);

--
-- Indices de la tabla `tdetailedsale`
--
ALTER TABLE `tdetailedsale`
  ADD PRIMARY KEY (`idDetailedSale`),
  ADD KEY `idProduct` (`idProduct`),
  ADD KEY `idSale` (`idSale`);

--
-- Indices de la tabla `tproduct`
--
ALTER TABLE `tproduct`
  ADD PRIMARY KEY (`idProduct`),
  ADD KEY `productCategory` (`productCategory`);

--
-- Indices de la tabla `tsale`
--
ALTER TABLE `tsale`
  ADD PRIMARY KEY (`idSale`),
  ADD KEY `idUser` (`idUser`);

--
-- Indices de la tabla `tuser`
--
ALTER TABLE `tuser`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `tcategory`
--
ALTER TABLE `tcategory`
  MODIFY `idCategory` int(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `tproduct`
--
ALTER TABLE `tproduct`
  MODIFY `idProduct` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `tdetailedsale`
--
ALTER TABLE `tdetailedsale`
  ADD CONSTRAINT `tdetailedsale_ibfk_1` FOREIGN KEY (`idProduct`) REFERENCES `tproduct` (`idProduct`),
  ADD CONSTRAINT `tdetailedsale_ibfk_2` FOREIGN KEY (`idSale`) REFERENCES `tsale` (`idSale`);

--
-- Filtros para la tabla `tproduct`
--
ALTER TABLE `tproduct`
  ADD CONSTRAINT `tproduct_ibfk_1` FOREIGN KEY (`productCategory`) REFERENCES `tcategory` (`idCategory`);

--
-- Filtros para la tabla `tsale`
--
ALTER TABLE `tsale`
  ADD CONSTRAINT `tsale_ibfk_1` FOREIGN KEY (`idUser`) REFERENCES `tuser` (`idUser`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
