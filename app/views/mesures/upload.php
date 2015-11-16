<div class="row center">
    <div class="col s12">
        <h5>Ajouter plusieurs relevés</h5>
    </div>
</div>
<div class="row">
    <form method="POST" class="col s12" enctype="multipart/form-data">
        <div class="file-field input-field">
            <div class="btn">
                <span>Upload</span>
                <input name="csv" type="file" multiple>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Fichier CSV">
            </div>
        </div>
        <button class="btn waves-effect waves-light right" type="submit" name="send">Envoyer
            <i class="material-icons right">send</i>
        </button>
    </form>
</div>

<?php if (isset($result)): ?>
    <script>
        <?php if ($result): ?>
        Materialize.toast('Relevés ajoutés avec succès !', 5000, 'rounded');
        <?php else: ?>
        Materialize.toast('Erreur dans l\'ajout des relevés !', 5000, 'rounded');
        <?php endif ?>
    </script>
<?php endif; ?>

<div class="fixed-action-btn horizontal" style="bottom: 45px; right: 24px;">
    <a href="<?= HOME; ?>" class="btn-floating btn-large red">
        <i class="large material-icons">replay</i>
    </a>
</div>
