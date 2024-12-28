<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Durian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-3 p-3">
        
        <div class="card mt-5">
            <div class="card-body mx-4">
              <div class="container">
                <p class="my-5 mx-5" style="font-size: 30px;">Thank for your purchase</p>
                <div class="row">
                  <ul class="list-unstyled">
                    <li class="text-black">{{$order->name}}</li>
                    <li class="text-muted mt-1"><span class="text-black">Invoice</span> {{$order->id}}</li>
                    <li class="text-black mt-1">{{$order->updated_at}}</li>
                    <li class="text-black mt-1">Status {{$order->status}}</li>
                  </ul>
                </div>

                @foreach($order->products as $product)
                <div class="row">
                  <div class="col-xl-9">
                    <p>{{ $product->name }}</p>
                  </div>
                  <div class="col-xl-1">
                    <p>{{ $product->pivot->quantity }}</p>
                  </div>
                  <div class="col-xl-2">
                    <p class="float-end">{{ money($product->price, 'IDR', true) }}
                    </p>
                  </div>
                  <hr>
                </div>
                @endforeach

                <div class="row text-black">
          
                  <div class="col-xl-12">
                    <p class="float-end fw-bold">{{ money($order->total_price, 'IDR', true) }}
                    </p>
                  </div>
                  <hr style="border: 2px solid black;">
                </div>
                <div class="text-center" style="margin-top: 90px;">
                  <a href="{{ url()->secure(route('user.showUser', [], false)) }}"><u class="text-info">Kembali ke halaman utama</u></a>
                  <p>Terima kasih telah melakukan pembayaran. </p>
                </div>
          
              </div>
            </div>
          </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>