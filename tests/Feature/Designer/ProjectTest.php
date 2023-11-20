<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "project";
    public $resource = [
        "id",
        "name",
        "sub_name",
        "note",
    ];
    public $data = [
        "name" => "Project Name",
        "sub_name" => "Project Sub Name",
        "note" => "Project Note",
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        if ($item) $parameters["project"] = Project::factory()->create();
        return $parameters;
    }

    public function test_get_projects()
    {
        $response = $this->get(route("{$this->routeName}.index", $this->getParameters()));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getIndexResource());
    }

    public function test_get_project()
    {
        $response = $this->get(route("{$this->routeName}.show", $this->getParameters(true)));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_store_project()
    {
        $response = $this->post(route("{$this->routeName}.store", $this->getParameters()), $this->data);
        $response->assertStatus(201);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_update_project()
    {
        $parameters = $this->getParameters(true);
        $response = $this->put(route("{$this->routeName}.update", $parameters), $this->data);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
        $this->assertEquals($this->data["name"], $parameters["project"]->fresh()->name);
    }

    public function test_delete_project()
    {
        $parameters = $this->getParameters(true);
        $response = $this->delete(route("{$this->routeName}.destroy", $parameters));
        $response->assertStatus(204);
        $this->assertNotNull($parameters["project"]->fresh()->deleted_at);
    }
}