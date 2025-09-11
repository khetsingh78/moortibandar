
@isset($items)
    <div class="col-lg-3 col-6  my-md-2 my-lg-2 my-2" data-aos="fade-up">
        <a href="{{ route('plan', [$items['id'], $items['Category']]) }}" class="text-decoration-none">
            <div class=" card most_popular_plan_card border-0 box-shadow-light  " style="width: 100%;">
                <div class="container1">
                    <img src="{{asset("/". $items['CoverImage']) }}" class=" image card-img-top" alt="...">
                </div>
                <div class="card-body">
                    <h5 class="card-title my-0">{{ substr($items['Title'], 0, 23) }}..</h5>
                    <p class="card-text d-none d-sm-block ">{{ substr($items['ShortDescreption'], 0, 35) }}...</p>
                    <div class="d-flex justify-content-between align-item-center">
                        <h3 class="card_price">&#8377 {{ $items['Price'] }}/-<span></span>
                        </h3>
                        
                        <a href="{{ route('plan', ['id' => $items['id'], 'category' => $items['Category']]) }}">
                            <button class="plan_card_btn shadow">
                                View
                            </button>

                        </a>

                    </div>
                </div>
            </div>
        </a>
    </div>
@endisset
