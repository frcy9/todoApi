<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Psy\debug;
use Symfony\Component\Routing\Annotation\Route;

use App\Http\Models\Todo;


class TodoController extends Controller
{
    public $todo;
    public function __construct()
    {
        parent::__construct();
        $this->todo = new Todo();
    }

    public function list()
    {
        $perPage = request()->limit;
        $currentPage = request()->page;
        $pageName = 'page';
        $columns = ['*'];

        $todoList = $this->todo->getTodoList($perPage, $currentPage, $pageName, $columns);
        if (isset($todoList)) {
            return $this->Success($todoList);
        } else {
            return $this->fail('220');
        }
    }




    public function todoAdd()
    {
        $name = request()->name;
        $content = request()->todoContent;
        $create_time = date('Y-m-d H:i:s', time());

        $newTodo = $this->todo->todoAdd($name, $content, $create_time);
        if (isset($newTodo)) {
            return $this->Success($newTodo);
        } else {
            return $this->fail('220');
        }
    }

    public function todoUpdate()
    {
        $id = request()->id;
        $name = request()->name;
        $content = request()->todoContent;

        $todo = $this->todo->todoUpdate($id, $name, $content);
        if (isset($todo)) {
            return $this->Success($todo);
        } else {
            return $this->fail('220');
        }
    }

    public function todoDelete()
    {
        $id = request()->id;
        $isTodo = $this->todo->todoDelete($id);
        if (isset($isTodo)) {
            return $this->Success($isTodo);
        } else {
            return $this->fail('220');
        }
    }

}
