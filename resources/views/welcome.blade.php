@extends('partial/layouts')

@section('title', 'Moorti Store | Spiritual Home Decor')

@push('header')
    <style>
        .modern-home {
            background: #f8f4f0;
            color: #1c1c1c;
        }

        .hero-modern {
            position: relative;
            background: linear-gradient(135deg, #f0e6dc 0%, #f8f4f0 45%, #f5efe8 100%);
            overflow: hidden;
            padding: 60px 0 40px;
        }

        .hero-modern::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(162, 109, 74, 0.12), transparent 40%);
        }

        .hero-modern .container {
            position: relative;
            z-index: 1;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(28, 28, 28, 0.08);
            border-radius: 999px;
            padding: 8px 16px;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
            color: #7a4a2a;
            margin-bottom: 18px;
        }

        .hero-title {
            font-size: clamp(2.4rem, 5vw, 4.5rem);
            line-height: 1.06;
            font-weight: 800;
            margin-bottom: 16px;
            color: #171717;
        }

        .hero-text {
            font-size: 1.08rem;
            color: rgba(27, 27, 27, 0.72);
            max-width: 560px;
            margin-bottom: 28px;
        }

        .hero-actions {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .primary-btn,
        .secondary-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 15px 28px;
            font-weight: 700;
            letter-spacing: 0.03em;
            transition: all 0.3s ease;
        }

        .primary-btn {
            background: linear-gradient(135deg, #1a1a1a 0%, #4b2a1d 100%);
            color: #fff;
            box-shadow: 0 14px 28px rgba(20, 20, 20, 0.18);
        }

        .secondary-btn {
            background: rgba(255, 255, 255, 0.7);
            color: #1a1a1a;
            border: 1px solid rgba(0, 0, 0, 0.08);
        }

        .primary-btn:hover,
        .secondary-btn:hover {
            transform: translateY(-2px);
            color: #fff;
        }

        .hero-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 30px;
        }

        .hero-stat .stat-box {
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(17, 17, 17, 0.06);
            border-radius: 16px;
            padding: 14px 18px;
            min-width: 120px;
        }

        .stat-box strong {
            display: block;
            font-size: 1.35rem;
            color: #171717;
        }

        .stat-box span {
            font-size: 12px;
            color: rgba(17, 17, 17, 0.7);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .hero-visual {
            position: relative;
            min-height: 520px;
        }

        .feature-photo {
            position: absolute;
            right: 0;
            top: 30px;
            width: 92%;
            height: 500px;
            border-radius: 36px;
            overflow: hidden;
            box-shadow: 0 32px 60px rgba(20, 20, 20, 0.12);
            background: #ddd;
        }

        .feature-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .floating-card {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(20, 20, 20, 0.06);
            border-radius: 18px;
            padding: 18px 20px;
            backdrop-filter: blur(6px);
            box-shadow: 0 18px 40px rgba(20, 20, 20, 0.08);
            max-width: 230px;
        }

        .floating-card.card-one {
            left: 20px;
            bottom: 40px;
        }

        .floating-card.card-two {
            right: 18px;
            top: 0;
        }

        .floating-card h6 {
            margin: 0 0 6px;
            color: #1d1d1d;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .floating-card strong {
            font-size: 1.5rem;
            color: #171717;
        }

        .floating-card small {
            display: block;
            margin-top: 8px;
            color: rgba(17, 17, 17, 0.75);
        }

        .section-modern {
            padding: 70px 0;
        }

        .section-head {
            display: flex;
            justify-content: space-between;
            align-items: end;
            margin-bottom: 28px;
            gap: 20px;
        }

        .section-head .section-title {
            margin: 0;
        }

        .section-head .section-title h2,
        .section-head .section-title h4 {
            font-weight: 800;
            margin: 0;
            color: #171717;
        }

        .section-head p {
            color: rgba(17, 17, 17, 0.7);
            margin: 0;
        }

        .pill-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #fff;
            border: 1px solid rgba(17, 17, 17, 0.08);
            color: #171717;
            padding: 10px 18px;
            border-radius: 999px;
            font-weight: 600;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 22px;
        }

        .category-card {
            position: relative;
            min-height: 310px;
            border-radius: 26px;
            overflow: hidden;
            background: #ddd;
        }

        .category-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .category-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0,0,0,0) 35%, rgba(0,0,0,0.72) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 22px;
            color: #fff;
        }

        .category-card h4 {
            margin: 0 0 5px;
            font-weight: 700;
            color: #fff;
        }

        .category-card p {
            margin: 0 0 15px;
            color: rgba(255,255,255,0.8);
        }

        .category-card a {
            display: inline-flex;
            align-items: center;
            width: fit-content;
            color: #fff;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.8);
            padding-bottom: 2px;
        }

        .promo-banner {
            background: linear-gradient(135deg, #1b1b1b 0%, #4d3024 100%);
            border-radius: 30px;
            padding: 50px 42px;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .promo-banner::before {
            content: "";
            position: absolute;
            right: -110px;
            top: -40px;
            width: 340px;
            height: 340px;
            border-radius: 50%;
            background: rgba(255,255,255,0.06);
        }

        .promo-banner .row {
            position: relative;
            z-index: 1;
        }

        .promo-banner .small-tag {
            display: inline-block;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: rgba(255,255,255,0.73);
            margin-bottom: 14px;
        }

        .promo-banner h2 {
            font-size: clamp(2rem, 4vw, 3.2rem);
            margin: 0 0 12px;
            color: #fff;
            font-weight: 800;
        }

        .promo-banner p {
            color: rgba(255,255,255,0.78);
            max-width: 500px;
            margin-bottom: 24px;
        }

        .promo-banner .primary-btn {
            background: #fff;
            color: #171717;
            box-shadow: none;
        }

        .product-section .product__item {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            border: 1px solid rgba(17, 17, 17, 0.04);
        }

        .product-section .product__item__pic {
            height: 260px;
        }

        .product-section .product__item__text {
            padding: 18px 18px 20px;
        }

        .trend-list {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 22px;
        }

        .mini-card {
            background: #fff;
            border-radius: 22px;
            border: 1px solid rgba(17, 17, 17, 0.06);
            padding: 18px;
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .mini-card .thumb {
            width: 90px;
            height: 90px;
            border-radius: 18px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .mini-card .thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .mini-card h6 {
            margin: 0 0 8px;
            font-weight: 700;
            color: #171717;
        }

        .mini-card .product__price {
            margin: 0;
            font-size: 1.05rem;
            color: #171717;
        }

        .features-wrap {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 24px;
            margin-top: 20px;
        }

        .feature-box {
            background: #fff;
            border: 1px solid rgba(17, 17, 17, 0.05);
            border-radius: 20px;
            padding: 28px 20px;
            text-align: center;
        }

        .feature-box i {
            font-size: 2.1rem;
            color: #7a4a2a;
            margin-bottom: 14px;
        }

        .feature-box h6 {
            font-weight: 700;
            margin-bottom: 8px;
            color: #171717;
        }

        .feature-box p {
            margin: 0;
            color: rgba(17, 17, 17, 0.7);
        }

        @media (max-width: 991px) {
            .category-grid,
            .features-wrap,
            .trend-list {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero-visual {
                margin-top: 20px;
                min-height: 420px;
            }
        }

        @media (max-width: 767px) {
            .category-grid,
            .features-wrap,
            .trend-list {
                grid-template-columns: 1fr;
            }

            .hero-modern {
                padding-top: 36px;
            }

            .hero-stat {
                flex-direction: column;
                align-items: stretch;
            }

            .feature-photo {
                width: 100%;
                right: 0;
            }
        }
    </style>
@endpush

@section('content')
    <section class="modern-home">
        <div class="hero-modern">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="hero-badge">Curated spiritual art</div>
                        <h1 class="hero-title">Bring peace, beauty, and devotion home.</h1>
                        <p class="hero-text">
                            Discover handcrafted statues and idols inspired by Jain and Hindu traditions.
                            Thoughtfully designed for sacred spaces, elegant interiors, and meaningful gifting.
                        </p>
                        <div class="hero-actions">
                            <a href="{{ route('shop', ['category' => 'all-product']) }}" class="primary-btn">Shop collection</a>
                            <a href="{{ route('about') }}" class="secondary-btn">Learn more</a>
                        </div>
                        <div class="hero-stat">
                            <div class="stat-box">
                                <strong>1200+</strong>
                                <span>Unique pieces</span>
                            </div>
                            <div class="stat-box">
                                <strong>4.9/5</strong>
                                <span>Customer love</span>
                            </div>
                            <div class="stat-box">
                                <strong>48h</strong>
                                <span>Fast dispatch</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="hero-visual">
                            <div class="feature-photo">
                                <img src="{{ URL::asset('/img/categories/parasnath-moorti.jpg') }}" alt="Featured collection">
                            </div>
                            <div class="floating-card card-one">
                                <h6>Most loved</h6>
                                <strong>Jain statues</strong>
                                <small>Handpicked spiritual decor</small>
                            </div>
                            <div class="floating-card card-two">
                                <h6>Premium range</h6>
                                <strong>₹1999+</strong>
                                <small>Elegant idol collection</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section class="section-modern">
            <div class="container">
                <div class="section-head">
                    <div class="section-title">
                        <h2>Shop by collection</h2>
                    </div>
                    <a href="{{ route('shop', ['category' => 'all-product']) }}" class="pill-btn">View all</a>
                </div>

                <div class="category-grid">
                    <div class="category-card">
                        <img src="{{ URL::asset('/img/categories/ganesh-moorti.jpg') }}" alt="Hindu Statue">
                        <div class="overlay">
                            <h4>Hindu Statue</h4>
                            <p>358 curated pieces</p>
                            <a href="{{ route('shop', ['category' => 'hindu-statue']) }}">Shop now</a>
                        </div>
                    </div>

                    <div class="category-card">
                        <img src="{{ URL::asset('/img/categories/mahavir-moorti.jpg') }}" alt="Mahavir Moorti">
                        <div class="overlay">
                            <h4>Mahavir Moorti</h4>
                            <p>273 handcrafted idols</p>
                            <a href="{{ route('shop', ['category' => 'mahavir']) }}">Shop now</a>
                        </div>
                    </div>

                    <div class="category-card">
                        <img src="{{ URL::asset('/img/categories/parasnath-statue.jpg') }}" alt="Parasnath Moorti">
                        <div class="overlay">
                            <h4>Parasnath Moorti</h4>
                            <p>159 sacred designs</p>
                            <a href="{{ route('shop', ['category' => 'parasnath']) }}">Shop now</a>
                        </div>
                    </div>

                    <div class="category-card">
                        <img src="{{ URL::asset('/img/categories/gautam-swami-moorti.jpg') }}" alt="Gautam Swami Moorti">
                        <div class="overlay">
                            <h4>Gautam Swami</h4>
                            <p>792 classic selections</p>
                            <a href="{{ route('shop', ['category' => 'gautam-swami']) }}">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-modern product-section">
            <div class="container">
                <div class="section-head">
                    <div class="section-title">
                        <h2>New arrivals</h2>
                    </div>
                    <p>Fresh spiritual decor and standout handcrafted pieces.</p>
                </div>

                <div class="row property__gallery">
                    @foreach (($products ?? [])->take(8) as $item)
                        <div class="col-lg-3 col-md-4 col-sm-6 mix {{ $item['category']['name'] ?? '' }}">
                            <x-product-item :item="$item" />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-modern">
            <div class="container">
                <div class="promo-banner">
                    <div class="row align-items-center">
                        <div class="col-lg-7">
                            <span class="small-tag">Luxury spiritual living</span>
                            <h2>Modern spirituality, timeless craftsmanship.</h2>
                            <p>
                                Explore elegant idols and sacred decor that blend devotion with contemporary design.
                                Created for homes, temples, and gifting occasions alike.
                            </p>
                            <a href="{{ route('shop', ['category' => 'jain-statue']) }}" class="primary-btn">Explore premium picks</a>
                        </div>
                        <div class="col-lg-5 text-lg-end">
                            <img src="{{ URL::asset('/img/banner/banner-4.png') }}" alt="Premium collection" style="max-width: 100%; border-radius: 24px; opacity: 0.9;">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-modern">
            <div class="container">
                <div class="section-head">
                    <div class="section-title">
                        <h2>Trending picks</h2>
                    </div>
                    <a href="{{ route('shop', ['category' => 'all-product']) }}" class="pill-btn">See all</a>
                </div>

                <div class="trend-list">
                    @foreach (($trend ?? [])->take(3) as $item)
                        <div class="mini-card">
                            <div class="thumb">
                                <img src="{{ URL::asset($item->cover_image ?? '') }}" alt="{{ $item->title ?? '' }}">
                            </div>
                            <div>
                                <h6>{{ $item->title ?? '' }}</h6>
                                <div class="rating">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="product__price">₹{{ $item->inventory->price ?? '' }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="section-modern">
            <div class="container">
                <div class="features-wrap">
                    <div class="feature-box">
                        <i class="fa fa-truck"></i>
                        <h6>Fast delivery</h6>
                        <p>Quick dispatch across India.</p>
                    </div>
                    <div class="feature-box">
                        <i class="fa fa-shield"></i>
                        <h6>Secure payment</h6>
                        <p>Trusted checkout and safety.</p>
                    </div>
                    <div class="feature-box">
                        <i class="fa fa-certificate"></i>
                        <h6>Authentic craft</h6>
                        <p>Handcrafted spiritual pieces.</p>
                    </div>
                    <div class="feature-box">
                        <i class="fa fa-headphones"></i>
                        <h6>Expert support</h6>
                        <p>Helpful guidance every step.</p>
                    </div>
                </div>
            </div>
        </section>

        <x-FooterImages />
    </section>
@endsection
