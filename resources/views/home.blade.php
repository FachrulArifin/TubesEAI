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
            <img src="{{asset('asset/image/durian1.jpeg')}}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Card title</h5>
                <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                
                <!-- Form Input Start -->
                <form action="/checkout" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="qty" class="form-label">Jumlah pesanan</label>
                        <input type="nubmer" name="qty" class="form-control" id="qty" placeholder="1">
                    </div>
                    <div class="mb-3">
                        <label for="frontname" class="form-label">Nama Depan</label>
                        <input type="text" name="frontname" class="form-control" id="frontname" placeholder="Jono">
                    </div>
                    <div class="mb-3">
                        <label for="backname" class="form-label">Nama Belakang</label>
                        <input type="text" name="backname" class="form-control" id="backname" placeholder="Jono">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">No Telpon</label>
                        <input type="nubmer" name="phone" class="form-control" id="phone" placeholder="0812345">
                    </div>
                    <div class="mb-3">
                        <label for="Addres" class="form-label">Alamat</label>
                        <textarea name="addres" class="form-control" id="addres" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Check Out</a>
                </form>
                <!-- Form Input End -->

            </div>
        </div>
        <!-- Card End -->

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>