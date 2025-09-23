<?php
namespace App\Http\Middleware;

use Closure;

class ActivityLog
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        // jangan log jika route / aksi sensitif (login, password reset, dsb)
        $skip = [
            'login', 'logout', 'password', '_debugbar', 'sanctum', 'oauth'
        ];
        $uri = $request->path();
        foreach ($skip as $s) {
            if (str_contains($uri, $s)) {
                return $response;
            }
        }

        $inputs = $request->except(config('activitylog.exclude_fields', []));

        // jangan log file upload besar
        foreach ($request->files->keys() as $k) {
            unset($inputs[$k]);
        }

        activity_log(
            'http.request.' . $request->method(),
            [
                'route' => optional($request->route())->getName(),
                'uri' => $request->getRequestUri(),
                'inputs' => $inputs,
                'status' => $response->getStatusCode(),
            ],
            auth()->user() ?? null,
            'info'
        );

        return $response;
    }
}
