<?php
    if(isset($_POST['signup'])){
        $connection = connectToDatabase();
        $name = mysqli_real_escape_string($connection, $_POST['name']);
        $email = mysqli_real_escape_string($connection, $_POST['email']);
        $gender = $_POST['gender'];
        $password = $_POST['password'];
        $verifyPassword = $_POST['verifyPassword'];

        if($verifyPassword == $password){
            $encryptedPassword = sha1($password.PASSWORD_SALT);
            
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