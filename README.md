# Crate Economy
A simple webapp to aggregate data from multiple sources to produce statistical metrics as to whether or not it's worth opening TF2 crates.

## Requirements

1. API Keys for Steam, Backpack.tf, Trade.tf

## Setup

1. Copy `api_keys_template.json` to `api_keys.json`
2. Enter API keys for Steam, Backpack.tf and Trade.tf into `api_keys.json` as appropriate
3. Install dependencies using `composer`

## Dependencies

The dependencies are stored in `composer.json`, so install composer (see https://getcomposer.org/ for instructions) then run:

```
composer install
```

Note that this project uses GuzzleHTTP which has a bug in it's default configuration where it'll insert apparently random 8 digit numbers in the HTTP stream. Please ensure that php-curl is installed to work around this bug. (https://github.com/guzzle/guzzle/issues/1385) As php-curl isn't technically a requirement I've not listed it as a depenency for composer.

## Unit Tests

We're using PHPUnit for unit tests. It should be installed by composer with the "dev" requirements and will be runnable using the following command:

```
./vendor/bin/phpunit
```

It's expected that all unit tests pass before any pull request is issued. Pull requests with failing unit tests or that introduce functionality without unit tests will be rejected.

## Contributing
All contributions must contain a signed-off-by line in accordance with the Developer Certificate of Origin: http://developercertificate.org/

All contributions must be licensed under the GPL 3 or later.
