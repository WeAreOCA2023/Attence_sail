<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('index.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/48efdb6da3.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>
<body>
    <div id="index" class="d-flex vh-100 flex-column">
        <div class="header d-flex align-items-center">
            <a href="#">
                <img src="{{ asset('img/logo-black.svg') }}" alt="ロゴ"/>
            </a>
            <div class="dropdown user">
                <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-gear padding" style="color: #0F1419;"></i>
                <div class="d-flex flex-flow">
                    <span class="fw-bold">{{ $user_name }}</span>
                </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                    <li><a class="dropdown-item" href="#">プロフィール</a></li>
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
                                ["next-7-days", "Next 7 days", '<i class="fa-solid fa-calendar-days"></i>'],
                                ["analytics", "Analytics", '<i class="fa-solid fa-poo"></i>'],
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
</body>
</html>
