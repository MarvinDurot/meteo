# API REST pour données météo

*Ce projet est une expérimentation réalisée dans le cadre de mes études à l'IUT de Valence.*

## Organisation

Le projet est organisé de la manière suivante :
```
app/                  => Partie spécifique à l'application
    config/           => Fichiers de configuration
    controllers/      => Contrôleurs
    migration/        => Script SQL
    models/           => Modèles
    tables/           => Accès aux tables
    view/             => Vues
    App.php           => Instance de l'application
core/                 => Classes métiers génériques (coeur de l'application)
public/               => Partie publique de l'application
    /css              => Feuilles de style
    index.php         => Point d'entrée de l'application
```

## Environnement

- Namespaces gérés par l'autoloader de Composer.
- Documentation générée avec Markdown.
- Interface basée sur Materialize.

## Installation

- Cloner le dépôt sur le serveur distant : `git clone https://github.com/MarvinDurot/meteo.git`
- Activer l'URL Rewriting : `a2enmod rewrite`
- Importer la base de données : `mysql -u USER -p --database BASE < app/migration/meteo.sql`
- Éditer le fichier de configuration : `app/config/database.php`
