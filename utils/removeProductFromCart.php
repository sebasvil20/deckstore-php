<?php
    function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['idProduct'] === $id) {
                return $key;
            }
        }
        return null;
    }

    function removeProduct(){
        $productToRemove = $_POST['productToRemove'];
        unset($_SESSION['cart'][searchForId($productToRemove, $_SESSION['cart'])]);

        if(count($_SESSION['cart']) === 0){
            unset($_SESSION["cart"]);
            unset($_SESSION["totalCart"]);
        }
    }
?>