<?php

    //Buscamos la key del producto a quitar
    //Para esto utilizamos el id y buscamos por todo
    //el carrito donde esta ese id
    function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            if ($val['idProduct'] === $id) {
                return $key;
            }
        }
        return null;
    }

    //Con la key retornada de la funcion anterior, 
    //eliminamos el producto del carrito
    //y verificamos si el carrito no queda en 0
    function removeProduct(){
        $productToRemove = $_POST['productToRemove'];
        unset($_SESSION['cart'][searchForId($productToRemove, $_SESSION['cart'])]);

        if(count($_SESSION['cart']) === 0){
            unset($_SESSION["cart"]);
            unset($_SESSION["totalCart"]);
        }
    }
?>