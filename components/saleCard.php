<?php
    function createSaleCard($idSale, $firstLetter, $productQtty, $date, $total){
        ?>
        <div class="card-container">
            <div class="name-image">
                <?php echo $firstLetter ?>
            </div>
            <div class="user-data">
                <a href="detailedSale.php?idSale=<?php echo $idSale ?>" class="title">
                    <?php echo $productQtty ?> Productos &#x2197;
                </a>
                <span class="date">
                    <?php echo date("F j, Y", strtotime($date)) ?>
                </span>
            </div>
            <div class="total">
                <?php echo number_format($total) ?> COP
            </div>
        </div>
        <?php
    }

?>