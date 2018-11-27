<?php

namespace Tests\Feature;

use Artisan;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->artisan('migrate:refresh');
    }

    /**
     * /users [GET]
     */
    public function testShouldReturnAllUsers()
    {
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

        $response = $this->json('GET', '/api/v1/users');

        $response->assertOk()
                 ->assertJsonStructure([
                    'data' => ['*' =>
                        [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                        ]
                    ],
                 ]);
    }

    /**
     * /users [POST]
     */
    public function testShouldCreateUser()
    {
        $parameters = [
            'name' => 'Test2',
            'email' => 'test2@email.com'
        ];

        $response = $this->json('POST', '/api/v1/users', $parameters);

        $response->assertStatus(201)
                 ->assertJsonStructure(
                    ['data' =>
                        [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                        ]
                    ]
        );
    }

    /**
     * /users/id [GET]
     */
    public function testShouldReturnUser()
    {
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

        $response = $this->json('GET', "/api/v1/users/1");

        $response->assertOk()
                 ->assertJsonStructure([
                    'data' =>
                        [
                            'id',
                            'name',
                            'email',
                            'created_at',
                            'updated_at'
                        ]
                ]);

    }

    /**
     * /users/id [PUT]
     */
    public function testShouldUpdateUser()
    {
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

        $parameters = [
            'name' => 'Lucas',
            'email' => 'lucas@email.com',
        ];

        $response = $this->json('PUT', '/api/v1/users/1', $parameters);
        $response->assertStatus(200)
             ->assertJsonStructure(
                ['data' =>
                    [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at'
                    ]
                ]
        );
    }
    /**
     * /users/id [DELETE]
     */
    public function testShouldDeleteUser()
    {
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

        $response = $this->delete("/api/v1/users/1");

        $response->assertStatus(204);
    }

    public function testShouldReturnErrorWhenExistsEmail()
    {
        $this->artisan('db:seed', ['--class' => 'UsersTableSeeder']);

        $parameters = [
            'name' => 'Test',
            'email' => 'test@email.com'
        ];

        $response = $this->json('POST', '/api/v1/users', $parameters);

        $response->assertStatus(422)
                 ->assertJsonStructure(
                    [
                        "message",
                        "errors" => [
                            "email"
                        ]
                    ]
                );
    }

    public function testShouldReturnError()
    {
        $response = $this->json('GET', "/api/v1/users/100");

        $response->assertStatus(404)
                 ->assertJsonStructure([
                    'message'
                ]);
    }
}
