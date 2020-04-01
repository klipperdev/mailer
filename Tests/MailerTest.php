<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer\Tests;

use Klipper\Component\Mailer\Exception\InvalidArgumentException;
use Klipper\Component\Mailer\Exception\TransporterNotFoundException;
use Klipper\Component\Mailer\Mailer;
use Klipper\Component\Mailer\Transporter\TransporterInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Mime\RawMessage;

/**
 * Tests for mailer.
 *
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @internal
 */
final class MailerTest extends TestCase
{
    public function testSend(): void
    {
        $message = new RawMessage('');
        $envelope = new \stdClass();

        $transport = $this->getMockBuilder(TransporterInterface::class)->getMock();
        $transport->expects(static::once())
            ->method('supports')
            ->with($message, $envelope)
            ->willReturn(true)
        ;

        $transport->expects(static::once())
            ->method('send')
            ->with($message, $envelope)
        ;

        $mailer = new Mailer([$transport]);
        $mailer->send($message, $envelope);
    }

    public function testInvalidTransporter(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The transporter must be an instance of Klipper\Component\Mailer\Transporter\TransporterInterface ("stdClass" given).');

        new Mailer([new \stdClass()]);
    }

    public function testTransporterNotFoundException(): void
    {
        $this->expectException(TransporterNotFoundException::class);
        $this->expectExceptionMessage('No transporter was found for the message');

        $mailer = new Mailer([]);
        $mailer->send(new RawMessage(''));
    }

    public function testHasRequiredFrom(): void
    {
        $message = new RawMessage('');
        $envelope = new \stdClass();

        $transport = $this->getMockBuilder(TransporterInterface::class)->getMock();
        $transport->expects(static::once())
            ->method('supports')
            ->with($message, $envelope)
            ->willReturn(true)
        ;

        $transport->expects(static::once())
            ->method('hasRequiredFrom')
            ->willReturn(true)
        ;

        $mailer = new Mailer([$transport]);

        static::assertTrue($mailer->hasRequiredFrom($message, $envelope));
    }

    public function testHasRequiredFromWithTransporterNotFoundException(): void
    {
        $this->expectException(TransporterNotFoundException::class);
        $this->expectExceptionMessage('No transporter was found for the message');

        $mailer = new Mailer([]);
        $mailer->hasRequiredFrom(new RawMessage(''));
    }
}
