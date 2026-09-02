<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\InfoContactModel;
use App\Models\ExpProModel;
use App\Models\ExpSportModel;
use App\Models\FormationModel;
use App\Models\LoisirsModel;
use App\Models\LienExternesModel;

class Home extends BaseController
{
    public function index()
    {
        $infoContactModel = new InfoContactModel();
        $expProModel = new ExpProModel();
        $expSportModel = new ExpSportModel();
        $formationModel = new FormationModel();
        $loisirsModel = new LoisirsModel();
        $lienExternesModel = new LienExternesModel();

        $data = [
            'contact' => $infoContactModel->find(1),
            'experiences_pro' => $expProModel->orderBy('id', 'DESC')->findAll(),
            'experiences_sport' => $expSportModel->orderBy('id', 'DESC')->findAll(),
            'formations' => $formationModel->orderBy('id', 'DESC')->findAll(),
            'loisirs' => $loisirsModel->orderBy('idLoisir', 'ASC')->findAll(),
            'lienExternes' => $lienExternesModel->getOneLink(1),
        ];

        // Le CV garde sa propre structure HTML indépendante du reste du site
        return view('index', $data);
    }
}