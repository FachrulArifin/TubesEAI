<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Dashboard Template · Bootstrap v5.0</title>

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

    
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow ">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Durian Runtuh</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
    <form action="{{ url()->secure(route('logout', [], false)) }}" method="POST" style="display: inline;">
      @csrf
      <button type="submit" class="btn btn-primary">Logout</button>
    </form>
    </div>
  </div>
</header>

<div class="container-fluid mt- 3">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">
              <span data-feather="home"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url()->secure(route('admin.viewAddProduct', [], false)) }}">
              <span data-feather="file"></span>
              Tambah Produk
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">History Transaksi</h1>
      </div>

      <form method="GET" action="{{ url()->secure(route('admin.dashboard', [], false)) }}" class="mb-3">
        <label for="status" class="form-label">Filter Berdasarkan Status</label>
        <select name="status" id="status" class="form-select" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
        </select>
      </form>

      <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Email Address</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
                <th scope="col">List Order</th>
                <th scope="col">Total Price</th>
                <th scope="col">Status</th>
                <th scope="col">Updated At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->email }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->phone }}</td>
                <td>
                  @foreach($order->products as $product)
                      {{ $product->name }} ({{ $product->pivot->quantity }})<br>
                  @endforeach
                </td>
                <td>{{ money($order->total_price, 'IDR', true) }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>{{ $order->updated_at->format('d-m-Y H:i:s') }}</td>
            </tr>
            @endforeach
        </tbody>
      </table>

      </div>
    </main>
  </div>
</div>


    <script src="{{ asset('js/dashboard.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
