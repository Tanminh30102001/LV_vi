<div>
    <style>
        .comment-form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .comment-form h4 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        div.stars {
            
            width: 200px;
            display: inline-block;
            }
            
            input.star { display: none; }
            
            label.star {
            float: right;
            padding: 10px;
            font-size: 20pxpx;
            color: #444;
            transition: all .2s;
            }
            
            input.star:checked ~ label.star:before {
            content: '\f005';
            color: #FD4;
            transition: all .25s;
            }
            
            input.star-5:checked ~ label.star:before {
            color: #FE7;
            text-shadow: 0 0 20px #952;
            }
            
            input.star-1:checked ~ label.star:before { color: #F62; }
            
            label.star:hover { transform: rotate(-15deg) scale(1.3); }
            
            label.star:before {
            content: '\f006';
            font-family: FontAwesome;
            }

        .form-group {
            margin-bottom: 20px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .button-contactForm {
            background-color: #28a745;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color .3s;
        }

        .button-contactForm:hover {
            background-color: #218838;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
    <div class="comment-form">
        <h4 class="mb-15"><strong>Đánh giá sẩn phẩm</strong>  {{$orderDetails->product->ten}}</h4>
        @if(Session::has('review_message'))
        <div class="alert alert-success" role="alert"> {{Session::get('review_message')}}</div>
        @endif
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <form class="form-contact comment_form" id="commentForm" wire:submit.prevent="addReview">
                    <div class=" d-inline-block mb-3">
                        <div class="stars">
                              <input class="star star-5" value="5" id="star-5" type="radio" name="rating" wire:model="rating"/>
                              <label class="star star-5" for="star-5"></label>
                              <input class="star star-4" value="4" id="star-4" type="radio" name="rating"wire:model="rating"/>
                              <label class="star star-4" for="star-4"></label>
                              <input class="star star-3"value="3" id="star-3" type="radio" name="rating"wire:model="rating"/>
                              <label class="star star-3" for="star-3"></label>
                              <input class="star star-2" value="2" id="star-2" type="radio" name="rating"wire:model="rating"/>
                              <label class="star star-2" for="star-2"></label>
                              <input class="star star-1" value="1" id="star-1" type="radio" name="rating"wire:model="rating"/>
                              <label class="star star-1" for="star-1"></label>
                              @error('rating')
                              <p class="text-danger">{{$message}} </p>
                              @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" name="comment" id="comment" cols="30" rows="9" placeholder="Write Comment" wire:model="comment"></textarea>
                        @error('comment')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="button button-contactForm">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
