<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>To-Do List Bersama</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 2rem;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .header h2 {
            margin: 0;
            color: #444;
        }

        .header .actions {
            display: flex;
            gap: 0.75rem;
        }

        .button {
            padding: 0.5rem 1rem;
            background-color: #FFD60A;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            text-decoration: none;
            color: #333;
            transition: background-color 0.3s ease;
            text-align: center;
        }

        .button:hover {
            background-color: #e4d94e;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 12px 16px;
            border-bottom: 1px solid #eee;
            text-align: left;
        }

        th {
            background-color: #9ca3af;
        }

        thead th {
            border-bottom: 2px solid #737373;
            background-color: #9ca3af
        }

        .done {
            color: green;
            font-weight: bold;
        }

        .not-done {
            color: red;
            font-style: italic;
        }

        form {
            display: inline;
        }

        .todo-actions {
            display: flex;
            flex-direction: row;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .todo-actions a,
        .todo-actions button {
            margin-right: 0.5rem;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
            accent-color: #e2b300;
            /* kuning kalem */
            cursor: pointer;
            margin-right: 5px;
            transform: scale(1.5);
        }

        select {
            padding: 6px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: #fffdf0;
            color: #333;
            font-size: 14px;
        }

        select:focus {
            border-color: #b28900;
            outline: none;
        }

        .filter {
            padding: 6px 10px;
        }

        .actions {
            padding-bottom: 6px;
        }

        .snackbar {
            visibility: visible;
            min-width: 250px;
            margin: auto;
            background-color: #28a745;
            /* hijau */
            color: #fff;
            text-align: center;
            border-radius: 8px;
            padding: 12px;
            position: fixed;
            z-index: 999;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            animation: fadeOut 4s forwards;
        }

        @keyframes fadeOut {
            0% {
                opacity: 1;
            }

            80% {
                opacity: 1;
            }

            100% {
                opacity: 0;
                visibility: hidden;
            }
        }

        .pagination {
            margin-top: 20px;
            text-align: center;
        }

        .pagination svg {
            width: 24px;
            height: 24px;
        }

        .pagination a,
        .pagination span {
            margin: 0 6px;
            text-decoration: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            color: #333;
        }

        .pagination .active {
            background-color: #007bff;
            color: #fff;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding: 10px;
            color: #0a3d62;
            font-size: 14px;
        }

        .footer-link {
            color: #0a3d62;
            text-decoration: none;
            font-weight: bold;
        }

        @media (max-width: 768px) {

            th,
            td {
                padding: 8px;
                /* Reduced padding */
                font-size: 14px;
                /* Adjust font size */
            }

            .actions a,
            .actions form {
                width: 100%;
                /* Full width buttons */
                display: block;
            }

            td {
                word-break: break-word;
                /* Allows long words to break */
                padding: 12px 8px;
                /* Adjusted padding */
            }

            tr {
                display: flex;
                flex-direction: column;
                /* Ensure items within are vertically stacked */
            }

            thead {
                display: none;
            }

            tr {
                display: flex;
                flex-direction: column;
                background-color: #fff8dc;
                margin-bottom: 1rem;
                padding: 1rem;
                border-radius: 10px;
                box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1);
            }

            td {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                padding: 6px 0;
                border: none;
                word-break: break-word;
            }

            td::before {
                content: attr(data-label);
                font-weight: bold;
                color: #666;
                margin-right: 10px;
                flex: 1;
                min-width: 100px;
            }

            .todo-actions {
                flex-direction: column;
                gap: 0.5rem;
                margin-top: 1rem;
            }

            .todo-actions a,
            .todo-actions button,
            .todo-actions form {
                width: 100%;
                margin-right: 0;
            }

            .deskripsi {
                border: none;
                word-break: break-word;
            }
        }

        * {
            box-sizing: border-box;
            /* Ensure box sizing includes padding and border */
        }
    </style>
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
                            <a href="{{ $todo->attachment }}" target="_blank" title="{{ basename($todo->attachment) }}">
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
                        <a href="/todos/{{ $todo->id }}/edit" class="button">✏️
                            Edit</a>
                        <br>
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

<footer class="footer">
    Powered by <a href="https://cloudinary.com" target="_blank" class="footer-link">Cloudinary</a>
</footer>


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

    document.querySelectorAll('td[data-label="Deadline"]').forEach(td => {
        const deadline = new Date(td.textContent.trim());
        const today = new Date();
        if (deadline < today && !isNaN(deadline)) {
            td.style.color = '#d90429';
            td.style.fontWeight = 'bold';
        }
    });
</script>


@if (session('success'))
    <div id="snackbar" class="snackbar">{{ session('success') }}</div>
@endif

</html>
