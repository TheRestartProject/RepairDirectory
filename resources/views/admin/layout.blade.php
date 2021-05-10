<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="/css/map/app.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <title>@lang('admin.title')</title>
</head>
<body>
   <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" role="button" href="{{ env('FIXOMETER_URL') }}" >
                    @include('admin.logo-large')
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav navbar-nav__left">
                        <li><a class="nav-link" href="{{ route('admin.index') }}"><i class="fas fa-store-alt"></i> Businesses</a></li>
                        <li><a class="nav-link" href="{{ route('admin.submissions.index') }}"><i class="fas fa-store-alt"></i> Submissions</a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                            <li class="nav-item dropdown">
                                @php( $user = Auth::user() )

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-target="#account-nav" aria-controls="account-nav" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" aria-label="Toggle account navigation" v-pre>
                                    {{-- @if ( isset( $user->getProfile($user->id)->path ) && !is_null( $user->getProfile($user->id)->path ) )--}}
                                    @if ( false )
                                        <img src="/uploads/thumbnail_{{ $user->getProfile($user->id)->path }}" alt="{{ $user->getName() }} Profile Picture" class="avatar">
                                    @else
                                        <img src="{{ asset('/images/placeholder-avatar.png') }}" alt="{{ $user->getName() }} Profile Picture" class="avatar">
                                    @endif
                                    <span class="user-name">{{ $user->getName() }}</span> <span class="caret"></span>
                                </a>

                                <div id="account-nav" class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ env('FIXOMETER_URL') }}">@lang('admin.homepage')</a>
                                    <a class="dropdown-item" href="{{ env('FIXOMETER_URL') }}/logout">@lang('admin.logout')</a>
                                </div>
                            </li>

                    </ul>
                </div>

                <div class="collapse navbar-start navbar-dropdown" id="startMenu">

                    <ul>
                        <li>
                            <strong><svg width="11" height="14" viewBox="0 0 9 11" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M8.55 0H0v10.687l4.253-3.689 4.297 3.689V0z" fill="#0394a6"/></svg> Community Tools</strong>
                            <ul>
                                <li><a href="{{ env('FIXOMETER_URL') }}">Fixometer</a></li>
                                <li><a href="{{ env('DISCOURSE_URL') }}">Discussion</a></li>
                                <li><a href="{{ env('WIKI_URL') }}">Restart Wiki</a></li>
                            </ul>
                        </li>

                        <li>
                            <strong><svg width="15" height="15" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="1.414"><path d="M5.625 0a5.627 5.627 0 0 1 5.625 5.625 5.627 5.627 0 0 1-5.625 5.625A5.627 5.627 0 0 1 0 5.625 5.627 5.627 0 0 1 5.625 0zm1.19 9.35l.104-.796c-.111-.131-.301-.249-.57-.352V4.073a9.365 9.365 0 0 0-.838-.031c-.331 0-.69.045-1.076.134l-.104.797c.138.152.328.269.57.352v2.877c-.283.103-.473.221-.57.352l.104.796h2.38zM5.604 3.462c-.572 0-.859-.26-.859-.781s.288-.781.864-.781c.577 0 .865.26.865.781s-.29.781-.87.781z" fill="#0394a6"/></svg> Other</strong>
                            <ul>
                                <li><a href="{{ url('/') }}">The Restart Project</a></li>
                                <li><a href="{{ url('/') }}/contact/">Help</a></li>
                                <li><a role="button"  data-toggle="modal" href="#onboarding" data-target="#onboarding">Welcome</a></li>
                            </ul>
                        </li>

                    </ul>

                </div>

            </div>
        </nav>

    <main role="main">
      <div class="page">
        <div class="container-fluid">
            @yield('content')
        </div>
      </div>
    </main>

    <footer class="text-muted">
        <div class="container-fluid">
            @if (!empty(Auth::user()->getRepairDirectoryRole())) 
                <p>@lang('admin.your_role_is'): {{ Auth::user()->getRepairDirectoryRole()->getName() }}.</p>
            @endif

            <p>Created by <a href="https://therestartproject.org">The Restart Project</a> and <a href="https://outlandish.com">Outlandish</a>.</p>
        </div>
    </footer>

    <script src="/js/map/admin.js"></script>
    <script src="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.js"></script>
    @stack('scripts')
</body>
</html>
