<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    @include('components.navbar')

    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('components.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Profile
                    </div>
                    @if (Session::has('success'))
                    <div class="alert alert-success fade show" role="alert">
                        {{Session::get('success')}}
                    </div>
                    @endif
                    @if (Session::has('error'))
                    <div class="alert alert-danger fade show" role="alert">
                        {{Session::get('error')}}
                    </div>
                    @endif
                    <form action="{{route('update.profile')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" value="{{old('name',Auth::user()->name)}}" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="" />
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Email</label>
                                <div class="input-group">
                                    <input type="text" value="{{old('email',Auth::user()->email)}}" class="form-control @error('email') is-invalid @enderror" placeholder="Email" name="email" id="email" />
                                    <span class="input-group-text">
                                        @if(Auth::user()->email_verified_at != null)
                                        <i class="fa fa-check-circle text-success" title="verified"></i>
                                        @else
                                        <i class="fa fa-exclamation-circle text-danger" title="Not verified"></i>
                                        @endif
                                    </span>
                                    @if (Auth::user()->email_verified_at == null)
                                    <a href="{{route('verification.notice')}}" class="btn btn-danger btn-sm mx-2" data-bs-toggle="modal" data-bs-target="#exampleModal" id="verifyEmail">Verify Email</a>
                                    @endif
                                </div>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Role</label>
                                <input type="text" disabled name="role" id="role" value="{{Auth::user()->role}}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Profile Pic</label>
                                <input type="file" class="form-control" name="profile" id="profile" class="form-control">
                                @error('profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <img src="{{asset(Auth::user()->profile ? 'images/'.Auth::user()->profile : 'images/default.jpg')}}" alt="profile" id="preview" class="img-thumbnail profile-pic">
                            </div>
                            <button class="btn btn-primary mt-2">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Verify Email Address</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('verification.send')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="text" value="{{Auth::user()->email}}" class="form-control" placeholder="Email" name="modalEmail" id="modalEmail" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Email</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        document.getElementById('profile').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();

                // When the file is loaded, set the image src to the file content
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                };

                // Read the file content
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>

</html>