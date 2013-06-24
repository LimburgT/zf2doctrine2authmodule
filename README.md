ZendSkeletonApplication with DoctrineAuth-Module
================================================

Introduction
------------
This is a simple, skeleton application using the ZF2 MVC layer and module
systems. This application is meant to be used as a starting place for those
looking to get their feet wet with ZF2.

Added is a module for Doctrine2 Authentification, derived from Abul Maliks' SanAuth-Module:
http://samsonasik.wordpress.com/2012/10/04/zend-framework-2-step-by-step-build-form-using-annotation-builder/
Thanks Abdul!
It uses Doctrine2 (DoctrineModule/DoctrineORMModule) to authentifcate Users stored in the database
The Skeleton Application/module.php is modified. It asks for authentification in every event. 
Unauthentified Users will be redirected to the "/login" route.


Installation
------------

Using Composer
----------------------------

1. Get the source from here
2. The necessary libraries & dependencies are stored in composer.json
3. cd to the directory and start composer with "php composer.phar update"
4. Composer installes the missing libraries and modifies the autoload files
5. Create the database with the user.sql-file, Insert a User with a salted an sha1-hashed password. Put the salt in the same row.
6. Complete config/autoload/database.local.php with Your DB-Credentials
