<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Repositories\ReviewRepo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    protected $repo;
    public function __construct(ReviewRepo $repo)
    {
        $this->repo = $repo;
    }

    public function reviewStore(Request $request)
    {
        // Check if the user is logged in
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to submit a review');
        }

        // Check if the user has already submitted a review for this product
        $existingReview = DB::table('product_reviews')
            ->where('user_id', auth()->id())
            ->where('product_id', $request->input('product_id'))
            ->first();

        if ($existingReview) {
            // If the user has already reviewed the product, show an error message
            return redirect()->back()->with('error', 'You have already submitted a review for this product');
        }

        // Proceed with the review submission if no review exists
        $data = $request->only($this->repo->getModel()->getFillable());
        $result = $this->repo->createRecord($data);

        if ($result) {
            return redirect()->back()->with('success', 'Review Added Successfully');
        } else {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }


}
