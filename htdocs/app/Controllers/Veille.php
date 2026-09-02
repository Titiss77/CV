<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\SyntheseModel; // <-- Ne pas oublier d'importer le nouveau modèle
use Config\Services;

class Veille extends BaseController
{
    public function index()
    {
        helper('text');
        $articleModel = new ArticleModel();
        $syntheseModel = new SyntheseModel();
        
        $data = [
            'title'    => 'Ma Veille IoT',
            'css'      => ['veille_style.css'],
            // On récupère la dernière synthèse en date
            'synthese' => $syntheseModel->orderBy('date_mise_a_jour', 'DESC')->first(),
            // On récupère tous les articles normalement
            'articles' => $articleModel->orderBy('pub_date', 'DESC')->findAll(),
        ];

        return view('veille/index', $data);
    }

    public function fetch_rss(): void
    {
        $model = new ArticleModel();
        // On charge le client HTTP natif de CodeIgniter
        $client = Services::curlrequest();

        $feeds = [
            'Google Alerts - Internet of Things' => 'https://www.google.fr/alerts/feeds/07930128904714915235/4610366205862015580',
            'Google Alerts - objets connectés' => 'https://www.google.fr/alerts/feeds/07930128904714915235/17509983635208520170',
            'Google Alerts - IoT' => 'https://www.google.fr/alerts/feeds/07930128904714915235/14995384441107474932',
            'Google Alerts - internet des objets' => 'https://www.google.fr/alerts/feeds/07930128904714915235/10372901485195743878',
        ];

        $nouveauxArticles = 0;
        $erreurs = [];  // Tableau pour stocker les éventuelles erreurs

        foreach ($feeds as $sourceName => $url) {
            try {
                // On fait la requête en simulant Google Chrome sous Windows
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/114.0.0.0 Safari/537.36',
                    ],
                    'http_errors' => false,  // Empêche le script de planter si un site renvoie une erreur 403 ou 404
                ]);

                // Si le site a bien répondu (Code 200 = OK)
                if (200 === $response->getStatusCode()) {
                    $xmlString = $response->getBody();
                    // On charge le XML depuis la chaîne de texte récupérée
                    $rss = @simplexml_load_string($xmlString);

                    if ($rss) {
                        $isAtom = isset($rss->entry);
                        $items = $isAtom ? $rss->entry : $rss->channel->item;

                        if ($items) {
                            foreach ($items as $item) {
                                // Extraction
                                if ($isAtom) {
                                    $title = (string) $item->title;
                                    $link = (string) $item->link['href'];
                                    $description = (string) $item->content;
                                    $pubDate = isset($item->published) ? (string) $item->published : (string) $item->updated;
                                } else {
                                    $title = (string) $item->title;
                                    $link = (string) $item->link;
                                    $description = (string) $item->description;
                                    $pubDate = (string) $item->pubDate;
                                }

                                // Nettoyage de la vraie URL Google Alerts
                                if (str_contains($link, 'google.com/url') && preg_match('/url=([^&]+)/', $link, $matches)) {
                                    $link = urldecode($matches[1]);
                                }

                                // Nettoyage des balises HTML
                                $title = strip_tags($title);
                                $description = strip_tags($description);

                                // Traduction des codes HTML (comme &#39;) en vrais caractères (comme l'apostrophe)
                                // ENT_QUOTES indique qu'on veut convertir les guillemets simples ET doubles
                                $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
                                $description = html_entity_decode($description, ENT_QUOTES, 'UTF-8');

                                // Sécurité : si la date du flux est illisible ou vide, on met la date actuelle
                                $dateSql = !empty($pubDate) ? date('Y-m-d H:i:s', strtotime($pubDate)) : date('Y-m-d H:i:s');

                                $data = [
                                    'title' => $title,
                                    'link' => $link,
                                    'description' => $description,
                                    'pub_date' => $dateSql,
                                    'source' => $sourceName,
                                ];

                                // Insertion
                                if ($model->insertIfNotExists($data)) {
                                    ++$nouveauxArticles;
                                }
                            }
                        }
                    } else {
                        $erreurs[] = "Le flux <b>{$sourceName}</b> a renvoyé du texte, mais ce n'est pas un XML valide.";
                    }
                } else {
                    $erreurs[] = "Le site <b>{$sourceName}</b> a bloqué la requête (Erreur HTTP ".$response->getStatusCode().').';
                }
            } catch (\Exception $e) {
                $erreurs[] = "Impossible de se connecter à <b>{$sourceName}</b> (".$e->getMessage().').';
            }
        }

        // --- AFFICHAGE DU RÉSULTAT ET DES ERREURS ---
        echo "<h3>Mise à jour terminée : {$nouveauxArticles} nouveaux articles ajoutés.</h3>\n<button onclick=\"location.href='../veille'\">Retour à la page de veille</button>";

        if (!empty($erreurs)) {
            echo "<h4>Attention, certaines sources n'ont pas pu être lues :</h4><ul>";
            foreach ($erreurs as $erreur) {
                echo "<li style='color:red;'>{$erreur}</li>";
            }
            echo '</ul>';
        }
    }
}
