<!--   Icon Section   -->
<div class="row">

    <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
        <a class="btn-floating btn-large red">
            <i class="large material-icons">add</i>
        </a>
        <ul>
            <li><a href="../releves/<?= $station->id ?>" class="btn-floating red"><i class="material-icons">playlist_add</i></a></li>
            <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
        </ul>
    </div>

    <div class="col s12 m4">
        <h5><?= $station->id; ?></h5>

        <p class="light"><?= $station->libelle; ?></p>
        <p>Latitude: <?= $station->latitude; ?></p>
        <p>Longitude: <?= $station->longitude; ?></p>
        <p>Altitude: <?= $station->altitude; ?></p>
    </div>

    <div class="col s12 m8">
        <h5>Derniers relevés</h5>

        <table class="centered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Température 1</th>
                    <th>Température 2</th>
                    <th>Pression</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($releves as $releve): ?>
                <tr>
                    <td><?= $releve->quand; ?></td>
                    <td><?= $releve->temp1; ?></td>
                    <td><?= $releve->temp2; ?></td>
                    <td><?= $releve->pressure; ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>