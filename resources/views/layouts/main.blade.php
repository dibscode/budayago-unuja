<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Mazer Admin Dashboard</title>

    @include('includes.styles')
    @stack('styles')
</head>

<body>
    <script src="/assets/static/js/initTheme.js"></script>
    <div id="app">
        @include('partials.sidebar')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>
                    @yield('title', 'Dashboard')
                </h3>
            </div>
            <div class="page-content">
                @yield('content')
            </div>
            @include('partials.footer')
        </div>
    </div>
    @include('includes.scripts')
    @stack('scripts')
</body>

</html>
