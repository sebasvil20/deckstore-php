<?php
    if(!isset($_SESSION)){
        session_start();
    }
    if(isset($_POST['fakeBuy'])){

        // TODO: Guardar nuevas compras e imprimir el resumen
        // Este una vez (Recibe total y idUsuario, respectivamente. Devuelve el id de la compra)
        // add_new_sale
        // Este una vez por cada producto en el carrito (Recibe el id de la compra y el id del producto, respectivamente)
        // add_new_detailed_sale 
        $connection = connectToDatabase();
        $addNewSaleQuery = $connection -> query("CALL add_new_sale(".$_SESSION['totalCart'].", '".$_SESSION['User']['idUser']."')");
        $connection -> close();
        if($addNewSaleQuery){
            $idSaleToAdd = mysqli_fetch_object($addNewSaleQuery) -> idSale;
            echo "<br>";
            $products = array_column($_SESSION['cart'], 'idProduct');
            foreach($products as $singleProductID){
                $connection2 = connectToDatabase();
                $addProductToSale = $connection2 -> query("CALL add_new_detailed_sale('$idSaleToAdd', $singleProductID)");
                $connection2 -> close();
                if(!$addProductToSale){
                    ?>
                        <script> 
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error finalizando la compra, intentelo de nuevo',
                            });
                        </script>
                    <?php
                }
            };
            ?>
                <script>
                    Swal.fire(
                        'Exito 😎',
                        'La compra se ha concretado correctamente',
                        'success'
                    );
                </script>
            <?php
        }
        else{
            ?>
                <script> 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Ha ocurrido un error finalizando la compra, intentelo de nuevo',
                    });
                </script>
            <?php
        }
    }
?>