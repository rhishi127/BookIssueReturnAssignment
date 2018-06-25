BookIssueReturn
=======================

Introduction
------------
This is a simple application to issue and return books using the ZF2 MVC layer and module
systems.

Installation
------------

Using Composer (recommended)
----------------------------
The recommended way to get a working copy of this project is to clone the repository
and use `composer` to install dependencies using the `create-project` command:

    curl -s https://getcomposer.org/installer | php --
    php composer.phar create-project -sdev --repository-url="https://packages.zendframework.com" zendframework/skeleton-application path/to/install

Alternately, clone the repository and manually invoke `composer` using the shipped
`composer.phar`:

    cd my/project/dir
    php composer.phar self-update
    php composer.phar install

(The `self-update` directive is to ensure you have an up-to-date `composer.phar`
available.)

Another alternative for downloading the project is to grab it via `curl`, and
then pass it to `tar`:

    cd my/project/dir
    curl -#L https://github.com/zendframework/ZendSkeletonApplication/tarball/master | tar xz --strip-components=1

You would then invoke `composer` to install dependencies per the previous
example.


Web Server Setup


### Apache Setup

To setup apache, setup a virtual host to point to the public/ directory of the
project and you should be ready to go! It should look something like below:

    <VirtualHost *:80>
        ServerName zf2-tutorial.localhost
        DocumentRoot /path/to/BookIssueReturn/public
        SetEnv APPLICATION_ENV "development"
        <Directory /path/to/BookIssueReturn/public>
            DirectoryIndex index.php
            AllowOverride All
            Order allow,deny
            Allow from all
        </Directory>
    </VirtualHost>

Importing Database
---------------------------
Import  zend.sql datbase file  located in Database Folder
by creating new db with name zend in mysql db