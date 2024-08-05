<?php

namespace App\View\Components;

use App\Models\Rating;
use Illuminate\View\Component;

class ReviewCard extends Component
{
    public $review;

    public function __construct($reviewId)
    {
        $this->review = Rating::find($reviewId);
    }

    public function render()
    {
        return view('components.review-card');
    }
}
