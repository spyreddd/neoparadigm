@extends('layouts.user.master')

@push('css')
<style>
.card-h100 {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.card-img-container {
    position: relative;
    width: 100%;
    padding-top: 150%; /* This ratio can be adjusted to match your desired aspect ratio */
    overflow: hidden;
    border-radius: 10px;
    flex-shrink: 0;
    margin: 10px 0; /* Add margin to create space between the card image and the top/bottom */
}

.card-img-container img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.card-img-container img:hover {
    transform: scale(1.05);
}

.blog_content {
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Ensure there is margin between cards */
.row > .col-xl-4,
.row > .col-md-6 {
    margin-bottom: 20px; /* Adjust as needed */
}

.bordered-content {
    border: 2px solid #f0f0f0; /* Light gray border */
    padding: 20px;
    border-radius: 10px;
    background: #fff; /* White background */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow */
    transition: box-shadow 0.3s ease;
    margin-top: 20px;
}

.bordered-content:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Slightly larger shadow on hover */
}

.bordered-content h3 {
    /* border-bottom: 2px solid #ff324d; Red underline for headings */
    padding-bottom: 5px;
    margin-bottom: 15px;
}

.bordered-content p, .bordered-content ol {
    margin-bottom: 15px;
}

.bordered-content ol {
    padding-left: 20px;
}

.bordered-content ol li {
    margin-bottom: 10px;
}

</style>
@endpush


@section('content')
    <!-- START SECTION CONTACT -->
    <div class="section pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-map2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Address</span>
                            <p>{{env('APP_ADDRESS')}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-envelope-open"></i>
                        </div>
                        <div class="contact_text">
                            <span>Email Address</span>
                            <a href="mailto:neoparadigmcomicsindonesia@gmail.com">{{env('APP_EMAIL')}} </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3">
                        <div class="contact_icon">
                            <i class="linearicons-tablet2"></i>
                        </div>
                        <div class="contact_text">
                            <span>Phone</span>
                            <p>{{env('APP_PHONE')}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION CONTACT -->

    <!-- START SECTION CONTACT -->
    <div class="section pt-0">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="heading_s1">
                        <h2>{{ config('app.name') }}</h2>
                    </div>
                    <p class="leads">{{ env('APP_DESCRIPTION') }}</p>
                </div>
            </div>
        </div>
    </div>

<!-- START SECTION NPC -->
<div class="section pb_20">
    <div class="container">
        <div class="row">
            <div class="col-md-6 ">
                <div class="p-3 single_banner text-white">
                    <img src="{{asset('assets/images/npc1.png')}}" alt="npc1" />
                    <div class="single_banner_info">
                    </div>
                </div>
            </div>
                <div class="col-md-6">
                    <div class="single_banner">
                        <img src="{{asset('assets/images/npc3.png')}}" alt="npc3" />
                        <div class="single_banner_info">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION NPC -->

<!-- START SECTION VISI DAN MISI -->
<div class="section pt-0">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="heading_s1">
                    <h2>Visi dan Misi</h2>
                </div>
                <div class="bordered-content">
                    <h3>Visi</h3>
                    <p>Menjadi studio komik profesional yang mampu bersaing, baik di lingkup lokal maupun internasional.</p>
                    <h3>Misi</h3>
                    <ol>
                        <li>Memuliakan komik Indonesia sebagai salah satu bentuk karya seni dan media berekspresi.</li>
                        <li>Meningkatkan kecintaan masyarakat terhadap komik Indonesia melalui penerbitan karya-karya komik yang bermutu dan kontinyu.</li>
                        <li>Membina dan menjadi wadah bagi para talent dalam mempublikasikan karya-karyanya secara profesional.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END SECTION VISI DAN MISI -->



    <!-- START SECTION EMPLOYEE -->
    <div class="section pb_70">
        <div class="container">
            <div class="row">
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100">
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Dwi Aspitono.png')}}" alt="dwi" />
                        </div>
                        <div class="contact_text">
                            <span>Dwi Aspitono</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Penciler, Inker, Writer
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100">
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Berny Julianto.png')}}" alt="berny" />
                        </div>
                        <div class="contact_text">
                            <span>Berny Julianto</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Writer, Colorist, Editor, CEO
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100">
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Kasmiyanto Samad.png')}}" alt="gino" />
                        </div>
                        <div class="contact_text">
                            <span>Kasmiyanto Samad (Gino)</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Penciler, Inker
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100">
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Arief Hargono.png')}}" alt="arief" />
                        </div>
                        <div class="contact_text">
                            <span>Arief Hargono</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Penciler, Writer
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100 d-none"> <!-- Add d-none class here -->
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Berny Julianto.png')}}" alt="berny" />
                        </div>
                        <div class="contact_text">
                            <span>Berny Julianto</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Writer, Colorist, Editor, CEO
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="contact_wrap contact_style3 card-h100">
                        <div class="card-img-container">
                            <img src="{{asset('assets/images/Arkan.jpg')}}" alt="arkan" />
                        </div>
                        <div class="contact_text">
                            <span>Arkan</span>
                            <li class="d-flex justify-content-center" style="list-style-type: none; margin: 0; padding: 0;">
                                as
                            </li>
                            <li class="d-flex justify-content-center fw-bold" style="list-style-type: none; margin: 0; padding: 0; color: rgb(255, 50, 77);">
                                Website Developer
                            </li>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END SECTION EMPLOYEE -->
                </div>
            </div>
        </div>
@endsection
