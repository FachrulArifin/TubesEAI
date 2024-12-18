<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Jumbotron example · Bootstrap v5.0</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/jumbotron/">

    

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>

    
  </head>
  <body>
    <main>
      <div class="container py-4">
        <header class="pb-3 mb-4 border-bottom">
          <a href="/admin/dashboard" class="d-flex align-items-center text-dark text-decoration-none">
            <span class="fs-4">Halaman Tambah Produk</span>
          </a>
        </header>
    
        <div class="p-5 mb-4 bg-light rounded-3">
          <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
    
            <form action="{{ route('admin.addProduct') }}" method="POST" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                  <label for="name" class="form-label">Nama Produk</label>
                  <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="Enter Name" required>
              </div>
              <div class="mb-3">
                  <label for="deskripsi" class="form-label">Deskripsi Produk</label>
                  <input type="text" name="description" class="form-control form-control-lg" id="description" placeholder="Enter Product Name" required>
              </div>
              <div class="mb-3">
                  <label for="price" class="form-label">Harga Produk</label>
                  <input type="number" name="price" class="form-control form-control-lg" id="price" placeholder="Enter harga" required>
              </div>
              <div class="mb-3">
                  <label for="stock" class="form-label">Stok Produk</label>
                  <input type="number" name="stock" class="form-control form-control-lg" id="stock" placeholder="Enter stok" required>
              </div>
              <div class="mb-4">
                  <label for="image" class="form-label">Input Gambar</label>
                  <input type="file" name="image" class="form-control form-control-lg" id="image" placeholder="Enter image" required>
              </div>
              @error('image')
                <p style="color: red;">{{ $message }}</p>
              @enderror
              <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Tambah Produk</button>
            </form>
          </div>
        </div>
    
        <div class="row align-items-md-stretch">
          <div class="col-md-12">
            <div class="h-100 p-5 bg-light border rounded-3">
              <table class="table table-striped table-sm" id="productTable">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Stok</th>
                    <th scope="col">Deskripsi</th>
                    <th scope="col">Gambar</th>
                    <th scope="col">Aksi</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
          <div class="modal-dialog">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="editModalLabel">Edit Produk</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="editForm">
                          @csrf
                          @method('PUT')
                          <input type="hidden" id="editId">
                          <div class="mb-3">
                              <label for="editName" class="form-label">Nama Produk</label>
                              <input type="text" id="editName" name="name" class="form-control" required>
                          </div>
                          <div class="mb-3">
                              <label for="editDescription" class="form-label">Deskripsi Produk</label>
                              <input type="text" id="editDescription" name="description" class="form-control" required>
                          </div>
                          <div class="mb-3">
                              <label for="editPrice" class="form-label">Harga Produk</label>
                              <input type="number" id="editPrice" name="price" class="form-control" required>
                          </div>
                          <div class="mb-3">
                              <label for="editStock" class="form-label">Stok Produk</label>
                              <input type="number" id="editStock" name="stock" class="form-control" required>
                          </div>
                          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </form>
                  </div>
              </div>
          </div>
        </div>
    
        <footer class="pt-3 mt-4 text-muted border-top">
          &copy; 2021
        </footer>
      </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  
    <!-- AJAX Script -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
      $(document).ready(function () {
        // Fungsi untuk mengambil data produk
        function fetchProducts() {
          $.ajax({
            url: "{{ route('admin.getProducts') }}",
            method: "GET",
            success: function (data) {
              let productTable = $('#productTable tbody');
              productTable.empty(); // Kosongkan tabel sebelum mengisi ulang
  
              data.forEach((product, index) => {
                productTable.append(`
                    <tr>
                      <td>${index + 1}</td>
                      <td>${product.name}</td>
                      <td>${product.price}</td>
                      <td>${product.stock}</td>
                      <td>${product.description}</td>
                      <td><img src="/storage/${product.file_path}" alt="${product.name}" width="50"></td>
                      <td>
                        <button class="btn btn-warning btn-sm edit-btn" data-id="${product.id}">Edit</button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${product.id}">Delete</button>
                      </td>
                    </tr>
                `);
              });
            }, error: function () {
              alert('Gagal memuat produk.');
            }
          });
        }
  
        // Panggil fetchProducts saat halaman dimuat
        fetchProducts();
  
        // Tangani form submit untuk menambahkan produk
        $('#productForm').on('submit', function (e) {
          e.preventDefault(); // Mencegah reload halaman
  
          let formData = new FormData(this);
          $.ajax({
            url: "{{ route('admin.addProduct') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
              // Notifikasi berhasil
              alert('Produk berhasil ditambahkan!');
  
              // Reset form
              $('#productForm')[0].reset();
  
              // Ambil data produk terbaru
              fetchProducts();
            },
            error: function (xhr) {
              alert('Gagal menambahkan produk.');
            }
          });
        });
      });
      
      //Menghapus produk di list sesuai ID
      $(document).on('click', '.delete-btn', function () {
        let productId = $(this).data('id');

        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
          $.ajax({
            url: `/admin/addProducts/${productId}`,
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
              fetchProducts(); // Refresh tabel
              alert(response.message);
            },
            error: function (xhr) {
              alert('Gagal menghapus produk.');
            }
          });
        }
      });

      $(document).on('click', '.edit-btn', function () {
        let productId = $(this).data('id');

        // Dapatkan data produk dan isi modal
        $.ajax({
          url: `/admin/addProducts/${productId}`,
          method: 'GET',
          success: function (product) {
            $('#editId').val(product.id);
            $('#editName').val(product.name);
            $('#editDescription').val(product.description);
            $('#editPrice').val(product.price);
            $('#editStock').val(product.stock);
  
            $('#editModal').modal('show'); // Tampilkan modal
          }
        });
      });

      // Tangani submit form edit
      $('#editForm').on('submit', function (e) {
        e.preventDefault();

        let productId = $('#editId').val();
        let formData = $(this).serialize();

        $.ajax({
          url: `/admin/addProducts/${productId}`,
          method: 'PUT',
          data: formData,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            alert(response.message);
            $('#editModal').modal('hide'); // Tutup modal
            fetchProducts(); // Refresh tabel
          },
          error: function () {
            alert('Gagal memperbarui produk.');
          }
        });
      });

    </script>
  </body>
</html>
