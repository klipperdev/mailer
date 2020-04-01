<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer\Tests\Twig\Loader;

use Klipper\Component\Mailer\Twig\Loader\FilesystemTemplateLoader;
use PHPUnit\Framework\TestCase;
use Twig\Error\LoaderError;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 *
 * @internal
 */
final class FilesystemTemplateLoaderTest extends TestCase
{
    /**
     * @var FilesystemTemplateLoader
     */
    protected $loader;

    /**
     * @var string
     */
    protected $rootPath;

    /**
     * @throws
     */
    protected function setUp(): void
    {
        $this->rootPath = realpath(__DIR__.'/../../Fixtures');
        \Locale::setDefault('fr_FR');

        $this->loader = new FilesystemTemplateLoader(
            $this->rootPath,
            'en_US',
            'loaders',
            '@templates'
        );
    }

    protected function tearDown(): void
    {
        $this->loader = null;
    }

    public function getExistsArguments(): array
    {
        return [
            [false, 'mail.html.twig'],
            [false, 'mail.fr.html.twig'],
            [true,  '@@templates/mail.html.twig'],
            [true,  '@@templates/mail.fr_FR.html.twig'],
            [true,  '@@templates/mail.fr.html.twig'],
            [true,  '@@templates/mail.en_US.html.twig'],
            [true,  '@@templates/mail.en.html.twig'],
            [true,  '@@templates/mail.it_IT.html.twig'],
            [true,  '@@templates/mail.it.html.twig'],
            [false, '@@templates/mail.aa_AA.html.twig'],
            [false, '@@templates/mail.aa.html.twig'],
        ];
    }

    /**
     * @dataProvider getExistsArguments
     *
     * @param bool   $expected
     * @param string $templateName
     */
    public function testExists(bool $expected, string $templateName): void
    {
        static::assertSame($expected, $this->loader->exists($templateName));
    }

    public function getGetSourceContextArguments(): array
    {
        return [
            ['@@templates/mail.html.twig', 'loaders/mail.fr.html.twig'],
            ['@@templates/mail.fr_FR.html.twig', 'loaders/mail.fr.html.twig'],
            ['@@templates/mail.fr.html.twig', 'loaders/mail.fr.html.twig'],
            ['@@templates/mail.en_US.html.twig', 'loaders/mail.en.html.twig'],
            ['@@templates/mail.en.html.twig', 'loaders/mail.en.html.twig'],
            ['@@templates/mail.it_IT.html.twig', 'loaders/mail.en.html.twig'],
            ['@@templates/mail.it.html.twig', 'loaders/mail.en.html.twig'],
        ];
    }

    /**
     * @dataProvider getGetSourceContextArguments
     *
     * @param string $templateName
     * @param string $expectedPath
     *
     * @throws
     */
    public function testGetSourceContext(string $templateName, string $expectedPath): void
    {
        $source = $this->loader->getSourceContext($templateName);
        $path = str_replace('\\', '/', substr($source->getPath(), \strlen($this->rootPath) + 1));

        static::assertSame($expectedPath, $path);
    }

    /**
     * @throws
     */
    public function testGetSourceContextWithInvalidName(): void
    {
        $this->expectException(LoaderError::class);
        $this->expectExceptionMessage('Unable to find template "@@templates/invalid.en_US.html.twig');

        $this->loader->getSourceContext('@@templates/invalid.en_US.html.twig');
    }
}
