<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EjerciciosControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        $this->seed();
    }

    public function test_index_returns_all_ejercicios()
    {
        $response = $this->getJson('/api/ejercicios', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['data' => [['name', 'instructions']]]);
    }

    public function test_get_byName_returns_ejercicio()
    {
        $response = $this->getJson('/api/ejercicios/Alternate Hammer Curl', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200)
                    ->assertJsonStructure(['data' => ['name', 'instructions']]);
    }

    public function test_get_byCategory_returns_ejercicio()
    {
        $response = $this->getJson('/api/ejercicios/getAll/category', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200)
                    ->assertJsonStructure(['data']);
    }

    public function test_get_byEquipment_return_ejercicio()
    {
        $response = $this->getJson('/api/ejercicios/getAll/equipment', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200)
                    ->assertJsonStructure(['data']);
    }

    public function test_get_byForce_returns_ejercicio()
    {
        $response = $this->getJson('/api/ejercicios/getAll/force', [
            'Accept' => 'application/json',
        ]);

        $response->assertStatus(200)
                    ->assertJsonStructure(['data']);
    }

    public function test_get_filtered()
    {
        $response = $this->getJson('/api/ejercicios/getAll/filter?muscle=biceps');

        $response->assertStatus(200)
            ->assertJsonStructure(['data' => [['name', 'instructions']]]);
    }
}
