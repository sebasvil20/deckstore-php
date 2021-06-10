<?php
    require_once 'utils/connection.php';

    if(!isset($_SESSION)){
        session_start();
    }

    if(!isset($_SESSION['User']) || $_SESSION['User']['role'] != 1){
        header('Location: login.php');
    }

    if(!isset($_GET['id'])){
        header('Location: maindashboard.php');
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
    <title>Deckstore | Actualizar producto</title>
</head>

<body>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php include_once 'components/header.php' ?>
    <h1 class="product-section-title">Cambia los datos de tu producto</h1>
    <section class="form-container">
        <?php
            $connection = connectToDatabase();
                $productInfo = $connection -> query("CALL get_product_by_id(".$_GET['id'].")");
                if($productInfo && $productInfo -> num_rows > 0){
                    $productInfo = mysqli_fetch_object($productInfo);
                    $connection -> close();
        ?>
                    <h2 class="title">Actualizar</h2>
                    <form action="" method="POST">
                        <input type='hidden' name='idProduct' value="<?php echo $_GET['id'] ?>">
                        <div class="input-wrapper input-wrapper-full">
                            <label for="">Nombre del producto*</label>
                            <input type="text" name="productName" class="form-input form-input-full"
                                placeholder="Ingrese el nombre del producto" value="<?php echo $productInfo -> productName ?>" required>
                        </div>
                        <div class="input-wrapper input-wrapper-full">
                            <label for="">Marca*</label>
                            <input type="text" name="productBrand" class="form-input form-input-full"
                                placeholder="Ingrese la marca del producto"  value="<?php echo $productInfo -> productBrand ?>" required>
                        </div>
                        <div class="input-wrapper input-wrapper-mid">
                            <label for="">Precio*</label>
                            <input type="text" name="productPrice" class="form-input form-input-full"
                                placeholder="Ingrese precio del producto" pattern="[0-9]{4,}"
                                title="Utilice solo números en este campo, mínimo 4 dígitos"  value="<?php echo $productInfo -> productPrice ?>"  required>
                        </div>
                        <div class="input-wrapper input-wrapper-mid">
                            <label for="">Cantidad en inventario*</label>
                            <input type="text" name="quantity" class="form-input form-input-full"
                                placeholder="Cantidad en inventario" pattern="[0-9]{1,}"
                                title="Utilice solo números en este campo"  value="<?php echo $productInfo -> quantity ?>"  required>
                        </div>
                        <div class="input-wrapper input-wrapper-full">
                            <label for="">Imagen del producto (URL)*</label>
                            <input type="text" name="productImg" class="form-input form-input-full"
                                placeholder="Escriba la url de la imagen"  value="<?php echo $productInfo -> productImg ?>"  required>
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

                        <button class="form-btn" type="submit" name="updateProduct">
                            Actualizar producto
                        </button>
                    </form>
        <?php
                }
                else{
                    ?>
                        <script>
                            Swal.fire({
                                title: 'Error 😥',
                                html: 'No hemos podido encontrar el producto que estas buscando',
                                icon: 'error',
                                confirmButtonText:
                                    'Continuar',
                            }).then((result) => {
                                if (result.isConfirmed || !result.isConfirmed) {
                                    location.href = "maindashboard.php"
                                }
                            });
                        </script>
                    <?php
                }  
            if (isset($_POST['updateProduct'])){
                $connection = connectToDatabase();
                
                $idProduct = mysqli_real_escape_string($connection, $_POST['idProduct']);
                $productName = mysqli_real_escape_string($connection, $_POST['productName']);
                $productBrand = mysqli_real_escape_string($connection, $_POST['productBrand']);
                $productPrice = mysqli_real_escape_string($connection, $_POST['productPrice']);
                $productImg = mysqli_real_escape_string($connection, $_POST['productImg']);
                $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
                $selectedCategoryId = mysqli_real_escape_string($connection, $_POST['selectCategory']);
                $updateProduct = "CALL update_product($idProduct, '$productName', '$productBrand', $productPrice, '$productImg', $quantity, $selectedCategoryId)";

                if($connection -> query($updateProduct)){
                    ?>
                        <script>
                            Swal.fire({
                                title: 'Exito 😎',
                                html: 'Se ha actualizado el producto correctamente',
                                icon: 'success',
                                confirmButtonText:
                                    'Continuar',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.href = "maindashboard.php"
                                }
                            });
                        </script>
                    <?php
                }
                else {
                    ?> 
                        <script> 
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Ha ocurrido un error actualizando el producto, intentelo de nuevo mas tarde',
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