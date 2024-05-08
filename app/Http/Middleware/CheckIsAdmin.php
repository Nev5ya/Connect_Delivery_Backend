<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|JsonResponse
     */
    public function handle(Request $request, Closure $next): Response|JsonResponse
    {
        if (auth()->user()->isAdministrator()) {
            return $next($request);
        }
        return response([
            'errors' => 'This action is unauthorized'
        ], 403);
    }
}
