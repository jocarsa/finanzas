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
                function createBarChart($data) {
                    $width = 800;
                    $height = 300;
                    $image = imagecreatetruecolor($width, $height);

                    // Colors
                    $background_color = imagecolorallocate($image, 255, 255, 255); // White background
                    $bar_color = imagecolorallocate($image, 0, 0, 255); // Blue bars
                    $axis_color = imagecolorallocate($image, 0, 0, 0); // Black axis
                    $text_color = imagecolorallocate($image, 0, 0, 0); // White for the text

                    imagefill($image, 0, 0, $background_color);

                    $num_bars = count($data);
                    $bar_width = ($width - 40) / $num_bars; // Leaving some padding for the axis
                    $max_value = max($data);
                    $scale = ($height - 40) / $max_value; // Leaving padding for the axis

                    // Draw bars and add text on top
                    for ($i = 0; $i < $num_bars; $i++) {
                        $bar_height = $data[$i] * $scale;
                        $x1 = 20 + $i * $bar_width;
                        $y1 = $height - 20;
                        $x2 = $x1 + $bar_width - 10;
                        $y2 = $height - 20 - $bar_height;

                        imagefilledrectangle($image, $x1, $y1, $x2, $y2, $bar_color);

                        // Add white text with the value of each bar
                        $text_x = ($x1 + $x2) / 2 - 10; // Centering text over the bar
                        $text_y = $y2 - 15; // Above the bar
                        imagestring($image, 3, $text_x, $text_y, $data[$i], $text_color); // Font size 3
                    }

                    // Draw X and Y axis
                    imageline($image, 20, $height - 20, $width - 20, $height - 20, $axis_color); // X-axis
                    imageline($image, 20, $height - 20, 20, 20, $axis_color); // Y-axis

                    // Output the image as base64
                    ob_start();
                    imagepng($image);
                    $image_data = ob_get_contents(); // Get the image data
                    ob_end_clean(); // End buffering
                    imagedestroy($image);

                    return 'data:image/png;base64,' . base64_encode($image_data);
                }
                
                $total = 0;
                $saldotemporal = 0;
                $saldo = [];
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
                while ($fila = mysqli_fetch_assoc($resultado)) {
                    if($fila['ingresogasto'] == '0'){  
                        $saldotemporal += $fila['cantidad'];
                    }else{
                        $saldotemporal -= $fila['cantidad'];
                    }
                    $saldo[] = $saldotemporal;
                }
                echo '<img src="'.createBarChart($saldo).'" alt="Bar Chart">';
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
