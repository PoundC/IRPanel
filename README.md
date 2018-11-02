# CakePHP Dashboard Skeleton

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)

[![CDNJS](https://img.shields.io/cdnjs/v/admin-lte.svg)](https://cdnjs.com/libraries/admin-lte)
[![Packagist](https://img.shields.io/packagist/v/almasaeed2010/adminlte.svg)](https://packagist.org/packages/cakephpkitchen/cakeadminlte)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

[![Total Downloads](https://img.shields.io/packagist/dt/cakephpkitchen/cakeadminlte.svg?style=flat-square)](https://packagist.org/packages/cakephpkitchen/cakeadminlte)

A skeleton for creating full featured applications with a dashbaord backend built on top of [CakePHP](http://cakephp.org) 3.x.

The framework source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp).

## AdminLTE - Admin Control Panel Theme (Bootstrap 3)

!["AdminLTE Presentation"](https://adminlte.io/AdminLTE2.png "AdminLTE Presentation")

Visit the [online documentation](https://adminlte.io/docs) for the most updated guide. [ [demo](https://adminlte.io/themes/AdminLTE/index2.html) ] [ [github](https://github.com/almasaeed2010/AdminLTE) ]


## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist cakephpkitchen/cakeadminlte [app_name]`.

If Composer is installed globally, run

```bash
composer create-project --prefer-dist cakephpkitchen/cakeadminlte
```

In case you want to use a custom app dir name (e.g. `/dash/`):

```bash
composer create-project --prefer-dist cakephpkitchen/cakeadminlte dash
```

You can now either use your machine's webserver to view the default home page, or start
up the built-in webserver with:

```bash
bin/cake server -p 10304
```

Then visit `http://localhost:10304` to see the welcome page.

## Update

Since this skeleton is a starting point for your application and various files
would have been modified as per your needs, there isn't a way to provide
automated upgrades, so you have to do any updates manually.

## Configuration

Read and edit `config/app.php` and setup the `'Datasources'` and any other
configuration relevant for your application.

## Layout

The app skeleton uses a subset of [Foundation](http://foundation.zurb.com/) (v5) CSS
framework by default. You can, however, replace it with any other library or
custom styles.

