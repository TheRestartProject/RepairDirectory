@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{ route('login') }}">
    <div class="row">
        <div class="col-xs-12 col-md-4 col-md-offset-4">
            <div class="form-group">
                <input name="email" placeholder="Email" />
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" />
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember" /> <label for="remember">Remember Me</label>
            </div>
            <div class="form-group">
                <button>Login</button>
            </div>
        </div>
    </div>
    {{ csrf_field() }}




</form>