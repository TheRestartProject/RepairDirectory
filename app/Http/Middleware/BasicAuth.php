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
        echo $_SERVER['PHP_AUTH_USER'] . " vs " . $AUTH_USER . "\n";
        echo $_SERVER['PHP_AUTH_PW'] . " vs " . $AUTH_PASS . "\n";
        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $AUTH_USER ||
            $_SERVER['PHP_AUTH_PW']   != $AUTH_PASS
        );
        echo "Not auth " . $is_not_authenticated . "\n";
//        if ($is_not_authenticated) {
//            header('HTTP/1.1 401 Authorization Required');
//            header('WWW-Authenticate: Basic realm="Access denied"');
//            exit;
//        }
        return $next($request);
    }
}