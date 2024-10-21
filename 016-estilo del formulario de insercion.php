<!doctype html>
<html>
    <head>
        <title>Finanzas personales</title>
        <style>
            body{font-family:sans-serif;background:rgb(240,240,240);}
            article{padding:20px;}
            article *{padding:0px;margin:0px;}
            .ingreso{border:2px solid green;}
            .gasto{border:2px solid red;}
            form *{width:400px;padding:5px 0px;margin:5px 0px;}
            header,main,footer{width:800px;margin:auto;background:white;padding:20px;}
            header{text-align:center;}
        </style>
    </head>
    <body>
        <header>
            <h1>Finanzas</h1>
            <h2>Gestiona tus finanzas personales</h2>
        </header>
        <main>
            <?php
                $total = 0;
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
                echo "<table>
                    <tr>
                        <th>Movimiento</th>
                        <th>Saldo</th>
                        <th>Operaciones</th>
                    </tr>
                ";
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    echo '<tr>';
                        echo '<td>';
                        if($fila['ingresogasto'] == '0'){
                            echo '<article class="ingreso">';  
                            $total += $fila['cantidad'];
                        }else{
                            echo '<article class="gasto">'; 
                            $total -= $fila['cantidad'];
                        }
                               
                        echo '<time>'.$fila['fecha'].'</time>';
                        echo '<h3>'.$fila['titulo'].'</h3>';
                        echo '<p>'.$fila['descripcion'].'</p>';
                        echo '<h5>'.$fila['cantidad'].'</h5>';
                        echo '</article>';
                        echo '</td>';
                        echo '<td>'.$total.'</td>';
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
                        
                        <td>
                        <form action="?" method="POST"><input type="date" name="fecha" placeholder="fecha">
                            <input type="text" name="titulo" placeholder="titulo">
                            <input type="text" name="descripcion" placeholder="descripcion">
                            <select name="ingresogasto">
                                <option>Seleciona</option>
                                <option value="0">Ingreso</option>
                                <option value="1">Gasto</option>
                            </select>
                            <input type="number" name="cantidad" step="0.01" placeholder="cantidad">

                            <input type="submit">
                        </form>
                        </td>
                        
                    </tr>
                ';
                echo "</table>";

            ?>
        </main>
        <footer></footer>
    </body>
</html>
