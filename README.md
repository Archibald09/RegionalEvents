# RegionalEvents

## Outils utilisés pour la conception de l'application :

- PHP 8.2
- Symfony 6.3
- Xampp
- MySQL
- Bootstrap

## Guide d'installation du projet "RegionalEvents" :

1. Cloner l'application via GitHub : `git clone lien_github` 

2. Effectuer un `composer install`

3. Faire un `php bin/console cache:clear`

4. Décommenter la ligne 28 du .env

5. Créer une base de données avec `php bin/console doctrine:database:create` ou `php bin/console d:d:c`

6. Créer une migration avec `php bin/console make:migration`

7. Migrer avec `php bin/console doctrine:migration:migrate` ou `php bin/console d:m:m`

8. Pour générer des fausses données grâce à la bibliothèque Fakerphp, on utilise `php bin/console doctrine:fixtures:load`

## Presentation de l'application

- L'application est composé d'une page d'acceuil avec la liste complète des évènements, un bouton pour s'inscrire (uniquement si l'utilisateur est connecté), un bouton pour voir l'évènement en détail et d'un filtre pour affiner ses recherches grâce aux dates de début et de fin.

- La navbar se compose d'une section pour créer son évènement (uniquemlent si l'utilisateur est connecté), d'une section pour consulter ses évènements afin les modifiers ou de les supprimers (uniquemlent si l'utilisateur est connecté), d'une section    pour se connecter et une pour s'inscrire. Lorsqu'on est connecté(e), les boutons "se connecter" et "s'inscrire" pour laisser place à un bouton se déconnecter. 

- Le footer est purement décoratif est ne sert à rien.

## Description technique de l'application

- Pour l'inscription et la connexion, j'ai utilisé Sécurity de Symfony, j'ai configuré les conditions pour qu'un mot de passe soit valide.

- La page d'accueil recupère tout les id des évènements et les affichent.

- Les éléments affichés quand l'utilisateur est connecté est géré par des conditions dans twig.

- La table user est composé des propiétés username, lastname, email, password, confirm password et roles.

- La table events est composé des propiétés titre, description, date_debut, date_fin, lieu et user_id (qui est un ManyToOne avec user).

- user_id permet de récupérer uniquement les évènements créer par son utilisateur et est donc relier a ses évènements.

## Ce que je n'ai réussi

- Pour l'inscription aux évènements, après de multiples tentatives, je n'y suis pas arrivé à le faire fonctionner. Mon but était que lorsque que l'on appuie sur le bouton pour s'inscrire, le bouton disparait et l'évènement s'affiche dans la page "mes évènement" et d'avoir également la possibilité de se déinscrire et de réafficher le bouton pour s'inscrire.

- Je ne suis pas encore à l'aise avec la CI et PhpUnit.

- J'ai rencotré des problèmes avec mon projet et Github et je n'ai que peu de commit à mon projet.


