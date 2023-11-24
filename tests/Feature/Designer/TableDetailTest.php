<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Project;
use ikepu_tp\DesignerHelper\app\Models\Table_detail;
use ikepu_tp\DesignerHelper\app\Models\Table_outline;
use ikepu_tp\DesignerHelper\app\Models\Table_setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TableDetailTest extends TestCase
{
    use RefreshDatabase;
    use Funcs;

    public $routeName = "table.detail";
    public $resource = [
        "id",
        "name",
        "col_name",
        "table_setting",
        "col_digits",
        "col_nullable",
        "col_default",
        "col_unique",
        "col_primary",
        "col_index",
        "note",
    ];
    public $data = [
        "name" => "名前",
        "col_name" => "name",
        "table_setting" => [
            "id" => 1,
        ],
        "col_digits" => 100,
        "col_nullable" => true,
        "col_default" => "test",
        "col_unique" => false,
        "col_primary" => false,
        "col_index" => true,
        "note" => "This is a test.",
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->setHeaders();
    }

    public function getParameters(bool $item = false, array $parameters = []): array
    {
        $parameters["project"] = Project::factory()->create();
        $parameters["table_outline"] = Table_outline::factory()->create(["project_id" => $parameters["project"]->id]);
        $this->data["table_setting"]["id"] = Table_setting::factory()->create(["project_id" => $parameters["project"]->id])->id;
        if ($item) $parameters["table_detail"] = Table_detail::factory()->create(["table_outline_id" => $parameters["table_outline"]->id]);
        return $parameters;
    }

    public function test_get_table_details()
    {
        $response = $this->get(route("{$this->routeName}.index", $this->getParameters()));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getIndexResource());
    }

    public function test_get_table_detail()
    {
        $response = $this->get(route("{$this->routeName}.show", $this->getParameters(true)));
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_store_table_detail()
    {
        $response = $this->post(route("{$this->routeName}.store", $this->getParameters()), $this->data);
        $response->assertStatus(201);
        $response->assertJsonStructure($this->getSuccessResource());
    }

    public function test_update_table_detail()
    {
        $parameters = $this->getParameters(true);
        $response = $this->put(route("{$this->routeName}.update", $parameters), $this->data);
        $response->assertStatus(200);
        $response->assertJsonStructure($this->getSuccessResource());
        $this->assertEquals($this->data["name"], $parameters["table_detail"]->fresh()->name);
    }

    public function test_delete_table_detail()
    {
        $parameters = $this->getParameters(true);
        $response = $this->delete(route("{$this->routeName}.destroy", $parameters));
        $response->assertStatus(204);
        $this->assertNotNull($parameters["table_detail"]->fresh()->deleted_at);
    }
}