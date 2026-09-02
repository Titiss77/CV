<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class PersonnelleModel extends Model
{
    protected $table = 'infos_generales';
    protected $primaryKey = 'id_personne';
    protected $allowedFields = ['photo_de_profil', 'nom', 'prenom', 'etudes', 'date_de_naissance', 'localisation', 'me_concernant'];
}
