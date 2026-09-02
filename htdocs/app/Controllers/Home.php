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
        helper('age');

        $infos_generalesModel = new PersonnelleModel();
        $lienExternesModel = new LienExternesModel();
        $loisirsModel = new LoisirsModel();

        $data = [
            'title' => 'Accueil - Portfolio',
            // Le CSS global (style.css) est déjà chargé dans le layout, pas besoin de l'ajouter ici
            'personne' => $infos_generalesModel->first(),
            'lienExternes' => $lienExternesModel->findAll(),
            'loisirs' => $loisirsModel->findAll(),
        ];

        // On ne retourne plus que la vue finale
        return view('home/index', $data);
    }

    public function tableau()
    {
        $catModel = new CategoriesBloc1Model();
        $compModel = new CompetencesAcocherModel();
        $justifModel = new JustificationModel();

        $categoriesBrutes = $catModel->findAll();
        $categories = [];

        foreach ($categoriesBrutes as $cat) {
            $competences = $compModel->where('id_categorie', $cat['id'])->orderBy('id', 'ASC')->findAll();

            foreach ($competences as &$comp) {
                if ('1' === $comp['vu'] && !empty($comp['id_justification'])) {
                    $comp['justification_data'] = $justifModel->find($comp['id_justification']);
                } else {
                    $comp['justification_data'] = null;
                }
            }
            $cat['competences'] = $competences;
            $categories[] = $cat;
        }

        $data = [
            'title' => 'Compétences - Portfolio',
            'categories' => $categories,
        ];

        return view('home/tableau', $data);
    }

    public function projets()
    {
        $projetModel = new ProjetModel();
        $data = [
            'title' => 'Mes Projets - Portfolio',
            'projets' => $projetModel->orderBy('id', 'DESC')->findAll(),
        ];

        return view('home/projets', $data);
    }

    public function contact()
    {
        helper('form');
        $data = [
            'title' => 'Contacts - Portfolio',
            'css' => ['contact.css'],  // <-- On charge le CSS spécifique au formulaire de contact !
        ];

        return view('home/contact', $data);
    }

    public function submitContact()
    {
        helper('form');

        $rules = [
            'nom' => 'required|min_length[2]',
            'prenom' => 'required|min_length[2]',
            'mail' => 'required|valid_email',
            'texte' => 'required|min_length[5]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $contactModel = new ContactModel();
        $contactModel->save([
            'adresse_ip' => $this->request->getIPAddress(),
            'date' => date('Y-m-d H:i:s'),
            'sexe' => $this->request->getPost('sexe'),
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'mail' => $this->request->getPost('mail'),
            'message' => $this->request->getPost('texte'),
        ]);

        return redirect()->to('contact')->with('success', 'Votre message a bien été envoyé !');
    }

    public function cv()
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
