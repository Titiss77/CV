<?php
require '../../serveur.php';
require '../../themeRoot.php';

// Récupérer les infos contact (1 seul enregistrement)
$stmt = $connexion->query("SELECT * FROM InfoContact WHERE id = 1");
$contact = $stmt->fetch();

// Récupérer les expériences pro
$stmt = $connexion->query("SELECT * FROM ExpPro ORDER BY id DESC");
$experiences = $stmt->fetchAll();

// Récupérer les formations
$stmt = $connexion->query("SELECT * FROM Formation ORDER BY id DESC");
$formations = $stmt->fetchAll();

// Récupérer les loisirs
$stmt = $connexion->query("SELECT * FROM `loisirs` ORDER BY idLoisir");
$loisirs = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>CV de Mathis FRANCES--LAVILLAUROY</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <link rel="stylesheet" href="https:/cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <header>
        <h1>CV de Mathis FRANCES--LAVILLAUROY</h1>
    </header>

    <section>
        <div class="photo">
            <img src="./images/me.png" alt="Ma photo de profil">
        </div>
        <div class="prez">
            <h2>Qui suis-je ?</h2>
            <p>Diplômé du Baccalauréat et actuellement en BTS SIO.</p>
            <a href="./images/CV- Mathis Frances--Lavillauroy.pdf" download>Mon CV au format PDF</a>
        </div>
        <div class="contact">
            <h2>Informations de contact</h2>
            <div class="contact-flex">
                <p>Nom : </p>
                <p><?= htmlspecialchars($contact['Nom']) ?></p>
            </div>
            <div class="contact-flex">
                <p>Adresse : </p>
                <p><?= htmlspecialchars($contact['Adresse']) ?></p>
            </div>
            <div class="contact-flex">
                <p>Téléphone :</p>
                <p><?= htmlspecialchars($contact['Telephone']) ?></p>
            </div>
            <div class="contact-flex">
                <p>Mail : </p>
                <p><a href="mailto:<?= htmlspecialchars($contact['Mail']) ?>"><?= htmlspecialchars($contact['Mail']) ?></a></p>
            </div>
            <div class="contact-flex">
                <p>Permis :</p>
                <p><?= htmlspecialchars($contact['Permis']) ?></p>
            </div>
            <div class="social">
                <a href="https://www.linkedin.com/in/mathis-frances-lavillauroy-83890a330/" target="_blank"><img src="./images/lk.png" alt="Logo Lk"></a>
            </div>
        </div>
    </section>

    <section>
        <h2>Expériences professionnelles</h2>
        <?php foreach ($experiences as $exp): ?>
            <div class="exp">
                <div class="exp-logo">
                    <a href="#"><img src="<?= htmlspecialchars($exp['cheminImg']) ?>" alt="<?= htmlspecialchars($exp['Libelle']) ?>" class="cheminImg"></a>
                </div>
                <div class="exp-info">
                    <h3 class="Libelle"><?= htmlspecialchars($exp['Libelle']) ?></h3>
                    <h4 class="NomEntreprise"><?= htmlspecialchars($exp['NomEntreprise']) ?></h4>
                    <h4 class="Periode"><?= htmlspecialchars($exp['Periode']) ?></h4>
                </div>
                <div class="exp-desc">
                    <p class="Description"><?= htmlspecialchars($exp['Description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section>
        <h2>Formation</h2>
        <?php foreach ($formations as $form): ?>
            <div class="exp">
                <div class="exp-logo">
                    <a href="#"><img src="<?= htmlspecialchars($form['CheminImg']) ?>" alt="Logo école"></a>
                </div>
                <div class="exp-info">
                    <h3 class="NomEtablissement"><?= htmlspecialchars($form['NomEtablissement']) ?></h3>
                    <h4 class="Periode"><?= htmlspecialchars($form['Periode']) ?></h4>
                </div>
                <div class="exp-desc">
                    <p><?= htmlspecialchars($form['Description']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <section>
        <h2>Compétences</h2>
        <h3 class="h3gauche">Professionnelles</h3>
        <div class="comp">
            <p>HTML / CSS</p>
            <div class="conteneur-barre"><span class="barre c100"></span></div>
        </div>
        <div class="comp">
            <p>MySQL</p>
            <div class="conteneur-barre"><span class="barre c100"></span></div>
        </div>
        <div class="comp">
            <p>JavaScript</p>
            <div class="conteneur-barre"><span class="barre c70"></span></div>
        </div>
        <div class="comp">
            <p>Python</p>
            <div class="conteneur-barre"><span class="barre c100"></span></div>
        </div>

        <h3 class="h3gauche">Personnelles</h3>
        <div class="comp2">
            <p>Créativité</p>
            <p>90%</p>
            <div class="conteneur-barre2"><span class="barre c90"></span></div>
        </div>
        <div class="comp2">
            <p>Adaptation</p>
            <p>90%</p>
            <div class="conteneur-barre2"><span class="barre c90"></span></div>
        </div>
        <div class="comp2">
            <p>Sérieux</p>
            <p>95%</p>
            <div class="conteneur-barre2"><span class="barre c95"></span></div>
        </div>
        <div class="comp2">
            <p>Pédagogie</p>
            <p>95%</p>
            <div class="conteneur-barre2"><span class="barre c95"></span></div>
        </div>
        <div class="comp2">
            <p>Utilisation de l'IA</p>
            <p>70%</p>
            <div class="conteneur-barre2"><span class="barre c70"></span></div>
        </div>
    </section>

    <section>
        <h2>Centres d'intérêt</h2>
        <?php foreach ($loisirs as $form): ?>
            <figure class="interet">
                <img src="../../<?= htmlspecialchars($form['urlImage']) ?>" alt="Coder">
                <figcaption><?= htmlspecialchars($form['libelle']) ?></figcaption>
            </figure>
        <?php endforeach; ?>
    </section>
</body>

</html>
