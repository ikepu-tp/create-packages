<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Form;
use ikepu_tp\DesignerHelper\app\Models\Form_element;
use ikepu_tp\DesignerHelper\app\Models\Form_setting;
use ikepu_tp\DesignerHelper\app\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormElementTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "form.element";
    public $modelName = "form_element";
    public $resource = [
        "id",
        "label",
        "name",
        "type",
        "note",
        "attributes",
    ];
    public $data = [
        "label" => "test",
        "name" => "test",
        "type" => ["id" => 1],
        "note" => "test",
        "attributes" => [
            "placeholder" => "project name",
            "default_value" => "project name",
            "attr_required" => false,
            "attr_min" => "0",
            "attr_max" => "50"
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        $parameters["project"] = Project::factory()->create();
        $parameters["form"] = Form::factory()->create(["project_id" => $parameters["project"]->id]);
        $this->data["type"]["id"] = Form_setting::factory()->create(["project_id" => $parameters["project"]->id])->id;
        if ($item) $parameters[$this->modelName] = Form_element::factory()->create(["form_id" => $parameters["form"]->id]);
        return $parameters;
    }

    public function test_get_records()
    {
        $response = $this->get(route("{$this->routeName}.index", $this->getParameters()));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getIndexResource());
    }

    public function test_get_record()
    {
        $response = $this->get(route("{$this->routeName}.show", $this->getParameters(true)));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_store_record()
    {
        $response = $this->post(route("{$this->routeName}.store", $this->getParameters()), $this->data);
        $response->assertStatus(201);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_update_record()
    {
        $parameters = $this->getParameters(true);
        $response = $this->put(route("{$this->routeName}.update", $parameters), $this->data);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
        $this->assertEquals($this->data["name"], $parameters[$this->modelName]->fresh()->name);
    }

    public function test_delete_record()
    {
        $parameters = $this->getParameters(true);
        $response = $this->delete(route("{$this->routeName}.destroy", $parameters));
        $response->assertStatus(204);
        $this->assertNotNull($parameters[$this->modelName]->fresh()->deleted_at);
    }
}