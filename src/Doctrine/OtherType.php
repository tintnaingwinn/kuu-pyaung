<?php

namespace Tintnaingwin\KuuPyaung\Doctrine;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class OtherType extends Type
{
    /**
     * @var string
     */
    public const NAME = 'other';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * {@inheritdoc}
     *
     * @param  mixed  $value    The value to convert.
     * @param  AbstractPlatform  $platform The currently used database platform.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * {@inheritdoc}
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
