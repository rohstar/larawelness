<?php

use Illuminate\Database\Seeder;

class WellnessQuestionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $questions = [

            [
                'question' => 'What did you eat for breakfast today?',
                'option_1' => 'Cereal',
                'option_2' => 'Eggs',
                'option_3' => 'Granola with Yogurt',
                'option_4' => 'Skipped Breakfast',
                'category' => 'Food'
            ],
            [
                'question' => 'What exercise did you do today?',
                'option_1' => 'Jogging',
                'option_2' => 'Biking',
                'option_3' => 'Gym',
                'option_4' => 'Skipped Exercise',
                'category' => 'Exercise'
            ],
            [
                'question' => 'Did you take your vitamins?',
                'option_1' => 'Yes',
                'option_2' => 'Not Yet',
                'option_3' => 'No',
                'option_4' => 'No vitamins prescribed',
                'category' => 'Medication'
            ],
            [
                'question' => 'Did you take your medication?',
                'option_1' => 'Yes',
                'option_2' => 'Not Yet',
                'option_3' => 'No',
                'option_4' => 'No medication prescribed',
                'category' => 'Medication'
            ],
        ];

        if(\App\WellnessQuestion::all()->isEmpty()){

            foreach ($questions as $q){

                \App\WellnessQuestion::create($q);

            }

        }



    }
}
