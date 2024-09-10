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
    <div class="container mt-3 pb-5">
        @if (Session::has('success'))
        <div class="alert alert-success" id="success-msg">
            {{Session::get('success')}}
        </div>
        @endif
        @if (Session::has('error'))
        <div class="alert alert-danger" id="error-msg">
            {{Session::get('error')}}
        </div>
        @endif
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <div class="d-flex justify-content-between">
                    <h2 class="mb-3">Books</h2>
                    <div class="mt-2">
                        <a href="{{route('home')}}" class="text-dark">Clear</a>
                    </div>
                </div>
                <div class="card shadow-lg border-0">
                    <form action="" method="get">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-11 col-md-11">
                                    <input type="text" name="keyword" class="form-control form-control-lg" placeholder="Search by title">
                                </div>
                                <div class="col-lg-1 col-md-1">
                                    <button class="btn btn-primary btn-lg w-100"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="row mt-4">
                    @if ($books->isNotEmpty())
                    @foreach ($books as $book)
                    <div class="col-md-4 col-lg-3 mb-4">
                        <div class="card border-0 shadow-lg">
                            <a href="{{route('book.details', $book->id)}}">
                                @if ($book->image != '')
                                <img src="{{Storage::url('uploads/books/' . $book->image)}}" alt="" class="card-img-top">
                                @else
                                <img src="https://placehold.co/910x1400?text=No Image" alt="" class="card-img-top">
                                @endif
                            </a>
                            <div class="card-body">
                                <h3 class="h4 heading"><a href="{{route('book.details', $book->id)}}">{{$book->title}}</a></h3>
                                <p>by {{$book->author}}</p>
                                @php
                                if($book->reviews_count > 0){
                                $avgRating = $book->reviews_sum_ratings/$book->reviews_count;
                                }
                                else{
                                $avgRating = 0;
                                }
                                $starRating = ($avgRating*100)/5;
                                @endphp
                                <div class="star-rating d-inline-flex ml-2" title="">
                                    <span class="rating-text theme-font theme-yellow">{{number_format($avgRating,1,'.',',')}}</span>
                                    <div class="star-rating d-inline-flex mx-2" title="">
                                        <div class="back-stars ">
                                            <i class="fa fa-star " aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>

                                            <div class="front-stars" style="width: {{$starRating}}%">
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                                <i class="fa fa-star" aria-hidden="true"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="theme-font text-muted">({{($book->reviews_count)}} reviews)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                    {{$books->links()}}

                </div>
            </div>
        </div>
    </div>
</body>

</html>