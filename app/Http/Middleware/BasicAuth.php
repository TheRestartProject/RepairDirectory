<?php
namespace App\Http\Middleware;
use Closure;
class BasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $AUTH_USER = config('auth.BASIC_AUTH_USER');
        $AUTH_PASS = config('auth.BASIC_AUTH_PASS');
        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        if ($has_supplied_credentials) {
            error_log('X-Auth-Debug1: ' . $_SERVER['PHP_AUTH_USER'] . " vs " . $AUTH_USER);
            error_log('X-Auth-Debug2: ' . $_SERVER['PHP_AUTH_PW'] . " vs " . $AUTH_PASS);
        }

        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );
        error_log('X-Not-Auth: '. $is_not_authenticated);

        if ($is_not_authenticated) {
            header('HTTP/1.1 401 Authorization Required');
            header('WWW-Authenticate: Basic realm="Access denied"');
            exit;
        }

        return $next($request);
    }
}