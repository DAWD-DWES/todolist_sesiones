<?php
session_start();

$tareas = $_SESSION['tareas'] ?? [];

define('TAREA_INVALIDA', '**Tarea inválida');
if (filter_has_var(INPUT_POST, 'crear_tarea')) { // Si se solicita la creación de una tarea
    $tarea = trim(filter_input(INPUT_POST, 'tarea', FILTER_SANITIZE_SPECIAL_CHARS)); // Lee la tarea del formulario
    $tareaErr = filter_var($tarea, FILTER_VALIDATE_REGEXP,
                    ['options' => ['regexp' => "/^[a-z A-Záéíóúñ0-9]{5,50}$/"]]) === false;
    if (!$tareaErr) {
        $tareas[] = ['tarea' => $tarea, 'estado' => false]; // Añado la tarea a la lista
    }
} else if (filter_has_var(INPUT_POST, 'borrar_tarea')) { // Si se solicita que se borre la tarea 
    $tareaId = filter_input(INPUT_POST, 'tarea_id', FILTER_VALIDATE_INT); // Se lee el número de tarea (uno más que el índice real)          
    unset($tareas[$tareaId - 1]); // Se borra la tarea de la lista
    $tareas = array_values($tareas); // Se reindexa la lista de tareas para que los índices sean consecutivos
} else if (filter_has_var(INPUT_POST, 'completar_tarea')) { // Si se solicita que se complete una tarea
    $tareaId = filter_input(INPUT_POST, 'tarea_id', FILTER_VALIDATE_INT); // Se lee el número de tarea (uno más que el índice real)          
    $tareas[$tareaId - 1]['estado'] = true; // Se cambia el estado de completado de la tarea
} else if (filter_input(INPUT_GET, 'limpiar_tareas')) {
    $tareas = [];
}

$_SESSION['tareas'] = $tareas;
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="stylesheet.css">
        <title>Agenda de Tareas</title>
    </head>
    <body>
        <main class="principal">
            <h1>Agenda de Tareas</h1>
            <form class="agenda" action="<?= $_SERVER['PHP_SELF'] ?>" method="POST">  <!-- Creo un formulario que envía los datos de nuevo al script -->
                <fieldset class="section"> <!-- Sección de nueva tarea -->
                    <legend>Nueva Tarea:</legend>
                    <div class="form-section">
                        <label for="tarea">Tarea:</label>
                        <input id="tarea" type="text" name="tarea" placeholder="Escribe tu tarea (5-50 caracteres)" 
                               value="<?= ($tareaErr ?? false) ? $tarea : '' ?>">
                        <span class="error <?= ($tareaErr ?? false) ? 'error-visible' : '' ?>">
                            <?= constant("TAREA_INVALIDA") ?>
                        </span>
                    </div>
                    <div class="form-section">
                        <input class="submit blue" type="submit" value="Añadir Tarea" name="crear_tarea"/> <!-- Envío de petición de nueva tarea -->
                        <input class="submit green" type="reset" value="Limpiar Campos"/>
                    </div>
                </fieldset>
                <?php if (!empty($tareas)): ?>
                    <fieldset class="section"> <!-- Sección de creación de la tabla de tareas -->
                        <legend>Lista de Tareas:</legend>
                        <table>
                            <thead>
                                <tr>
                                    <th>Número Tarea</th>
                                    <th>Tarea</th>
                                    <th>Completado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tareas as $numTarea => $tarea): ?> <!-- Bucle de creación de las filas de la tabla -->
                                    <tr>
                                        <td><?= $numTarea + 1 ?></td> <!-- Añado uno al índice para que la lista se inicie en 1 -->
                                        <td><?= $tarea['tarea'] ?></td>
                                        <td><?= $tarea['estado'] ? "Si" : "No" ?></td>
                                    </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </fieldset>
                    <fieldset class="section"> <!-- Sección de operaciones sobre la lista de tareas -->
                        <div class="form-section">
                            <label class="blue" for="tarea">Num Tarea:</label>
                            <input id="tarea" type="number" min="1" max=<?= count($tareas) ?> value="1" name="tarea_id">
                            <input class="submit blue" type="submit" value="Tarea Completada" name='completar_tarea'/>
                            <input class="submit blue" type="submit" value="Tarea Borrada" name='borrar_tarea'/>
                            <input class="submit red" type="submit" formaction="<?= "{$_SERVER['PHP_SELF']}?limpiar_tareas" ?>"  value="Vaciar Agenda">
                            <!-- Otra manera de enviar la petición al servidor con un mensaje GET-->   
                            <!-- Esta forma no requiere que el botón sea de tipo submit -->
                            <!-- <a href="<?= "{$_SERVER['PHP_SELF']}?limpiar_tareas" ?>"><input type="button" class="submit red" value="Vaciar Agenda"></a> -->                     
                        </div> 
                    </fieldset>
                <?php else: ?>
                    <fieldset class="section"> 
                        <legend>Lista de Tareas:</legend>
                        <p class="blue">No hay tareas</p>
                    </fieldset>  
                <?php endif ?>
            </form>
        </main>
    </body>
</html>
