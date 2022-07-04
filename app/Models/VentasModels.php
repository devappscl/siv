<?php

namespace App\Models;

use CodeIgniter\Model;

class VentasModels extends Model{

    protected $table      = 'ventas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['total', 'sucursal', 'estado','vendedor','formapago','cliente_rut'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    
}


?>