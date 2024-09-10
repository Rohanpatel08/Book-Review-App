<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function dashboard(UsersDataTable $dataTable)
    {
        return $dataTable->render('auth.index');
    }

    public function index(Request $request)
    {
        if (Auth::check()) {

            $books = Book::withCount('reviews')->withSum('reviews', 'ratings')->orderBy('created_at', 'DESC');
            if ($request->keyword) {
                $books->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('author', 'like', '%' . $request->keyword . '%');
            }
            $books = $books->where('status', 1)->paginate(4);
            return view('index', ['books' => $books]);
        } else {
            return view('auth.login');
        }
    }

    public function details(string $id)
    {
        $book = Book::withCount('reviews')->withSum('reviews', 'ratings')->with('reviews', 'reviews.user')->find($id);
        // dd($book->toArray());
        $relatedBooks = Book::where('status', 1)
            ->withCount('reviews')
            ->withSum('reviews', 'ratings')
            ->take(3)
            ->where('id', '!=', $id)
            ->inRandomOrder()->get();
        return view('books.details', ['book' => $book, 'relatedBooks' => $relatedBooks]);
    }

    public function saveReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'review' => 'required|min:10',
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $countReview = Review::where('user_id', Auth::user()->id)->where('book_id', $request->book_id)->count();
        if ($countReview > 0) {
            session()->flash('error', 'You already submitted a review.');
            return response()->json([
                'status' => true
            ]);
        }

        Review::create([
            'review' => $request->review,
            'ratings' => $request->rating,
            'book_id' => $request->book_id,
            'user_id' => Auth::user()->id,
        ]);

        session()->flash('success', 'Review Submitted successfully');

        return response()->json([
            'status' => true
        ]);
    }
}
