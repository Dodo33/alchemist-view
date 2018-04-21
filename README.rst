.. image:: https://i.imgur.com/EqWwNDn.png
    :target: https://github.com/Dodo33/alchemist-view
    :width: 300px
    :height: 150px
    :align: center
    :alt: Alchemist

Alchemist-view
**************

Description
===========
Alchemist-view is a php/javascript application which allow to view a summary
of trading strategies created with alchemist-lib.

Screenshot
==========

.. image:: https://i.imgur.com/90o7jRe.png
    :width: 100%
    :align: center
    :alt: Alchemist-view screenshot


Requirements
============

 - A webserver
 - PHP
 - Mysql
 

Installation
============

Just copy the `alchemist-view` folder to the root directory of the webserver.
It should be something like ``/var/www/html/`` on debian-derived Linux distributions.
::
    $ sudo cp -r alchemist-view /var/www/html/alchemist-view/


After that, set all permissions for the `temp/` sub-directory.
::
    $ sudo chmod 777 /var/www/html/alchemist-view/temp/

Usage
=====

Type ``localhost/alchemist-view/index.php`` into the browser and login with mysql 
credentials setted during the installation of ``alchemist-lib``.

.. image:: https://i.imgur.com/wQO1ZlY.png
    :align: center
    :width: 100%
    :alt: Alchemist-view login 







