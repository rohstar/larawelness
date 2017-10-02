<?php

namespace Tests\Browser;

use App\User;
use App\WellnessRecord;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {

        $record = factory(WellnessRecord::class)->create();

        $this->assertDatabaseHas('wellness_records', $record->toArray());

        $user = User::find($record->user_id);

        $this->browse(function ($browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertSee('Today\'s Wellness Questions')
                ->pause(1000)
                ->assertSee('What did you eat for breakfast today?');

        });

    }

}
