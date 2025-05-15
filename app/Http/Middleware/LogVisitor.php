<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorLog;

class LogVisitor
{
    public function handle(Request $request, Closure $next)
    {
        // Avoid tracking some routes like admin or API if needed
        if (!$request->is('admin/*') && !$request->is('api/*')) {
            $ipAddress = $request->ip();
            $url = $request->fullUrl();

            // Check if the IP address has already visited the same URL
            $existingLog = VisitorLog::where('ip_address', $ipAddress)
                                     ->where('url', $url)
                                     ->first();

            // If not logged yet, create a new record, otherwise update the visit count
            if (!$existingLog) {
                VisitorLog::create([
                    'user_id' => auth()->check() ? auth()->id() : null,
                    'ip_address' => $ipAddress,
                    'url' => $url,
                    'user_agent' => $request->userAgent(),
                    'visit_count' => 1, // Start visit count at 1
                ]);
            } else {
                // Increment visit count for the existing record
                $existingLog->visit_count += 1;
                $existingLog->save();
            }
        }

        return $next($request);
    }
}

