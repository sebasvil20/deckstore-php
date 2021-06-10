<section class="cart">
    <section class="detailedCart">
    <h1 class="cartTitle">Carrito</h1>
        <?php
            include 'cartCard.php';

            $idProducts = array_column($_SESSION['cart'], 'idProduct');
            $_SESSION['totalCart'] = 0;

            foreach($idProducts as $singleProductID){
                $connection = connectToDatabase();
                $productInfo = $connection -> query("CALL get_product_by_id($singleProductID)");
                if($productInfo){
                    while($row = mysqli_fetch_object($productInfo)){
                        createCartElement($row -> productName, $row -> productPrice, $row -> productImg, $singleProductID, true);
                        $_SESSION['totalCart'] += $row -> productPrice;
                    }
                }
                $connection -> close();
            };
            echo "<h3 class='total'>Total: " . number_format( $_SESSION['totalCart']) . " COP </h3>";
            echo "<a href='detailedCart.php' class='cartEndSaleButton'> Finalizar Compra &#x2192; </a>"
        ?>
    </section>
    <section class="closeCartSection"></section>
</section>