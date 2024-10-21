<?php

    $conexion = mysqli_connect("localhost", "finanzas", "finanzas", "finanzas");
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
            echo '<td>'.$fila['ingresogasto'].'</td>';
            echo '<td>'.$fila['cantidad'].'</td>';
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
            <td><input type="number" name="cantidad"></td>
            <td><input type="submit"></td>
            </form>
        </tr>
    ';
    echo "</table>";

?>