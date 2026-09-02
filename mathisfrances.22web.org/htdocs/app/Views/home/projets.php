<?php echo $this->extend('templates/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="projets-grid">
    <?php if (!empty($projets)) { ?>
    <?php foreach ($projets as $projet) { ?>
    <div class="projet-card">
        <span
            class="date"><?php echo date('d/m/Y', strtotime($projet['dateRealisation'] ?? $projet['date_realisation'])); ?></span>
        <div class="titre"><?php echo esc($projet['libelleProjet'] ?? $projet['libelle']); ?></div>
        <div class="description"><?php echo esc($projet['descriptionProjet'] ?? $projet['description']); ?></div>
        <button
            onclick="window.open('<?php echo esc($projet['urlProjet'] ?? $projet['lien']); ?>', '_blank', 'noopener,noreferrer')"
            type="button">
            Ouvrir le projet
        </button>
    </div>
    <?php } ?>
    <?php } else { ?>
    <p style="text-align: center; width: 100%;">Aucun projet à afficher.</p>
    <?php } ?>
</div>

<?php echo $this->endSection(); ?>