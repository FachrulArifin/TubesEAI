<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
          class="img-fluid" alt="Sample image">
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
          <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start mb-4">
            <p class="lead fw-normal mb-0 me-3">Sign in</p>
          </div>

          <form action="{{ url()->secure(route('loginAccount', [], false))}}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Enter Email">
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Enter Password">
            </div>
            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
          </form>
          @if(session('gagal'))
          <p class="text-danger">{{ session('gagal') }}</p>
          @endif

          <div class="text-center text-lg-start mt-4 pt-2">
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{route('showRegister')}}"
                class="link-danger">Register</a></p>
          </div>

      </div>
    </div>
  </div>
</section>