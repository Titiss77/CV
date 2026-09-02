<?php echo $this->extend('templates/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="main">

    <section class="presentation" id="presentation">
        <img src="<?php echo base_url(esc($personne['photo_de_profil'])); ?>" alt="photo de profil" class="image">
        <p class="nom"><?php echo esc($personne['prenom']).' '.esc($personne['nom']); ?></p>
        <p class="etudes"><?php echo esc($personne['etudes']); ?></p>

        <div class="liens_extern">
            <p class="entete">Liens externes</p>
            <?php foreach ($lienExternes as $lien) { ?>
            <a href="<?php echo esc($lien['url']); ?>" id="lien">➜ <?php echo esc($lien['libelle']); ?></a>
            <?php } ?>
        </div>

        <div class="div_age">
            <p class="entete">Âge</p>
            <p id="info"><?php echo calculate_age($personne['date_de_naissance']); ?> ans</p>
        </div>

        <div class="div_loca">
            <p class="entete">Localisation</p>
            <p id="info"><?php echo esc($personne['localisation']); ?></p>
        </div>
    </section>

    <section class="autre">
        <div class="expertise" id="expertise">
            <p class="entete2">Me concernant</p>
            <p class="perso">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo nl2br(esc($personne['me_concernant'])); ?></p>
        </div>
        <div class="divLoisir">
            <p class="entete2">Loisirs</p>
            <div class="loisir">
                <?php foreach ($loisirs as $loisir) { ?>
                <figure class="interet">
                    <img src="<?php echo base_url(esc($loisir['chemin_image'])); ?>" alt="<?php echo esc($loisir['libelle']); ?>">
                    <figcaption><?php echo esc($loisir['libelle']); ?></figcaption>
                </figure>
                <?php } ?>
            </div>
        </div>
    </section>

    <div class="light" id="light"></div>
</div>
<?php echo $this->endSection(); ?>