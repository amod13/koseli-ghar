@extends('site.main.app')
@section('content')
@include('alert.sitemessage')

<!-- breadcrumb area start -->
<section class="breadcrumb__area box-plr-75">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__wrapper">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                          <li class="breadcrumb-item active" aria-current="page">Thank You</li>
                        </ol>
                      </nav>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb area end -->

<style>
    .wrapper-1 {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .wrapper-2 {
        padding: 30px;
        text-align: center;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0px 4px 16px rgba(0, 0, 0, 0.1);
    }

    .wrapper-2 h1 {
        font-family: 'Kaushan Script', cursive;
        font-size: 4em;
        letter-spacing: 3px;
        color: #5892FF;
        margin: 0;
        margin-bottom: 20px;
    }

    .wrapper-2 p {
        margin: 0;
        font-size: 1.3em;
        color: #777;
        font-family: 'Source Sans Pro', sans-serif;
        letter-spacing: 1px;
    }

    .go-home {
        color: #fff;
        background: #5892FF;
        border: none;
        padding: 10px 50px;
        margin: 30px 0;
        border-radius: 30px;
        text-transform: capitalize;
        box-shadow: 0 10px 16px 1px rgba(174, 199, 251, 1);
        transition: all 0.3s ease;
    }

    .go-home:hover {
        cursor: pointer;
        background: #4678CC;
    }

    .footer-like {
        margin-top: auto;
        background: #D7E6FE;
        padding: 6px;
        text-align: center;
    }

    .footer-like p {
        margin: 0;
        padding: 4px;
        color: #5892FF;
        font-family: 'Source Sans Pro', sans-serif;
        letter-spacing: 1px;
    }

    .footer-like p a {
        text-decoration: none;
        color: #5892FF;
        font-weight: 600;
    }

    @media (min-width: 600px) {
        .wrapper-1 {
            max-width: 700px;
            margin: 0 auto;
            height: auto;
        }

        .go-home {
            padding: 12px 60px;
        }
    }
</style>

<div class="content mb-4">
    <div class="wrapper-1">
        <div class="wrapper-2">
            <h1>Thank You!</h1>
            <p>Thanks for your order.</p>
            <p>You should receive a confirmation email soon.</p>
            <a href="{{ url('/') }}">
                <button class="go-home">
                    Go Home
                </button>
            </a>
        </div>
    </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Kaushan+Script&family=Source+Sans+Pro:wght@300;400&display=swap" rel="stylesheet">
@endsection
