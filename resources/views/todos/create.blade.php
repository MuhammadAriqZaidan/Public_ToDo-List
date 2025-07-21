<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Tambah To-Do</title>
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

        .create-container {
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
            margin-bottom: 2rem;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        label {
            display: block;
            margin-bottom: 1rem;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="date"] {
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

        /* Tambahan untuk error messages */
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
    <script src="https://widget.cloudinary.com/v2.0/global/all.js" type="text/javascript"></script>

</head>

<body>
    <div class="create-container">
        <h2>➕ Tambah To-Do Baru</h2>

        @if ($errors->any())
            <div>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="/todos">
            @csrf

            <label>
                Judul:
                <input type="text" name="title" required>
            </label>

            <label>
                Deskripsi:
                <input type="text" name="description">
            </label>

            <label>
                Deadline:
                <input type="date" name="due_date">
            </label>

            {{-- input cloudinary --}}
            <label>
                Lampiran (Opsional):
                <button type="button" id="upload_widget" class="button">Upload File</button>
                <br>
                <strong id="uploaded_filename" style="color: green;"></strong> <!-- Tambahan ini -->
                <br>
                <span>Pastikan file tidak lebih dari 20 MB, dan berformat .jpg, .jpeg, .png, .webp</span>

            </label>

            <input type="hidden" name="attachment_url" id="attachment_url">
            <input type="hidden" name="attachment_public_id" id="attachment_public_id">

            <button type="submit" class="button">Tambah</button>
        </form>

        <a href="/todos" class="back-link">← Kembali ke daftar</a>
    </div>
</body>

<script type="text/javascript">
    var myWidget = cloudinary.createUploadWidget({
        cloudName: 'dkixchlli',
        uploadPreset: 'TodosPublicNew',
        resourceType: 'auto',
        maxFileSize: 20000000,
        contentType: true
    }, (error, result) => {
        if (!error && result && result.event === "success") {
            console.log('File berhasil diupload ke Cloudinary:', result.info);
            document.getElementById('attachment_url').value = result.info.secure_url;
            document.getElementById('attachment_public_id').value = result.info.public_id;
            document.getElementById('uploaded_filename').innerText = "File berhasil diupload: " + result.info
                .original_filename;
        }
    });

    document.getElementById("upload_widget").addEventListener("click", function() {
        myWidget.open();
    }, false);
</script>



</html>
