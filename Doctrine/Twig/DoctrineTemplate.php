<?php

/*
 * This file is part of the Klipper package.
 *
 * (c) François Pluchino <francois.pluchino@klipper.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Klipper\Component\Mailer\Doctrine\Twig;

use Klipper\Component\Mailer\Model\TemplateMessageInterface;

/**
 * @author François Pluchino <francois.pluchino@klipper.dev>
 */
class DoctrineTemplate
{
    /**
     * @var int|string
     */
    protected $id;

    protected string $name;

    protected ?string $type;

    protected string $body;

    protected ?\DateTime $updatedAt = null;

    public function __construct(TemplateMessageInterface $template)
    {
        $id = $template->getId();
        $this->id = \is_int($id) ? $id : (string) $id;
        $this->name = (string) $template->getName();
        $this->type = $template->getType();
        $this->body = (string) $template->getBody();

        if (method_exists($template, 'getUpdatedAt') && ($date = $template->getUpdatedAt()) instanceof \DateTime) {
            $this->updatedAt = clone $date;
        }
    }

    /**
     * Gets the id.
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the unique template name.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get the type.
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * Get the body.
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * Get the date of update of model.
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }
}
