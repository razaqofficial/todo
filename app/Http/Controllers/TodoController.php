<?php

namespace App\Http\Controllers;

use App\Http\Requests\Todo\CreateRequest;
use App\Http\Requests\Todo\UpdateRequest;
use App\Models\Todo;
use Illuminate\Database\ConnectionInterface as DB;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    private DB $db;
    private Todo $todo;

    /**
     * TodoController constructor.
     *
     * @param DB $db
     * @param Todo $todo
     *
     */
    public function __construct(DB $db, Todo $todo)
    {
        $this->db = $db;
        $this->todo = $todo;
    }

    /**
     * Get all the todos.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $todos = $this->todo->all();

        return ResponseBuilder::asSuccess()
            ->withHttpCode(Response::HTTP_OK)
            ->withMessage('Todo List')
            ->withData(['todos' => $todos])
            ->build();
    }

    /**
     * Show a specific to do.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function show(Todo $todo)
    {
        return ResponseBuilder::asSuccess()
            ->withHttpCode(Response::HTTP_OK)
            ->withMessage('Todo Details')
            ->withData(['todo' => $todo])
            ->build();
    }

    /**
     * Create a to do.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(CreateRequest $request)
    {
        $this->db->beginTransaction();

        $todo = new $this->todo();
        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();

        $this->db->commit();

        return ResponseBuilder::asSuccess()
        ->withHttpCode(Response::HTTP_OK)
        ->withMessage('Todo created successfully')
        ->withData(['todo' => $todo])
        ->build();
    }

    /**
     * Update an existing to do.
     *
     * @param UpdateRequest $request
     * @param Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(UpdateRequest $request, Todo $todo)
    {
        $this->db->beginTransaction();

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->save();

        $this->db->commit();

        return ResponseBuilder::asSuccess()
            ->withHttpCode(Response::HTTP_OK)
            ->withMessage('Todo updated successfully')
            ->withData(['todo' => $todo])
            ->build();
    }

    /**
     * Delete a to do.
     *
     * @param Todo $todo
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Todo $todo)
    {
        $this->db->beginTransaction();

        $todo->delete();

        $this->db->commit();

        return ResponseBuilder::asSuccess()
            ->withHttpCode(Response::HTTP_OK)
            ->withMessage('Todo deleted successfully')
            ->build();
    }

}
