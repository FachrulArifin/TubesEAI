<h1>Welcome Admin {{Auth::User()->name }}</h1>
<form action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-outline-primary">Logout</button>
</form>