<div class="row center">
    <div class="col s12">
        <h5>Ajouter un relevé</h5>
    </div>
</div>
<div class="row">
    <form method="POST" class="col s12">
        <div class="row">
            <div class="input-field col s4">
                <input id="temp1" name="temp1" type="text" class="validate" required>
                <label for="temp1">Température 1</label>
            </div>
            <div class="input-field col s4">
                <input id="temp2" name="temp2" type="text" class="validate" required>
                <label for="temp2">Température 2</label>
            </div>
            <div class="input-field col s4">
                <input id="pressure" name="pressure" type="text" class="validate" required>
                <label for="pressure">Pression</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s3">
                <input id="hygro" name="hygro" type="text" class="validate">
                <label for="hygro">Humidité</label>
            </div>
            <div class="input-field col s3">
                <input id="lux" name="lux" type="text" class="validate">
                <label for="lux">Luminosité</label>
            </div>
            <div class="input-field col s3">
                <input id="windSpeed" name="windSpeed" type="text" class="validate">
                <label for="windSpeed">Vitesse du vent</label>
            </div>
            <div class="input-field col s3">
                <input id="windDir" name="windDir" type="text" class="validate">
                <label for="windDir">Orientation du vent</label>
            </div>
        </div>
        <button class="btn waves-effect waves-light right" type="submit" name="one">Enregistrer
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>

<?php if (isset($result)): ?>
<script>
    <?php if ($result): ?>
    Materialize.toast('Relevé ajouté avec succès !', 3000, 'rounded');
    <?php else: ?>
    Materialize.toast('Erreur dans l\'ajout du relevé !', 3000, 'rounded');
    <?php endif ?>
</script>
<?php endif; ?>

<div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
    <a href="../stations/<?= $station->id; ?>" class="btn-floating btn-large red">
        <i class="large material-icons">replay</i>
    </a>
</div>