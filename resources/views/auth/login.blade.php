<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>{{ config('app.name', 'Laravel') }} - Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- <title>{{ config('app.name', 'IngramMicroGBS') }}</title> --}}

        {{-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> --}}
        {{-- <link rel="icon" href="{{asset('images/icon.png')}}"> --}}
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}" type="text/css"> --}}
        {{-- <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet"> --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="{{ asset('css/plugins/iziToast.min.css') }}"> --}}

        <style>
            * { box-sizing: border-box }
            body { background: #f7fafc; font-family: 'Roboto', sans-serif; }
            main {
                align-items: center;
                display: flex;
                justify-content: center;
                height: 100%;
                position: fixed;
                width: 100%;
            }
            form { width: 100%; }

            h6 { margin-bottom: 2.5rem; color: #a0aec0; font-weight: 500; margin-top: 0; }
            .inner-wrapper {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }
            .branding { display: flex; padding: 2rem; margin-bottom: 1.25rem; height: 120px; }
            .im-logo { margin-right: 0.5rem; padding-right: .5rem; position:relative; padding-top: .6rem;}
            .im-logo::after {
                display: block;
                height: 100%;
                width: 2px;
                position: absolute;
                top: 0;
                right: 0;
                content: '';
                background-color: #a0aec0;
             }
            .im-logo img, .gbs-logo img { object-fit: cover; height: 2rem; }
            .gbs-logo .tower { color: #718096; font-size: .75rem; }
            .login-form {
                background: white;
                border-radius: 0.25rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                display: flex;
                height: 100%;
                padding: 1.25rem 2rem;
                width: 400px;
            }
            .inner-form {
                display: flex;
                flex-direction: column;
                height: 100%;
                width: 100%;
                align-items: center;
            }
            .form-label { color: #a0aec0; }
            .btn {
                width: 100%;
            }
            .btn-light, .btn-primary { box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.2); }
            .btn-primary {
                background: #7D6086;
                outline: #7D6086;
                border-color: #7D6086;
            }
            .btn-primary:hover {
                background: #503d56;
                outline: #503d56;
                border-color: #503d56;
            }
            .display { color: #7D6086; }
        </style>
    </head>
    <body>

        <main class="wrapper">
            <div class="inner-wrapper">
                <div class="branding">
                    <div class="im-logo">
                        <img src="https://imgbsdevfs01.s3-ap-southeast-1.amazonaws.com/dna/images/logos/im-logo-black.png" alt="Ingram Logo">
                    </div>
                    <div class="gbs-logo">
                        <img src="https://imgbsdevfs01.s3-ap-southeast-1.amazonaws.com/dna/images/logos/gbs-logo-black.png" alt="Ingram GBS Logo">
                        <p class="tower">DIGITALIZATION AND APPLICATIONS</p>
                    </div>
                </div>

                <section class="login-form">
                    <div class="inner-form">

                        <p class="mb-0">Log in to continue to:</p>
                        <h3 class="display mt-2 mb-4">{{ config('app.name', 'Project Excelerate') }}</h3>
                        <!-- <h3 class="display mt-2 mb-4 text-center">Scorecard v2.0</h3> -->

                        <form action="{{ route('login') }}" method="POST">
                            @csrf

                            @if($errors->any())
                                @foreach ($errors->all() as $error)
                                    <small class="text-danger">{{ $error }}</small>
                                @endforeach
                            @endif

                            <div class="form-group">
                                <input id="email" name="email" type="text" class="form-control" v-model="email" required autofocus>
                                <small class="text-muted">Email</small>
                            </div>

                            <div class="form-group">
                                <input id="password" name="password" type="password" class="form-control" v-model="password" required>
                                <small class="text-muted">Password</small>
                            </div>

                            <!-- <div class="d-flex justify-content-between align">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                                    <label class="custom-control-label text-muted" for="customCheck1">Remember Me</label>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#forgot-password"> Forgot Password </a>
                            </div> -->

                            <button class="btn btn-primary mt-3" type="submit"> Login </button>

                            {{-- <a href="{{ route('sso.login') }}" class="btn btn-light"> --}}
                                {{-- <img src="https://imgbsdevfs01.s3-ap-southeast-1.amazonaws.com/dna/images/vendor-logos/microsoft-logo.319d9b9a.svg" alt="Microsoft" style="height: 18px; margin-right: 8px; width: 18px;"> --}}
                                <!-- <img src="{{ asset("/assets/images/microsoft.png")}}" alt="Microsoft" style="height: 18px; margin-right: 8px; width: 18px;">
                                Continue with Microsoft </a> -->
                        </form>

                    </div>
                </section>

                <a class="btn btn-link" target="_blank" href="http://corp.ingrammicro.com/Terms-of-Use/Privacy-Statement.aspx">
                    <small>{{ __('Privacy Policy') }}</small>
                </a>
            </div>
        </main>

        <!--  Extract Report Modal -->
        <div class="modal fade" id="forgot-password" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="forgot-password" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Forgot Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    {{-- <form class="form-group col" method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row mt-4">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>

                        </div> --}}
                        <div class="d-flex justify-content-end">
                            <div class="col-md-4" style="margin-right: 7.5rem;">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>
{{--
                    </form> --}}

                </div>
            </div>
        </div>
    </body>
</html>
