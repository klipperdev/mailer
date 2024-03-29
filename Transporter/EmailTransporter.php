<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer\Transporter;

use Klipper\Component\Mailer\Exception\InvalidArgumentException;
use Klipper\Component\Mailer\Exception\TransporterException;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\RawMessage;

/**
 * Email transporter.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class EmailTransporter implements TransporterInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @param null|mixed $envelope
     */
    public function supports(RawMessage $message, $envelope = null): bool
    {
        return $message instanceof Email;
    }

    public function hasRequiredFrom(): bool
    {
        return true;
    }

    /**
     * @param null|mixed $envelope
     */
    public function send(RawMessage $message, $envelope = null): void
    {
        if (null !== $envelope && !$envelope instanceof Envelope) {
            throw new InvalidArgumentException(sprintf(
                'The envelope of message must be an instance of %s ("%s" given).',
                Envelope::class,
                \get_class($envelope)
            ));
        }

        try {
            $this->mailer->send($message, $envelope);
        } catch (TransportExceptionInterface $e) {
            throw new TransporterException($e->getMessage(), 0, $e);
        }
    }
}
