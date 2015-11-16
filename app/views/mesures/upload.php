<div class="row center">
    <div class="col s12">
        <h5>Ajouter plusieurs relevés</h5>
    </div>
</div>
<div class="row">
    <form method="POST" class="col s12">
        <div class="file-field input-field">
            <div class="btn">
                <span>Upload</span>
                <input type="file" multiple>
            </div>
            <div class="file-path-wrapper">
                <input class="file-path validate" type="text" placeholder="Fichier XML">
            </div>
        </div>
        <button class="btn waves-effect waves-light right" type="submit" name="two">Envoyer
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