<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class ActivityControllerTest 
 * ---- 
 * Testsuite for the activity logger pages 
 * 
 * @author      Tim Joosten <tim@activisme.be>
 * @copyright   2018 Tim Joosten
 * @package     Tests\Feature
 */
class ActivityControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @testdox Testde error response wanneer een niet aangemelde gebruiker de activiteiten log wilt bekijken.
     */
    public function indexNoAuth()
    {
        $this->get(route('admin.logs.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /**
     * @test 
     * @testdox Test if a uauthenticated user can view the log page without problems.
     */
    public function indexSuccess()
    {
        $user = factory(User::class)->create();

        $this->actingAs($user)
            ->assertAuthenticatedAs($user)
            ->get(route('admin.logs.index'))
            ->assertStatus(200);
    }
}
