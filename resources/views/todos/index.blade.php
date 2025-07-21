<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>To-Do List Bersama</title>
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>


<body>
    <div class="header">
        <h2>📝 To-Do List Bersama</h2>
        <div class="actions">
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="button">🚪 Logout</button>
            </form>
        </div>
    </div>




    <p>Halo, <strong>{{ auth()->user()->name }}</strong>!</p>

    <div class="actions">
        <a href="/todos/create" class="button">➕ Tambah To-Do</a>


        <form method="GET" action="/todos" class="filter">
            <label for="status">Filter:</label>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="" {{ $filter === null ? 'selected' : '' }}>Semua</option>
                <option value="done" {{ $filter === 'done' ? 'selected' : '' }}>Selesai</option>
                <option value="not_done" {{ $filter === 'not_done' ? 'selected' : '' }}>Belum Selesai</option>
            </select>
        </form>
    </div>

    {{-- @foreach ($todos as $todo) --}}

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Judul</th>
                <th>Deskripsi</th>
                <th>Lampiran</th>
                <th>Pembuat</th>
                <th>Status</th>
                <th>Deadline</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($todos as $todo)
                <tr>
                    <td data-label="#"> {{ $loop->iteration }}</td>
                    <td data-label="Judul">{{ $todo->title }}</td>
                    <td data-label="Deskripsi">
                        {{ $todo->description ? Str::limit($todo->description, 100) : '-' }}
                    </td>
                    {{-- <td data-label="Lampiran">
                        @if ($todo->attachment)
                            @if (Str::startsWith($todo->attachment, ['http://', 'https://']))
                                <a href="{{ $todo->attachment }}" target="_blank">📎 Lihat</a>
                            @elseif ($todo->attachment && Str::endsWith($todo->attachment, ['jpg', 'jpeg', 'png', 'webp']))
                                <br>
                                <img src="{{ $todo->attachment }}" alt="Lampiran"
                                    style="max-width:100px; margin-top:4px;">
                            @endif
                        @else
                            -
                        @endif
                    </td> --}}
                    <td data-label="Lampiran">
                        @if ($todo->attachment)
                            <a href="{{ $todo->attachment }}" target="_blank"
                                title="{{ basename($todo->attachment) }}">
                                📎 Lihat Lampiran
                            </a>

                            @if (Str::endsWith($todo->attachment, ['jpg', 'jpeg', 'png', 'webp']))
                                <br>
                                <img src="{{ $todo->attachment }}" alt="Lampiran"
                                    style="max-width:100px; margin-top:4px;">
                            @endif
                        @else
                            -
                        @endif
                    </td>


                    <td data-label="Pembuat" class="user-name">{{ $todo->user->name }}</td>
                    <td data-label="Status">
                        <form action="/todos/{{ $todo->id }}/toggle" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <label>
                                <input type="checkbox" onchange="this.form.submit()"
                                    {{ $todo->is_done ? 'checked' : '' }}>
                                {{ $todo->is_done ? '✔ Selesai' : '⏳ Belum' }}
                            </label>
                        </form>
                    </td>
                    <td data-label="Deadline">
                        {{ $todo->due_date ? \Carbon\Carbon::parse($todo->due_date)->translatedFormat('d F Y') : '-' }}
                    </td>

                    <td class="todo-actions">
                        <a href="/todos/{{ $todo->id }}/edit" class="button" style="background-color:#ffe08a;">✏️
                            Edit</a>
                        <form action="/todos/{{ $todo->id }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="button" style="background-color:#fa6f6f;">🗑️ Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Belum ada to-do.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- @endforeach --}}

    {{-- <div class="pagination">{{ $todos->links() }}</div> --}}

</body>

<script>
    // Fungsi hashing sederhana → hasilkan angka dari string
    function hashStringToColor(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        // Konversi ke kode warna hex
        let color = '#';
        for (let i = 0; i < 3; i++) {
            const value = (hash >> (i * 8)) & 0xFF;
            color += ('00' + value.toString(16)).slice(-2);
        }
        return color;
    }

    // Cari semua elemen nama user
    document.querySelectorAll('.user-name').forEach(el => {
        const name = el.textContent.trim();
        const color = hashStringToColor(name);
        el.style.color = color;
        el.style.fontWeight = 'bold';
    });
</script>


@if (session('success'))
    <div id="snackbar" class="snackbar">{{ session('success') }}</div>
@endif

</html>
