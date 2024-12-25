<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>Checkout</title>


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
    <link href="form-validation.css" rel="stylesheet">
  </head>
  <body class="bg-light">
    
<div class="container">
  <main>
    <div class="py-5 text-center">

    </div>

    <div class="row g-5">
      <div class="col-md-5 col-lg-4 order-md-last">
        <h4 class="d-flex justify-content-between align-items-center mb-3">
          <span class="text-primary">Your cart</span>
        </h4>
        <ul class="list-group mb-3">
          @foreach($order['selected_items'] as $index => $item)
          <li class="list-group-item d-flex justify-content-between lh-sm">
            <div>
              <h6 class="my-0">{{ $order['names'][$item] }} ( {{ money($order['prices'][$item], 'IDR', true) }} X {{ $order['quantities'][$item] }} )</h6>
            </div>
            <span class="text-muted">{{ money($order['prices'][$item], 'IDR', true) }}</span>
          </li>
          @endforeach
          
          <li class="list-group-item d-flex justify-content-between">
            <span>Total (IDR)</span>
            <strong>{{ money($order['total_price'], 'IDR', true) }}</strong>
          </li>
        </ul>

      </div>
      <div class="col-md-7 col-lg-8">
        <h4 class="mb-3">Billing address</h4>
        <form class="needs-validation" novalidate method="post" action="{{ Route('user.checkout') }}">
          @csrf
          <div class="row g-3">
            <div class="col-sm-12">
              <label for="firstName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
              <div class="invalid-feedback">
                Valid first name is required.
              </div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
              <div class="invalid-feedback">
                Please enter a valid email address for shipping updates.
              </div>
            </div>

            <div class="col-12">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" name="address" id="address" placeholder="1234 Main St" required>
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="col-12">
              <label for="phone" class="form-label">Phone</label>
              <input type="number" class="form-control" id="phone" name="phone" placeholder="080000" required>
              <div class="invalid-feedback">
                Please enter your phone number.
              </div>
            </div>

          </div>

          <hr class="my-4">

          <input type="number" name="total_price" value="{{ $order['total_price'] }}" hidden>

          <button type="submit" class="w-100 btn btn-primary btn-lg" type="submit">Continue to checkout</button>
        </form>
      </div>
    </div>
  </main>
</div>


    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

      <script src="form-validation.js"></script>
  </body>
</html>
