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
    <input name="email" placeholder="Email" />
    <input type="password" name="password" placeholder="Password" />
    <button>Login</button>
</form>