<?php

namespace App\Http\Controllers;

use App\DataTables\MyReviewDataTable;
use App\DataTables\ReviewDataTable;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function my_reviews(MyReviewDataTable $dataTable)
    {
        return $dataTable->render('reviews.my-reviews');
        // $reviews = Review::where('user_id', Auth::id())->paginate(5);
        // return view('reviews.my-reviews', ['reviews' => $reviews]);
    }

    public function my_reviewsEdit($id)
    {
        $review = Review::where([
            'id' => $id,
            'user_id' => Auth::id(),
        ])->first();

        return view('reviews.edit-myReview', ['review' => $review]);
    }

    public function my_reviewUpdate($id, Request $request)
    {
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'ratings' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('userReviews.edit', $id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->ratings = $request->ratings;
        $review->update();

        session()->flash('success', 'Review updated successfully');
        return redirect()->route('userReviews');
    }

    public function my_reviewDelete(Request $request)
    {
        $id = $request->id;
        $review = Review::findOrFail($id);

        if ($review == null) {
            session()->flash('error', 'Review not Found');
            return response()->json([
                'success' => false,
            ]);
        } else {
            $review->delete();
            session()->flash('success', 'Review deleted successfully');
            return response()->json([
                'success' => true,
            ]);
        }
    }
    public function index(ReviewDataTable $dataTable)
    {
        return $dataTable->render('reviews.list');
    }

    public function edit($id)
    {
        $review = Review::find($id);

        return view('reviews.edit', ['review' => $review]);
    }

    public function update($id, Request $request)
    {
        $review = Review::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'review' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->route('reviews.edit', $id)->withInput()->withErrors($validator);
        }

        $review->review = $request->review;
        $review->status = $request->status;
        $review->update();

        session()->flash('success', 'Review updated successfully');
        return redirect()->route('reviews.index');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $review = Review::findOrFail($id);

        if ($review == null) {
            session()->flash('error', 'Review not Found');
            return response()->json([
                'success' => false,
            ]);
        } else {
            $review->delete();
            session()->flash('success', 'Review deleted successfully');
            return response()->json([
                'success' => true,
            ]);
        }
    }
}
