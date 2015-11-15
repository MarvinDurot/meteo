<ul class="collection with-header">
    <li class="collection-header"><h4>Stations</h4></li>
    <?php foreach ($stations as $station): ?>
        <li class="collection-item">
            <div>
                <?= $station->id ?>
                <a href="stations/<?= $station->id; ?>" class="secondary-content">
                    <i class="material-icons">send</i></a>
            </div>
        </li>
    <?php endforeach; ?>
</ul>