<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />  
    <link rel="stylesheet" href="{{ asset('styles/layouts/app.blade.css') }}">
    @yield('styles')
</head>
<body>
<header>
    <nav class="nav-bar text-center d-flex justify-content-center align-items-center">
        <div class="nav-out d-flex">
            <div class="nav-mid me-5">
                <div class="nav-i">
                    <a href="{{ url('/') }}" class="vertical-line"><i class="fa-solid fa-house"></i></a>
                    <h3>Home</h3>
                </div>
                <div class="nav-i">
                    <a href="{{ route('articles.index') }}" class="vertical-line"><i class="fa-solid fa-book-open"></i></a>
                    <h3>Articles</h3>
                </div>
                <div class="nav-i">
                    <a href="{{ route('articles.create') }}" class="vertical-line"><i class="fa-solid fa-pencil-alt"></i></a>
                    <h3>Create</h3>
                </div>
            </div>
            <div class="nav-mid ms-5">
                @auth
                <div class="nav-i">
                    <span><i class="fa-solid fa-lock-open"></i></span>
                    <h3>User: {{ auth()->user()->name }}!</h3>
                </div>

                <div class="nav-i">
                    <!-- Change from form to link for consistency -->
                    <a href="{{ route('logout') }}" class="text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                    <h3>Logout</h3>
                    <!-- Hidden form for logout -->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>  

                @else  
                <div class="nav-i">
                    <span><i class="fa-solid fa-lock fa-lg"></i></span>
                    <h3>Viewing as guest</h3>
                </div>
                <div class="nav-i">
                    <a href="{{ route('login') }}"><i class="fas fa-key"></i></a>
                    <h3>Login</h3>
                </div>
                <div class="nav-i">
                    <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i></a>
                    <h3>Register</h3>
                </div>
                @endauth
            </div>
        </div> 
    </nav>
</header>


    <div class="container mt-5 content">
        @yield('content') <!-- Page-specific content will be injected here -->
    </div>

    <footer>
        <p>&copy; 2024 My Website. All rights reserved.</p>
        <p>Contact us at info@example.com</p>
    </footer>
    <div class="login-success-modal" id="loginSuccessModal">
        <div class="icon-container" id="iconContainer">
            <i class="fa-solid fa-lock"></i>
            <i class="fa-solid fa-lock-open"></i>
        </div>
    </div>
    <script>
        // Show modal if login was successful (simulate using a session flash message)
        @if(session('login_success'))
            document.getElementById('loginSuccessModal').classList.add('show');
            setTimeout(() => {
                // Add 'unlock' class to trigger icon transition
                document.getElementById('iconContainer').classList.add('unlock');
            }, 500); // Delay for initial effect

            // Hide the modal after 3 seconds
            setTimeout(() => {
                document.getElementById('loginSuccessModal').classList.remove('show');
            }, 5000);
        @endif
    </script>
</body>
</html>
