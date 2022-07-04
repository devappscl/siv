<?php

namespace App\Models;

use CodeIgniter\Model;

class CajaModels extends Model{

    protected $table      = 'caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['tipo','tipodetalle', 'sucursal', 'created_at','cantidad','comentario','cajera', 'turno'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}

