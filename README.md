# Marketo REST API PHP Client [WIP]

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/pmatseykanets/marketo-client-php/master.svg?style=flat-square)](https://travis-ci.org/pmatseykanets/marketo-client-php)

It's work in progress. Use at your own risk.

## Contents
- [Installation](#installation)
- [Usage](#usage)
- [Marketo REST API Coverage](#marketo-rest-api-coverage)
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
    // required (credentials below are not real)
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

## Marketo REST API Coverage

- [ ] LeadDatabase
  - [ ] Activities
    - [x] GetActivities
    - [x] GetActivityTypes
    - [x] GetDeletedActivities
    - [x] GetLeadChangesActivities
    - [x] GetPagingToken
    - [ ] AddCustomActivities
    - [ ] CreateCustomActivityType
    - [ ] DeleteCustomActivityType
    - [ ] DiscardCustomActivityTypeDraft
    - [ ] UpdateCustomActivityType
    - [ ] ApproveCustomActivityType
    - [ ] CreateCustomActivityTypeAttributes
    - [ ] DeleteCustomActivityTypeAttributes
    - [ ] UpdateCustomActivityTypeAttributes
  - [ ] BulkCustomObjects
  - [ ] BulkExportActivities
  - [ ] BulkExportLeads
  - [ ] BulkLeads
  - [ ] Campaigns
    - [x] FindCampaign
    - [x] GetCampaigns
    - [ ] ScheduleCampaign
    - [ ] TriggerCampaign
  - [ ] Companies
    - [x] DescribeCompany
    - [x] GetCompanies
    - [ ] SyncCompanies
    - [ ] DeleteCompanies
  - [ ] CustomObjects
  - [ ] Leads
    - [x] AssociateLead
    - [x] DeleteLeads
    - [x] DescribeLead
    - [x] GetLeadPartitions
    - [x] GetLeads
    - [x] MergeLeads
    - [x] PushLeads
    - [x] SyncLeads
    - [x] UpdateLeadPartition
    - [ ] GetLeadsByProgramId
    - [ ] ChangeLeadProgramStatus
  - [x] Lists
    - [x] AddToList
    - [x] DeleteFromList
    - [x] FindList
    - [x] GetListLeads
    - [x] GetLists
    - [x] IsListMember
  - [ ] NamedAccountLists
  - [ ] NamedAccounts
  - [ ] Opportunities
  - [ ] SalesPersons
  - [ ] Usage
- [ ] Assets
  - [ ] Channels
  - [ ] EmailTemplates
  - [ ] Emails
  - [ ] FileContents
  - [ ] Files
  - [ ] Folders
  - [ ] FormFields
  - [ ] Forms
  - [ ] LandingPageContent
  - [ ] LandingPageTemplates
  - [ ] LandingPages
  - [ ] Programs
  - [ ] Segments
  - [ ] SmartCampaigns
  - [ ] SmartLists
  - [ ] StaticLists
  - [ ] Tags
  - [ ] Tokens
- [x] Identity
  - [x] GetOAuthToken
    
## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information about what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Peter Matseykanets](https://github.com/pmatseykanets)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
