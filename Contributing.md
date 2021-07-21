Marc-Alban MILLET		17/07/2021


![](Aspose.Words.10bfe038-8187-4dce-b453-19aa1e858aef.001.png)![](Aspose.Words.10bfe038-8187-4dce-b453-19aa1e858aef.002.png)ToDoList

Created by ToDo&Co

Marc-Alban MILLET July 2021							

summary

` `**TOC \O "1-3" \H \Z \U [HOW TO CONTRIBUTE:	 PAGEREF _TOC77423180 \H ](#_TOC77423180)[2	 PAGEREF _TOC77423180 \H** ](#_TOC77423180)**

[Step 1: Get repository	 PAGEREF _Toc77423181 \h ](#_Toc77423181)[3	 PAGEREF _Toc77423181 \h ](#_Toc77423181)

[Step 2 - Work on the project:	 PAGEREF _Toc77423182 \h ](#_Toc77423182)[4	 PAGEREF _Toc77423182 \h ](#_Toc77423182)

[Step 3 - Propose your changes to the project:	 PAGEREF _Toc77423183 \h ](#_Toc77423183)[6	 PAGEREF _Toc77423183 \h ](#_Toc77423183)

[**MAKE SURE YOUR CODE FOLLOWS CODING STANDARDS AND THE QUALITY PROCESS	 PAGEREF _TOC77423184 \H ](#_TOC77423184)[8	 PAGEREF _TOC77423184 \H** ](#_TOC77423184)

[Coding standards	 PAGEREF _Toc77423185 \h ](#_Toc77423185)[8	 PAGEREF _Toc77423185 \h ](#_Toc77423185)

[Quality process	 PAGEREF _Toc77423186 \h ](#_Toc77423186)[9	 PAGEREF _Toc77423186 \h ](#_Toc77423186)



# How to contribute:
***(All commands used in this document are on: [https://git-scm.com/doc)***](https://git-scm.com/doc)***

Enhance an existing Symfony application from ToDo&Co. It is an application to manage daily tasks.

To contribute to this project, follow the steps below.

Before you follow these steps, you need to install [**git,**](https://git-scm.com/) [` `**dial**](https://getcomposer.org/) on your local machine, and create a GitHub account.

## **Step 1: Get the repository**
**1. First of all, you need a local fork of the project.**

Then fork the "ToDoList" repository by clicking on the "fork" button at the top right of this page. This will create a copy of this repository in your own GitHub account and you will see a note that it has been forked under the project name:**"forked from Marc-Alban/ToDoList".**

**2. Now you need a copy locally. Then clone your copy of GitHub to your local machine.**

Click the**"code"**button. Then click on the copy icon to clipboard, return to your terminal and run the git command:

**à git clone [https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git**](https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git)**

You can also download the ZIP with the "Download ZIP" button.

Here, you copy the contents of the "ToDoList" repository into GitHub on your local machine to a directory called like the repository: "ToDoList".

Always at your terminal, the path to the cloned directory is taken into account once cloned. All that remains is to access it in this directory.

Run this command: **cd ToDoList**

**3. Add the original ToDoList repository as a "git remote" called upstream.**

The remote repository on your GitHub and called **"origin".**  

At this point, if you want to keep your fork in sync with the toDoList forked repository, you need to configure **"git remote"**  that points to the original project so that you can retrieve the changes and import them into your local copy.

First click on the link to the original repository – it's labeled "Forked from" at the top of the GitHub page. This takes you back to the GitHub page of the main project, so you can find the**"SSH cloning URL"**  and use it to create the new "git  remote", which we'll call  **"upstream".****  

Run this command:

**->git remote add upstream [https://github.com/Marc-Alban/ToDoList.git**](https://github.com/Marc-Alban/ToDoList.git)**

Check the new upstream repository you specified for your fork:

**->git remote -v**

**->origin https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git (fetch)**

**->origin https://github.com/YOUR-GITHUB-USERNAME/ToDoList.git (push)**

->**upstream https://github.com/Marc-Alban/ToDoList.git (fetch)**

->**upstream https://github.com/Marc-Alban/ToDoList.git (push)**

You now have two "remote" for this project:

1. Origin,  which points to your GitHub **fork**  of the project. (You can read and write).
1. Upstream,  which points to the GitHub repository of the main project. (You can only read from this **remote**).

Retrieve all commits from the upstream branches by running this command:

->**git fetch upstream**

The purpose of this step is to allow you to work simultaneously on the official ToDoList repository and on your own fork.
## **Step 2 - Work on the project:**
1. Install the project by referring to README.md.

1. Navigate to the repository directory on your computer (if you are not already there). **"cd ToDoList/"**

1. Create a new branch dedicated to yourchanges.

Use a short, rememberable name for the new branch (if you're solving a reported problem, use **"fix\_XXX"** as the branch name, where  **XXX is the problem number):**

**à git checkout -b my-new-feature upstream/features**

In this example, the branch name is **"my-new-feature"**  and the value  **"upstream/features" tells**  Git to create this branch based on the upstream remote's feature branch, which is the original ToDoList repository.

Patches should always be based on the oldest maintained branch that contains the error. If you are documenting a new feature instead, go to the **"upstream/features"**branch. If you are not sure, use the  **"upstream/master"**branch.**  

1. Make yourchanges.

Before you make your changes, read the [following best practices:](https://github.com/caroleguardiola/P8-OC-ToDoList/blob/master/documentation/Contributing%20to%20the%20project.md#making-your-code-follow-the-coding-standards-and-quality-process)  

***(Ensure***  ***that your code follows coding standards and the quality process)***

1. Commit your changes:

If the modified content existed before:

**à git commit -am ‘Add some feature'**

If the modified content did not exist before:

**à git add Feature.php**

**à git commit -m 'Add some feature'**

Be sure to write clear validation messages.

1. Send the changes to your forked repository:

**à git push origin my-new-feature**

The origin value is the name of the remote that corresponds to your fork repository and "my-new-feature" is the name of the branch you created earlier.  This will create this branch on your GitHub project.

## **Step 3 - Propose your changes to the project:**
**1. Create a Pull Request**

Everything is now ready to initiate a pull request. Navigate to your forked repository at:[` `**https://github.com/YOUR-GITHUB-USERNAME/ToDoList**](https://github.com/YOUR-GITHUB-USERNAME/ToDoList)

You will see that your new branch is listed at the top with a handy **"Compare & pull request" button.** Then click on this button.

On this page, make sure that the **base** **fork**  points to the right repository and branch. In this example, the  **base fork**  should be Marc-Alban/ToDoList and the base **branch** should be la  **feature,**which is on the branch on which you selected to base your changes.

The primary **head fork**  should be YOUR-GITHUB-USERNAME/ToDoList (your fork copy of ToDoList) and the comparison branch should be  **"my-new-feature",**which is the name of the branch you created and where you made your changes.

Next, make sure you provide a good short title for your pull request and explain why you created it in the description box. Add any relevant problem numbers if you have any.

**2. Submit the Pull Request**

You must now submit the **pull request** to the original ToDoList repository. To do this, press the  **"Create pull request"** button and you are done.

**3. Review by "Revisers"**

To make your work part of the project, reviewers will review your work and notify you of any required changes or merge them.

In case you are asked to add or modify something, do not create a new pull request. Instead, make sure you're on the right branch, make your changes, and submit the new changes:

**à cd P8-OC-ToDoList**

**à git checkout my-new-feature**

Make your changes and send them with:

**à git push**

**4. Sync your fork with the original repository after the changes**

The master branch of your fork will not have the changes. In order to keep your fork in sync with the original ToDoList repository, follow the steps below:

After the changes are merged into the original ToDoList repository, check out its new version:

**à git pull upstream master**

To make your fork have the changes:

**à git push origin master**

Notice here that you are pushing towards the remote named origin.

# Make sure your code follows coding standards and the quality process

## **Coding standards**

To make every piece of code familiar, Symfony sets coding standards that all contributions must follow.

So make sure your code complies with:


- [Symfony Coding Standards](https://symfony.com/doc/current/contributing/code/standards.html)[PHP Standards Recommendations (PSR)](https://www.php-fig.org/psr/)
  - [PSR-1](https://www.php-fig.org/psr/psr-1/)
  - [PSR-2](https://www.php-fig.org/psr/psr-2/)
  - [PSR-4](https://www.php-fig.org/psr/psr-4/)

- [Symfony Best Practices](https://symfony.com/doc/current/best_practices.html)

[Conventions Symfony](https://symfony.com/doc/current/contributing/code/conventions.html)Please also follow these recommendations:

- Have readable code, use understandable variable names, extract functions if necessary, avoid overly complex code

"PHP\_CodeSniffer is a set of two PHP scripts; the main phpcsscript that tokenizes PHP, JavaScript and CSS files to detect violations of a defined encoding standard, and a second  phpcbfscript to automatically fix encoding standard violations. PHP\_CodeSniffer is an essential development tool that ensures that your code stays clean and consistent. » 

(Source : https://github.com/squizlabs/PHP\_CodeSniffer)

Install the [**PHP** ](https://cs.sensiolabs.org/) **CodeSniffer** tool and then run this command to fix any code syntax issues:

**à cd your-project/**

**à /vendor/bin/phpcs -h (Examines for errors)**

**à /vendor/bin/phpcbf -h (Resolve errors)**

Learn more about **"PHP**  [**CodeSniffer"**](https://github.com/squizlabs/PHP_CodeSniffer)  ifyou needit.
## **Quality process**
**Code Review**

For this project, we use this free code reviewer that automates code reviews and monitors code quality over time:

- [**Codacy**](https://www.codacy.com/)

You can use it to check your code or you can also use another automated code review tool.

**test:**

For this project, we use **"PHPUnit"**  for unit tests and functional tests and we have made a code coverage that you can find in the  **"web/"**directory.

So follow these steps:

- Run PHPUnit regularly in order to check the code
- Implement your own tests but make sure you don't decrease code coverage
- Make sure you don't modify existing tests

If you need it, learn**  more about [**"PHPUnit,**](https://phpunit.de/)**   [**Symfony Testing".**](https://symfony.com/doc/current/testing.html)**  

**Performance :**

To check the impact on the performance of this project, we use**   [**"Blackfire",**](https://www.blackfire.io/)**  so use it too.

Thank you for contributing!
PAGE   \\* MERGEFORMAT8

ToDoList-OC-P8
