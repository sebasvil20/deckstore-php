
<?php
    require_once 'utils/connection.php';
    require_once 'utils/removeProductFromCart.php';
    require 'components/cartCard.php';
    
    if(!isset($_SESSION)){
        session_start();
    }
    
    if(isset($_POST['removeProduct'])){
        removeProduct();
    }

    if(!isset($_SESSION['User'])){
        header('Location: login.php');
    }

    if(!isset($_SESSION['cart'])){
        header('Location: index.php');
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
    <title>Deckstore | Finalizar compra</title>
</head>
<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php 
        include_once 'components/header.php';
        require_once 'controllers/fakeBuyController.php';
    ?>
    <div class="detailedCartContainer">
        <?php
            if(!isset($_POST['fakeBuy'])){
                ?>
                    <h1 class="cartTitle">Termina tu compra</h1>
                    <?php
                        $idProducts = array_column($_SESSION['cart'], 'idProduct');
                        $_SESSION['totalCart'] = 0;
            
                        foreach($idProducts as $singleProductID){
                            $connection = connectToDatabase();
                            $productInfo = $connection -> query("CALL get_product_by_id($singleProductID)");
                            if($productInfo){
                                while($row = mysqli_fetch_object($productInfo)){
                                    createCartElement($row -> productName, $row -> productPrice, $row -> productImg, $singleProductID);
                                    $_SESSION['totalCart'] += $row -> productPrice;
                                }
                            }
                            $connection -> close();
                        };
                        echo "<h3 class='total'>Total: " . number_format( $_SESSION['totalCart']) . " COP </h3>";
                    ?>  
                    <form action="" method="post">
                        <button class='cartEndSaleButton' type="submit" name="fakeBuy"> Finalizar Compra &#x2192; </button>
                    </form>
                <?php
            }
            else{

                ?>
                    <h1 class="cartTitle">😉 Gracias por su compra, resumen de su compra:</h1>
                <?php
                $idProducts = array_column($_SESSION['cart'], 'idProduct');
            
                foreach($idProducts as $singleProductID){
                    $connection = connectToDatabase();
                    $productInfo = $connection -> query("CALL get_product_by_id($singleProductID)");
                    if($productInfo){
                        while($row = mysqli_fetch_object($productInfo)){
                            createCartElement($row -> productName, $row -> productPrice, $row -> productImg, $singleProductID, false);
                        }
                    }
                    $connection -> close();
                };
                echo "<h3 class='total'>Total: " . number_format( $_SESSION['totalCart']) . " COP </h3>";
                ?>
                    <a href="index.php" class="home-link">&#8592; Volver al inicio</a>
                <?php
                unset($_SESSION["cart"]);
                unset($_SESSION["totalCart"]);
                unset($_POST['fakeBuy']);
            }
        ?>
    </div>
    <?php include_once 'components/footer.php' ?>
</body>
</html>