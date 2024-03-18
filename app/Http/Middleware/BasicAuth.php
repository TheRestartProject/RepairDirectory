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
        $user = null;
        $pass = null;

        try {
            $config = new \Platformsh\ConfigReader\Config();

            if (!$config->isValidPlatform()) {
                die("Not in a Platform.sh Environment.");
            }

            $user = $config->variable('BASIC_AUTH_USER', '');
            $pass = $config->variable('BASIC_AUTH_PASS', '');
            error_log("Passed basic auth user and pass " . $user . " " . $pass);
        } catch (\Exception $e) {
            error_log("No basic auth user and pass " . $e->getMessage());
        }

        header('Cache-Control: no-cache, must-revalidate, max-age=0');
        $has_supplied_credentials = !(empty($_SERVER['PHP_AUTH_USER']) && empty($_SERVER['PHP_AUTH_PW']));
        if ($has_supplied_credentials) {
            error_log('X-Auth-Debug1: ' . $_SERVER['PHP_AUTH_USER'] . " vs " . $user);
            error_log('X-Auth-Debug2: ' . $_SERVER['PHP_AUTH_PW'] . " vs " . $pass);
        }

        $is_not_authenticated = (
            !$has_supplied_credentials ||
            $_SERVER['PHP_AUTH_USER'] != $user ||
            $_SERVER['PHP_AUTH_PW']   != $pass
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