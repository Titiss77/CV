<?php declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class SyntheseModel extends Model
{
    protected $table = 'veille_synthese';
    protected $primaryKey = 'id';
    protected $allowedFields = ['titre', 'contenu', 'date_mise_a_jour'];
}