<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Durian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container my-3">
        <h1>Toko Durian</h1>

        <!-- Card Start -->
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Invoice</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                
                <h5 class="card-title">Detil Pesanan</h5>
                <table>
                    <tr>
                        <td>Nama</td>
                        <td> : {{$order->frontname}} {{$order->backname}}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td> : {{$order->addres}}</td>
                    </tr>
                    <tr>
                        <td>No Telpon</td>
                        <td> : {{$order->phone}}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td> : {{$order->qty}}</td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td> : {{$order->total_price}}</td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td> : {{$order->status}}</td>
                    </tr>
                </table>

            </div>
        </div>
        <!-- Card End -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>