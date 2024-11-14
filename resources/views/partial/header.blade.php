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
                     <a href="{{ route('home') }}"><img src="{{ URL::asset('/public/img/logo.png') }}"
                             alt=""></a>
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
                         <a href="{{ route('login') }}">Login</a>
                         <a href="{{ route('register') }}">Register</a>
                     </div>
                     <ul class="header__right__widget">
                         <li><span class="icon_search search-switch"></span></li>
                         <li><a href="#"><span class="icon_heart_alt"></span>
                                 <div class="tip">2</div>
                             </a></li>
                         <li><a href="{{ route('shopCart') }}"><span class="icon_bag_alt"></span>
                                 <div class="tip">2</div>
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
