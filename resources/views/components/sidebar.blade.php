<div class="card border-0 shadow-lg">
    <div class="card-header  text-white">
        Welcome, {{Auth::user()->name}}
    </div>
    <div class="card-body">
        <div class="text-center mb-3">
            <img src="{{asset('images/profile-img-1.jpg')}}" class="img-fluid rounded-circle" alt="Luna John">
        </div>
        <div class="h5 text-center">
            <strong>{{Auth::user()->name}}</strong>
            <p class="h6 mt-2 text-muted">{{count(Auth::user()->reviews)}} Reviews</p>
        </div>
    </div>
</div>
<div class="card border-0 shadow-lg mt-3">
    <div class="card-header  text-white">
        Navigation
    </div>
    <div class="card-body sidebar">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{route('profile')}}">Profile</a>
            </li>
            <li class="nav-item">
                <a href="{{route('userReviews')}}">My Reviews</a>
            </li>
            <li class="nav-item">
                <a href="{{route('auth.changePassword')}}">Change Password</a>
            </li>
            <li class="nav-item">
                <a href="{{route('logout')}}">Logout</a>
            </li>
        </ul>
    </div>
</div>