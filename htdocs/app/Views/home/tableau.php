<?php echo $this->extend('templates/layout'); ?>

<?php echo $this->section('content'); ?>

<div class="tableau">
    <table id="monTableau">
        <thead>
            <tr>
                <th>Activité Bloc n°1</th>
                <th>Compétences</th>
                <th>VU</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categories as $categorie) { ?>
            <?php
                $rowspan = count($categorie['competences']);
                $firstRow = true;
                foreach ($categorie['competences'] as $comp) {
                    ?>
            <tr>
                <?php if ($firstRow) { ?>
                <td rowspan="<?php echo $rowspan; ?>"><?php echo esc($categorie['appellation'] ?? $categorie['libelle']); ?></td>
                <?php $firstRow = false; ?>
                <?php } ?>

                <td><?php echo esc($comp['libelle']); ?></td>

                <?php if ('1' === $comp['vu'] && $comp['justification_data']) { ?>
                <?php
                            $justification = nl2br(htmlspecialchars($comp['justification_data']['justification'], ENT_QUOTES));
                    // NOUVEAU : On récupère urlDrive à la place de l'image
                    $url_drive = !empty($comp['justification_data']['urlDrive']) ? esc($comp['justification_data']['urlDrive']) : '';
                    ?>
                <td style="text-align: center;">
                    <button class="btn-justification" data-justification="<?php echo $justification; ?>"
                        data-drive="<?php echo $url_drive; ?>">X</button>
                </td>
                <?php } else { ?>
                <td></td>
                <?php } ?>
            </tr>
            <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>

<div id="overlay"></div>
<div class="justification-popup" id="popup">
    <button class="close-btn" onclick="closePopup()">Fermer</button>
    <p id="justification-text" style="font-size: 1.1em; line-height: 1.5; margin-bottom: 25px;"></p>

    <a id="justification-drive-btn" href="#" target="_blank" rel="noopener noreferrer" class="drive-btn"
        style="display: none;">
        <i class="fas fa-external-link-alt"></i> Consulter le document joint
    </a>
</div>

<script>
document.querySelectorAll('.btn-justification').forEach(btn => {
    btn.addEventListener('click', () => {
        const justification = btn.getAttribute('data-justification');
        const urlDrive = btn.getAttribute('data-drive'); // On récupère l'URL

        document.getElementById('justification-text').innerHTML = justification;
        const driveBtn = document.getElementById('justification-drive-btn');

        // Si un lien Drive existe, on configure le href et on affiche le bouton
        if (urlDrive && urlDrive !== 'null' && urlDrive !== '') {
            driveBtn.href = urlDrive;
            driveBtn.style.display = 'inline-block';
        } else {
            // Sinon, on cache le bouton
            driveBtn.style.display = 'none';
        }

        document.getElementById('popup').style.display = 'flex';
        document.getElementById('overlay').style.display = 'block';
    });
});

function closePopup() {
    document.getElementById('popup').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}

document.getElementById('overlay').addEventListener('click', closePopup);
</script>

<?php echo $this->endSection(); ?>