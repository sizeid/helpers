# SizeID Helpers
[![Build Status](https://travis-ci.org/sizeid/helpers.svg?branch=master)](https://travis-ci.org/sizeid/helpers)
[![Coverage Status](https://coveralls.io/repos/github/sizeid/helpers/badge.svg?branch=master)](https://coveralls.io/github/sizeid/helpers)

Package for SizeID Advisor integration into e-shop platforms.

[SizeID Advisor Demo](http://demo.sizeid.com/advisor.products/)

## Features

* verify client credentials
* get and format active size charts
* get and format available button styles
* get available languages
* render SizeID Button code
* render SizeID Connect code


## Installation into existing project

1. Get the code
```
composer require sizeid/helpers
```
2. Get `clientId` and `clientSecret` from your [SizeID for Business account](https://business.sizeid.com/integration.settings/). Free tariff available.
3. Start using helpers see [examples/example.php](examples/example.php)

## Examples

1. Get the code
```
composer create-project sizeid/helpers
```
2. Get `clientId` and `clientSecret` from your [SizeID for Business account](https://business.sizeid.com/integration.settings/). Free tariff available.
3. Navigate to `examples` directory, copy `config.example.php` to `config.php`, change constants `CLIENT_ID` and `CLIENT_SECRET`, run example file with webserver.
