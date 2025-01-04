<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSiteMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // جلب حالة الموقع من الإعدادات
        $siteMode = get_setting('site_mode', 'down'); // افتراضياً يكون الموقع "up"
        
        // إذا كانت حالة الموقع "down" والمستخدم ليس مسؤولاً
        if ($siteMode === 'down' && !$request->user()?->can('admin_view')) {
            // تنفيذ abort(503) لعرض صفحة 503
            abort(503);
        }

        return $next($request);
    }
}
