<!-- Footer Section Begin -->
<footer class="footer modern-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4 col-md-6 col-sm-7">
                <div class="footer__about">
                    <div class="footer__logo">
                        <a href="{{ route('home') }}"><img src="{{ URL::asset('/img/logo.png') }}" alt="Moorti Store Logo"></a>
                    </div>
                    <p>
                        Discover handcrafted spiritual decor and timeless idols for home, temple, and gifting.
                        Thoughtfully designed to bring devotion and elegance together.
                    </p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-5">
                <div class="footer__widget">
                    <h6>Menu</h6>
                    <ul>
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                        <li><a href="{{ route('shop', ['category' => 'all-product']) }}">Shop</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-4">
                <div class="footer__widget">
                    <h6>Account</h6>
                    <ul>
                        <li><a href="{{ route('user.profile') }}">My Account</a></li>
                        <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                        <li><a href="{{ route('checkout.index') }}">Checkout</a></li>
                        <li><a href="#">Orders Tracking</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-4 col-md-8 col-sm-8">
                <div class="footer__newslatter">
                    <h6>Follow us</h6>
                    <p>Stay inspired with spiritual decor ideas and new arrivals.</p>
                    <div class="footer__social">
                        <a href="#"><i class="fa fa-facebook"></i></a>
                        <a href="#"><i class="fa fa-instagram"></i></a>
                        <a href="#"><i class="fa fa-youtube-play"></i></a>
                        <a href="#"><i class="fa fa-twitter"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="footer__copyright__text">
                    <p>Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved by <a href="{{ route('home') }}" target="_blank">Moorti Jeevan</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer Section End -->

<style>
    .modern-footer {
        background: linear-gradient(135deg, #171717 0%, #2d1e1a 100%);
        color: #f7f2ee;
        padding: 70px 0 30px;
        margin-top: 30px;
    }

    .modern-footer .footer__about p,
    .modern-footer .footer__widget li a,
    .modern-footer .footer__newslatter p,
    .modern-footer .footer__copyright__text p {
        color: rgba(255,255,255,0.74);
    }

    .modern-footer .footer__logo {
        margin-bottom: 18px;
    }

    .modern-footer .footer__logo img {
        max-width: 150px;
        filter: brightness(0) invert(1);
    }

    .modern-footer .footer__widget h6,
    .modern-footer .footer__newslatter h6 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 16px;
        font-size: 1.05rem;
    }

    .modern-footer .footer__widget ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .modern-footer .footer__widget li {
        margin-bottom: 10px;
    }

    .modern-footer .footer__widget li a:hover {
        color: #fff;
    }

    .modern-footer .footer__social {
        display: flex;
        gap: 10px;
        margin-top: 16px;
        flex-wrap: wrap;
    }

    .modern-footer .footer__social a {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: rgba(255,255,255,0.08);
        color: #fff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modern-footer .footer__social a:hover {
        background: #fff;
        color: #171717;
    }

    .modern-footer .footer__copyright__text {
        border-top: 1px solid rgba(255,255,255,0.12);
        margin-top: 30px;
        padding-top: 24px;
        text-align: center;
    }
</style>

<!-- Search Begin -->
<div class="search-model">
    <div class="h-100 d-flex align-items-center justify-content-center">
        <div class="search-close-switch">+</div>
        <form class="search-model-form">
            <input type="text" id="search-input" placeholder="Search here.....">
        </form>
    </div>
</div>
