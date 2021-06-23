<?php
    if(isset($_POST['login'])){

        // Inicializamos la sesión en caso de que no lo esté ya.
        if(!isset($_SESSION)){
            session_start();
        }

        $connection = connectToDatabase();

        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $password = mysqli_real_escape_string($connection, $_POST['password']);

        // Encriptamos la password con la PASSWORD_SALT antes de verificar que sean las mismas.
        $encryptedPassword = sha1($password.PASSWORD_SALT);
        $verifyUser = $connection -> query("CALL login_user('$email', '$encryptedPassword')");
        $connection -> close();

        // Si los datos del usuario son correctos, iniciamos sesión y guardamos sus datos en 
        // la variable de sesión
        
        if($verifyUser -> num_rows === 1){
            $_SESSION['User'] = $verifyUser -> fetch_assoc();
        }
        else{
            ?>
                <script> 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Contraseña o usuario incorrecto, intentelo de nuevo',
                    });
                </script>
            <?php
        }
    }
?>