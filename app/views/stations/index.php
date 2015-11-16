<ul class="collection with-header">
    <li class="collection-header center"><h4>Stations</h4></li>
    <?php foreach ($stations as $station): ?>
        <li class="collection-item">
            <div>
                <strong><?= $station->id ?></strong> // <?= $station->libelle ?>
                <a href="stations/<?= $station->id; ?>" class="secondary-content">
                    <i class="material-icons">send</i></a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>

<div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
    <a href="./mesures" class="btn-floating btn-large red">
        <i class="large material-icons">publish</i>
    </a>
</div>
