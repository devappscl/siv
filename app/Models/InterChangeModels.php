<?php 

namespace App\Models;

use CodeIgniter\Model;

class InterChangeModels extends Model{


    public function sucursales(){

        $db = \Config\Database::connect();

        $query = $db->query("SELECT * FROM sucursales");
    
        $row = $query->getResult();
    
        return $row; 

    }

}

