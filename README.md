# MM SMS
[![Stable](https://img.shields.io/badge/stable-v1.0.2-blue.svg)](https://packagist.org/packages/milan-sahana/mm-sms#1.0.2) [![License](https://img.shields.io/badge/license-MIT-20B2AA)](LICENSE)

A simple library to send SMS using MM Sms Service

Official PHP library for [Mail Mantra SMS](https://sms1.mailmantra.com/v2).

Read up here for getting started and understanding the sms flow with MM Sms: <https://sms1.mailmantra.com/v2>

### Prerequisites
- A minimum of PHP 7.3 upto 8.3


## Installation

-   If your project using composer, run the below command

```
composer require mail-mantra/sms
```

- If you are not using composer, download the latest release from [the releases section](https://github.com/mail-mantra/sms/releases).
  
##Note:
This PHP library follows the following practices:

- Namespaced under `MM\Sms`
- API throws exceptions instead of returning errors
- Options are passed as an array instead of multiple arguments wherever possible
- All requests and responses are communicated over JSON

## Documentation

Documentation of MM SMS's API and their usage is available at <https://sms1.mailmantra.com>

## Basic Usage

Instantiate the MM Sms instance with `auth_key`. You can obtain the keys from the dashboard app ([https://sms1.mailmantra.com/v2/sender_id/list_all]([https://dashboard.razorpay.com/#/app/keys](https://sms1.mailmantra.com/v2/sender_id/list_all)))

```php
use MailMantra\Sms\Sms;

$mmSMS = new Sms($auth_key);
```

The resources can be accessed via the `$mmSMS` object. All the methods invocations follows the following pattern

```php
    // $mmSMS->function() to access the API
    //Example
    $mmSMS->send('9876543210', '1234 is Your OTP. Do not share with anyone.','123456789101112');
```

# Common Examples
### View Balance:
To view your balance
```php
use MilanSahana\MmSms\Sms;

$mmSMS = new Sms("JFDG231HFDJ34KGH8438DSUG4FUD8SG");

$balance_arr = $mmSMS->balance();

var_dump($balance_arr);
```
##### Output:
```php

array(3) {
    ["status"]=>
  int(1)
  ["message"]=>
  string(1) "7"
    ["code"]=>
  string(6) "MMTEST"
}

```

### Send sms:
Send a sms to one or more mobile number(comma seperated mobile numbers)
```php
use MilanSahana\MmSms\Sms;

$mmSMS = new Sms("JFDG231HFDJ34KGH8438DSUG4FUD8SG");

$send_report = $mmSMS->send('9876543210', '123456 is Your OTP. Do not share with anyone.','12345678901234567890');

var_dump($send_report);
```
##### Output:
```php
array(3) {
    ["status"]=>
  int(1)
  ["message"]=>
  string(25) "1 SMS send Successfully.."
    ["code"]=>
  string(24) "346772774568353130393036"
}
```



### Send Bulk sms:
Send a sms to one or more mobile number(comma seperated mobile numbers)
```php
use MilanSahana\MmSms\Sms;

$mmSMS = new Sms("JFDG231HFDJ34KGH8438DSUG4FUD8SG");

$sms = [
    [
        'message' =>'1234 Your OTP. Do not share with anyone.',
        'to'=>[
            '9999999999',
            '8888888888',
        ]
    ],
    [

        'message' =>'56789 Your OTP. Do not share with anyone.',
        'to'=>[
            '7777777777',
            '9876543210'
        ]
    ],
];

$send_bulk_report = $mmSMS->sendBulk($sms, '12345678901234567890');

var_dump($send_bulk_report);
```
##### Output:
```php
array(3) {
    ["status"]=>
  int(1)
  ["message"]=>
  string(25) "4 SMS send Successfully.."
    ["code"]=>
  string(24) "346772774163393934343834"
}
```


## Changelog
#### Version 1.0.1 provided by [milan-sahana](https://github.com/milan-sahana) - *Testing*
- Cleaned Up Code
- Fixed Bugs
- A minimum of PHP 7.3
- Added Option to prevent json error

##### Version 1.0.0 - *Stable Release*
- View Balance
- Added Send SMS in Bulk
- Fixed issue Send SMS
- Update extras array
- Updating version pattern.
```
x.y.z
x = Main version of the plugin
y = New features were added to the plugin
z = Fixes/patches to existing features of the plugin
```


## License

The Razorpay PHP SDK is released under the MIT License. See [LICENSE](LICENSE) file for more details.

