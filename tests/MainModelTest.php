<?php

use Laravel\Lumen\Testing\DatabaseMigrations;

class MainModelTest extends TestCase
{
    protected array  $sample_data = [
        [
            "id"                => 1,
            'first_name'        => 'Gabriel',
            'last_name'         => 'Georgescu',
            'username'          => 'gabriel.georgescu',
            'password'          => '3f76818f507fe7eb6422bd0703c64c88',
            'business_id'       => null,
            'file_id'           => null,
            'is_admin'          => 0,
            'email'             => 'georgescu.gabriel90@gmail.com',
            'phone'             => '02110010010',
            'email_verified_at' => null,
        ],
        [
            "id"                => 2,
            'first_name'        => 'Vasile',
            'last_name'         => 'Gheorge',
            'username'          => 'darkinvault',
            'password'          => '6e51c78128da7bb0eda6428ee90d7f4c',
            'business_id'       => 1,
            'file_id'           => 1,
            'is_admin'          => 0,
            'email'             => 'darkinvault@gmail.com',
            'phone'             => '+40722492508',
            'email_verified_at' => null,
        ],
    ];
    protected string $table       = "users";
    use DatabaseMigrations;

    /** @test */
    public function can_create ()
    {
        foreach ($this->sample_data as $data) {
            $this->post('/', $data);
            unset($data['password']);
            $this->seeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_without_first_name ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['first_name']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_without_last_name ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['last_name']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_without_username ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['username']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_without_phone ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['phone']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_with_same_username ()
    {
        $this->post('/', $this->sample_data[0]);
        unset($this->sample_data[0]['password']);
        $this->seeInDatabase($this->table, $this->sample_data[0]);
        $this->sample_data[1]['username'] = $this->sample_data[0]['username'];
        $this->post('/', $this->sample_data[1]);
        $this->notSeeInDatabase($this->table, $this->sample_data[1]);
    }

    /** @test */
    public function cant_create_without_password ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['password']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function cant_create_without_email ()
    {
        foreach ($this->sample_data as $data) {
            unset($data['email']);
            $this->post('/', $data);
            $this->notSeeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function can_edit ()
    {
        foreach ($this->sample_data as $data) {
            $this->post('/', $data);
            unset($data['password']);
            $this->seeInDatabase($this->table, $data);
            $data['email_verified_at'] = time();
            $this->put('/'.$data['id'], $data);
            $this->seeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function can_delete ()
    {
        foreach ($this->sample_data as $data) {
            $this->post('/', $data);
            unset($data['password']);
            $this->seeInDatabase($this->table, $data);
            $this->delete('/'.$data['id']);
            $this->seeInDatabase($this->table, $data);
        }
    }

    /** @test */
    public function show_all ()
    {
        foreach ($this->sample_data as $data) {
            $this->post('/', $data);
            unset($data['password']);
            $this->seeInDatabase($this->table, $data);
        }
        unset($this->sample_data[0]['password']);
        unset($this->sample_data[1]['password']);
        $this->sample_data[0]['created_at'] = date("Y-m-d H:i:s");
        $this->sample_data[0]['updated_at'] = date("Y-m-d H:i:s");
        $this->sample_data[1]['created_at'] = date("Y-m-d H:i:s");
        $this->sample_data[1]['updated_at'] = date("Y-m-d H:i:s");
        $this->get('/')->seeJson([
            'data' => $this->sample_data,
            'total' => count($this->sample_data),
            'pages' => 1
        ]);
    }

    /** @test */
    public function show_one_by_id ()
    {
        foreach ($this->sample_data as $data) {
            $this->post('/', $data);
            unset($data['password']);
            $this->seeInDatabase($this->table, $data);
            unset($data['password']);
            $data['created_at'] = date("Y-m-d H:i:s");
            $data['updated_at'] = date("Y-m-d H:i:s");
            $this->get('/'.$data['id'])->seeJson([
                'data' => $data
            ]);
        }
    }
}
