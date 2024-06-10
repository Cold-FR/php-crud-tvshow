# sae2-01

## Auteur : Clément DAVID (davi0063) et Killian Bouroult (bour0415)

## Installation / Configuration

### Dépendances

Pour installer les dépendances, il suffit de lancer la commande suivante :
```shell
composer install
```

### Auto-chargement des classes

En cas de besoin, pour recharger l'auto-chargement des classes, il suffit de lancer la commande suivante :
```shell
composer dump-autoload
```

### Configuration de la base de données

Pour configurer la base de données, il suffit de créer un fichier `.mypdo.ini` à la racine du projet avec le contenu suivant, en remplaçant les `...` par les valeurs correspondantes :
```ini
[mypdo]
dsn = ...
username = ...
password = ...
```

## Serveur Web local

Si vous êtes sur Linux, avant de lancer une des commandes ci-dessous, exécutez cette commande :
```shell
setfacl -m u::rwx bin/run-server.sh
```

Pour lancer le serveur web local, il suffit de lancer la commande suivante :  
Pour Linux :
```shell
composer start:linux
```
ou
```shell
composer start
```
Pour Windows :
```shell
composer start:windows
```

## Style de codage

Pour vérifier le style de codage, on utilise PHP CS Fixer :
- Commande pour vérifier le style de codage et voir les changements possibles : 
```shell
composer test:cs
```
- Commande pour corriger le style de codage et appliquer les changements : 
```shell
composer fix:cs
```
