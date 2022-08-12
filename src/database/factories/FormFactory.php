<?php

namespace Database\Factories;

use App\Models\CheckList;
use App\Models\Form;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factory>
 */
class FormFactory extends Factory
{
    /**
     * The name of the form's corresponding model.
     *
     * @var string
     */
    protected $model = Form::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::factory()->create();
        $checkList = CheckList::create([
            'user_id'=>$user->id,
            'title'=>$this->faker->word,
            'description'=>$this->faker->text,
        ]);

        return [
            'uuid' => $this->faker->uuid,
            'check_list_id' => $checkList->id,
            'type' => Form::TYPE_FORM
        ];
    }

}
