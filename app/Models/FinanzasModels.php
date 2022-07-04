<?php

namespace App\Models;

use CodeIgniter\Model;

class FinanzasModels extends Model{

    protected $table      = 'finanzas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['tipo','tipodetalle', 'sucursal', 'created_at','cantidad','comentario','cajera'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

}

