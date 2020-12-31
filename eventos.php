<?php
    header('Content-Type: application/json');
    $conn = new PDO('mysql:dbname=calendar;host=127.0.0.1', 'root', '');

    $accion = (isset($_GET['accion'])) ? $_GET['accion'] : 'leer';
    
    switch ($accion) {
        case 'agregar':
            $sentenciaSQL = $conn->prepare('INSERT INTO
            eventos (title, descripcion, color, textColor, start, end)
            VALUES (:title, :descripcion, :color, :textColor, :start, :end);');

            $resultado = $sentenciaSQL->execute(array(
                'title' => $_POST['title'],
                'descripcion' => $_POST['descripcion'],
                'color' => $_POST['color'],
                'textColor' => $_POST['textColor'],
                'start' => $_POST['start'],
                'end' => $_POST['end']
            ));

            echo json_encode($resultado);
        break;
        case 'eliminar':
            $resultado = false;

            if (isset($_POST['id'])) {
                $sentenciaSQL = $conn->prepare('DELETE FROM eventos WHERE id=:id;');
                $resultado = $sentenciaSQL->execute(array('id'=>$_POST['id']));
            }

            echo json_encode($resultado);
            break;
        case 'modificar':
            $sentenciaSQL = $conn->prepare('UPDATE eventos SET
            title=:title,
            descripcion=:descripcion,
            color=:color,
            textColor=:textColor,
            start=:start,
            end=:end
            WHERE id=:id;');

            $resultado = $sentenciaSQL->execute(array(
                'id' => $_POST['id'],
                'title' => $_POST['title'],
                'descripcion' => $_POST['descripcion'],
                'color' => $_POST['color'],
                'textColor' => $_POST['textColor'],
                'start' => $_POST['start'],
                'end' => $_POST['end']
            ));

            echo json_encode($resultado);
        break;
        default:
            // Seleccionar los eventos del calendario
            $sentenciaSQL = $conn->prepare('SELECT * FROM eventos;');
            $sentenciaSQL->execute();

            $resultado = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($resultado);
            break;
    }
    
?>