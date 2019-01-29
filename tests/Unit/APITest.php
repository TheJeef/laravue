<?php

namespace Tests\Unit;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class APITest extends TestCase
{

    public function testUserCreation() {
        $response = $this->json('POST','/api/register', [
            'name' => 'Demo User',
            'email' => str_random(10).'@demo.com',
            'password' => '12345',
        ]);

        $response->assertStatus(200)->assertJsonStructure([
            'success' => ['token','name']
        ]);
    }

    public function testUserLogin() {
        $respone = $this->json('POST','/api/login', [
            'email' => 'test@test.com',
            'password' => 'test1234'
        ]);

        $respone->assertStatus(200)->assertJsonStructure([
            'success' => ['token']
        ]);
    }

    public function testCategoryFetch() {
        $user = User::first();
        $response = $this->actingAs($user,'api')
            ->json('GET','/api/category')
            ->assertJsonStructure([
                '*' => [
                    'id',
                    'name',
                    'created_at',
                    'updated_at',
                    'deleted_at'
                ]
            ]);
    }

    public function testCategoryCreation() {
        $user = User::first();
        $response = $this->actingAs($user,'api')
            ->json('POST','/api/category', [
            'name' => str_random(10),
        ]);

        $response->assertStatus(200)->assertJson([
            'status' => true,
            'message' => 'Category Created'
        ]);
    }

    public function testCategoryDeletion() {
        $user = User::first();
        $category = Category::create([
            'name' => 'To be Deleted'
        ]);

        $response = $this->actingAs($user, 'api')
            ->json('DELETE',"/api/category/{$category->id}")
            ->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Category Deleted'
            ]);
    }
}
