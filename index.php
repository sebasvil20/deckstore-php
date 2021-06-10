<?php
    require_once 'utils/connection.php';
    require_once 'utils/removeProductFromCart.php';

    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_POST['removeProduct'])){
        removeProduct();
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
    <title>Deckstore</title>
</head>
<body>
    <?php 
        include_once 'components/header.php';
        include_once 'components/productCard.php';

        $sectionTitle = "Todos los productos";
        $getProductsQuery = "CALL get_all_products()";

        if(isset($_GET['categoryId'])){
            $connection = connectToDatabase();
            $categoryId = mysqli_real_escape_string($connection, $_GET['categoryId']);
            $getProductsQuery = "CALL get_products_by_categoryId($categoryId)";
            $categoryName = $connection -> query("CALL get_category_name($categoryId)");
            $connection -> close();
            if($categoryName -> num_rows > 0){
                $sectionTitle = "Productos de la categoría: " . mysqli_fetch_object($categoryName) -> categoryName;
            }
            else{
                $sectionTitle = "No hemos encontrado la categoría que estabas buscando 😥";
            }
        }
        
        if(isset($_POST['addProductToCart'])){
            if(isset($_SESSION['cart'])){
                $productID = $_POST['idProduct'];
                $item_array_id = array_column($_SESSION['cart'], "idProduct");
                if(!in_array($productID, $item_array_id)){
                    $item_array = array('idProduct' => $productID);
                    array_push($_SESSION['cart'], $item_array);
                }
            }
            else{
                $productID = $_POST['idProduct'];
                $item_array = array('idProduct' => $productID);
                $_SESSION['cart'][0] = $item_array;
            }
        }
    ?>

    <h1 class="product-section-title">
        <?php echo $sectionTitle; ?>
    </h1>
    <div class="card-container">
        <?php
            $connection = connectToDatabase();
            $productsRows = $connection -> query($getProductsQuery);
            $connection -> close();
            if($productsRows -> num_rows > 0){
                while($row = mysqli_fetch_object($productsRows)){
                    createProductCard($row -> productName, $row -> productBrand, $row -> productPrice, $row -> productImg, $row -> categoryName, $row -> idProduct);
                }
            }
        ?>
    </div>

    <?php
        include_once 'components/footer.php';
        if(isset($_SESSION['cart'])){
            echo '<div class="closeCart">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                <path d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z"/>
            </svg>
            </div>
            <div class="cartIcon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#fff">
                    <path d="M10 19.5c0 .829-.672 1.5-1.5 1.5s-1.5-.671-1.5-1.5c0-.828.672-1.5 1.5-1.5s1.5.672 1.5 1.5zm3.5-1.5c-.828 0-1.5.671-1.5 1.5s.672 1.5 1.5 1.5 1.5-.671 1.5-1.5c0-.828-.672-1.5-1.5-1.5zm1.336-5l1.977-7h-16.813l2.938 7h11.898zm4.969-10l-3.432 12h-12.597l.839 2h13.239l3.474-12h1.929l.743-2h-4.195z"/>
                </svg>
            </div>';

        }
        include_once 'components/cart.php';
    ?>

    <script>
        var cartMenu = document.querySelector('.cart');
        var cartOpen = document.querySelector('.cartIcon');
        var cartClose = document.querySelector('.closeCart');
        var closeCartSection = document.querySelector('.closeCartSection');
        
        const openMenu = () => {
            cartMenu.style.display = 'block';
            cartOpen.style.display = 'none';
            cartClose.style.display = 'flex';
        }
        
        const closeMenu = () => {
            cartMenu.style.display = 'none'
            cartClose.style.display = 'none';
            cartOpen.style.display = 'flex';
        }

        cartOpen.addEventListener("click", openMenu);
        cartClose.addEventListener("click", closeMenu);
        closeCartSection.addEventListener("click", closeMenu);

    </script>
</body>
</html>