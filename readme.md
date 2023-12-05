# MailboxValidator Yii Email Validation Extension

MailboxValidator Yii Email Validation Extension enables user to easily validate if an email address is valid, a type of disposable email or free email.

This extension can be useful in many types of projects, for example

 - to validate an user's email during sign up
 - to clean your mailing list prior to email sending
 - to perform fraud check
 - and so on



## Installation

Install this extension by using Composer:

``composer require mailboxvalidator/mailboxvalidator-yii``



## Dependencies

An API key is required for this module to function.

Go to https://www.mailboxvalidator.com/plans#api to sign up for FREE API plan and you'll be given an API key.

After you get your API key, open your ``config/params.php`` and add the following line into the array:

```php
'mbvAPIKey' => 'PASTE_YOUR_API_KEY_HERE',
```

You can also set you API key in controller after calling library. Just do like this:

```php
$mbv = new EmailValidation('PASTE_YOUR_API_KEY_HERE');
```

or like this:

```php
['email', MailboxValidator::className(), 'option'=>'YOUR_SELECTED_OPTION','api_key'=>'PASTE_YOUR_API_KEY_HERE',],
```


## Functions

### EmailValidation (api_key)

Creates a new instance of the MailboxValidator object with the API key.

### validateDisposable (email_address)

Check whether the email address is belongs to a disposable email provider or not. Return Values: True, False

### validateFree (email_address)  

Check whether the email address is belongs to a free email provider or not. Return Values: True, False

### validateEmail (email_address)

Performs email validation on the supplied email address.

#### Return Fields

| Field Name | Description |
|-----------|------------|
| email_address | The input email address. |
| domain | The domain of the email address. |
| is_free | Whether the email address is from a free email provider like Gmail or Hotmail. Return values: True, False |
| is_syntax | Whether the email address is syntactically correct. Return values: True, False |
| is_domain | Whether the email address has a valid MX record in its DNS entries. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_smtp | Whether the mail servers specified in the MX records are responding to connections. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_verified | Whether the mail server confirms that the email address actually exist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_server_down | Whether the mail server is currently down or unresponsive. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_greylisted | Whether the mail server employs greylisting where an email has to be sent a second time at a later time. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_disposable | Whether the email address is a temporary one from a disposable email provider. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_suppressed | Whether the email address is in our blacklist. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_role | Whether the email address is a role-based email address like admin@example.net or webmaster@example.net. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_high_risk | Whether the email address contains high risk keywords. Return values: True, False, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| is_catchall | Whether the email address is a catch-all address. Return values: True, False, Unknown, -&nbsp;&nbsp;&nbsp;(- means not applicable) |
| mailboxvalidator_score | Email address reputation score. Score > 0.70 means good; score > 0.40 means fair; score <= 0.40 means poor. |
| time_taken | The time taken to get the results in seconds. |
| status | Whether our system think the email address is valid based on all the previous fields. Return values: True, False |
| credits_available | The number of credits left to perform validations. |
| error_code | The error code if there is any error. See error table in the below section. |
| error_message | The error message if there is any error. See error table in the below section. |

### isDisposableEmail (email_address)

Check if the supplied email address is from a disposable email provider.

#### Return Fields

| Field Name | Description |
|-----------|------------|
| email_address | The input email address. |
| is_disposable | Whether the email address is a temporary one from a disposable email provider. Return values: True, False |
| credits_available | The number of credits left to perform validations. |
| error_code | The error code if there is any error. See error table in the below section. |
| error_message | The error message if there is any error. See error table in the below section. |

### isFreeEmail (email_address)

Check if the supplied email address is from a free email provider.

#### Return Fields

| Field Name | Description |
|-----------|------------|
| email_address | The input email address. |
| is_free | Whether the email address is from a free email provider like Gmail or Hotmail. Return values: True, False |
| credits_available | The number of credits left to perform validations. |
| error_code | The error code if there is any error. See error table in the below section. |
| error_message | The error message if there is any error. See error table below. |

## Usage

### Form Validation

To use this library in form validation, first call this library in your model like this:

```php
use MailboxValidator\MailboxValidator;
```

After that, in the function rules, add the new validator rule for the email:

```php
['YOUR_EMAIL_FIELD_NAME', MailboxValidator::className(), 'option'=>'disposable,free',],
```

In this line, the extension is been called, and you will need to specify which validator to use. The available validators are disposable and free. After that, refresh you form and see the outcome.

### Email Validation

To use this library to get validation result for an email address, firstly load the library in your controller like this:

```php
use MailboxValidator\EmailValidation;
```

After that, you can get the validation result for the email address like this:

```php
$mbv = new EmailValidation(Yii::$app->params['mbvAPIKey']);
$results = $mbv->isFreeEmail('example@example.com');
```

To pass the result to the view, just simply add the $results to your view loader like this:

```php
return $this->render('YOUR_VIEW_NAME', ['results' => $results]);
```

And then in your view file, call the validation results. For example:

```php
echo 'email_address = ' . $results->email_address . "<br>";
```

You can refer the full list of response parameters available at above.



## Errors

| error_code | error_message         |
| ---------- | --------------------- |
| 100        | Missing parameter.    |
| 101        | API key not found.    |
| 102        | API key disabled.     |
| 103        | API key expired.      |
| 104        | Insufficient credits. |
| 105        | Unknown error.        |



## Copyright

Copyright (C) 2018-2023 by MailboxValidator.com, support@mailboxvalidator.com
