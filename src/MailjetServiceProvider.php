<?php

declare(strict_types=1);

namespace Windy\Mailjet;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Mailjet\Client;
use Mailjet\MailjetSwiftMailer\SwiftMailer\MailjetTransport;
use Swift_Events_SimpleEventDispatcher;

/**
 * Register the {@see MailjetTransport} in the {@see MailManager}.
 */
class MailjetServiceProvider extends ServiceProvider
{
    /**
     * @throws BindingResolutionException
     */
    public function register(): void
    {
        /** @var Repository $config */
        $config = $this->app->make('config');

        $this->app->make('mail.manager')->extend('mailjet', static function () use ($config) {
            return new MailjetTransport(
                new Swift_Events_SimpleEventDispatcher(),
                $config->get('services.mailjet.key'),
                $config->get('services.mailjet.secret'),
                $config->get('services.mailjet.call', true),
                $config->get('services.mailjet.options', [])
            );
        });

        $this->app->singleton(Client::class, static function () use ($config) {
            return new Client(
                $config->get('services.mailjet.key'),
                $config->get('services.mailjet.secret'),
                $config->get('services.mailjet.call', true),
                $config->get('services.mailjet.options', [])
            );
        });
    }
}
