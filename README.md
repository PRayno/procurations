# Application de gestion des procurations

Cette application permet à un utilisateur de déclarer et d'imprimer une procuration de vote.

## Pré-requis

L'application est basée sur le framework Symfony en version 4.4 et nécessite un serveur web avec PHP 7.1+ et MySQL / MariaDB.

L'authentification s'effectue par le biais d'un serveur CAS et la gestion des administrateurs de l'application à l'aide d'une requête LDAP.

## Installation

1. Récupération du code
2. Installation des librairies en utilisant Composer `composer install`
3. Configuration de l'environnement `cp .env .env.local` puis édition des paramètres
4. Création et installation de la base de données `bin/console doctrine:database:create` puis `bin/console doctrine:schema:create`

## Configuration

Explication des variables de configuration de l'appli (dans .env.local) :

Configuration LDAP
```dotenv
LDAP_URL=ldaps://ldapserver:636
LDAP_BIND_DN="cn=user,ou=foo,dc=bar,dc=fr"
LDAP_BIND_PASSWORD="MySecretPassword"
LDAP_USER_DN="ou=people,dc=bar,dc=fr"
```

Requête LDAP correspondant aux utilisateurs admin de l'application (nous gérons ces accès en utilisant un groupe LDAP).
Attention à bien mettre {{username}} qui sera remplacé par le login renvoyé par le serveur CAS
```dotenv
LDAP_ADMIN_QUERY="(&(memberOf=cn=myadmingroup,ou=groups,dc=bar,dc=fr )(uid={{username}}))"
```

Les variables `PDF_GENERATOR_URL` et `THEME` 

### Configurer l'apparence de l'application

Vous pouvez insérer une feuille de style, du CSS ou même modifier le squelette du HTML généré en créant votre propre fichier de base.

1. Copier le répertoire de theme uca (templates/themes/uca) et le renommer du nom de votre theme
2. Modifier le fichier base.html.twig avec les changements souhaités
3. Editer le fichier `.env.local` avec le nom de votre theme dans la variable `THEME`
4. Vider le cache (si vous êtes en environnement  de production)

### Edition des PDF

L'application permet à un utilisateur de générer un PDF. A l'Université Clermont Auvergne, 
nous avons un web service interne qui permet la génération de PDF à partir d'une requête HTTP 
(définie dans la variable `PDF_GENERATOR_URL`).

Pour définir sa propre implémentation de la génération du PDF, il faut :

1. Créer une nouvelle classe qui implémente l'interface `App\Logic\PdfInterface`
2. Coder les fonctions de cette classe avec votre logique de création du template et de génération du PDF
3. Décrire cette classe comme étant celle qui est utilisée par `App\Logic\PDF` dans le fichier `config/services.yml` (voir https://symfony.com/doc/current/service_container.html#explicitly-configuring-services-and-arguments)
