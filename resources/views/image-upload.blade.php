<!DOCTYPE html>
<html>
<head>
    <title>Laravel Image Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="p-5">

    <div class="container">
        <h2>Test Image Upload</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            <img src="{{ asset('storage/' . session('path')) }}" class="img-thumbnail mt-2" style="max-width: 300px;">
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mt-2">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data" class="mt-3">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Choose Image</label>
                <input class="form-control" type="file" name="image" id="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

</body>
</html>
