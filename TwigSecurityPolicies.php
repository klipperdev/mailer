<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class TwigSecurityPolicies
{
    public const ALLOWED_TAGS = [
        'apply',
        'autoescape',
        'block',
        'do',
        'embed',
        'extends',
        'for',
        'if',
        'include',
        'set',
        'use',
        'verbatim',
        'with',
    ];

    public const ALLOWED_FILTERS = [
        'abs',
        'batch',
        'capitalize',
        'column',
        'convert_encoding',
        'date',
        'date_modify',
        'default',
        'escape',
        'filter',
        'first',
        'format',
        'inky',
        'inline_css',
        'join',
        'json_encode',
        'keys',
        'last',
        'length',
        'lower',
        'map',
        'merge',
        'nl2br',
        'number_format',
        'raw',
        'reduce',
        'replace',
        'reverse',
        'round',
        'slice',
        'sort',
        'spaceless',
        'split',
        'striptags',
        'title',
        'trim',
        'url_encode',
    ];

    public const ALLOWED_METHODS = [
        \Symfony\Bridge\Twig\Mime\WrappedTemplatedEmail::class => [
            'toName',
            'image',
            'attach',
            'setSubject',
            'getSubject',
            'getReturnPath',
            'addFrom',
            'getFrom',
            'addReplyTo',
            'getReplyTo',
            'addTo',
            'getTo',
            'addCc',
            'getCc',
            'addBcc',
            'getBcc',
        ],
        \Symfony\Component\Mime\Address::class => [
            'getAddress',
            'getEncodedAddress',
        ],
        \Symfony\Component\Mime\NamedAddress::class => [
            'getName',
            'getEncodedNamedAddress',
        ],
        \Klipper\Bridge\SmsSender\Twig\Mime\WrappedTemplatedSms::class => [
            'getFrom',
            'addTo',
            'getTo',
        ],
        \Klipper\Component\SmsSender\Mime\Phone::class => [
            'getPhone',
            'getEncodedPhone',
        ],
    ];

    public const ALLOWED_PROPERTIES = [];

    public const ALLOWED_FUNCTIONS = [
        'attribute',
        'block',
        'constant',
        'cycle',
        'date',
        'include',
        'max',
        'min',
        'parent',
        'random',
        'range',
        'source',
        'template_from_string',
    ];
}
