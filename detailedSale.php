<?php
    require_once 'utils/connection.php';
    require 'components/cartCard.php';
    
    
    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['User']) || !isset($_GET['idSale'])){
        header('Location: login.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/detailedCart.css">
    <title>Document</title>
</head>
<body>    
    <?php 
        include_once 'components/header.php';
    ?>
    <!-- Obtener todos los productos get_sale_products_resume(idSale) -->
    <!-- Obtener datos de la compra get_sale_by_id(idSale, idUser)  -->
    <div class="detailedCartContainer">
        
        <?php
                $connection = connectToDatabase();
                $idSale = mysqli_real_escape_string($connection, $_GET['idSale']);
                $idUser = $_SESSION['User']['idUser'];
                $saleInfo = $connection -> query("CALL get_sale_by_id('$idSale', '$idUser')");
                $connection -> close();
                if($saleInfo -> num_rows > 0){
                    $saleInfo = $saleInfo -> fetch_assoc();
                    $date = date("F j, Y", strtotime($saleInfo['timestamp']));
                    $total = number_format($saleInfo['total']);
                    ?>
                        <h1 class="cartTitle">Compra realizada en: <?php echo $date ?> 😉</h1>
                    <?php

                    $connection = connectToDatabase();
                    $products = $connection -> query("CALL get_sale_products_resume('$idSale')");
                    $connection -> close();
                    while($row = mysqli_fetch_object($products)){
                        createCartElement($row -> productName, $row -> productPrice, $row -> productImg, "0", false);
                    }
                    ?>
                        <h3 class='total'>Total:  <?php echo $total ?>  COP </h3>
                    <?php
                }
                else{
                    ?>
                        <h1 class="cartTitle">No hemos encontrado esta compra, intenta con otra 😥</h1>
                    <?php
                }
        ?>
        <a href="userProfile.php" class="home-link">&#8592; Volver a tu perfil</a>
    </div>
    <?php include_once 'components/footer.php' ?>
    
</body>
</html>