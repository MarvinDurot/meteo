### Documentation de l'API
- - -

*Cette documentation est entièrement rédigée en Markdown et ça c'est cool :)*

#### Qu'est-ce qu'une API REST ?

REST est un style d’architecture qui repose sur le protocole HTTP.

On accède à une ressource par son URI unique pour procéder à diverses opérations (supportées nativement par HTTP) :
GET lecture / POST écriture / PUT modification / DELETE suppression.

#### Actions

> 1. Lister les stations :
    - **GET** `api/stations`
2. Afficher une station :
    - **GET** `api/station/:id`
3. Afficher les mesures d'une station :
   - **GET** `api/mesures/:station`
4. Ajouter une mesure :
    - **POST** `api/mesures`