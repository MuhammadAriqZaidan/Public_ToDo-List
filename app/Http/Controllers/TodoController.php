<?php

namespace App\Http\Controllers;

// app/Http/Controllers/TodoController.php

// app/Http/Controllers/TodoController.php

use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::with('user')->latest()->get();
        return response()->json($todos);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date'
        ]);

        $todo = Todo::create([
            'user_id' => $request->user()->id,
            // 'user_id' => Auth::user()->id,
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return response()->json($todo);
    }

    public function update(Request $request, $id)
{
    $todo = Todo::findOrFail($id);

    // Cek apakah user pemiliknya
    if ($todo->user_id !== $request->user()->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $todo->update($request->only(['title', 'description', 'is_done', 'due_date']));
    return response()->json($todo);
}

public function destroy(Request $request, $id)
{
    $todo = Todo::findOrFail($id);

    if ($todo->user_id !== $request->user()->id) {
        return response()->json(['message' => 'Unauthorized'], 403);
    }

    $todo->delete();
    return response()->json(['message' => 'Deleted']);
}

}   
