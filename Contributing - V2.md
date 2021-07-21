![Ellipse: 8](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.001.png)![Zone de Texte: Projet](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.002.png)![](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.003.png)ToDoList

Créée par ToDo&Co

![](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.004.png)































|||
| :- | :- |
||![](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.005.png)|





Marc-Alban MILLET                                                               Juillet 2021



![](Aspose.Words.34f6655e-a848-4565-a1a6-c1ad1e7367b1.006.png)







Sommaire

[**COMMENT CONTRIBUER : 2**](#_TOC77423180)

[ETAPE 1 : OBTENEZ LE REPOSITORY. 3](#_Toc77423181)

[ÉTAPE 2 - TRAVAILLER SUR LE PROJET : 4](#_Toc77423182)

[ÉTAPE 3 - PROPOSEZ VOS MODIFICATIONS AU PROJET : 6](#_Toc77423183)

[**FAIRE EN SORTE QUE VOTRE CODE SUIVE LES NORMES DE CODAGE ET LE PROCESSUS DE QUALITÉ  8**](#_TOC77423184)

[NORMES DE CODAGE. 8](#_Toc77423185)

[PROCESSUS DE QUALITÉ. 9](#_Toc77423186)




# Comment contribuer :
***(Toutes les commandes utilisées dans ce document sont sur : <https://git-scm.com/doc>)***

Améliorer une application Symfony existante de ToDo&Co. C'est une application pour gérer les tâches quotidiennes.

Pour contribuer à ce projet, suivez les étapes ci-dessous.

Avant de suivre ces étapes, vous devez installer [**git**](https://git-scm.com/), [**composer**](https://getcomposer.org/) sur votre machine locale et créer un compte GitHub.


## **Etape 1 : obtenez le repository**
**1. Tout d'abord, vous avez besoin d'un fork local du projet.**

Alors bifurquez le repository "ToDoList" en cliquant sur le bouton "fork" en haut à droite de cette page. Cela créera une copie de ce référentiel dans votre propre compte GitHub et vous verrez une note indiquant qu'il a été bifurqué sous le nom du projet : "**forked from Marc-Alban/ToDoList**".



**2. Maintenant, vous avez besoin d'une copie localement. Alors clonez votre copie de GitHub sur votre machine locale.**

Cliquez sur le bouton "**code**". Cliquez ensuite sur l'icône copier dans le presse-papiers, revenez à votre terminal et exécutez la commande git :

**à git clone [https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git**](https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git)**

Vous pouvez également télécharger le ZIP avec le bouton "Télécharger ZIP".

Ici, vous copiez le contenu du référentiel "ToDoList" dans GitHub sur votre machine locale dans un répertoire appelé comme le référentiel : "ToDoList".

Toujours au niveau de votre terminal, le chemin vers le répertoire cloné est pris en compte une fois cloné. Il ne reste plus qu’à y accéder à ce répertoire.

Exécutez cette commande : **cd ToDoList**

**3. Ajoutez le référentiel ToDoList d'origine en tant que "git remote" appelé upstream.**

Le référentiel distant sur votre GitHub et appelé « **origin** ».

À ce stade, si vous souhaitez garder votre fork synchronisé avec le référentiel ToDoList forké, vous devez configurer « **git remote** » qui pointe vers le projet d'origine afin que vous puissiez récupérer les modifications et les importer dans votre copie locale.

Cliquez d'abord sur le lien vers le référentiel d'origine - il est étiqueté "Forked from" en haut de la page GitHub. Cela vous ramène à la page GitHub du projet principal, vous pouvez donc trouver « l**'URL de clonage SSH** » et l'utiliser pour créer la nouvelle « git **remote** », que nous appellerons « **upstream »**.

Exécuter cette commande :

**->git remote add upstream [https://github.com/Marc-Alban/ToDoList.git**](https://github.com/Marc-Alban/ToDoList.git)**

Vérifiez le nouveau dépôt en amont que vous avez spécifié pour votre fork :

**->git remote -v**

**->origin https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git (fetch)**

**->origin https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git (push)**

->**upstream https://github.com/Marc-Alban/ToDoList.git (fetch)**

->**upstream https://github.com/Marc-Alban/ToDoList.git (push)**

Vous disposez maintenant de deux « remote » pour ce projet :

1. Origin, qui pointe vers votre **fork** GitHub du projet. (Vous pouvez lire et écrire).
1. Upstream, qui pointe vers le référentiel GitHub du projet principal. (Vous ne pouvez lire qu'à partir de cette **remote**).

Récupérez tous les commits des branches amont en exécutant cette commande :

->**git fetch upstream**

Le but de cette étape est de vous permettre de travailler simultanément sur le référentiel officiel ToDoList et sur votre propre fork.
## **Étape 2 - Travailler sur le projet :**
\1.    Installez le projet en vous référant à README.md.
**


\2.    Accédez au répertoire du référentiel sur votre ordinateur (si vous n'y êtes pas déjà). **« cd ToDoList/ »**
**


\3.    Créez une nouvelle branche dédiée à vos modifications.

Utilisez un nom court et mémorisable pour la nouvelle branche (si vous résolvez un problème signalé, utilisez **« fix\_XXX »** comme nom de branche, où **XXX est le numéro du problème**) :

**à git checkout -b my-new-feature upstream/features**

Dans cet exemple, le nom de la branche est **« my-new-feature »** et la valeur **« upstream/features »** indique à Git de créer cette branche en fonction de la branche de fonctionnalités de la remote en amont, qui est le référentiel ToDoList d'origine.

Les correctifs doivent toujours être basés sur la branche maintenue la plus ancienne qui contient l'erreur. Si vous documentez plutôt une nouvelle fonctionnalité, passez à la branche **« upstream/features »**. Si vous n'êtes pas sûr, utilisez la branche **« upstream/master »**.



\4.    Faites vos modifications.

Avant d'effectuer vos modifications, lisez les [bonnes pratiques](https://github.com/caroleguardiola/P8-OC-ToDoList/blob/master/documentation/Contributing%20to%20the%20project.md#making-your-code-follow-the-coding-standards-and-quality-process) :

***(Faites en sorte que votre code suive les normes de codage et le processus de qualité)***



\5.   Commiter vos modifications :

Si le contenu modifié existait auparavant :

**à git commit -am ‘Add some feature'**

Si le contenu modifié n'existait pas auparavant :

**à git add Feature.php**

**à git commit -m 'Add some feature'**

Assurez-vous d'écrire des messages de validation clairs.

\6.    Envoyez les modifications à votre référentiel forké :

**à git push origin my-new-feature**

La valeur origin est le nom de la remote qui correspond à votre référentiel fork et « my-new-feature » est le nom de la branche que vous avez créée précédemment.  Cela créera cette branche sur votre projet GitHub.


## **Étape 3 - Proposez vos modifications au projet :**
**1. Créez une Pull Request**

Tout est maintenant prêt pour initier une pull request. Accédez à votre référentiel forké à : [**https://github.com/YOUR-GITHUB-USERNAME/ToDoList**](https://github.com/YOUR-GITHUB-USERNAME/ToDoList)

Vous verrez que votre nouvelle branche est répertoriée en haut avec un bouton pratique **“Compare & pull request”.** Cliquez ensuite sur ce bouton.

Sur cette page, assurez-vous que le **fork** **de base** pointe vers le bon référentiel et la bonne branche. Dans cet exemple, le **fork de base** doit être Marc-Alban/ToDoList et la **branche de base** doit être la **feature**, qui est sur la branche sur laquelle vous avez sélectionné pour baser vos modifications.

Le **head fork** principale doit être YOUR-GITHUB-USERNAME/ToDoList (votre copie fork de ToDoList) et la branche de comparaison doit être **« my-new-feature »**, qui est le nom de la branche que vous avez créée et où vous avez apporté vos modifications.

Ensuite, assurez-vous de fournir un bon titre succinct pour votre pull request et expliquez pourquoi vous l'avez créé dans la zone de description. Ajoutez tous les numéros de problème pertinents si vous en avez.

**2. Soumettez la Pull Request**

Vous devez maintenant soumettre la **pull request** au référentiel ToDoList d'origine. Pour ce faire, appuyez sur le bouton **“Create pull request”** et vous avez terminé.

**3. Révision par les « Reviseurs »**

Pour que votre travail soit intégré au projet, les réviseurs examineront votre travail et vous informeront de tout changement requis ou le fusionneront.

Dans le cas où l'on vous demande d'ajouter ou de modifier quelque chose, ne créez pas de nouvelle pull request. Au lieu de cela, assurez-vous que vous êtes sur la bonne branche, apportez vos modifications et envoyez les nouvelles modifications :

**à cd P8-OC-ToDoList**

**à git checkout my-new-feature**

Effectuez vos modifications et envoyer les avec :

**à git push**

**4. Synchronisez votre fork avec le référentiel d'origine après les modifications**

La branche master de votre fork n'aura pas les changements. Afin de garder votre fork synchronisé avec le référentiel ToDoList d'origine, suivez les étapes ci-dessous :

Une fois les modifications fusionnées dans le référentiel ToDoList d'origine, extrayez sa nouvelle version :

**à git pull upstream master**

Pour que votre fourche ait les changements :

**à git push origin master**

Remarquez ici que vous poussez vers la remote nommée origin.
# Faire en sorte que votre code suive les normes de codage et le processus de qualité

## **Normes de codage**


Pour que chaque morceau de code soit familier, Symfony définit des normes de codage que toutes les contributions doivent suivre.

Assurez-vous donc que votre code respecte :

- [Normes de codage Symfony](https://symfony.com/doc/current/contributing/code/standards.html)
- [Recommandations de normes PHP (PSR)](https://www.php-fig.org/psr/)
  - [PSR-1](https://www.php-fig.org/psr/psr-1/)
  - [PSR-2](https://www.php-fig.org/psr/psr-2/)
  - [PSR-4](https://www.php-fig.org/psr/psr-4/)
- [Bonnes pratiques Symfony](https://symfony.com/doc/current/best_practices.html)
- [Conventions Symfony](https://symfony.com/doc/current/contributing/code/conventions.html)

Veuillez également suivre ces recommandations :

- Avoir un code lisible, utiliser des noms de variables compréhensibles, extraire des fonctions si besoin, éviter un code trop complexe

« PHP\_CodeSniffer est un ensemble de deux scripts PHP ; le phpcsscript principal qui tokenise les fichiers PHP, JavaScript et CSS pour détecter les violations d'une norme de codage définie, et un second phpcbfscript pour corriger automatiquement les violations de norme de codage. PHP\_CodeSniffer est un outil de développement essentiel qui garantit que votre code reste propre et cohérent. » 

(Source : https://github.com/squizlabs/PHP\_CodeSniffer)

Installez l'outil [**PHP ](https://cs.sensiolabs.org/)**CodeSniffer** puis exécutez cette commande pour résoudre tout problème de syntaxe de code :

**à cd your-project/**

**à /vendor/bin/phpcs -h (Examine les erreurs)**

**à /vendor/bin/phpcbf -h (Résout les erreurs)**

En savoir plus sur **« [PHP CodeSniffer**](https://github.com/squizlabs/PHP_CodeSniffer)** » si vous en avez besoin.
## **Processus de qualité**
**Revue de code**

Pour ce projet, nous utilisons ce réviseur de code gratuits qui automatise les révisions de code et surveillent la qualité du code au fil du temps :

- [**Codacy**](https://www.codacy.com/)

Vous pouvez l’utiliser pour vérifier votre code ou vous pouvez également utiliser un autre outil de révision de code automatisé.



**Essai :**

Pour ce projet, nous utilisons « **PHPUnit** » pour les tests unitaires et les tests fonctionnels et nous avons réalisé une couverture de code que vous pouvez retrouver dans le répertoire **« web/ »**.

Alors suivez ces étapes :

è Exécutez régulièrement PHPUnit afin de vérifier le code

è Implémentez vos propres tests mais assurez-vous de ne pas diminuer la couverture du code

è Assurez-vous de ne pas modifier les tests existants

Si vous en avez besoin, en savoir plus sur **« [PHPUnit](https://phpunit.de/) , [Symfony Testing](https://symfony.com/doc/current/testing.html) ».**



**Performance :**

Pour vérifier l'impact sur les performances de ce projet, nous utilisons **« [Blackfire ](https://www.blackfire.io/)»**, alors utilisez-le aussi.



Merci d'avoir contribué !
