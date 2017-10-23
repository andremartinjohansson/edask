Elite Ask
==================================

[![Build Status](https://api.travis-ci.org/andymartinj/edask.svg?branch=master)](https://travis-ci.org/andymartinj/edask)
[![Build Status](https://scrutinizer-ci.com/g/andymartinj/edask/badges/build.png?b=master)](https://scrutinizer-ci.com/g/andymartinj/edask/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/andymartinj/edask/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/andymartinj/edask/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/andymartinj/edask/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/andymartinj/edask/?branch=master)

Installation
------------

Perform the following steps to run the website on your own system:

1. Clone the repo
2. Run `composer install` to install all dependencies
3. Edit `config/database_mysql.php` or `config/database_sqlite.php` with your connection details and rename the file to `config/database.php`
4. Run `sql/setup.sql` on the on your database server.
5. Edit the paths in `htdocs/.htaccess` to match your setup
6. Done.

License
------------------

This software carries a MIT license.



```
 .  
..:  Copyright (c) 2017 Andre Johansson (anjd16@student.bth.se)
```
