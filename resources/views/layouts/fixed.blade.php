<!doctype html>
<html lang="ja" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('index.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="shortcut icon" href="{{ asset('img/logo-black.svg') }}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/48efdb6da3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @livewireStyles
</head>
<body>
<div id="index" class="d-flex vh-100 flex-column">
    <div class="header d-flex align-items-center">
        <a href="#" class="logo">
        </a>
        <div class="dropdown user">
            <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
            @if(is_null($profile_image))
                <span class="defaultProfileImageSmall"></span>
            @else
                <img class="setProfileImageSmall" src="{{ $profile_image }}" alt="Profile Icon">
            @endif
                <div class="d-flex flex-flow">
                    <span class="fw-bold ml-3">{{ $user_name }}</span>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="{{ route('profile.index') }}">プロフィール</a></li>
                <li><hr class="dropdown-divider"></li>
                <livewire:Themebutton />
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                    document.getElementById('logout-form').
                                    submit();">
                        サインアウト
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
    <main class="w-100 h-100 d-flex">
        <div class="sidebar d-inline-block">
            <div class="d-flex flex-nowrap h-100">
                <div class="d-flex flex-column flex-shrink-0 p-3" style="width: 12vw;">
                    <?php
                    $url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://") . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];

                    $navs = [
                        ["home", "Home", '<i class="fa-solid fa-house"></i>'],
                        ["tasks", "My all tasks", '<i class="fa-solid fa-table-list"></i>'],
                        ["analytics", "Analytics", '<i class="fa-solid fa-chart-simple"></i>'],
                        ["department-management", "Department Management", '<i class="fa-solid fa-calendar-days"></i>'],
                        ["position-management", "Position Management", '<i class="fa-solid fa-calendar-days"></i>'],
                        ["user-management", "User Management", '<i class="fa-solid fa-calendar-days"></i>'],
                        ["#", "Add new board", ''],
                    ];
                    ?>
                    <?php
                    if ($navs) {
                        ?>
                    <ul class="nav nav-pills flex-column mb-auto">
                        @foreach ($navs as $vals)
                            @php
                                $current = (strpos($url, $vals[0]) !== false) ? 'class="nav-link selected" aria-current="page"' : 'class="nav-link"';
                            @endphp

                            @if ($vals[0] === 'department-management' | $vals[0] === 'position-management' | $vals[0] === 'user-management')
                                @can('boss')
                                    <li class="nav-item">
                                        <a href="{{ $vals[0] }}" {!! $current !!}>
                                            {!! $vals[2] !!}
                                            {{ $vals[1] }}
                                        </a>
                                    </li>
                                @endcan
                            @else
                                <li class="nav-item">
                                    <a href="{{ $vals[0] }}" {!! $current !!}>
                                        {!! $vals[2] !!}
                                        {{ $vals[1] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>

                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        @yield('content')
    </main>
</div>
@livewireScripts
</body>
<script>
    window.addEventListener('default-theme', event => {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
    });

    window.addEventListener('change-theme', event => {
        if(document.documentElement.getAttribute('data-bs-theme') === 'dark') {
            document.documentElement.setAttribute('data-bs-theme', 'light');
        } else {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
        }
    });
</script>
</html>
