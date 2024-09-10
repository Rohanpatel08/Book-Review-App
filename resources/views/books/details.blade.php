<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Review App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body>
    @include('components.navbar')
    <div class="container mt-3 ">
        <div class="row justify-content-center d-flex mt-5">
            <div class="col-md-12">
                <a href="{{route('home')}}" class="text-decoration-none text-dark ">
                    <i class="fa fa-arrow-left" aria-hidden="true"></i> &nbsp; <strong>Back to books</strong>
                </a>
                <div class="row mt-4">
                    <div class="col-md-4">
                        @if ($book->image != '')
                        <img src="{{Storage::url('uploads/books/' . $book->image)}}" alt="" class="card-img-top border">
                        @else
                        <img src="https://placehold.co/910x1400?text=No Image" alt="" class="card-img-top">
                        @endif
                    </div>
                    <div class="col-md-8">
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
                        <h3 class="h2 mb-3">{{$book->title}}</h3>
                        <div class="h4 text-muted">{{$book->author}}</div>
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
                            <span class="theme-font text-muted">({{$book->reviews_count}} Reviews)</span>
                        </div>

                        <div class="content mt-3">
                            {{$book->description}}
                        </div>

                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h2 class="h3 mb-4">Readers also enjoyed</h2>
                            </div>
                            @if ($relatedBooks->isNotEmpty())
                            @foreach ($relatedBooks as $relatedBook)
                            <div class="col-md-4 col-lg-4 mb-4">
                                <div class="card border-0 shadow-lg">
                                    <a href="{{route('book.details', $relatedBook->id)}}">
                                        @if ($book->image != '')
                                        <img src="{{Storage::url('uploads/books/' . $relatedBook->image)}}" alt="" class="card-img-top border">
                                        @else
                                        <img src="https://placehold.co/910x1400?text=No Image" alt="" class="card-img-top">
                                        @endif
                                    </a>
                                    <div class="card-body">
                                        <a href="{{route('book.details', $relatedBook->id)}}">
                                            <h3 class="h4 heading text-dark">{{$relatedBook->title}}</h3>
                                        </a>
                                        <p>by {{$relatedBook->author}}</p>
                                        @php
                                        if($relatedBook->reviews_count > 0){
                                        $relatedBookRating = $relatedBook->reviews_sum_ratings/$relatedBook->reviews_count;
                                        }
                                        else{
                                        $relatedBookRating = 0;
                                        }
                                        $relatedBookStarRating = ($relatedBookRating*100)/5;
                                        @endphp
                                        <div class="star-rating d-inline-flex ml-2" title="">
                                            <span class="rating-text theme-font theme-yellow">{{number_format($relatedBookRating,1,'.',',')}}</span>
                                            <div class="star-rating d-inline-flex mx-2" title="">
                                                <div class="back-stars ">
                                                    <i class="fa fa-star " aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>
                                                    <i class="fa fa-star" aria-hidden="true"></i>

                                                    <div class="front-stars" style="width: {{$relatedBookStarRating}}%">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="theme-font text-muted">({{$relatedBook->reviews_count}} Reviews)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                        <div class="col-md-12 pt-2">
                            <hr>
                        </div>
                        <div class="row pb-5">
                            <div class="col-md-12  mt-4">
                                <div class="d-flex justify-content-between">
                                    <h3>Reviews</h3>
                                    <div>
                                        @if (Auth::check())
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            Add Review
                                        </button>
                                        @else
                                        <a href="{{route('login')}}" class="btn btn-primary">Add Review</a>
                                        @endif

                                    </div>
                                </div>
                                @if ($book->reviews->isNotEmpty())
                                @foreach ($book->reviews as $review)
                                <div class="card border-0 shadow-lg my-4">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <h5 class="mb-3">{{$review->user->name}}</h4>
                                                <span class="text-muted">{{\Carbon\Carbon::parse($review->created_at)->format('d M, Y')}}</span>
                                        </div>
                                        @php
                                        $ratingPer = ($review->ratings/5)*100;
                                        @endphp

                                        <div class="mb-3">
                                            <div class="star-rating d-inline-flex" title="">
                                                <div class="star-rating d-inline-flex " title="">
                                                    <div class="back-stars ">
                                                        <i class="fa fa-star " aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars" style="width: {{$ratingPer}}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="content">
                                            <p>{{$review->review}}</p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div>
                                    Reviews not Found.
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade " id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Review for <strong>{{$book->title}}</strong></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" id="bookReviewForm" class="bookReviewForm">
                    <input type="hidden" name="book_id" value="{{$book->id}}">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="" class="form-label">Review</label>
                            <textarea name="review" id="review" class="form-control" cols="5" rows="5" placeholder="Review"></textarea>
                            <p class="invalid-feedback" id="review-error"></p>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Rating</label>
                            <select name="rating" id="rating" class="form-control">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

    <script>
        $('#bookReviewForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{route('book.savereview')}}",
                headers: {
                    'X-CSRF-TOKEN': '{{csrf_token()}}'
                },
                data: $('#bookReviewForm').serializeArray(),
                success: function(response) {
                    if (response.status == false) {
                        var errors = response.errors;
                        if (errors.review) {
                            $('#review').addClass('is-invalid');
                            $('#review-error').html(errors.review);
                        } else {
                            $('#review').removeClass('is-invalid');
                            $('#review-error').html('');
                        }
                    } else {
                        window.location.href = "{{route('book.details', $book->id)}}"
                    }
                },
                error: function(xHr) {
                    console.log("Error");
                }
            })
        })
    </script>
</body>

</html>