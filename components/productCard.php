
<?php
function createProductCard($productName, $productBrand, $productPrice, $productImg, $categoryName, $idProduct){
    echo "
        <form action='' method='post' class='card'>
            <img class='card-image' src='$productImg' alt=''>
            <h1 class='card-title'>
                $productName
            </h1>
            <h3 class='card-brand'>
                $productBrand
            </h3>
            <h3 class='card-price'> 
                " . number_format($productPrice) . " COP
            </h3>
            <h4 class='card-category'>
                $categoryName
            </h4>
            <input type='hidden' name='idProduct' value='$idProduct'>
            <button type='submit' name='addProductToCart'> Añadir al carrito </button>
        </form>";
}
?>