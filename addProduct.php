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
    <title>Deckstore | Agregar producto</title>
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include_once 'components/header.php' ?>
    <h1 class="product-section-title">Llena el formulario para agregar un nuevo producto</h1>
    <section class="form-container">
        <h2 class="title">Nuevo producto</h2>
        <form action="" method="POST">
            <div class="input-wrapper input-wrapper-full">
                <label for="">Nombre del producto*</label>
                <input type="text" name="productName" class="form-input form-input-full"
                    placeholder="Ingrese el nombre del producto" required>
            </div>
            <div class="input-wrapper input-wrapper-full">
                <label for="">Marca*</label>
                <input type="text" name="productBrand" class="form-input form-input-full"
                    placeholder="Ingrese la marca del producto" required>
            </div>
            <div class="input-wrapper input-wrapper-mid">
                <label for="">Precio*</label>
                <input type="text" name="productPrice" class="form-input form-input-full"
                    placeholder="Ingrese precio del producto" pattern="[0-9]{4,}"
                    title="Utilice solo números en este campo, mínimo 4 dígitos" required>
            </div>
            <div class="input-wrapper input-wrapper-mid">
                <label for="">Cantidad en inventario*</label>
                <input type="text" name="quantity" class="form-input form-input-full"
                    placeholder="Cantidad en inventario" pattern="[0-9]{1,}"
                    title="Utilice solo números en este campo" required>
            </div>
            <div class="input-wrapper input-wrapper-full">
                <label for="">Imagen del producto (URL)*</label>
                <input type="text" name="productImg" class="form-input form-input-full"
                    placeholder="Escriba la url de la imagen" required>
            </div>

            <div class="input-wrapper input-wrapper-full">

                <label for="">Categoria del producto*</label>
                <select name="selectCategory">
                    <option value="0">Seleccione una categoria</option>
                    <?php
                        $getCategoriesQuery = "CALL get_all_categories()";
                        $connection = connectToDatabase();
                        $categoriesRows = $connection -> query($getCategoriesQuery);
                        $connection -> close();

                        while($row = mysqli_fetch_object($categoriesRows)){
                            echo "<option value=\"". $row -> idCategory ."\">". $row -> categoryName ."</option>";
                        }
                    ?>
                </select>
            </div>

            <button class="form-btn" type="submit" name="addProduct">
                Guardar producto
            </button>
        </form>
        <?php
            if (isset($_POST['addProduct'])){
                $connection = connectToDatabase();

                $productName = mysqli_real_escape_string($connection, $_POST['productName']);
                $productBrand = mysqli_real_escape_string($connection, $_POST['productBrand']);
                $productPrice = mysqli_real_escape_string($connection, $_POST['productPrice']);
                $productImg = mysqli_real_escape_string($connection, $_POST['productImg']);
                $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
                $selectedCategoryId = mysqli_real_escape_string($connection, $_POST['selectCategory']);
                $saveNewProductQuery = "CALL add_new_product('$productName', '$productBrand', $productPrice, '$productImg', $quantity, $selectedCategoryId)";

                if($connection -> query($saveNewProductQuery)){
                    ?>
                        <script>
                            Swal.fire(
                                'Exito 😎',
                                'Se ha guardado el producto correctamente',
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
                                text: 'Ha ocurrido un error guardando el producto, intentelo de nuevo mas tarde',
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