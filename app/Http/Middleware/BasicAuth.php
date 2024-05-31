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
        header('X-Debug-Upsun-1:', "Basic auth handle");
        $user = null;
        $pass = null;

        try {
            $config = new \Platformsh\ConfigReader\Config();
            Log::error("Got config");
            header('X-Debug-Upsun-2:', "Got config");

            if ($config->isValidPlatform()) {
                Log::error("Valid platform");
                header('X-Debug-Upsun-3:', "Valid platform");
                $user = $config->variable('BASIC_AUTH_USER', '');
                $pass = $config->variable('BASIC_AUTH_PASS', '');
                header('X-Debug-Upsun-4:', "Auth user " . $user);
            }
        } catch (\Exception $e) {
            Log::error("No basic auth user and pass " . $e->getMessage());
            header('X-Debug-Upsun-5:', "No basic auth user and pass " . $e->getMessage());
        }

        if ($user && $pass) {
            // Basic auth configured, apply.
            header('Cache-Control: no-cache, must-revalidate, max-age=0');
            $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
            if ($has_supplied_credentials) {
                Log::error('X-Auth-Debug1: ' . $_SERVER['PHP_AUTH_USER'] . " vs " . $user);
                Log::error('X-Auth-Debug2: ' . $_SERVER['PHP_AUTH_PW'] . " vs " . $pass);
            }

            $is_not_authenticated = (
                !$has_supplied_credentials ||
                $_SERVER['PHP_AUTH_USER'] != $user ||
                $_SERVER['PHP_AUTH_PW']   != $pass
            );

            if ($is_not_authenticated) {
                header('HTTP/1.1 401 Authorization Required');
                header('WWW-Authenticate: Basic realm="Access denied"');
                exit;
            }
        }

        return $next($request);
    }
}