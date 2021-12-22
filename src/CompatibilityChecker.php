<?php

namespace Oro\Api;

use Oro\Api\Exceptions\IncompatiblePlatform;

class CompatibilityChecker
{
    /**
     * @var string
     */
    public const MIN_PHP_VERSION = "8.0.0";

    /**
     * @throws IncompatiblePlatform
     * @return void
     */
    public function checkCompatibility(): void
    {
        if (! $this->satisfiesPhpVersion()) {
            throw new IncompatiblePlatform(
                "The client requires PHP version >= " . self::MIN_PHP_VERSION . ", you have " . PHP_VERSION . ".",
                IncompatiblePlatform::INCOMPATIBLE_PHP_VERSION
            );
        }

        if (! $this->satisfiesJsonExtension()) {
            throw new IncompatiblePlatform(
                "PHP extension json is not enabled. Please make sure to enable 'json' in your PHP configuration.",
                IncompatiblePlatform::INCOMPATIBLE_JSON_EXTENSION
            );
        }
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    public function satisfiesPhpVersion(): bool
    {
        return (bool)version_compare(PHP_VERSION, self::MIN_PHP_VERSION, ">=");
    }

    /**
     * @return bool
     * @codeCoverageIgnore
     */
    public function satisfiesJsonExtension(): bool
    {
        // Check by extension_loaded
        if (function_exists('extension_loaded') && extension_loaded('json')) {
            return true;
        }

        if (function_exists('json_encode')) {
            return true;
        }

        return false;
    }
}
