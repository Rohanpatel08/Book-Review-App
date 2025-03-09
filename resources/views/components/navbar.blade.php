<div class="container-fluid shadow-lg header">
    <div class="container">
        <div class="d-flex justify-content-between">
            <h1 class="text-center"><a href="{{route('home')}}" class="h3 text-white text-decoration-none">Book Review App</a></h1>
            <div class="d-flex align-items-center navigation">
                <a href="{{route('home')}}" class="text-white mx-3">Dashboard</a>
                @if (Auth::user()->role == 'admin')
                <a href="{{route('reviews.index')}}" class="text-white mx-3">Reviews</a>
                <a href="{{route('books.index')}}" class="text-white mx-3">Books</a>
                @endif
                <a href="{{route('profile')}}"><img src="{{asset(Auth::user()->profile ? 'images/'.Auth::user()->profile : 'images/default.jpg')}}" id="nav-profile-img" alt=""></a>
            </div>
        </div>
    </div>
</div>