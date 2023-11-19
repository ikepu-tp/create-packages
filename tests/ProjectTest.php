<?php

namespace Tests\Feature\Designer;

use ikepu_tp\DesignerHelper\app\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Funcs;
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

    public function setUp(): void
    {
        parent::setUp();
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
}