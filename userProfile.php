<?php
    require_once 'utils/connection.php';



    //Verificaciones iniciales
    if(!isset($_SESSION)){
        session_start();
    }

    //Si el usuario oprime el boton de cerrar sesión
    //la sesión se destruye y se redirige a login.php
    if(isset($_POST['logout'])){
        session_destroy();
        header('Location: login.php');
    }

    //Si la variable de sesion 'usuario' no está
    //declarada, significa que el usuario no ha iniciado
    //sesión, por lo tanto lo redirigimos al login.php
    if(!isset($_SESSION['User'])){
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
    <link rel="stylesheet" href="styles/userProfile.css">
    <title>Deckstore | User Profile</title>
</head>
<body>
    <?php 
        include_once 'components/header.php';
        include_once 'components/saleCard.php'; 
    ?>
    <div class="section">
        <div class="container">
            
            <!-- 
                Obtenemos los datos del usuario de la variable de sesión usuario
                Esta variable de sesión se inicializa cuando se inicia sesión
             -->

            <img src="<?php echo $_SESSION['User']['gender'] == 0 ? "https://i.ibb.co/pLxVZz5/mavatar.png" : "https://i.ibb.co/PgZ7MRn/Avatar.png"?>" alt="">                
            <h2 class="profileTitles">Nombre: <span> <?php echo $_SESSION['User']['name'] ?> </span></h2>
            <h2 class="profileTitles">Email: <span><?php echo $_SESSION['User']['email'] ?></span></h2>
            <h3 class="profileTitles h3Title">Rol: <span><?php echo ($_SESSION['User']['role'] == 1 ? "Administrador" : "Usuario") ?></span></h3>
            <form action="#" method="POST">
                <button class="logout" type="submit" name="logout"> Cerrar Sesión </button>
            </form>
        </div>
        <?php
            //Obtenemos las ventas del usuario
            $idUSer = $_SESSION['User']['idUser'];
            $connection = connectToDatabase();
            $allSales = $connection -> query("CALL get_sales_from_user('$idUSer')");
            $connection -> close();

            if($allSales -> num_rows > 0){
                ?>
                    <div class="right-container">
                        <h2>Tus últimas compras</h2>
                        <?php
                            while($row = mysqli_fetch_object($allSales)){
                                $connection = connectToDatabase();
                                $totalProducts = $connection -> query("CALL get_total_products_per_sale('".$row -> idSale."')");
                                $connection -> close();
                                if($totalProducts -> num_rows > 0){
                                    createSaleCard($row -> idSale, $_SESSION['User']['name'][0], mysqli_fetch_object($totalProducts) -> totalProducts, $row -> timestamp, $row -> total);
                                }
                                else{
                                    echo $row -> idSale;
                                    echo "   <br>         Esta causando problemas";
                                }
                            }
                        ?>
                    </div>
                <?php
            }
        ?>
        
    </div>

    <?php include_once 'components/footer.php' ?>
    
</body>
</html>