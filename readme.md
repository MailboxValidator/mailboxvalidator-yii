# MailboxValidator Yii Email Validation Extension

MailboxValidator Yii Email Validation Extension provides an easy way to call the MailboxValidator API which validates if an email address is valid.



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
$mbv = new SingleValidation('PASTE_YOUR_API_KEY_HERE');
```

or like this:

```php
['email', MailboxValidator::className(), 'option'=>'YOUR_SELECTED_OPTION','api_key'=>'PASTE_YOUR_API_KEY_HERE',],
```



## Methods

Below are the methods supported in this library.

| Method Name        | Description                                                  |
| ------------------ | ------------------------------------------------------------ |
| ValidateEmail      | Return the validation result of an email address. Please visit [MailboxValidator](https://www.mailboxvalidator.com/api-single-validation) for the list of the response parameters. |
| validateFree       | Check whether the email address is belongs to a free email provider or not. Return Values: True, False |
| validateDisposable | Check whether the email address is belongs to a disposable email provider or not. Return Values: True, False |



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
use MailboxValidator\SingleValidation;
```

After that, you can get the validation result for the email address like this:

```php
$mbv = new SingleValidation(Yii::$app->params['mbvAPIKey']);
$results = $mbv->FreeEmail('example@example.com');
```

To pass the result to the view, just simply add the $results to your view loader like this:

```php
return $this->render('YOUR_VIEW_NAME', ['results' => $results]);
```

And then in your view file, call the validation results. For example:

```php
echo 'email_address = ' . $results->email_address . "<br>";
```

You can refer the full list of response parameters available at [here](https://www.mailboxvalidator.com/api-single-validation).



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

Copyright (C) 2018 by MailboxValidator.com, support@mailboxvalidator.com