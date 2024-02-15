<?php

namespace Affise\Tracking;

/**
 * Enum PostbackStatus
 */
final class PostbackStatus
{
    public const CONFIRMED = 1;
    public const PENDING = 2;
    public const DECLINED = 3;
    public const HOLD = 5;

    private int $value;

    private static array $values = [
        self::CONFIRMED => null,
        self::PENDING => null,
        self::DECLINED => null,
        self::HOLD => null,
    ];

    public static function Confirmed(): PostbackStatus
    {
        if (self::$values[self::CONFIRMED] == null) {
            self::$values[self::CONFIRMED] = new PostbackStatus(self::CONFIRMED);
        }
        return self::$values[self::CONFIRMED];
    }

    public static function Pending(): PostbackStatus
    {
        if (self::$values[self::PENDING] == null) {
            self::$values[self::PENDING] = new PostbackStatus(self::PENDING);
        }
        return self::$values[self::PENDING];
    }

    public static function Declined(): PostbackStatus
    {
        if (self::$values[self::DECLINED] == null) {
            self::$values[self::DECLINED] = new PostbackStatus(self::DECLINED);
        }
        return self::$values[self::DECLINED];
    }

    public static function Hold(): PostbackStatus
    {
        if (self::$values[self::HOLD] == null) {
            self::$values[self::HOLD] = new PostbackStatus(self::HOLD);
        }
        return self::$values[self::HOLD];
    }

    /**
     * @param int $status
     */
    private function __construct(int $status)
    {
        $this->value = $status;
    }

    public function value(): int
    {
        return $this->value;
    }
}