<?php
    require_once 'utils/connection.php';

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['User'])){
        header('Location: login.php');
    }

    if(isset($_SESSION['User']) && $_SESSION['User']['role'] != 1){
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/global.css">
    <link rel="stylesheet" href="styles/addNew.css">
    <title>Deckstore | Agregar categoría</title>
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include_once 'components/header.php' ?>
    <h1 class="product-section-title">Llena el formulario para agregar una categoría</h1>
    <section class="form-container">
        <h2 class="title">Nueva categoría</h2>
        <form action="" method="POST">
            <div class="input-wrapper input-wrapper-full">
                <label for="">Nombre de la categoria*</label>
                <input type="text" name="categoryName" class="form-input form-input-full"
                    placeholder="Ingrese el nombre de la categoría" required>
            </div>
            <div class="input-wrapper input-wrapper-full">
                <label for="">Descripción corta*</label>
                <input type="text" name="categoryDesc" class="form-input form-input-full"
                    placeholder="Escriba la descripcion de la categoría" required>
            </div>
            <button class="form-btn" type="submit" name="addCategory">
                Guardar categoría
            </button>
        </form>
        <?php
            if (isset($_POST['addCategory'])){
                $connection = connectToDatabase();

                $categoryName = mysqli_real_escape_string($connection, $_POST['categoryName']);
                $categoryDesc = mysqli_real_escape_string($connection, $_POST['categoryDesc']);
                $saveNewCategoryQuery = "CALL add_new_category('$categoryName', '$categoryDesc')";

                if($connection -> query($saveNewCategoryQuery)){
                    ?>
                        <script>
                            Swal.fire(
                                'Exito 😎',
                                'Se ha guardado la categoría correctamente',
                                'success'
                            );
                        </script>
                    <?php
                }
                else {
                    ?> 
                        <script> 
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error guardando la categoría, intentelo de nuevo mas tarde',
                            });
                        </script>
                    <?php
                }
                $connection -> close();
            }
        ?>
    </section>
    <?php include 'components/footer.php' ?>
</body>

</html>