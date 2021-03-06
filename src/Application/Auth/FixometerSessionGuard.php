<?php

namespace TheRestartProject\RepairDirectory\Application\Auth;

use Illuminate\Auth\Events;
use Illuminate\Auth\GuardHelpers;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\Cookie;
use RuntimeException;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Contracts\Session\Session;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Auth\StatefulGuard;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Contracts\Auth\SupportsBasicAuth;
use Illuminate\Contracts\Cookie\QueueingFactory as CookieJar;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

/**
 * Implementation of the StatefulGuard that uses the FixometerSession
 *
 * @category Auth
 * @package  TheRestartProject\RepairDirectory\Application\Auth
 * @author   Matthew Kendon <matt@outlandish.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://www.outlandish.com/
 *
 * @SuppressWarnings(PHPMD)
 */
class FixometerSessionGuard extends SessionGuard
{
    /**
     * Refresh the "remember me" token for the user.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user The user to cycle the remember token on
     *
     * @return void
     */
    protected function cycleRememberToken(AuthenticatableContract $user)
    {
        $user->setRememberToken($token = Str::random(45));

        $this->provider->updateRememberToken($user, $token);
    }

    /**
     * Get a unique identifier for the auth session value.
     *
     * @return string
     */
    public function getName()
    {
        return 'user';
    }

}
