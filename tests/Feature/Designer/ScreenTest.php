<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Project;
use ikepu_tp\DesignerHelper\app\Models\Screen;
use ikepu_tp\DesignerHelper\app\Models\Screen_class;
use ikepu_tp\DesignerHelper\app\Models\Screen_progress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScreenTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "screen";
    public $modelName = "screen";
    public $resource = [
        "id",
        "name",
        "screen_class",
        "screen_progress",
        "note",
        "url",
        "route_name",
    ];
    public $data = [];
    public $project;

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
        $this->project = Project::factory()->create();
        $this->data = [
            "name" => "name",
            "screen_class" => [
                "id" => Screen_class::factory()->create(["project_id" => $this->project->id])->id,
            ],
            "screen_progress" => [
                "id" => Screen_progress::factory()->create(["project_id" => $this->project->id])->id,
            ],
            "note" => "note",
            "url" => "url",
            "route_name" => "route_name",
        ];
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        $parameters["project"] = $this->project;
        if ($item) $parameters[$this->modelName] = Screen::factory()->create(["project_id" => $parameters["project"]->id]);
        return $parameters;
    }

    public function test_get_table_outlines()
    {
        $response = $this->get(route("{$this->routeName}.index", $this->getParameters()));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getIndexResource());
    }

    public function test_get_table_outline()
    {
        $response = $this->get(route("{$this->routeName}.show", $this->getParameters(true)));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_store_table_outline()
    {
        $response = $this->post(route("{$this->routeName}.store", $this->getParameters()), $this->data);
        $response->assertStatus(201);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_update_table_outline()
    {
        $parameters = $this->getParameters(true);
        $response = $this->put(route("{$this->routeName}.update", $parameters), $this->data);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
        $this->assertEquals($this->data["name"], $parameters[$this->modelName]->fresh()->name);
    }

    public function test_delete_table_outline()
    {
        $parameters = $this->getParameters(true);
        $response = $this->delete(route("{$this->routeName}.destroy", $parameters));
        $response->assertStatus(204);
        $this->assertNotNull($parameters[$this->modelName]->fresh()->deleted_at);
    }
}