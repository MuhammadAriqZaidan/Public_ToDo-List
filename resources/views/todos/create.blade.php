<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/x-icon" href="{{ asset('ikon_todos.ico') }}">
    <title>Tambah To-Do</title>
    <link rel="stylesheet" href="{{ asset('css/create.css') }}">
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
