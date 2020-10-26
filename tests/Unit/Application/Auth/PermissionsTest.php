<?php

namespace TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use TheRestartProject\RepairDirectory\Tests\TestCase;
use TheRestartProject\Fixometer\Domain\Entities\User;
use TheRestartProject\Fixometer\Domain\Entities\Role;
use Mockery as m;

/**
 * Tests for the FixometerSessionService
 *
 * @category Test
 * @package  TheRestartProject\RepairDirectory\Tests\Unit\Application\Auth
 * @author   Neil Mather <neil@therestartproject.org>
 * @license  GPLv2 https://www.gnu.org/licenses/old-licenses/gpl-2.0.en.html
 * @link     https://therestartproject.org
 */
class PermissionsTest extends TestCase
{
    private function getRole($roleName)
    {
        $registry = resolve('Doctrine\Common\Persistence\ManagerRegistry');
        $manager = $registry->getManager('restarters_testing');
        $roleRepo = $manager->getRepository(Role::class);

        return $roleRepo->findBy(['name' => $roleName])[0];
    }

    /// ASSIGNING SUPER ADMIN

    /** @test */
    public function it_permits_superadmin_assigning_superadmin()
    {
        $user = entity(User::class)->create(['username' => 'ugo']);
        $user->setRepairDirectoryRole($this->getRole('SuperAdmin'));

        $this->be($user);

        $this->assertTrue(Gate::forUser($user)->allows('assignRole', 'SuperAdmin'));
    }

    /** @test */
    public function it_denies_regionaladmin_assigning_superadmin()
    {
        $user = entity(User::class)->create(['username' => 'vanessa']);
        $user->setRepairDirectoryRole($this->getRole('RegionalAdmin'));

        $this->be($user);

        $this->assertFalse(Gate::forUser($user)->allows('assignRole', 'SuperAdmin'));
    }

    /** @test */
    public function it_denies_editor_assigning_superadmin()
    {
        $user = entity(User::class)->create(['username' => 'stefania']);
        $user->setRepairDirectoryRole($this->getRole('Editor'));

        $this->be($user);

        $this->assertFalse(Gate::forUser($user)->allows('assignRole', 'SuperAdmin'));
    }


    /// ASSIGNING REGIONAL ADMIN

    /** @test */
    public function it_permits_superadmin_assigning_regionaladmin()
    {
        $user = entity(User::class)->create(['username' => 'ugo']);
        $user->setRepairDirectoryRole($this->getRole('SuperAdmin'));

        $this->be($user);

        $this->assertTrue(Gate::forUser($user)->allows('assignRole', 'RegionalAdmin'));
    }

    /** @test */
    public function it_denies_regionaladmin_assigning_regionaladmin()
    {
        $user = entity(User::class)->create(['username' => 'vanessa']);
        $user->setRepairDirectoryRole($this->getRole('RegionalAdmin'));

        $this->be($user);

        $this->assertFalse(Gate::forUser($user)->allows('assignRole', 'RegionalAdmin'));
    }

    /** @test */
    public function it_denies_editor_assigning_regionaladmin()
    {
        $user = entity(User::class)->create(['username' => 'stefania']);
        $user->setRepairDirectoryRole($this->getRole('Editor'));

        $this->be($user);

        $this->assertFalse(Gate::forUser($user)->allows('assignRole', 'RegionalAdmin'));
    }
}
