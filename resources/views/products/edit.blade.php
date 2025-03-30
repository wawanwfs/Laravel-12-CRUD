<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Edit Product' }} | Laravel 12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* tambahkan bintang merah pada input yang memiliki required */
        .form-group:has([required]) label:after {
            content: "*";
            color: red;
            margin-left: 5px;
        }
    </style>
</head>

<body class="bg-secondary-subtle">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card-border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('products.update', $product) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group  mb-3">
                                <label class="font-weight-bold">Judul</label>
                                <input type="text" name="title" id=""
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Judul Produk"
                                    value="{{ old('title', $product->title) }}" required>
                                @error('title')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Harga</label>
                                <input type="number" name="price" id=""
                                    class="form-control @error('price') is-invalid @enderror" placeholder="Harga Produk"
                                    value="{{ old('price', $product->price) }}" required>
                                @error('price')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Stok</label>
                                <input type="number" name="stock" id=""
                                    class="form-control @error('stock') is-invalid @enderror" placeholder="Stok Produk"
                                    value="{{ old('stock', $product->stock) }}" required>
                                @error('stock')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Deskripsi</label>
                                <textarea name="description" id="" cols="30" rows="5"
                                    class="form-control @error('description') is-invalid @enderror" placeholder="Deskripsi Produk" required>{{ old('description', $product->description) }}</textarea>
                                @error('description')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="font-weight-bold">Gambar Saat Ini</label>
                                @if ($product->image)
                                    <div class="border rounded p-2 mb-3">
                                        <img src="{{ '/images/' . $product->image }}" alt="{{ $product->title }}"
                                            class="img-fluid" style="max-height: 200px;">
                                    </div>
                                @else
                                    <p>Tidak ada gambar</p>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Upload Gambar Baru</label>
                                <input type="file" name="image" id=""
                                    class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                                @error('image')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div id="image-preview-container" style="display: none;">
                                <label class="font-weight-bold">Preview Gambar</label>
                                <div class="border rounded p-2">
                                    <img id="image-preview" src="#" alt="Preview" class="img-fluid"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <div class="form-group mt-4 d-flex gap-2">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        // Suppress security warning by hiding notifications with CSS
        var style = document.createElement('style');
        style.innerHTML = '.cke_notifications_area { display: none !important; }';
        document.head.appendChild(style);

        // Additional cleanup for any notifications that might appear
        document.addEventListener('DOMContentLoaded', function() {
            setInterval(function() {
                document.querySelectorAll('.cke_notification, .cke_notifications_area').forEach(function(
                    el) {
                    if (el.innerHTML.includes('not secure') || el.innerHTML.includes('upgrading')) {
                        el.remove();
                    }
                });
            }, 100);
        });
    </script>
    <script>
        CKEDITOR.replace('description');
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.querySelector('input[name="image"]');
            const previewContainer = document.getElementById('image-preview-container');
            const previewImage = document.getElementById('image-preview');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        previewContainer.style.display = 'block';
                    }

                    reader.readAsDataURL(this.files[0]);
                } else {
                    previewContainer.style.display = 'none';
                    previewImage.src = '#';
                }
            });
        });
    </script>
</body>

</html>
