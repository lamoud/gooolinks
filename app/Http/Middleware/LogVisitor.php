<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Visitor;
use Illuminate\Support\Facades\Auth;
use hisorange\BrowserDetect\Parser as Browser;
use Torann\GeoIP\Facades\GeoIP;
use Illuminate\Support\Facades\Route;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Execute the request
        $response = $next($request);

        // Skip for asset requests, AJAX calls, or Sanctum routes if needed
        if ($request->is('api/*') || $request->ajax() || $request->is('sanctum/*')) {
            return $response;
        }

        // Create or find visitor record
        $visitor = Visitor::firstOrCreate(
            [
                'user_id' => Auth::check() ? Auth::id() : null,
                'ip_address' => $request->ip(),
            ],
            [
                'user_agent' => $request->userAgent(),
            ]
        );

        // Get geographical information using stevebauman/location or torann/geoip
        $location = $request->ip() ?: GeoIP::getLocation($request->ip());

        // Get browser, OS, and device information using hisorange/browser-detect
        $browser = Browser::browserName();
        $os = Browser::platformName();
        $device = Browser::deviceType();
        $routeName = Route::currentRouteName() ?? $request->path();
        // Store visit data in the visits table
        $visitor->visits()->create([
            'visitor_id' => $visitor->id,
            'page' =>  $routeName,
            'browser' => $browser,
            'os' => $os,
            'country_code' => $location->countryCode ?? null,
            'country_name' => $location->countryName ?? null,
            'region_name' => $location->regionName ?? null,
            'city' => $location->cityName ?? null,
            'zip_code' => $location->zipCode ?? null,
            'time_zone' => $location->timeZone ?? null,
            'latitude' => $location->latitude ?? null,
            'longitude' => $location->longitude ?? null,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'referer' => $request->header('referer'),
            'device' => $device,
        ]);

        return $response;
    }
}
