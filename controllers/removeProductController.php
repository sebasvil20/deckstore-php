<?php
    if(isset($_POST['removeProduct'])){
        $idProductToRemove = $_POST['idProduct'];
        $connection = connectToDatabase();
        if($connection -> query("CALL remove_product($idProductToRemove)")){
            ?>
                <script>
                    Swal.fire(
                        'Exito 😎',
                        'Se ha eliminado el producto correctamente',
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
                        text: 'Ha ocurrido un error eliminando el producto, intentelo de nuevo',
                    });
                </script>
            <?php
        }
        $connection -> close();
    }
?>