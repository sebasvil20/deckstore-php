<?php
function createProductCard($id, $name, $price, $brand, $img, $category){
    ?>  
        <form action="" method="POST">
            <hr>
            <div class="product-list-card">
                    <div class="list-card-text">
                    <input type='hidden' name='idProduct' value="<?php echo $id ?>">
                    <span class="grey product-list-id"><?php echo $id ?></span>
                    <span class="grey product-list-category"><?php echo $category ?></span>
                    <h1 class="product-list-name"><a href="updateProduct.php?id=<?php echo $id ?>"><?php echo $name ?></a></h1>
                    <h2 class="product-list-brand"><?php echo $brand ?></h2>
                    <h3 class="product-list-price">$ <?php echo number_format($price) ?> COP</h3>
                </div>
                <img src="<?php echo $img ?>" alt="" class="product-list-image">
                <button type='submit' name='removeProduct' class='removeItemButton'>
                    <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='#ff4141'>
                        <path d='M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm4.597 17.954l-4.591-4.55-4.555 4.596-1.405-1.405 4.547-4.592-4.593-4.552 1.405-1.405 4.588 4.543 4.545-4.589 1.416 1.403-4.546 4.587 4.592 4.548-1.403 1.416z'/>
                    </svg>
                </button>
            </div>
        </form>
    <?php
}
?>