<!--   Icon Section   -->
<div class="row">

    <div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
        <a href="../mesures/<?= $station->id; ?>" class="btn-floating btn-large red">
            <i class="large material-icons">add</i>
        </a>
    </div>

    <div class="col s12 m4">
        <h5><?= $station->id; ?></h5>

        <p class="light"><?= $station->libelle; ?></p>


        <dl>
            <dt>Latitude</dt>
            <dd><?= $station->latitude; ?></dd>
            <dt>Longitude</dt>
            <dd><?= $station->longitude; ?></dd>
            <dt>Altitude</dt>
            <dd><?= $station->altitude; ?></dd>
        </dl>

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