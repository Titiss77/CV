<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\CategoriesBloc1Model;
use App\Models\CompetencesAcocherModel;
use App\Models\ContactModel;
use App\Models\ExpProModel;
use App\Models\FormationModel;
use App\Models\InfoContactModel;
use App\Models\JustificationModel;
use App\Models\LienExternesModel;
use App\Models\LoisirsModel;
use App\Models\PersonnelleModel;
use App\Models\ProjetModel;

class Home extends BaseController
{
    public function index()
    {
        $infoContactModel = new InfoContactModel();
        $expProModel = new ExpProModel();
        $formationModel = new FormationModel();
        $loisirsModel = new LoisirsModel();
        $lienExternesModel = new LienExternesModel();

        $data = [
            'contact' => $infoContactModel->find(1),
            'experiences' => $expProModel->orderBy('id', 'DESC')->findAll(),
            'formations' => $formationModel->orderBy('id', 'DESC')->findAll(),
            'loisirs' => $loisirsModel->orderBy('idLoisir', 'ASC')->findAll(),
            'lienExternes' => $lienExternesModel->getOneLink(1),
        ];

        // Le CV garde sa propre structure HTML indépendante du reste du site
        return view('cv/index', $data);
    }
}