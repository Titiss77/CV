<?php echo $this->extend('templates/layout'); ?> 
<?php echo $this->section('content'); ?> 

<div class="veille">
    <h1>Veille Technologique : L'internet des objets (IoT)</h1>
    <button class="btn_maj" onclick="location.href='veille/fetch_rss'">Mettre à jour</button>

    <!-- Affichage de la synthèse indépendante -->
    <?php if (!empty($synthese)) { ?>
    <div class="synthese-encart" style="background: #f8f9fa; padding: 25px; border-radius: 10px; margin-bottom: 40px; border-left: 6px solid #dd4814; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="margin-top: 0; color: #333;"><?php echo esc($synthese['titre']); ?></h2>
        <div class="meta" style="font-size: 0.85em; color: #888; margin-bottom: 15px;">
            Dernière mise à jour : <?php echo date('d/m/Y', strtotime($synthese['date_mise_a_jour'])); ?>
        </div>
        <p style="line-height: 1.7; color: #444;">
            <?php echo nl2br(esc($synthese['contenu'])); ?>
        </p>
    </div>
    <?php } ?>

    <!-- Liste des articles -->
    <?php if (!empty($articles) && is_array($articles)) { ?> 
    <div class="articles-grid">
        <?php foreach ($articles as $article) { ?>
        <div class="article-card">
            <h2>
                <a href="<?php echo esc($article['link']); ?>" target="_blank" rel="noopener noreferrer">
                    <?php echo esc($article['title']); ?>
                </a>
            </h2>
            <div class="meta">
                <span class="source-badge"><?php echo esc($article['source']); ?></span>
                <br> Publié le : <?php echo date('d/m/Y à H:i', strtotime($article['pub_date'])); ?>
            </div>
            <div class="description">
                <?php echo character_limiter(strip_tags($article['description']), 200); ?>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</div>

<?php echo $this->endSection(); ?>