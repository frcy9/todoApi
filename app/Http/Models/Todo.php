<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Todo extends Model
{
    protected $fillable = [
        'id',
        'name',
        'content',
        'create_time'
    ];


    public function getTodoList($perPage, $currentPage, $pageName, $columns)
    {
        return DB::table('todoList')
            ->orderBy('id', 'desc')
            ->paginate($perPage, $columns, $pageName, $currentPage);
    }

    public function todoAdd($name, $content, $create_time)
    {
        $id = DB::table('todoList')->insertGetId(
            [
                'name' => $name,
                'content' => $content,
                'create_time' => $create_time,
            ]
        );
        if (empty($id)) {
            return $this->fail('220');
        }
        return DB::table('todoList')->where('id', $id)->first();
    }

    public function todoUpdate($id,  $name, $content)
    {
        DB::table('todoList')
            ->where('id', $id)
            ->update([
                    'name' => $name,
                    'content' => $content,
                ]
            );
        return DB::table('todoList')->where('id', $id)->first();
    }

    public function todoDelete($id)
    {
        return DB::table('todoList')
            ->where('id', $id)
            ->delete();
    }
}
