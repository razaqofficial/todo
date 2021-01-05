<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index()
    {
        $response = $this->get(route('todo.index'));

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'message' => 'Todo List',
        ]);

       // $response->dump();
    }

    public function test_show()
    {
        $todo = Todo::first();

        $response = $this->get(route('todo.show', $todo));

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'message' => 'Todo Details',
        ]);
    }

    public function test_create()
    {
        $response = $this->post(route('todo.create'), [
            'title' => 'Test Title',
            'description' => 'This is a test description'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'message' => 'Todo created successfully',
        ]);

        $this->assertDatabaseHas('todos', [
            'title' => 'Test Title',
            'description' => 'This is a test description'
        ]);

       // $response->dump();

    }

    public function test_update()
    {
        $todo = Todo::first();

        $response = $this->post(route('todo.update', $todo), [
            'title' => 'Updated Title',
            'description' => 'This is an updated description',
            '_method' => 'patch'
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
            'message' => 'Todo updated successfully',
        ]);

        $this->assertNotEquals($todo->title, 'Updated Title');
        $this->assertNotEquals($todo->description, 'This is an updated description');

        $this->assertDatabaseHas('todos', [
            'title' => 'Updated Title',
            'description' => 'This is an updated description'
        ]);
    }

    public function test_delete()
    {
        $todo = Todo::first();

        $response = $this->post(route('todo.delete', $todo), [
            '_method' => 'delete'
        ]);

        $response->assertJson([
            'success' => true,
            'message' => 'Todo deleted successfully',
        ]);

        $this->assertDatabaseMissing('todos', [
            'title' => $todo->title,
            'description' => $todo->description
        ]);
    }

}
