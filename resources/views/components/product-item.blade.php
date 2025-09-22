 <div class="product__item">
     <div class="product__item__pic set-bg" data-setbg="{{ asset($item['cover_image']) ?? '' }}">
         <div class="label new">New</div>
         <ul class="product__hover">
             <li><a href="{{ asset($item['cover_image']) ?? '' }}" class="image-popup"><span
                         class="arrow_expand"></span></a></li>
             <li><a href="javascript:void(0)"><span class="icon_heart_alt add-to-wishlist"
                         data-product_id="{{ $item['id'] }}"></span></a></li>
             <li><a href="javascript:void(0)"><span class="icon_bag_alt add-to-cart"
                         data-product_id="{{ $item['id'] }}"></span></a></li>
         </ul>
     </div>
     <div class="product__item__text">
         <h6><a href="{{ route('productDetails', ['slug' => $item['slug']]) }}">{{ $item['title'] }}</a>
         </h6>
         <div class="rating">
             <i class="fa fa-star"></i>
             <i class="fa fa-star"></i>
             <i class="fa fa-star"></i>
             <i class="fa fa-star"></i>
             <i class="fa fa-star"></i>
         </div>
         <div class="product__price">&#8377;{{ $item['inventory']['price'] }}</div>
     </div>
 </div>
