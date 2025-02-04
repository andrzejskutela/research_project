<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUUID
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route()->parameter('uuid') !== (string)session('unique_id')) {
            return redirect('/');
        }

        $controlledPaths = ['new_participant', 'introduction', 'preparation', 'memory_task',];
        $current = $request->route()->getName();

        if (in_array($current, $controlledPaths)) {
            $visitedPaths = session('visited', []);
            if (in_array($current, $visitedPaths)) {
                return redirect('/')->with('refresh_error', true);
            }

            $visitedPaths[] = $current;
            session(['visited' => $visitedPaths]);
        }

        return $next($request);
    }
}
