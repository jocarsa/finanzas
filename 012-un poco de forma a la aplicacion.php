<!doctype html>
<html>
    <head>
        <title>Finanzas personales</title>
        <style>
            .ingreso{background:green;color:white;}
            .gasto{background:red;color:white;}
        </style>
    </head>
    <body>
        <header>
            <h1>Finanzas</h1>
            <h2>Gestiona tus finanzas personales</h2>
        </header>
        <main>
            <?php

                $conexion = mysqli_connect(
                    "localhost", 
                    "finanzas", 
                    "finanzas", 
                    "finanzas"
                );
                if(isset($_GET['o'])){
                    if($_GET['o'] == "eliminar"){
                        $peticion = "
                            DELETE FROM movimientos
                            WHERE Identificador = ".$_GET['id'].";
                        ";
                        mysqli_query($conexion, $peticion);
                    }
                }
                if(isset($_POST['fecha'])){
                    $peticion = "
                        INSERT INTO movimientos
                        VALUES (
                            NULL,
                            '".$_POST['fecha']."',
                            '".$_POST['titulo']."',
                            '".$_POST['descripcion']."',
                            '".$_POST['ingresogasto']."',
                            '".$_POST['cantidad']."'
                        )
                    ";
                    mysqli_query($conexion, $peticion);
                }

                $peticion = "SELECT * FROM movimientos";
                $resultado = mysqli_query($conexion, $peticion);
                echo "<table border='1'>
                    <tr>
                        <th>Fecha</th>
                        <th>Titulo</th>
                        <th>Descripcion</th>
                        <th>Ingreso</th>
                        <th>Cantidad</th>
                    </tr>
                ";
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo '<tr>';
                        echo '<td>'.$fila['fecha'].'</td>';
                        echo '<td>'.$fila['titulo'].'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>';
                            if($fila['ingresogasto'] == '0'){
                                echo '<div class="ingreso">Ingreso</div>';       
                            }else{
                                echo '<div class="gasto">Gasto</div>'; 
                            }
                        echo'</td>';
                        echo '<td>'.$fila['cantidad'].'</td>';
                        echo '
                        <td>
                            <a href="?o=eliminar&id='.$fila['Identificador'].'">
                                <button>🗑️</button>
                            </a>
                        </td>';
                    echo '</tr>';
                }
                echo '
                    <tr>
                        <form action="?" method="POST">
                        <td><input type="date" name="fecha"></td>
                        <td><input type="text" name="titulo"></td>
                        <td><input type="text" name="descripcion"></td>
                        <td><select name="ingresogasto">
                            <option>Seleciona</option>
                            <option value="0">Ingreso</option>
                            <option value="1">Gasto</option>
                        </select></td>
                        <td><input type="number" name="cantidad" step="0.01"></td>
                        <td><input type="submit"></td>
                        </form>
                    </tr>
                ';
                echo "</table>";

            ?>
        </main>
        <footer></footer>
    </body>
</html>
