<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Checkout</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">

    <!-- Midtrans Snap Script -->
    <script type="text/javascript"
        src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>
    <!-- Replace with https://app.midtrans.com/snap/snap.js for production -->
</head>

<body class="bg-light">
    <div class="container">
        <main>
            <div class="py-5 text-center">
                <h2>Checkout</h2>
                <p class="lead">Please fill out the form to complete your purchase.</p>
            </div>

            <div class="row g-5">
                <!-- Cart Section -->
                <div class="col-md-5 col-lg-4 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your cart</span>
                    </h4>
                    <ul class="list-group mb-3">
                        @foreach($order['selected_items'] as $item)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $order['names'][$item] }}</h6>
                                <small class="text-muted">({{ money($order['prices'][$item], 'IDR', true) }} x {{ $order['quantities'][$item] }})</small>
                            </div>
                            <span class="text-muted">{{ money($order['prices'][$item]*$order['quantities'][$item], 'IDR', true) }}</span>
                        </li>
                        @endforeach
                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (IDR)</span>
                            <strong>{{ money($order['total_price'], 'IDR', true) }}</strong>
                        </li>
                    </ul>
                </div>

                <!-- Billing Form -->
                <div class="col-md-7 col-lg-8">
                    <h4 class="mb-3">Billing Address</h4>
                    <form id="checkout-form" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ auth()->user()->name }}" required>
                                <div class="invalid-feedback">Valid name is required.</div>
                            </div>

                            <div class="col-12">
                                <label for="email" class="form-label">Email <span class="text-muted">(Optional)</span></label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ auth()->user()->email }}">
                                <div class="invalid-feedback">Please enter a valid email address.</div>
                            </div>

                            <div class="col-12">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" placeholder="1234 Main St" required>
                                <div class="invalid-feedback">Please enter your address.</div>
                            </div>

                            <div class="col-12">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="080000" required>
                                <div class="invalid-feedback">Please enter your phone number.</div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="total_price" value="{{ $order['total_price'] }}">
                        @foreach($order['selected_items'] as $item)
                        <input type="hidden" name="products[]" value="{{ $item }}">
                        <input type="hidden" name="quantities[]" value="{{ $order['quantities'][$item] }}">
                        @endforeach

                        <button type="submit" class="w-100 btn btn-primary btn-lg">Continue to Checkout</button>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('checkout-form').addEventListener('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            const formData = new FormData(this);

            // AJAX request to server to handle checkout and retrieve Snap token
            fetch("{{ url()->secure(route('user.checkout', [], false)) }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: formData,
            })

            .then(response => response.json())
            .then(data => {
              console.log(data); // Check if snapToken is present
              if (data.snapToken) {
                  window.snap.pay(data.snapToken, {
                      onSuccess: function (result) {
                          alert('Payment success!');
                          window.location.href = `/invoice/${data.orderId}`;
                      },
                      onPending: function (result) {
                          alert('Waiting for your payment!');
                      },
                      onError: function (result) {
                          alert('Payment failed!');
                      },
                      onClose: function () {
                          alert('You closed the popup without finishing the payment.');
                      },
                  });
                } else {
                  alert('Failed to get Snap token.');
                }
              })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>
