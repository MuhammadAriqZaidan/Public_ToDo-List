<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Api\Admin\AdminApi;

class TodoWebController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('status');

        $query = Todo::with('user');

        if ($filter === 'done') {
            $query->where('is_done', true);
        } elseif ($filter === 'not_done') {
            $query->where('is_done', false);
        }

        $todos = $query->latest()->get();

        return view('todos.index', compact('todos', 'filter'));
    }


    public function create()
    {
        return view('todos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'attachment_url' => 'nullable|url|max:10000',
            'attachment_public_id' => 'nullable|string',
        ]);

        Todo::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'attachment' => $request->attachment_url,
            'attachment_public_id' => $request->attachment_public_id,
            'is_done' => false,
        ]);

        return redirect('/todos')->with('success', 'To-Do berhasil ditambahkan!');
    }


    public function edit($id)
    {
        $todo = Todo::findOrFail($id);
        return view('todos.edit', compact('todo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'is_done' => 'boolean',
            'attachment_url' => 'nullable|url|max:10000',
            'attachment_public_id' => 'nullable|string',
        ]);

        $todo = Todo::findOrFail($id);

        // Hapus attachment lama dari Cloudinary jika ada attachment baru
        if ($request->attachment_url && $request->attachment_url !== $todo->attachment) {
            if ($todo->attachment_public_id) {
                try {
                    (new UploadApi())->destroy($todo->attachment_public_id);
                } catch (\Exception $e) {
                    Log::warning("Gagal hapus file lama dari Cloudinary: " . $e->getMessage());
                }
            }

            $todo->attachment = $request->attachment_url;
            $todo->attachment_public_id = $request->attachment_public_id;
        }

        $todo->title = $request->title;
        $todo->description = $request->description;
        $todo->due_date = $request->due_date;
        $todo->is_done = $request->is_done ?? false;
        $todo->save();

        return redirect('/todos')->with('success', 'To-Do berhasil diperbarui!');
    }


    public function toggleStatus($id)
    {
        $todo = Todo::findOrFail($id);
        $todo->is_done = !$todo->is_done;
        $todo->save();

        return redirect('/todos');
    }

    public function destroy($id)
    {
        $todo = Todo::findOrFail($id);

        if ($todo->attachment_public_id) {
            try {
                (new UploadApi())->destroy($todo->attachment_public_id);
            } catch (\Exception $e) {
                Log::warning("Gagal hapus file dari Cloudinary: " . $e->getMessage());
            }
        }

        $todo->delete();

        return redirect('/todos')->with('success', 'To-Do berhasil dihapus!');
    }
}
