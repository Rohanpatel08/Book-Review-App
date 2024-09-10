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

    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('components.sidebar')
            </div>
            <div class="col-md-9">
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Books
                    </div>
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
                    <div class="card-body pb-0">
                        <a href="{{route('books.create')}}" class="btn btn-primary mb-2">Add Book</a>
                        {{$dataTable->table()}}
                        <!-- <table class="table table-striped mt-3 mb-3 dataTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table> -->
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script>
        // var success_msg = document.getElementById('success-msg');
        // var error_msg = document.getElementById('error-msg');
        // $(document).ready(function() {
        //     $(function() {
        //         $('.dataTable').DataTable({
        //             type: "GET",
        //             pageLength: 5,
        //             lengthMenu: [
        //                 [5, 10, 25, 50, 100],
        //                 [5, 10, 25, 50, 100]
        //             ],
        //             processing: true,
        //             serverSide: true,
        //             ajax: "{{ route('books.index') }}",
        //             columns: [{
        //                     data: 'DT_RowIndex',
        //                     name: 'DT_RowIndex'
        //                 },
        //                 {
        //                     data: 'title',
        //                     name: 'title'
        //                 },
        //                 {
        //                     data: 'author',
        //                     name: 'author'
        //                 },
        //                 {
        //                     data: 'status',
        //                     name: 'status'
        //                 },
        //                 {
        //                     data: 'Action',
        //                     name: 'Action'
        //                 }
        //             ]
        //         });
        //     })
        // })

        function deleteBook(id) {
            if (confirm("Are you sure you want to delete this book?")) {
                $.ajax({
                    url: '{{url("books")}}/' + id, // Adjust this route to match your routes setup
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Book deleted successfully!");
                        success_msg.innerText('Book deleted successfully!')
                        $('.dataTable').DataTable().ajax.reload(); // Reload the DataTable
                    },
                    error: function(xhr) {
                        error_msg.innerText('Something went wrong!')
                        alert("Something went wrong!");
                    }
                });
                $('.dataTable').DataTable().ajax.reload();
            }
        }
    </script>
</body>

</html>