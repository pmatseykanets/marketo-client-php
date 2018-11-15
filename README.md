# Marketo REST API PHP Client [WIP]

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/pmatseykanets/marketo-client-php/master.svg?style=flat-square)](https://travis-ci.org/pmatseykanets/marketo-php-client)

## Contents
- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

```bash
composer require pmatseykanets/marketo-client
```

## Usage

When instantiating a client you can pass an array of following parameters

- `client_id`
- `client_secret`
- `base_url`
- `partner_id` (optional)

```php
$config = [
    // required
    'client_id' => '02d92ff0-9d94-4de7-b152-3df68969b947',
    'client_secret' => 'bB6wmEvjlsfVr1Vs3NfGwSD9HL2AAHzZ',
    'url' => 'https://123-XYZ-456.mktorest.com'
    // optional
    'partner_id' => '123456789'
];

$marketo = new Client($config);

foreach ($marketo->leadDatabase()->getLists()->send() as $response) {
    foreach ($response->result as $list) {
        echo $list->name.PHP_EOL;
    }
}
```

Alternatively the client can read parameters from the following environment variables

- `MARKETO_CLIENT_ID` 
- `MARKETO_CLIENT_SECRET`
- `MARKETO_URL`
- `MARKETO_PARTNER_ID`

```php
$marketo = new Client();
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Peter Matseykanets](https://github.com/pmatseykanets)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
