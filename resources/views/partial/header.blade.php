 <!-- Page Preloder -->
 <div id="preloder">
     <div class="loader"></div>
 </div>

 <!-- Offcanvas Menu Begin -->
 <div class="offcanvas-menu-overlay"></div>
 <div class="offcanvas-menu-wrapper">
     <div class="offcanvas__close">+</div>
     <ul class="offcanvas__widget">
         <li><span class="icon_search search-switch"></span></li>
         <li><a href="#"><span class="icon_heart_alt"></span>
                 <div class="tip">2</div>
             </a></li>
         <li><a href="#"><span class="icon_bag_alt"></span>
                 <div class="tip">2</div>
             </a></li>
     </ul>
     <div class="offcanvas__logo">
         <a href="./index.html"><img src="img/logo.png" alt=""></a>
     </div>
     <div id="mobile-menu-wrap"></div>
     <div class="offcanvas__auth">
         <a href="#">Login</a>
         <a href="#">Register</a>
     </div>
 </div>
 <!-- Offcanvas Menu End -->

 <!-- Header Section Begin -->
 <header class="header">
     <div class="container-fluid">
         <div class="row">
             <div class="col-xl-3 col-lg-2">
                 <div class="header__logo">
                     <a href="{{ route('home') }}"><img src="{{ URL::asset('/img/logo.png') }}" alt=""></a>
                 </div>
             </div>
             <div class="col-xl-6 col-lg-7">
                 <nav class="header__menu">
                     <ul>
                         <li class="active"><a href="{{ route('home') }}">Home</a></li>
                         <li><a href="#">Jain Collection</a>
                             <ul class="dropdown">
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'mahavir']) }}">Mahavir
                                         Statue</a></li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'parasnath']) }}">Parasnath
                                         Statue</a></li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'gautam-swami']) }}">Gautam
                                         Swami Statue</a></li>
                                 {{-- Padmavati
                                 Manibhadra
                                 Nakoda Bhairav
                                 Gautam Swami
                                 Rajendrasuri
                                 Ghantakaran Mahavir --}}
                             </ul>
                         </li>
                         <li><a href="#">Hindu Collection</a>
                             <ul class="dropdown">
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'ganesh']) }}">Ganesh</a>
                                 </li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'mahalakshmi']) }}">Mahalakshmi</a>
                                 </li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'saraswati']) }}">Saraswati</a>
                                 </li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'durga']) }}">Durga</a>
                                 </li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'krishna']) }}">Krishna</a>
                                 </li>
                                 <li><a
                                         href="{{ route('shop', ['category' => 'jain-statue', 'subcategory' => 'radha-krishan']) }}">Radha
                                         Krishna</a></li>

                                 {{-- Vishnu Lakshmi
                                 Ram Darbar
                                 Sai Baba
                                 Hanuman
                                 Shankar
                                 Shiv Parivar
                                 Tirupati Balaji --}}
                             </ul>
                         </li>
                         <li><a href="{{ route('shop', ['category' => 'all-product']) }}">All Product</a></li>

                         {{-- <li><a href="./blog.html">Customise</a></li> --}}
                         <li><a href="{{ route('contact') }}">Contact</a></li>
                     </ul>
                 </nav>
             </div>
             <div class="col-lg-3">
                 <div class="header__right">
                     <div class="header__right__auth">
                         @if (Auth::user())
                             <a href="{{ route('user.profile') }}">My Account</a>
                             <a href="{{ route('logout') }}">Logut</a>
                         @else
                             <a href="{{ route('login') }}">Login</a>
                             <a href="{{ route('register') }}">Register</a>
                         @endif
                     </div>
                     <ul class="header__right__widget">
                         <li><span class="icon_search search-switch"></span></li>
                         <li><a href="{{ route('wishlist.index') }}"><span class="icon_heart_alt"></span>
                                 <div class="tip wishlist">
                                     {{ Cart::session('wishlist')->getTotalQuantity() ?? '' }}</div>
                             </a></li>
                         <li><a href="{{ route('cart.index') }}"><span class="icon_bag_alt"></span>
                                 <div class="tip cart cart_count">{{ Cart::session('cart')->getTotalQuantity() ?? '' }}
                                 </div>
                             </a></li>
                     </ul>
                 </div>
             </div>
         </div>
         <div class="canvas__open">
             <i class="fa fa-bars"></i>
         </div>
     </div>
 </header>

 <style>
     .header {
         position: sticky;
         top: 0;
         z-index: 999;
     }

     .header__menu ul li {
         position: relative;
     }

     .header__menu .dropdown {
         position: absolute;
         top: calc(100% + 8px);
         left: 0;
         min-width: 220px;
         background: #fff;
         border: 1px solid rgba(17,17,17,0.08);
         border-radius: 14px;
         box-shadow: 0 18px 35px rgba(17,17,17,0.08);
         padding: 10px;
         list-style: none;
         opacity: 0;
         visibility: hidden;
         transform: translateY(10px);
         transition: all 0.25s ease;
         pointer-events: none;
         z-index: 1000;
     }

     .header__menu ul li:hover > .dropdown,
     .header__menu ul li:focus-within > .dropdown {
         opacity: 1;
         visibility: visible;
         transform: translateY(0);
         pointer-events: auto;
     }

     .header__menu .dropdown li {
         display: block;
     }

     .header__menu .dropdown li a {
         display: block;
         width: 100%;
         padding: 10px 12px;
         border-radius: 10px;
         text-align: left;
     }
 </style>

 {{-- @dd(Cart::count()); --}}
