<?php use \Michelf\Markdown; ?>

<div class="row">
    <div class="col s8">
        <?php
            echo Markdown::defaultTransform(
                file_get_contents(ROOT . '/public/documentation.md')
            );
        ?>
    </div>
</div>