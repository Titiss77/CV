<?php

declare(strict_types=1);

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';

    // Les champs que l'on autorise à insérer
    protected $allowedFields = ['title', 'link', 'description', 'pub_date', 'source'];

    /**
     * Insère un article si son lien n'existe pas déjà dans la base.
     *
     * @param mixed $data
     */
    public function insertIfNotExists($data)
    {
        $existing = $this->where('link', $data['link'])->first();

        if (!$existing) {
            return $this->insert($data);
        }

        return false; // L'article existe déjà
    }
}
