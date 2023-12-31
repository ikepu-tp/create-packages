<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Exception;
use ikepu_tp\DesignerHelper\app\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExceptionTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "exception";
    public $modelName = "exception";
    public $resource = [
        "id",
        "name",
        "http_code",
        "error_code",
        "abstract",
        "title",
        "default_message",
        "note",
    ];
    public $data = [
        "name" => "project name",
        "http_code" => "404",
        "error_code" => "404000",
        "abstract" => "ERROR",
        "title" => "エラーが発生",
        "default_message" => "エラーが発生しました。",
        "note" => "This is a example note."
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        $parameters["project"] = Project::factory()->create();
        if ($item) $parameters[$this->modelName] = Exception::factory()->create(["project_id" => $parameters["project"]->id]);
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