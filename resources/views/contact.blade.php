@extends('partial/layouts')
@section('title', 'Contact Moorti Jeevan | Customer Support')
@section('meta_description', 'Contact Moorti Jeevan for help with handcrafted moortis, product questions, orders, or your shopping experience.')

@push('header')
    <style>
        .contact-page {
            padding: 30px 0 80px;
        }

        .contact-hero {
            background: linear-gradient(135deg, rgba(23, 23, 23, 0.96), rgba(87, 60, 48, 0.9));
            border-radius: 30px;
            padding: 60px 40px;
            color: #fff;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .contact-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top right, rgba(255,255,255,0.2), transparent 35%);
        }

        .contact-hero > * {
            position: relative;
            z-index: 1;
        }

        .contact-hero .eyebrow {
            display: inline-block;
            padding: 8px 14px;
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 999px;
            font-size: 12px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            opacity: 0.9;
            margin-bottom: 18px;
        }

        .contact-hero h2 {
            font-size: clamp(2rem, 3vw, 3rem);
            font-weight: 800;
            margin-bottom: 12px;
            color: #fff;
        }

        .contact-hero p {
            max-width: 640px;
            margin: 0;
            color: rgba(255,255,255,0.8);
            font-size: 1rem;
        }

        .contact-card {
            background: #fff;
            border: 1px solid rgba(17, 17, 17, 0.08);
            border-radius: 24px;
            padding: 28px;
            box-shadow: none;
            height: 100%;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 18px 0;
            border-bottom: 1px solid rgba(17,17,17,0.06);
        }

        .info-list li:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-icon {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            background: rgba(184, 124, 74, 0.12);
            color: #874f2e;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            flex-shrink: 0;
        }

        .info-list h6 {
            margin: 0 0 8px;
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #6b6b6b;
            font-weight: 700;
        }

        .info-list p {
            margin: 0;
            color: #1d1d1d;
            line-height: 1.7;
            font-weight: 500;
        }

        .contact-form-wrap {
            background: #fff;
            border: 1px solid rgba(17, 17, 17, 0.08);
            border-radius: 24px;
            padding: 28px;
            box-shadow: none;
            height: 100%;
        }

        .section-label {
            font-size: 0.75rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: #874f2e;
            font-weight: 700;
            margin-bottom: 10px;
            display: block;
        }

        .contact-form-wrap h3 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 22px;
            color: #1d1d1d;
        }

        .contact-form {
            display: grid;
            gap: 16px;
        }

        .contact-form .row {
            margin-left: -8px;
            margin-right: -8px;
        }

        .contact-form .col-md-6,
        .contact-form .col-12 {
            padding-left: 8px;
            padding-right: 8px;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            border: 1px solid rgba(17,17,17,0.1);
            border-radius: 14px;
            background: #faf8f5;
            padding: 16px 18px;
            color: #1d1d1d;
            outline: none;
        }

        .contact-form input:focus,
        .contact-form textarea:focus {
            border-color: rgba(135, 79, 46, 0.5);
            box-shadow: 0 0 0 4px rgba(135, 79, 46, 0.08);
            background: #fff;
        }

        .contact-form textarea {
            min-height: 150px;
            resize: vertical;
        }

        .contact-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 999px;
            background: linear-gradient(135deg, #171717 0%, #5b4034 100%);
            color: #fff;
            font-weight: 700;
            padding: 16px 28px;
            width: auto;
            min-width: 180px;
        }

        .contact-map {
            margin-top: 30px;
            border-radius: 28px;
            overflow: hidden;
            border: 1px solid rgba(17, 17, 17, 0.08);
            box-shadow: none;
        }

        .contact-map iframe {
            width: 100%;
            min-height: 420px;
            border: 0;
            display: block;
        }

        @media (max-width: 767px) {
            .contact-hero {
                padding: 36px 20px;
            }

            .contact-card,
            .contact-form-wrap {
                padding: 20px;
            }

            .contact-form-wrap h3 {
                font-size: 1.6rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="{{ route('home') }}"><i class="fa fa-home"></i> Home</a>
                        <span>Contact</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="contact-page">
        <div class="container">
            <div class="contact-hero">
                <span class="eyebrow">Let’s Talk</span>
                <h2>We’re here to help with your spiritual finds.</h2>
                <p>Reach out for product guidance, custom requests, bulk orders, or general support. We’ll respond as quickly as possible.</p>
            </div>

            <div class="row">
                <div class="col-lg-5 col-md-12 mb-4">
                    <div class="contact-card">
                        <span class="section-label">Contact Info</span>
                        <h3 style="font-size: 2rem; font-weight: 800; margin-bottom: 18px; color: #1d1d1d;">Get in touch</h3>
                        <ul class="info-list">
                            <li>
                                <div class="info-icon"><i class="fa fa-map-marker"></i></div>
                                <div>
                                    <h6>Address</h6>
                                    <p>160 Pennsylvania Ave NW, Washington, Castle, PA 16101-5161</p>
                                </div>
                            </li>
                            <li>
                                <div class="info-icon"><i class="fa fa-phone"></i></div>
                                <div>
                                    <h6>Phone</h6>
                                    <p><span>125-711-811</span><br><span>125-668-886</span></p>
                                </div>
                            </li>
                            <li>
                                <div class="info-icon"><i class="fa fa-headphones"></i></div>
                                <div>
                                    <h6>Support</h6>
                                    <p>support.moorti@gmail.com</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 mb-4">
                    <div class="contact-form-wrap">
                        <span class="section-label">Send a Message</span>
                        <h3>We’d love to hear from you</h3>
                        <form action="{{ route('contact') }}" method="post" class="contact-form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name" placeholder="Your name" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email" placeholder="Your email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <input type="tel" name="phone" placeholder="Phone number" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <textarea name="message" placeholder="Write your message"></textarea>
                                </div>
                            </div>
                            <button type="submit" class="contact-submit">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="contact-map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d48158.305462977965!2d-74.13283844036356!3d41.02757295168286!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c2e440473470d7%3A0xcaf503ca2ee57958!2sSaddle%20River%2C%20NJ%2007458%2C%20USA!5e0!3m2!1sen!2sbd!4v1575917275626!5m2!1sen!2sbd"
                    allowfullscreen="">
                </iframe>
            </div>
        </div>
    </section>

    <x-FooterImages />
@endsection

@push('footer')
@endpush
