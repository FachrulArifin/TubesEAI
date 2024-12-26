
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Durian Runtuh</title>

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Favicons -->
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

  <header>
  <nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand"><strong>Durian Runtuh</strong></a>
      <div class="d-flax m-2">   
        <form action="" method="POST" style="display: inline;">
          @csrf
          <button type="button" class="btn btn-outline-primary" data-bs-target="#exampleModal" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          </button>
        </form>
        <form action="{{ url()->secure(route('logout', [], false)) }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-outline-primary">Logout</button>
        </form>
      </div>
    </div>
  </nav>
    
  </header>

  <main>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Keranjang Belanja</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form action="{{ url()->secure(route('user.viewCheckout', [], false)) }}" method="post">
            @csrf
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col">harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                        <tr>
                            <th scope="row">
                                <!-- Set name sebagai array dan value dengan ID item -->
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox" data-id="{{ $item->id }}">
                            </th>
                            <td>
                                <img src="{{ asset('storage/' . $item->file_path) }}" width="50" alt="{{ $item->product_name }}">
                            </td>
                            <td>
                                <!-- Nama yang ditampilkan -->
                                {{ $item->name }}
                                <!-- Input hidden untuk nama -->
                                <input type="hidden" name="names[{{ $item->id }}]" value="{{ $item->name }}" class="name-input" data-id="{{ $item->id }}" disabled>
                            </td>
                            <td>
                                <!-- Nama input untuk quantity terkait item -->
                                <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->pivot->quantity }}" class="quantity-input" data-id="{{ $item->id }}" style="width: 3rem;" disabled>
                            </td>
                            <td>
                                <!-- Input untuk price -->
                                <input type="hidden" name="prices[{{ $item->id }}]" value="{{ $item->price }}" class="price-input" data-id="{{ $item->id }}" disabled>
                                {{ money($item->price * $item->pivot->quantity, 'IDR', true) }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                <button type="submit" class="btn btn-primary">Checkout</button>
            </div>
        </form>
        </div>
      </div>
    </div>

    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Durian Runtuh</h1>
          <p class="lead text-muted">merupakan platform pembelian durian secara online dan memiliki berbagai jenis durian.</p>
          <div class="container">
            <form action="{{ url()->secure(route('products.search', [], false)) }}" method="POST" class="mb-4">
              @csrf
              <div class="input-group">
                <input type="text" name="query" class="form-control" placeholder="Cari produk..." value="{{ old('query') }}">
                <button type="submit" class="btn btn-primary">Cari</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-light">
      <!-- start Container -->
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">
          @foreach($data as $item)
            <div class="col">

              <!-- Card Start -->
              <form action="{{ url()->secure(route('addToCard', [], false)) }}" method="post">
                  @csrf
                  <div class="card mb-3 h-100" style="width: 18rem;">
                      <img src="{{ asset('storage/' . $item->file_path) }}" class="card-img-top" alt="Durian" style="height: 200px;">
                      <div class="card-body">
                          <h5 class="card-title">{{ $item->name }}</h5>
                          <p class="card-text">{{ $item->description }}</p>
                      </div>
                      <div class="card-footer mt-auto d-flex justify-content-between">
                          <input type="hidden" name="product_id" value="{{ $item->id }}">
                          <input type="hidden" name="product_name" value="{{ $item->name }}">
                          <input type="hidden" name="product_img" value="{{ $item->file_path }}">
                          <input type="number" name="product_qty" value="1" min="1" class="form-control" style="width: 4rem;">
                          <button class="btn btn-primary add-to-cart">Tambah</button>
                          <p class="card-text mb-0"><small class="text-muted"> {{ money($item->price, 'IDR', true) }}</small></p> 
                      </div>              
                  </div>
              </form>
              <!-- End Card -->

            </div>
          @endforeach
        </div>
      </div>
      <!-- End Container -->
    </div>


  </main>

  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <script>
      document.addEventListener('DOMContentLoaded', () => {
          const checkboxes = document.querySelectorAll('.item-checkbox');
          
          checkboxes.forEach(checkbox => {
              checkbox.addEventListener('change', () => {
                  const itemId = checkbox.getAttribute('data-id');
                  const quantityInput = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
                  const priceInput = document.querySelector(`.price-input[data-id="${itemId}"]`);
                  const nameInput = document.querySelector(`.name-input[data-id="${itemId}"]`);
                  
                  // Aktifkan atau nonaktifkan input jumlah berdasarkan checkbox
                  if (checkbox.checked) {
                      quantityInput.disabled = false;
                      priceInput.disabled = false;
                      nameInput.disabled = false;
                  } else {
                      quantityInput.disabled = true;
                      priceInput.disabled = true;
                      nameInput.disabled = true;
                  }
              });
          });
      });
  </script>
</html>


