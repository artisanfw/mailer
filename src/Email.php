<?php

namespace Artisan\Services;

use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Email as SymfonyEmail;


class Email extends SymfonyEmail
{
    private const string EMAIL_CONFIG_ERROR = 'Email service requires setup before being used.';

    private static ?Mailer $mailer = null;
    private static bool $isConfigured = false;
    private static ?self $instance = null;

    private function __construct()
    {
        if (!self::$isConfigured) {
            throw new \LogicException(self::EMAIL_CONFIG_ERROR);
        }
        parent::__construct();
    }

    public static function i(): self
    {
        if (!self::$isConfigured) {
            throw new \LogicException(self::EMAIL_CONFIG_ERROR);
        }

        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public static function load(array $config): void
    {
        if (!self::$isConfigured) {
            if (!isset($config['dsn'])) {
                throw new \InvalidArgumentException('"dsn" configuration not found.');
            }
            $transport = Transport::fromDsn($config['dsn']);
            self::$mailer = new Mailer($transport);

            self::$isConfigured = true;
        }
    }

    public function send(): void
    {
        if (!self::$mailer) {
            throw new \LogicException(self::EMAIL_CONFIG_ERROR);
        }
        self::$mailer->send($this);
    }

}
