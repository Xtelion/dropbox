@extends('layouts.old-app')

@section('content')

    <main role="main">
        <section class="jumbotron bg text-center mb-0">
            <div class="row pt-5 bg-home">
                <div class="col-sm-12 col-md-12 col-lg-6 pt-5 text-left">

                    <div class="container">
                        <h5 class="title-home pt-5 ml-5">Almacena tus archivos  <br> con más eficiencia y <b>seguridad</b></h5>
                        <p class="subtitle-home pt-4 ml-5">Obtén el espacio que necesitas. <br>Sube tus archivos y accede a ellos <br> desde cualquier dispositivo cuando quieras.</p>
                        @guest
                            <a href="{{ route('register') }}" class="btn btn-primary mt-4 ml-5">Pruébalo gratis 30 días</a>
                            <p class="mt-2 ml-5">O bien, <a href="{{ route('login') }}">cómpralo ya mismo</a></p>
                        @else
                            @if(Auth::user()->hasRole('SUBS|ADMIN'))
                                <a href="{{ route('files.create') }}" class="btn btn-danger mt-4 ml-5">Sube tus archivos</a>
                            @else
                                <a href="{{ route('register') }}" class="btn btn-primary mt-4 ml-5">Pruébalo gratis 30 días</a>
                                <p class="mt-2 ml-5">O bien, <a href="{{ route('login') }}">cómpralo ya mismo</a></p>
                            @endif
                        @endguest
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 d-none d-md-none d-lg-block shadow">
                    <div class="container"><img class="w-100 img-home" src="img/admin.png">
                    </div>
                </div>
            </div>
        </section>

        <div class="alert alert-light text-center alert-home mb-4" role="alert">
            Descubre todo el potencial que esta aplicación tiene para ti. Disponible 24/7.
        </div>

        @if(session('info'))
            <div class="container">
                <div class="alert alert-{{ session('info')[0] }}" role="alert">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">x</span>
                    <strong>Éxito</strong> {{ session('info')[1] }}
                </div>
            </div>
        @endif

        <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
            <p class="lead subtitle-home">Compara los planes y escoge el que más se adapte a lo que necesitas.</p>
        </div>

        <div class="container">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <div class="row mt-5 pt-2">
                    @foreach($plans as $plan)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="my-0 font-weight-normal">{{ $plan->plan_name }}</h4>
                            </div>
                            <div class="card-body text-left">
                                <h1 class="card-title pricing-card-title">{{ $plan->plan_price }}&euro;<small class="text-muted">/ {{ $plan->plan_duration }}</small></h1>
                                <ul class="list-unstyled mt-3 mb-4">
                                     {!! $plan->plan_description  !!}

                                </ul>
                                @guest
                                    <a href="{{ route('login') }}" class="btn btn-lg btn-block btn-outline-info">Iniciar Sesion</a>
                                @else
                                    @can('payForThis', Auth::user())
                                        @if(Auth::user()->hasRole('SUBS'))
                                            <a class="btn btn-lg btn-block btn-outline-info" disabled="">Ya estas suscrito</a>
                                        @else
                                            <form action="{{ route('subscription.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="plan_type" value="{{ $plan->plan_type }}">
                                                <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                                        {{--data-key="{{ env('STRIPE_KEY') }}"--}}
                                                        {{-- Si falla cambiar los data-key --}}
                                                        data-key="{{ config('services.stripe.key') }}"
                                                        data-amount="{{ $plan->amount }}"
                                                        data-name="Suscripcion Mensual"
                                                        data-description="Suscripcion que dura 1 meses"
                                                        data-label="Seleccionar plan"
                                                        data-image="{{asset('img/logo.png')}}"
                                                        data-email="{{ Auth()->user()->email }}"
                                                        data-locale="auto">
                                                </script>
                                            </form>
                                        @endif
                                    @else
                                        <a class="btn btn-lg btn-block btn-outline-info">No puedes suscribirte</a>
                                    @endcan
                                @endguest
                            </div>
                        </div>
                    </div>
                        @endforeach

                        </div>
                    </div>

                </div>
            </div>


            <div class="row mt-5 pt-3 mb-5">
                <div class="col-lg-4 text-center">
                    <img class="img-fluid" src="img/features/dashboard.svg" alt="Generic placeholder image" width="120">
                    <h5 class="mt-5 feature-text">Interfaz amigable</h5>
                </div>

                <div class="col-lg-4 text-center">
                    <img class="img-fluid" src="img/features/secure.svg" alt="Generic placeholder image" width="120">
                    <h5 class="mt-5 feature-text">Almacenamiento seguro</h5>
                </div>

                <div class="col-lg-4 text-center">
                    <img class="img-fluid" src="img/features/support.svg" alt="Generic placeholder image" width="120">
                    <h5 class="mt-5 feature-text">Soporte técnico</h5>
                </div>
            </div>


        </div>
    </main>

@endsection