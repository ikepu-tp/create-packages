<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Project;
use ikepu_tp\DesignerHelper\app\Models\Table_setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableSettingTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "table.setting";
    public $resource = [
        "id",
        "model_cast",
        "db_type",
        "php_type",
    ];
    public $data = [
        "model_cast" => "string",
        "db_type" => "varchar",
        "php_type" => "string",
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        $parameters["project"] = Project::factory()->create();
        if ($item) $parameters["table_setting"] = Table_setting::factory()->create(["project_id" => $parameters["project"]->id]);
        return $parameters;
    }

    public function test_get_table_settings()
    {
        $response = $this->get(route("{$this->routeName}.index", $this->getParameters()));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getIndexResource());
    }

    public function test_get_table_setting()
    {
        $response = $this->get(route("{$this->routeName}.show", $this->getParameters(true)));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_store_table_setting()
    {
        $response = $this->post(route("{$this->routeName}.store", $this->getParameters()), $this->data);
        $response->assertStatus(201);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_update_table_setting()
    {
        $parameters = $this->getParameters(true);
        $this->data["model_cast"] = "integer";
        $response = $this->put(route("{$this->routeName}.update", $parameters), $this->data);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
        $this->assertEquals($this->data["model_cast"], $parameters["table_setting"]->fresh()->model_cast);
    }

    public function test_delete_table_setting()
    {
        $parameters = $this->getParameters(true);
        $response = $this->delete(route("{$this->routeName}.destroy", $parameters));
        $response->assertStatus(204);
        $this->assertNotNull($parameters["table_setting"]->fresh()->deleted_at);
    }
}