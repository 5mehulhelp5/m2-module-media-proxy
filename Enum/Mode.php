<?php // phpcs:ignoreFile Generic.WhiteSpace.ScopeIndent

declare(strict_types=1);

namespace SamJUK\MediaProxy\Enum;

enum Mode : string
{
    case Proxy = 'proxy';
    case Cache = 'cache';
}
