<?php

namespace Tests\Unit;

use App\Http\Controllers\api\v1\form\FormController;
use App\Models\CheckList;
use App\Models\Form;
use App\Models\User;
use App\Services\FormService;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;


class FormTest extends TestCase
{

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_can_not_see_form_with_wrong_id()
    {
        Sanctum::actingAs(User::factory()->create());
        $formService = new FormService();
        $this->formController = new FormController($formService);
        $form = Form::latest()->first();;
        $response = $this->formController->getForm($form->id + 1);
        $this->assertEquals($response->original[0], 'form not found');

    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCountCheckList5()
    {
        $checkList = CheckList::factory(5)->create();
        $this->assertLessThanOrEqual(5, count($checkList));
    }

    /** @test */
    public function TestModelFormHasRelation()
    {
        $form = Form::factory()->create();
        $this->assertModelExists($form->checklist);
    }
}
