<?php echo $this->extend('templates/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="formulaire">
    <?php if (session()->getFlashdata('success')) { ?>
    <p style="color: green; text-align: center; font-weight: bold;">
        <?php echo session()->getFlashdata('success'); ?>
    </p>
    <?php } ?>

    <?php if (session()->getFlashdata('errors')) { ?>
    <div style="color: red; text-align: center; margin-bottom: 15px;">
        <?php foreach (session()->getFlashdata('errors') as $error) { ?>
        <p><?php echo esc($error); ?></p>
        <?php } ?>
    </div>
    <?php } ?>

    <form action="<?php echo base_url('contact/submit'); ?>" method="post">
        <?php echo csrf_field(); ?> <h2>Formulaire de Contact</h2>

        <div class="sexe-container">
            <label>Sexe :</label>
            <label><input type="radio" name="sexe" value="1" <?php echo '1' == old('sexe') || !old('sexe') ? 'checked' : ''; ?>>
                Homme</label>
            <label><input type="radio" name="sexe" value="2" <?php echo '2' == old('sexe') ? 'checked' : ''; ?>> Femme</label>
        </div>

        <label for="nom">nom :</label>
        <input type="text" name="nom" size="20" value="<?php echo old('nom'); ?>" required>

        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" size="20" value="<?php echo old('prenom'); ?>" required>

        <label for="mail">adresse mail :</label>
        <input type="email" name="mail" size="20" value="<?php echo old('mail'); ?>" required>

        <label for="texte">Message :</label>
        <textarea class="messageBox" name="texte" rows="5" required><?php echo old('texte'); ?></textarea>

        <p>
            <input type="submit" value="Envoyer">
            <input type="reset" value="Annuler">
        </p>
    </form>
</div>
<?php echo $this->endSection(); ?>