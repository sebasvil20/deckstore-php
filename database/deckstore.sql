SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `deckstore`
--
-- --------------------------------------------------------
--
-- Estructura de tabla para la tabla `tcategory`
--

CREATE TABLE `tcategory` (
  `idCategory` int(2) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `categoryName` varchar(500) NOT NULL,
  `categoryDescription` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tcategory`
--

INSERT INTO `tcategory` (`categoryName`, `categoryDescription`) VALUES
('Cardistry', 'Las barajas enfocadas a cardistry son barajas prémium, con acabados impresionantes para que cualquier show de se vea simplemente impresionante. Son livianas y no se recomiendan para practicar lanzamientos.'),
('Throwable cards', 'Las cartas que tienen el objetivo de ser lanzadas, son cartas duras, pero finas, con la capacidad de penetrar cualquier objeto sin importar su dureza. Perfectas para practicar lanzamiento de cartas.'),
('Poker', 'Cartas enfocadas al juego, disfruta de una tarde de poker con las barajas mas premium.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tproduct`
--

CREATE TABLE `tproduct` (
  `idProduct` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `productBrand` varchar(100) NOT NULL,
  `productPrice` int(8) NOT NULL,
  `productImg` varchar(600) NOT NULL,
  `quantity` int(5) NOT NULL,
  `timesSold` int(6) NOT NULL DEFAULT 0,
  `productCategory` int(2) DEFAULT NULL,
  FOREIGN KEY (`productCategory`) REFERENCES `tcategory` (`idCategory`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tproduct`
--

INSERT INTO `tproduct` (`productName`, `productBrand`, `productPrice`, `productImg`, `quantity`, `productCategory`) VALUES
('007 Cardistry', 'Theory11', 450900, 'https://i.ibb.co/QDvN8hJ/jamesbond.png', 1, 1),
('SolarMatrix', 'Bierdof', 178900, 'https://images-na.ssl-images-amazon.com/images/I/41Bl6PTLPWL.jpg', 1, 1),
('Cardistry Green Edition', 'Biclycle', 190900, 'https://images.unsplash.com/photo-1562766879-ce73e9394f94?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=820&q=80', 1, 1),
('Citizens Premium Edition', 'Pluribus & Unum', 322900, 'https://images.unsplash.com/photo-1615229337219-52fa96d6e9f9?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=700&q=80', 1, 2),
('Banshees', 'Banshees', 459900, 'https://images-na.ssl-images-amazon.com/images/I/51GF3Q2d4kL._AC_SX466_.jpg', 1, 2),
('Bicycle Guardians - Black Edition', 'Bicycle', 90900, 'https://images.unsplash.com/photo-1577137026054-be825cb4b0c6?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1574&q=80', 1, 3),
('Hudson Premium Deck', 'Hudson', 390000, 'https://images.unsplash.com/photo-1559323516-be2f83ce450b?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1317&q=80', 1, 3),
('Monarchs Black Edition', 'Theory11', 192900, 'https://images.unsplash.com/photo-1530405018134-136fa7826184?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=700&q=80', 1, 3),
('Violet Luna Moon', '52 Kards', 172900, 'https://cdn.shopify.com/s/files/1/0956/5418/products/63817-alt1_1024x1024.png?v=1557292165', 1, 3),
('Stargazer new moon', 'Bicycle', 99900, 'https://pbs.twimg.com/media/EhedHzzX0AAFyvy.jpg:large', 1, 3),
('Memento Mori', 'Chris ramsay', 139000, 'https://images-na.ssl-images-amazon.com/images/I/61KlUKF1tWL._AC_SL1125_.jpg', 1, 1),
('Neon Cardistry Deck', 'Bicycle', 190000, 'https://spielkartenshop.com/media/image/product/2912/lg/bicycle-neon-cardistry-playing-cards.jpg', 1, 1),
('Mandalorian Deck', 'Theory11', 56000, 'https://www.mundomagos.com/wp-content/uploads/2021/05/Baraja-Mandalorian.jpg', 1, 2),
('Hops & Barley', 'Jocu', 145000, 'https://jocu.cards/wp-content/uploads/2020/10/IMG_9850.jpg', 1, 3),
('Paperwave Venomous Edition', '52 Kards', 123500, 'https://spielkartenshop.com/media/image/product/5308/lg/paperwave-venomous-edition-playing-cards.jpg', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tuser`
--

CREATE TABLE `tsale` (
  `idSale` char(36) NOT NULL PRIMARY KEY DEFAULT uuid(),
  `timestamp` date NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `total` int(10) NOT NULL,
  `idUser` char(36) NOT NULL,
  FOREIGN KEY (`idUser`) REFERENCES `tuser` (`idUser`)
);

CREATE TABLE `tdetailedsale`(
  `idDetailedSale` char(36) NOT NULL PRIMARY KEY DEFAULT uuid(),
  `idSale` char(36) NOT NULL,
  `idProduct` int(11) NOT NULL,
  FOREIGN KEY (`idProduct`) REFERENCES `tproduct` (`idProduct`),
  FOREIGN KEY (`idSale`) REFERENCES `tsale` (`idSale`)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tuser`
--

CREATE TABLE `tuser` (
  `idUser` char(36) NOT NULL PRIMARY KEY DEFAULT uuid(),
  `name` varchar(50) NOT NULL,
  `gender` tinyint(1) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(500) NOT NULL,
  `userRole` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------


DELIMITER $$
-- --------------------------------------------------------
--
-- Procedimientos
--

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_products` ()  NO SQL
BEGIN 
  SELECT COUNT(idProduct) as totalProducts
  FROM `tproduct`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_users` ()  NO SQL
BEGIN 
  SELECT COUNT(iduser) as totalUsers
  FROM `tuser`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_sales` ()  NO SQL
BEGIN 
  SELECT SUM(tsale.total) as total
  FROM `tsale`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sold_times` ()  NO SQL
BEGIN 
  SELECT COUNT(idSale)
  FROM `tsale`;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_best_selling_product` ()  NO SQL
BEGIN 
  SELECT tproduct.productName, tproduct.productPrice, tproduct.productBrand, tproduct.productImg, tproduct.timesSold
  FROM `tproduct`
  ORDER BY timesSold DESC LIMIT 1;
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sale_by_id` (IN `idSale` char(36), IN `idUser` char(36))  NO SQL
BEGIN 
  SELECT tsale.idSale, tsale.timestamp, tsale.total
  FROM `tsale`   
  WHERE tsale.idUser = idUser and tsale.idSale = idSale;
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sales_from_user` (IN `idUser` char(36))  NO SQL
BEGIN 
  SELECT tsale.idSale, tsale.timestamp, tsale.total
  FROM `tsale`   
  WHERE tsale.idUser = idUser
  ORDER BY tsale.time DESC
  LIMIT 5;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_total_products_per_sale` (IN `idSale` char(36))  NO SQL
BEGIN 
  SELECT count(tdetailedsale.idDetailedSale) as totalProducts
  FROM `tdetailedsale`  
  WHERE tdetailedsale.idSale = idSale
  GROUP BY tdetailedsale.idSale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_sale_products_resume` (IN `idSale` char(36))  NO SQL
BEGIN 
  SELECT tproduct.productName, tproduct.productPrice, tproduct.productImg
  FROM `tdetailedsale` 
  inner join tsale on tsale.idSale = tdetailedsale.idSale 
  INNER join tproduct on tdetailedsale.idProduct = tproduct.idProduct  
  WHERE tsale.idSale = idSale;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_product` (IN `productName` VARCHAR(50), IN `productBrand` VARCHAR(100), IN `productPrice` INT(11), IN `productImg` VARCHAR(500), IN `quantity` int(5), IN `productCategory` INT(11))  NO SQL
BEGIN 
  INSERT INTO tproduct (productName, productBrand, productPrice, productImg, quantity, productCategory) 
  VALUES(productName, productBrand, productPrice, productImg, quantity, productCategory); 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_sale` (IN `total` int(10),`idUser` char(36))  NO SQL
BEGIN 
  INSERT INTO tsale (tsale.total, tsale.idUser) VALUES (total, idUser);
  SELECT tsale.idSale FROM tsale ORDER BY tsale.timestamp DESC LIMIT 1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_detailed_sale` (IN `idSale` char(36),`idProduct` int(11))  NO SQL
BEGIN 
  INSERT INTO tdetailedsale (idSale, idProduct) VALUES (idSale, idProduct);
END$$


CREATE DEFINER=`root`@`localhost` PROCEDURE `create_new_user` (IN `name` VARCHAR(50), IN `gender` tinyint(1), IN `email` VARCHAR(200), IN `password` VARCHAR(500),IN `userRole` tinyint(1))  NO SQL
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `login_user` (IN `email` VARCHAR(200), IN `password` VARCHAR(500))  NO SQL
BEGIN 
  SELECT tuser.idUser, tuser.name, tuser.email, tuser.userRole, tuser.gender as role from tuser WHERE tuser.email = email and tuser.password = password;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `get_product_by_id` (IN `productId` int(11))  NO SQL
BEGIN 
  SELECT * FROM tproduct WHERE idProduct = productId;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `add_new_category` (IN `categoryName` varchar(500), IN `categoryDesc` varchar(500))  NO SQL
BEGIN 
  INSERT INTO tcategory (categoryName, categoryDescription) VALUES (categoryName, categoryDesc);
END$$

DELIMITER ;

-- --------------------------------------------------------