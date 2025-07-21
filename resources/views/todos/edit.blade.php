<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Edit To-Do</title>
    <style>
        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            padding: 2rem;

            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            flex-direction: column;
        }

        .edit-container {
            background-color: #fffbe6;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            margin-bottom: 1.5rem;
            color: #444;
            font-size: 1.75rem;
        }

        form {
            background-color: #fffbe6;
            padding: 1.5rem;
            border-radius: 8px;
            max-width: 500px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
        }

        label {
            display: block;
            margin-bottom: 1.25rem;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"],
        select {
            width: 100%;
            padding: 0.75rem;
            margin-top: 0.25rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }


        .button {
            padding: 0.6rem 1.2rem;
            background-color: #f5e663;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            color: #333;
            font-size: 1rem;
            margin-top: 1rem;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #e4d94e;
        }

        .back-link {
            display: inline-block;
            margin-top: 1rem;
            text-decoration: none;
            color: #444;
            font-size: 0.95rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error-list {
            color: red;
            margin-bottom: 1rem;
            background: #ffe0e0;
            padding: 0.75rem;
            border-radius: 6px;
            list-style: square inside;
        }

        span {
            color: red;
            size: 5px;
        }



        @media (max-width: 600px) {
            body {
                padding: 1rem;
            }

            form {
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="edit-container">
        <h2>✏️ Edit To-Do</h2>

        @if ($errors->any())
            <div>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('todos.update', $todo->id) }}">
            @csrf
            @method('PUT')

            <label for="title">Judul:</label>
            <input type="text" id="title" name="title" value="{{ old('title', $todo->title) }}" required>
            @error('title')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <label for="description">Deskripsi:</label>
            <input type="text" id="description" name="description"
                value="{{ old('description', $todo->description) }}">
            @error('description')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <label for="is_done">Status:</label>
            <select id="is_done" name="is_done">
                <option value="0" {{ old('is_done', $todo->is_done) == 0 ? 'selected' : '' }}>Not Completed
                </option>
                <option value="1" {{ old('is_done', $todo->is_done) == 1 ? 'selected' : '' }}>Completed</option>
            </select>
            @error('is_done')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <label>Lampiran:</label>
            <button type="button" id="upload_widget" class="button">Upload Lampiran (Cloudinary)</button>

            <input type="hidden" name="attachment_url" id="attachment_url"
                value="{{ old('attachment_url', $todo->attachment) }}">
            <input type="hidden" name="attachment_public_id" id="attachment_public_id"
                value="{{ old('attachment_public_id', $todo->attachment_public_id) }}">

            @error('attachment_url')
                <div class="error-text">{{ $message }}</div>
            @enderror

            @if ($todo->attachment)
                <p>Lampiran saat ini:</p>
                <a href="{{ $todo->attachment }}" target="_blank">{{ basename($todo->attachment) }}</a>
                @if (Str::endsWith($todo->attachment, ['jpg', 'jpeg', 'png', 'webp']))
                    <br><img src="{{ $todo->attachment }}" alt="Lampiran" style="max-width:200px; margin-top:10px;">
                @endif
            @endif

            <button type="submit" class="button">Update</button>
        </form>


        <a href="/todos" class="back-link">← Kembali ke daftar</a>
    </div>

    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>
    <script type="text/javascript">
        var myWidget = cloudinary.createUploadWidget({
            cloudName: 'dkixchlli', // Ganti sesuai cloud kamu
            uploadPreset: 'TodosPublicNew' // Preset yang kamu atur di Cloudinary
        }, (error, result) => {
            if (!error && result && result.event === "success") {
                console.log('File berhasil diupload ke Cloudinary:', result.info);
                document.getElementById('attachment_url').value = result.info.secure_url;
            }
        });

        document.getElementById("upload_widget").addEventListener("click", function() {
            myWidget.open();
        }, false);
    </script>


</body>

</html>
