<?php

namespace App\Models;

use CodeIgniter\Model;

class CarritoModels extends Model{

    protected $table      = 'carro';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['producto_id', 'user_id', 'cantidadcarro','pcompracarro','pventacarro','subtotalcarro'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;



    

    
}


?>