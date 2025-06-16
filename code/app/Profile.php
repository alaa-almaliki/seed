<?php

declare(strict_types=1);

namespace Seed;

use InvalidArgumentException;
use Seed\Actions\Action;
use Seed\Actions\Profiles\Copy;
use Seed\Actions\Profiles\Create;
use Seed\Actions\Profiles\Delete;
use Seed\Actions\Profiles\Scan;

class Profile
{
    public static string $profileDir = __DIR__ . '/../var/profiles/';
    public static array $profile;

    public static function getAction(string $action): Action
    {
        $actions = [
            'list' => new Scan(),
            'create' => new Create(),
            'copy' => new Copy(),
            'delete' => new Delete(),
        ];

        if (isset($actions[$action])) {
            return $actions[$action];
        }
        throw new InvalidArgumentException('Invalid action');
    }

    public static function load(string $name, ?string $section = null): array
    {
        if (!empty(static::$profile)) {
            if (null !== $section) {
                return static::$profile[$section] ?? [];
            }

            return static::$profile;
        }
        static::$profile = require static::$profileDir . $name . '/env.php';
        return static::$profile[$section] ?? static::$profile;
    }

    public static function create(string $name): bool
    {
        $profile = static::$profileDir . $name;
        if (is_dir($profile)) {
            return false;
        }
        if (mkdir($profile) && is_dir($profile)) {
            return copy(__DIR__ . '/../var/stubs/env.php', $profile . '/env.php');
        }

        return false;
    }

    public static function delete(string $name): bool
    {
        $profile = static::$profileDir . $name;

        foreach (scandir($profile) as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            unlink($profile . '/' . $file);
        }

        return rmdir($profile);
    }

    public static function copy(string $source, string $target): bool
    {
        $from = self::$profileDir . $source . '/env.php';
        $to = self::$profileDir . $target;
        if (mkdir($to) && is_dir($to)) {
            return copy($from, $to . '/env.php');
        }
        return false;
    }

    public static function list(): array
    {
        return array_values(preg_grep('/^([^.])/', scandir(static::$profileDir)));
    }
}