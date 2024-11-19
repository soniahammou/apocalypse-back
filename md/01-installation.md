# Installation

## TLDR

```bash
# installation de symfony
composer create-project symfony/skeleton

# Eventuellement déplacer les fichiers
mv skeleton/* ./
mv skeleton/.* ./
rmdir skeleton

# création du fichier de configuration
touch .env.local

# installation des composants de base pour une app web
# a terme on utilisera `composer require webapp`
composer require symfony/apache-pack twig symfony/asset symfony/orm-pack symfony/form symfony/validator symfony/security-csrf

# les composants à installer en dev
composer require --dev symfony/profiler-pack
composer require --dev symfony/debug-bundle symfony/maker-bundle

# ajout de la configuration de BDD dans le .env.local, 
# MODIFIER le nom de la bdd et la version de mariadb
echo "DATABASE_URL=\"mysql://explorateur:6q595XmCKm@127.0.0.1:3306/LE_NOM_DE_MA_BDD?serverVersion=10.3.39-MariaDB&charset=utf8mb4\"" > .env.local
bin/console doctrine:database:create
```

## Installation avec composer

```bash
# installation de symfony skeleton
composer create-project symfony/skeleton
# facultatif déplacer les fichiers dans le repo actuel
mv skeleton/* ./
mv skeleton/.* ./
rmdir skeleton
# création du fichier de configuration en local
touch .env.local
```

## Pour accéder avec apache

On installe le symfony/apache-pack

```bash
composer require symfony/apache-pack
```

## Installation de Twig

```bash
composer require twig
composer require symfony/asset
```

## WDT (Web Debug Toolbar)

Installation de la WDT ( visible dans une page contenant une balise `body` )

```bash
composer require symfony/profiler-pack
# pour integrer le var_dumper à twig
composer require --dev symfony/debug-bundle
```

## Maker

Le maker génère une base de code prête à l'emploi

```bash
composer require --dev symfony/maker-bundle
```

## Installation de Doctrine

```bash
composer require symfony/orm-pack
# créer la BDD
bin/console doctrine:database:create
```

Habituellement on va :

- modifier nos entités `bin/console make:entity`
- générer une migration `bin/console make:migration`
- appliquer la migration `bin/console doctrine:migration:migrate`

### Erreur lors des migrations

Si on n'a pas encore livré en prod => supprimer la BDD et relancer les migrations peut résoudre le pb

Si on a déjà livré en prod alors on ne peut pas se permettre de supprimer les données donc il va falloir la modifier pour que cela fonctionne.

1. Détecter la requete qui a généré l'erreur
2. Comprendre pourquoi la requete est en erreur
3. Trouver les requêtes nécessaires pour corriger le soucis et les ajouter à la migration
4. Appliquer à la main les requêtes restantes dans la migration
5. Ajouter une ligne dans la table `doctrine_migration_versions` pour que doctrine sache que la migration a été appliquée

## Symfony/form

### Installation de Symfony/form

```bash
composer require symfony/form
```

### Création de la classe de formulaire

```bash
bin/console make:form
```

N'hésitez pas à ajouter / supprimer / modifier la configuration générée par le maker.

La liste de [tous les types est disponible ici](https://symfony.com/doc/current/reference/forms/types.html)

### Affichage d'un formulaire

- Dans le controller :
  1. instancier un objet de la classe FormType créé précédemment
  2. fournir cet objet à la vue
- Dans la vue :
  - Utiliser [les fonctions helper de Twig](https://symfony.com/doc/current/form/form_customization.html#form-functions-and-variables-reference) pour afficher le formulaire.
    - on utilisera principalement `form_start`, `form_end` et `form_row`

Pour demander au composant form de générer du HTML compatible avec boostrap.
Ajouter dans la configuration

```yml
# config/packages/twig.yaml
twig:
    form_themes: ['bootstrap_5_layout.html.twig']
```

### Validation des données

La liste des [contraintes existantes](https://symfony.com/doc/current/validation.html#constraints)

- Installer le composant symfony/validator `composer require symfony/validator`
- Ajouter les contraintes
  - sur l'entité directement
  - ou dans le FormType

### Attaque csrf

Pour protéger nos formulaires des attaques csrf, on ajoute le composant suivant :

```bash
composer require symfony/security-csrf
```

## Sécurité

### Authentification

```bash
# installer le composant de sécurité
composer require symfony/security-bundle
# créer l'entité user utilisée par le composant de sécurité
php bin/console make:user

bin/console make:migration
bin/console doctrine:migration:migrate

# hasher un mot de passe pour notre premier utilisateur
bin/console security:hash-password
# avec adminer créer un user ( utiliser le mdp haché ) et mettre [] dans le champ rôle

# créer le formulaire d'authentification
php bin/console make:security:form-login
```
