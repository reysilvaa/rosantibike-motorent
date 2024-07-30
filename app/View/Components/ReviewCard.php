<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ReviewCard extends Component
{
    public $avatar;
    public $name;
    public $role;
    public $review;
    public $rating;
    public $timeAgo;

    public function __construct($avatar, $name, $role, $review, $rating, $timeAgo)
    {
        $this->avatar = $avatar;
        $this->name = $name;
        $this->role = $role;
        $this->review = $review;
        $this->rating = $rating;
        $this->timeAgo = $timeAgo;
    }

    public function render()
    {
        return view('components.review-card');
    }
}
