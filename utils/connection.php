<?php
    require 'config.php';

    function connectToDatabase(){
        $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die ("Error en la conexión a la base de datos");
        if (!mysqli_set_charset($conn, "utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", mysqli_error($enlace));
        }
        return $conn;
    }
?>