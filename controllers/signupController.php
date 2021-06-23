<?php
    if(isset($_POST['signup'])){
        $connection = connectToDatabase();
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $verifyPassword = $_POST['verifyPassword'];

        // Verificamos que tanto la contraseña con la confirmación sean las mismas
        if($verifyPassword == $password){

            // Encriptamos la contraseña con la PASSWORD_SALT antes de entrar a la base de datos
            $encryptedPassword = sha1($password.PASSWORD_SALT);
            
            // Verificamos que el usuario no exista
            $verifyUser = $connection -> query("CALL find_user_by_email('$email')");
            $connection -> close();
            if($verifyUser -> num_rows > 0){
                ?>
                    <script> 
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'El usuario ya existe, intentelo de nuevo con otro correo',
                        });
                    </script>
                <?php
            }
            else{

                //Creamos el nuevo usuario y mostramos mensaje de confirmación
                $connection = connectToDatabase();
                $signupUser = $connection -> query("CALL create_new_user('$name', $gender, '$email', '$encryptedPassword', 0)");
                $connection -> close();
                if($signupUser){
                    ?>
                        <script>
                            Swal.fire(
                                'Exito 😎',
                                'Se ha registrado correctamente, inicie sesión para continuar',
                                'success'
                            );
                        </script>
                    <?php
                }
            }
        }
        else{
            ?>
                <script> 
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Las constraseñas no coinciden, verifique su contraseña',
                    });
                </script>
            <?php
        }
    }
?>