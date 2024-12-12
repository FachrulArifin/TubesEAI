
<!doctype html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Durian Runtuh</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/album/">

  

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
      @if(Auth::check())
        <form action="" method="POST" style="display: inline;">
          @csrf
          <button type="button" class="btn btn-outline-primary" data-bs-target="#exampleModal" data-bs-toggle="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
            <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/>
          </svg>
          </button>
        </form>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-outline-primary">Logout</button>
        </form>
      @else
        <a href="{{ route('showLogin') }}">
        <button type="button" class="btn btn-outline-primary">Login</button>
        </a>
      @endif
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
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
            <button type="button" class="btn btn-primary">Checkout</button>
          </div>
        </div>
      </div>
    </div>

    <section class="py-5 text-center container">
      <div class="row py-lg-5">
        <div class="col-lg-6 col-md-8 mx-auto">
          <h1 class="fw-light">Durian Runtuh</h1>
          <p class="lead text-muted">merupakan platform pembelian durian secara online dan memiliki berbagai jenis durian.</p>
        </div>
      </div>
    </section>

    <div class="album py-5 bg-light">

      <!-- start Container -->
      <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
          <div class="col">

            <!-- Card Start -->
            <div class="card mb-3" style="width: 18rem">
              <img src="{{asset('asset/image/durian1.jpeg')}}" class="card-img-top" alt="Durian">
              <div class="card-body">
                <h5 class="card-title">Durian Kampung</h5>
                <p class="card-text">Durian enak.</p>
                <p class="card-text"><small class="text-muted">Stock 50</small></p>
                <button type="submit" class="btn btn-primary">Tambah ke-keranjang</button>
              </div>
            </div>
            <!-- End Card -->

          </div>
        </div>
      </div>
      <!-- End Container -->

    </div>

  </main>

  <footer class="text-muted py-5">
    <div class="container">
      <p class="float-end mb-1">
        <a href="#">Back to top</a>
      </p>
      <p class="mb-1">Album example is &copy; Bootstrap, but please download and customize it for yourself!</p>
      <p class="mb-0">New to Bootstrap? <a href="/">Visit the homepage</a> or read our <a href="/docs/5.0/getting-started/introduction/">getting started guide</a>.</p>
    </div>
  </footer>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>


