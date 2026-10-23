<?php

declare(strict_types=1);

namespace App\Utils;

use App\Models\Visitor;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;
use Throwable;

class GlobalVisitor
{
    public const LOCAL_IP = '127.0.0.1';

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

    public function get(): Visitor|null
    {
        $ip = self::getIp();

        if (self::$visitor && self::$visitor->ip === $ip) {
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

    private static function getIp(): string
    {
        return trim(request()->ip() ?? '');
    }

    /**
     * @throws QueryException
     */
    private static function getOrCreateVisitor(): Visitor|null
    {
        $ip = self::getIp();

        if ($ip === self::LOCAL_IP) {
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

        $position = self::getVisitorPosition($ip);

        try {
            /** @var Visitor */
            return Visitor::query()->firstOrCreate(compact('ip'), [
                'ip' => $ip,
                'country' => $position->countryName ?? 'Unknown',
                'city' => $position->cityName ?? 'Unknown',
                'code' => $position->countryCode ?? 'Unknown',
            ]);
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }

    private static function getVisitorPosition(string $ip): Position|null
    {
        try {
            $result = Location::get($ip);
            return is_bool($result) ? null : $result;
        } catch (Throwable $e) {
            Log::warning($e->getMessage());
            return null;
        }
    }
}
