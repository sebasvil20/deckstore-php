<?php     
    if(!isset($_SESSION)){
        session_start();
    }
?>

<nav>
    <a href="/Deckstore">
        <img src="https://i.ibb.co/SmRcPz2/image-1-removebg-preview.png" alt="" class="logo">
    </a>
    <ul>
        <li><a href="/Deckstore" class="menu-link">Inicio</a></li>
        <li class="menu-link dropdown">
            Categorías
            <img src="img/downarrow.svg" alt="down arrow" class="down-arrow">
            <div class="dropdown-content">
                <ul class="dropdown-list">
                    <?php
                        $getCategoriesQuery = "CALL get_all_categories() ";
                        $connection = connectToDatabase();
                        $categoriesRows = $connection -> query($getCategoriesQuery);
                        $connection ->close();

                        while($row = mysqli_fetch_object($categoriesRows)){
                            echo '<a href="/Deckstore/?categoryId='. $row -> idCategory.'">'. $row -> categoryName .'</a>';
                        }
                    ?>
                </ul>
            </div>
        </li>
        <?php 
            if(!isset($_SESSION['User'])){
                ?>
                    <li><a href='login.php' class="menu-link">Login</a></li>
                <?php
            }
            else{
                if($_SESSION['User']['role'] == 1){
                ?>
                    <li class="menu-link dropdown">
                        Agregar
                        <img src="img/downarrow.svg" alt="down arrow" class="down-arrow">
                        <div class="dropdown-content">
                            <ul class="dropdown-list">
                                <a href="addProduct.php">Producto</a>
                                <a href="addCategory.php">Categoría</a>
                            </ul>
                        </div>
                    </li>
                    <li><a href="maindashboard.php" class="menu-link">Dashboard</a></li>
                <?php
                }
                ?>
                    <li><a href='userProfile.php' class='menu-link user'><?php echo explode(" ", $_SESSION['User']['name'])[0] ?></a></li>
                <?php
            }
        ?>
        
    </ul>
</nav>