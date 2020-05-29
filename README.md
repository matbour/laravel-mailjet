# Mailjet integration for Laravel and Lumen
![GitHub license](https://img.shields.io/github/license/mathieu-bour/laravel-mailjet?style=flat-square)
![Packagist Version](https://img.shields.io/packagist/v/mathieu-bour/laravel-mailjet?style=flat-square)
![Packagist](https://img.shields.io/packagist/dt/mathieu-bour/laravel-mailjet?style=flat-square)
![GitHub issues](https://img.shields.io/github/issues/mathieu-bour/laravel-mailjet?style=flat-square)
![GitHub pull requests](https://img.shields.io/github/issues-pr/mathieu-bour/laravel-mailjet?style=flat-square)
![Scrutinizer code quality](https://img.shields.io/scrutinizer/quality/g/mathieu-bour/laravel-mailjet?style=flat-square)

Allow to use the [Mailjet Templating Language](https://www.mailjet.com/feature/templating-language/) in Laravel mailables.

**This package is not supported by Mailjet.**

This package follows the [Semantic Versioning specification](https://semver.org/).

## Prerequisites
- PHP >= 7.2
- Laravel/Lumen 6 or 7

### Compatibility matrix

| laravel-mailjet | Laravel / Lumen | 
|-----------------|-----------------|
| ^1.0.0          | ^6.0 \|\| ^7.0  |

## Installation / configuration

Simply add the package to your dependencies.

```bash
composer require mathieu-bour/laravel-mailjet
```

### Laravel
The package support the [Package Discovery](https://laravel.com/docs/7.x/packages#package-discovery).

### Lumen
Add the service provider to your `bootstrap/app.php`.

## Configuration
In the `config/services.php`, add the following entry:

```php
return [
    // ...
    'mailjet'   => [
        'key'     => 'your-mailjet-key',
        'secret'  => 'your-mailjet-secret',
        'call'    => true, // can be set to false to mock requests
        'options' => ['version' => 'v3.1'], // additional Mailjet options, see https://github.com/mailjet/mailjet-apiv3-php#options
    ],
    // ...
];
```

## Usage
You can now use the class `Windy\Mailjet\MailjetTemplateMailable` as a base for your emails.

Example:

```php
use Windy\Mailjet\MailjetTemplateMailable;

class PasswordForgottenMail extends MailjetTemplateMailable
{
    /** @var int The Mailjet Template ID. */
    protected $templateId = 1185614;
    public $firstName;
    public $resetLink;

    public function __construct(User $user)
    {
        // You can now use {{var:firstName}} and {{var:resetLink}} variables in your Mailjet templates
        $this->firstName = $user->firstname ?? $user->username ?? '';
        $this->resetLink = 'https://mysite.com/password-reset?token=' . $user->token;
    }
}
```
