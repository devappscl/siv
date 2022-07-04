<?php

namespace App\Models;

use CodeIgniter\Model;

class StockModels extends Model{

    protected $table      = 'stock';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['sucursal', 'producto_id', 'cantidad'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';


    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

   

    

    //Consulta producto por codigo
	public function PorStock($id){
       
        $db = db_connect();
		return $this->$db->where("stock", ["id" => $id]);

	}

        //$this->StockModel->StockProduto(1);
    
}


?>