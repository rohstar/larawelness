<?php

namespace Tests\Browser;

use App\User;
use App\WellnessQuestion;
use App\WellnessRecord;
use Illuminate\Support\Facades\DB;
use Tests\DuskTestCase;

class WellnessTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testRecordCreation()
    {

        $record = factory(WellnessRecord::class)->create();
        $question = factory(WellnessQuestion::class)->create();

        $this->assertDatabaseHas('wellness_records', $record->toArray());

        $user = User::find($record->user_id);

        $this->browse(function ($browser) use ($user, $question, $record) {

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertSee('Today\'s Wellness Questions')
                ->pause(1000)
                ->assertSee($question->question)
                ->radio('question_radio', 'option_1')
                ->assertSee($question->option_1);

            $user_record = DB::table('user_records')
                ->where('wellness_record_id', $record->id)
                ->where('wellness_question_id', $question->id)->get();

            //if record doesn't exist, this assertion should fail
            $this->assertDatabaseHas('user_records', $user_record->toArray());

        });

    }

}
