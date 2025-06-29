# email
A Singleton-based Email implementation for Symfony Mailer.

## Install
```shell
  composer require artisanfw/mailer
```

## Loading the Service
```php
$mailerConf = [
    'dsn' => 'smtp://user:password@smtp.server:port',
];

$mailer = Email::load($mailerConf);
```

## Sending an Email
```php
Email::i()
    ->from('test@domain.com')
    ->to('who@domain.com')
    ->subject('Welcome to Artisan!')
    ->html('Send the body msg here!')
    ->send();
```
