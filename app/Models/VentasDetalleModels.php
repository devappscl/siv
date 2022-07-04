<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasDetalleModels extends Model{

    protected $table      = 'ventadetalle';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['nventa','sucursal', 'user_id', 'producto_id', 'cantidad','pventa','descripcion'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;



    

    
}


?>