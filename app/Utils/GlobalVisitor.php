<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\Visitor;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Location;
use Stevebauman\Location\Position;
use Throwable;

class GlobalVisitor
{
    public const LOCAL_IP = '127.0.0.1';
    public const LOCAL_COUNTRY = 'Ukraine';
    public const LOCAL_CITY = 'Kharkiv';
    public const LOCAL_CODE = 'UA';
    public const BLOCKED_MESSAGE = <<<TEXT
    <h1>⛔️ You are blocked due to some website rules violation</h1>
    <h2>⚠️ If you think that this is a mistake, please contact the website administrator</h2>
    TEXT;

    private static ?self $instance = null;
    private static ?Visitor $visitor = null;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function get(): ?Visitor
    {
        if (self::$visitor) {
            return self::$visitor;
        }

        self::$visitor = self::getOrCreateVisitor();

        return self::$visitor;
    }

    public function load(): void
    {
        if (!self::$visitor) {
            self::$visitor = self::getOrCreateVisitor();
        }
    }

    /**
     * @throws QueryException
     */
    private static function getOrCreateVisitor(): ?Visitor
    {
        $ip = trim(request()->ip() ?? '');

        $position = $ip === self::LOCAL_IP
            ? self::defaultPosition()
            : self::getRealPosition($ip);

        if (!$position) {
            return null;
        }

        /** @var Visitor|null $visitor */
        $visitor = Visitor::query()->where('ip', $ip)->first();

        if ($visitor && $visitor->is_blocked) {
            Log::info("Blocked visitor with IP: {$ip}");
            die(self::BLOCKED_MESSAGE);
        }

        if ($visitor) {
            return $visitor;
        }

        try {
            /** @var Visitor */
            return Visitor::query()->create([
                'ip' => $ip,
                'country' => $position->countryName,
                'city' => $position->cityName,
                'code' => $position->countryCode,
            ]);
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }

    private static function defaultPosition(): Position
    {
        $result = new Position();

        $result->countryName = self::LOCAL_COUNTRY;
        $result->cityName = self::LOCAL_CITY;
        $result->countryCode = self::LOCAL_CODE;

        return $result;
    }

    private static function getRealPosition(string $ip): ?Position
    {
        try {
            $result = app(Location::class)->get($ip);
            return is_bool($result) ? null : $result;
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }
}
