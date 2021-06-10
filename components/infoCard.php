<?php
    function createInfoCard($cardTitle, $cartSubtitle, $cartImage, $isPrice = false){
        ?>
            <div class="info-card">
                <div class="card-image-container">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#466ce6" viewBox="0 0 24 24"><path d="
                        <?php echo $cartImage ?>"/></svg>
                </div>
                <div class="card-text-container">
                    <h1 class="card-title">
                        <?php echo $isPrice ? "$ ". number_format($cardTitle)." COP" : $cardTitle ?>
                    </h1>
                    <span class="card-subtitle">
                        <?php echo $cartSubtitle ?>
                    </span>
                </div>
            </div>
        <?php

    }

?>