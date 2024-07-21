<?php

namespace App\Http\Livewire\User;

use App\Models\OrderDetails;
use App\Models\Review;
use Livewire\Component;

class UserReviewComponent extends Component
{
    public $order_details_id;
    public $rating;
    public $comment;
    public  function mount($order_details_id){
        $this->order_details_id=$order_details_id;
    }
    public function updated($fields){
        $this->validateOnly($fields,[
            'rating'=>"required",
            'comment'=>"required"
        ], [
            'rating.required' => 'Vui lòng nhập đánh giá.',
            'comment.required' => 'Vui lòng nhập bình luận.'
        ]);
    }
    public function addReview(){
        $this->validate([
            'rating'=>"required",
            'comment'=>"required"
        ], [
            'rating.required' => 'Vui lòng nhập đánh giá.',
            'comment.required' => 'Vui lòng nhập bình luận.'
        ]);
        $review=new Review();
        $review->rating=$this->rating;
        $review->binh_luan=$this->comment;
        $review->don_hang_detail_id=$this->order_details_id;
        $review->save();
        $orderDetails=OrderDetails::find($this->order_details_id);
        $orderDetails->trang_thai_danh_gia=true;
        $orderDetails->save();
        session()->flash('review_message','Review successsfully and thanks for your review');
        return redirect()->route('user.orderdetails',[$orderDetails->don_hang_id])->with('review_message','Review successsfully and thanks for your review');
    }
    public function render()
    {
        $orderDetails=OrderDetails::find($this->order_details_id);
        return view('livewire.user.user-review-component',['orderDetails'=>$orderDetails]);
    }
}
