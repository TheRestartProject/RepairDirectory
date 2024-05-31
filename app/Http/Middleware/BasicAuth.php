<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Log;

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
        Log::error("Basic auth handle");
        $user = null;
        $pass = null;

        try {
            $config = new \Platformsh\ConfigReader\Config();
            Log::error("Got config");

            if ($config->isValidPlatform()) {
                Log::error("Valid platform");
                $user = $config->variable('BASIC_AUTH_USER', '');
                $pass = $config->variable('BASIC_AUTH_PASS', '');
            }
        } catch (\Exception $e) {
            Log::error("No basic auth user and pass " . $e->getMessage());
        }

        Log::error("User $user pass $pass");

        if ($user && $pass) {
            // Basic auth configured, apply.
            Log::error("Basic auth configured");
            header('Cache-Control: no-cache, must-revalidate, max-age=0');
            $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
            if ($has_supplied_credentials) {
                Log::error('X-Auth-Debug1: ' . $_SERVER['PHP_AUTH_USER'] . " vs " . $user);
                Log::error('X-Auth-Debug2: ' . $_SERVER['PHP_AUTH_PW'] . " vs " . $pass);
            }

            Log::error("Has supplied credentials $has_supplied_credentials, user " . $_SERVER['PHP_AUTH_USER'] . " pass " . $_SERVER['PHP_AUTH_PW']);
            $is_not_authenticated = (
                !$has_supplied_credentials ||
                $_SERVER['PHP_AUTH_USER'] != $user ||
                $_SERVER['PHP_AUTH_PW']   != $pass
            );

            Log::error("Is not authenticated $is_not_authenticated");
            if ($is_not_authenticated) {
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Access denied"');
                Log::error("Unauthorized");
                exit;
            }
        }

        return $next($request);
    }
}