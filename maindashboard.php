<?php
    require_once 'utils/connection.php';

    //Verificaciones iniciales
    if(!isset($_SESSION)){
        session_start();
    }

    //Para poder ver el dashboard principal, necesitamos que sea 
    //administrador, por lo tanto, verificamos si 
    //la variable de sesión esta inicializada o si el usuario es 
    //administrador
    if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1){
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
    <link rel="stylesheet" href="styles/dashboard.css">
    <title>Deckstore | Dashboard</title>
</head>
<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php 
        include_once 'components/header.php'; 
        include_once 'components/infoCard.php';
        include_once 'controllers/removeProductController.php';
    ?>
    <div class="main-container">
        <h1 class="title">¡Hola, <?php echo explode(" ", $_SESSION['User']['name'])[0] ?>!</h1>
        <h2 class="subtitle">Bienvenido al dashboard principal</h2>
        <!-- Card para mostrar cantidad de ventas, total ventas, usuarios y cantidad de productos -->
        <div class="info-card-container">
            <?php 

                // Obtenemos los datos de importancia de la base de datos (Ultimas ventas, total ventas, producto mas vendido, etc)

                $connection = connectToDatabase();
                $totalSales = mysqli_fetch_object($connection -> query("CALL get_total_sales()")) -> total;
                $connection -> close();

                $connection = connectToDatabase();
                $timesSold = mysqli_fetch_object($connection -> query("CALL get_sold_times()")) -> timesSold;
                $connection -> close();

                $connection = connectToDatabase();
                $totalProducts = mysqli_fetch_object($connection -> query("CALL get_total_products()")) -> totalProducts;
                $connection -> close();

                $connection = connectToDatabase();
                $totalUsers = mysqli_fetch_object($connection -> query("CALL get_total_users()")) -> totalUsers;
                $connection -> close();

                //Mostramos la información reutilizando el componente createInfoCard

                createInfoCard(
                    $totalSales, 
                    "Total ventas", 
                    "M6 23.73l-3-2.122v-14.2l3 1.359v14.963zm2-14.855v15.125l13-1.954v-15.046l-13 1.875zm5.963-7.875c-2.097 0-3.958 2.005-3.962 4.266l-.001 1.683c0 .305.273.54.575.494.244-.037.425-.247.425-.494v-1.681c.003-1.71 1.416-3.268 2.963-3.268.537 0 1.016.195 1.384.564.422.423.654 1.035.653 1.727v1.747c0 .305.273.54.575.494.243-.037.423-.246.423-.492l.002-1.749c.002-1.904-1.32-3.291-3.037-3.291zm-6.39 5.995c.245-.037.427-.247.427-.495v-2.232c.002-1.71 1.416-3.268 2.963-3.268l.162.015c.366-.283.765-.513 1.188-.683-.405-.207-.858-.332-1.35-.332-2.096 0-3.958 2.005-3.962 4.266v2.235c0 .306.272.538.572.494z",
                    true
                ); 
                
                createInfoCard(
                    $timesSold, 
                    "Ventas", 
                    "M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm9.805-16.5l-3.432 12h-2.102l2.541-9h-5.993c.115.482.181.983.181 1.5 0 3.59-2.91 6.5-6.5 6.5-.407 0-.805-.042-1.191-.114l1.306 3.114h13.239l3.474-12h1.929l.743-2h-4.195zm-6.305 15c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm-9-15c-2.486 0-4.5 2.015-4.5 4.5s2.014 4.5 4.5 4.5c2.484 0 4.5-2.015 4.5-4.5s-2.016-4.5-4.5-4.5zm-.469 6.484l-1.687-1.636.695-.697.992.94 2.115-2.169.697.696-2.812 2.866z"
                ); 
                
                createInfoCard(
                    $totalUsers, 
                    "Usuarios", 
                    "M10.118 16.064c2.293-.529 4.428-.993 3.394-2.945-3.146-5.942-.834-9.119 2.488-9.119 3.388 0 5.644 3.299 2.488 9.119-1.065 1.964 1.149 2.427 3.394 2.945 1.986.459 2.118 1.43 2.118 3.111l-.003.825h-15.994c0-2.196-.176-3.407 2.115-3.936zm-10.116 3.936h6.001c-.028-6.542 2.995-3.697 2.995-8.901 0-2.009-1.311-3.099-2.998-3.099-2.492 0-4.226 2.383-1.866 6.839.775 1.464-.825 1.812-2.545 2.209-1.49.344-1.589 1.072-1.589 2.333l.002.619z"
                ); 

                createInfoCard(
                    $totalProducts, 
                    "Productos", 
                    "M7 16.462l1.526-.723c1.792-.81 2.851-.344 4.349.232 1.716.661 2.365.883 3.077 1.164 1.278.506.688 2.177-.592 1.838-.778-.206-2.812-.795-3.38-.931-.64-.154-.93.602-.323.818 1.106.393 2.663.79 3.494 1.007.831.218 1.295-.145 1.881-.611.906-.72 2.968-2.909 2.968-2.909.842-.799 1.991-.135 1.991.72 0 .23-.083.474-.276.707-2.328 2.793-3.06 3.642-4.568 5.226-.623.655-1.342.974-2.204.974-.442 0-.922-.084-1.443-.25-1.825-.581-4.172-1.313-6.5-1.6v-5.662zm-1 6.538h-4v-8h4v8zm15-11.497l-6.5 3.468v-7.215l6.5-3.345v7.092zm-7.5-3.771v7.216l-6.458-3.445v-7.133l6.458 3.362zm-3.408-5.589l6.526 3.398-2.596 1.336-6.451-3.359 2.521-1.375zm10.381 1.415l-2.766 1.423-6.558-3.415 2.872-1.566 6.452 3.558z"
                ); 
            ?>
        </div>

        <div class="most-time-sold">
            <h1 class="most-time-sold-title">Producto mas vendido</h1>
            <div class="product-text">
                <?php
                    $connection = connectToDatabase();
                    $productInfo = mysqli_fetch_object($connection -> query("CALL get_best_selling_product()"));
                    $connection -> close();
                ?>
                <h1 class="product-title">
                    <?php echo $productInfo -> productName ?>
                </h1>
                <h3 class="product-brand">
                    <?php echo $productInfo -> productBrand ?>
                </h3>
                <h3 class="product-brand">
                    Veces vendido: <?php echo $productInfo -> timesSold ?>
                </h3>
                <h4 class="product-price">
                    $ <?php echo number_format($productInfo -> productPrice) ?> COP
                </h4>
            </div>
            <div class="product-img">
                <img src="<?php echo $productInfo -> productImg ?>" alt="">
            </div>
        </div>

    <div class="productList">
        <h1 class="list-title">Lista de productos</h1>
        <?php
            include 'components/productCardDashboard.php';

            //Listamos los productos

            $connection = connectToDatabase();
                $productInfo = $connection -> query("CALL get_all_products()");
                if($productInfo){
                    while($row = mysqli_fetch_object($productInfo)){
                        createProductCard($row -> idProduct, $row -> productName, $row -> productPrice, $row -> productBrand, $row -> productImg, $row -> categoryName);
                    }
                }
            $connection -> close();
        ?>
    </div>
    </div>
    
    <?php include_once 'components/footer.php' ?>
</body>
</html>