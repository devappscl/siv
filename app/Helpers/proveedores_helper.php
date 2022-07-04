<?php


function NombreProveedor($id){

    $db = \Config\Database::connect();

    $query = $db->query("SELECT * FROM proveedores WHERE id='$id'");

    $row = $query->getRow();

    return $row->nombre;

}


?>