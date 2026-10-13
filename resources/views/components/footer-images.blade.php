<div class="instagram-gallery">
    <div class="container">
        <div class="instagram-header text-center">
            <span class="section-kicker">Instagram</span>
            <h3>@moortijeevan</h3>
            <p>Handpicked spiritual pieces that bring home a sense of peace, beauty, and devotion.</p>
        </div>

        <div class="row g-3">
            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ URL::asset('/img/instagram/ganesh.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Ganesh</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ asset('img/instagram/lakshmi.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Lakshmi</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ asset('img/instagram/nakoda-bhairav.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Nakoda</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ URL::asset('/img/instagram/parshawanath.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Parshwanath</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ asset('img/instagram/radha-krishan.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Radha</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                <div class="instagram__item set-bg" data-setbg="{{ asset('img/instagram/sharashwati.jpeg') }}">
                    <div class="instagram__text">
                        <i class="fa fa-instagram"></i>
                        <a href="#">Saraswati</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .instagram-gallery {
        padding: 54px 0 10px;
        background: #f8f4f0;
    }

    .instagram-header {
        margin-bottom: 24px;
    }

    .section-kicker {
        display: inline-block;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        color: #874f2e;
        margin-bottom: 10px;
    }

    .instagram-header h3 {
        font-size: clamp(2rem, 2.4vw, 2.5rem);
        font-weight: 800;
        margin: 0;
        color: #1d1d1d;
    }

    .instagram-header p {
        margin: 10px auto 0;
        max-width: 640px;
        color: #6b6b6b;
    }

    .instagram-gallery .instagram__item {
        position: relative;
        height: 260px;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid rgba(17,17,17,0.06);
        box-shadow: 0 18px 32px rgba(17,17,17,0.06);
        background-size: cover;
        background-position: center;
    }

    .instagram-gallery .instagram__text {
        position: absolute;
        inset: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background: rgba(17, 17, 17, 0.36);
        color: #fff;
        opacity: 0;
        transition: 0.3s ease;
    }

    .instagram-gallery .instagram__item:hover .instagram__text {
        opacity: 1;
    }

    .instagram-gallery .instagram__text i {
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .instagram-gallery .instagram__text a {
        color: #fff;
        font-weight: 700;
        letter-spacing: 0.04em;
    }
</style>

