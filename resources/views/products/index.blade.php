<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Products' }} | Laravel 12</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-secondary-subtle">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div>
                    <h3 class="text-center my-4">Laravel Apps</h3>
                    <h5 class="text-center">By. Wahyu Fajar Setiawan</h4>
                        <hr>
                </div>
                @if (request('search'))
                    <div class="alert alert-info my-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Hasil pencarian untuk: <strong>"{{ request('search') }}"</strong></span>
                            <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-dark">Reset
                                Pencarian</a>
                        </div>
                    </div>
                @endif
                <div class="card-border-0 shadow-sm rounded">
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div>
                                        <a href="{{ route('products.create') }}" class="btn btn-md btn-success">Tambah
                                            Data</a>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">Data Produk</h5>
                                    </div>
                                    <div>
                                        <form action="{{ route('products.index') }}" method="GET" class="d-flex">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari Produk" value="{{ request('search') }}">
                                        </form>
                                    </div>
                                </div>
                                @if ($products->count() > 0)
                                    <tr>
                                        <th colspan="6" class="text-center">Total Data : {{ $products->total() }}
                                        </th>
                                    </tr>
                                @endif
                                <tr class="text-center">
                                    <th scope="col">No</th>
                                    <th scope="col">Gambar</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Stok</th>
                                    <th scope="col" style="width: 20%;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td><img src="{{ asset('images/' . $product->image) }}" alt=""
                                                width="100px" class="rounded"></td>
                                        <td>{{ $product->title }}</td>
                                        <td>{{ 'Rp. ' . number_format($product->price, 2, ',', '.') }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-primary detail-btn"
                                                data-id="{{ $product->id }}">Detail</button>

                                            <button class="btn btn-sm btn-danger delete-btn"
                                                data-id="{{ $product->id }}">Hapus</button>

                                            <a href="{{ route('products.edit', $product->id) }}"
                                                class="btn btn-sm btn-warning">Edit</a>

                                            <form id="delete-form-{{ $product->id }}"
                                                action="{{ route('products.destroy', $product->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            <div class="alert alert-danger text-center" role="alert">
                                                Data Produk Kosong
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('delete-form-' + id).submit();
                    }
                });
            });
        });

        // Detail confirmation
        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Detail Produk',
                    html: '<div id="detail-content"></div>',
                    showCloseButton: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        fetch('/products/' + id)
                            .then(response => response.json())
                            .then(data => {
                                const detailContent = `
                                    <img src="/images/${data.image}" alt="" width="300px" class="rounded mb-2">
                                    <h5>${data.title}</h5>
                                    <p><strong>Harga:</strong> Rp. ${data.price.toLocaleString()}</p>
                                    <p><strong>Stok:</strong> ${data.stock}</p>
                                    <p>${data.description}</p>
                                `;
                                document.getElementById('detail-content').innerHTML =
                                    detailContent;
                            });
                    }
                });
            });
        });

        // Session messages
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @elseif (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>

</body>

</html>
