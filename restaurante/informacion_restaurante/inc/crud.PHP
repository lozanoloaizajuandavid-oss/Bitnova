<?php

//crud para realizar updates borrar y crear


//funcion para update
function update($table, $data, $id){

    if ($table == 'contrato') {
        // Crear la base de la consulta SQL
        $sql = "UPDATE $table SET ";

        // Array para las columnas y valores a actualizar
        $columns = [];
        $values = [];

        // Solo agregar a la consulta los campos que no sean nulos
        foreach ($data as $key => $value) {
            if (!empty($value)) { // Solo actualizar si el campo no está vacío
                $columns[] = "$key = ?";
                $values[] = $value;
            }
        }

        // Si no hay campos para actualizar, retornar null o algún valor de error
        if (empty($columns)) {
            return null; // O puedes manejar un mensaje de error
        }

        // Concatenar las columnas a la consulta
        $sql .= join(", ", $columns);

        // Añadir la cláusula WHERE
        $sql .= " WHERE cont_id = ?";

        // Agregar el ID al final de los valores
        $values[] = $id;

        // Retornar solo el SQL y los valores
        return ['sql' => $sql, 'values' => $values];
    }
}




?>