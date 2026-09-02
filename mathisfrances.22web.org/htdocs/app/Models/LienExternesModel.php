<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class LienExternesModel extends Model
{
    protected $table = 'liens_externes';
    protected $primaryKey = 'id_lien';

    public function getOneLink($id)
    {
        return $this->where('id_lien', $id)->first();
    }
}
