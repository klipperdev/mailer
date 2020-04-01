<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer\Tests\Twig\Mime;

use Klipper\Component\Mailer\Twig\Mime\SandboxTemplatedEmail;
use PHPUnit\Framework\TestCase;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @internal
 */
final class SandboxTemplatedEmailTest extends TestCase
{
    public function testConstructor(): void
    {
        static::assertInstanceOf(TemplatedEmail::class, new SandboxTemplatedEmail());
    }
}
