# sib-listTS2sql
Fetch Sendinblue lists total subscribers and inject the results into SQL DB

# French

### Résumé
Sendinblue peut faire office de "CRM" : gestion des contacts, de l'historique des échanges et interactions avec le contact, etc. La partie Contacts de Sendinblue fonctionne avec des listes.

Ces listes peuvent être créées à volonté selon vos besoins. Via l'API de Sendinblue il est possible de manipuler les informations des contacts au sein de ces listes.
Pour plus d'informations : https://developers.sendinblue.com/docs

### Problématique

Nativement nous ne possédons aucun moyen de générer des KPI ou stats de performance liés à ces listes. Aucun moyen non plus de savoir combien il y avait de contacts à une date donnée dans telle ou telle liste.

### Solution

Grâce à l'API Sendinblue il est possible de faire une extraction de tous les contacts de toutes les listes et de les injecter dans une base de données afin de pouvoir effectuer des reqêtes plus précises, conserver un historique du nombre de contacts dans une liste à un instant T ou durant une certaine période de dates, etc.

J'ai donc écrit ce petit script qui, à l'aide de l'API PHP Sendinblue :

- se connecte à notre compte SIB
- récupère la totalité des infos de nos listes avec la  fonction getLists()
- sélectionne le nombre total de contacts dans les listes dont nous avons besoin
- les injecte dans une base de données MySQL tournant en local sur un petit Raspberry Pi (temporaire)

Le script tourne tous les jours, une ligne = 1 jour. Nous récupérons ces infos via Excel grâce à un requêtage SQL. Nous pouvons ainsi choisir par la suite une plage de dates pour avoir une visu sur les contacts présents dans telle ou telle liste pendant une période ou un jour donné.

Plusieurs améliorations sont possibles et sont en cours de réflexion.

A noter qu'il existe sûrement des connecteurs existants pour faire la liaison entre Sendinblue et une base MySQL (Zappier, etc.)

# English

Coming soon...
