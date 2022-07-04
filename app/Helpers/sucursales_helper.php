<?php




function NombreSucursal($id){

    $db = \Config\Database::connect();

    $query = $db->query("SELECT * FROM sucursales WHERE id='$id'");

    $row = $query->getRow();

    return $row->nombre;

}


function TotalVentas($id){

    $db = \Config\Database::connect();

    $query = $db->query("SELECT SUM(total) AS total FROM ventas WHERE vendedor='$id' AND created_at >= 'CURDATE()'");

    $row = $query->getRow();

    return $row->total;

    
}

function Vendedor($id){

    $db = \Config\Database::connect();

    $query = $db->query("SELECT * FROM usuarios WHERE rut='$id'");

    $row = $query->getRow();

    return $row->nombre . " " . $row->apaterno . " " . $row->amaterno;

    
}


?>