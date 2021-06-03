@extends('layouts.app',['class' => 'email-page', 'page' => 'XAVIE', 'contentClass' => 'email-page', 'section' => 'auth'])

@section('content')
    <div class="col-lg-4 col-md-6 ml-auto mr-auto">

        @if (session('status'))
            <div class="alert alert-success" role="alert" style="position: absolute ; top: -104px ; right: 0"  >
                {{ session('status') }}
            </div>
        @endif
                        <form class="form" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="card card-login card-white">
                                <div class="card-header">
                                    <img src="{{ asset('assets') }}/img/card-primary.png" alt="">
                                    <h1 class="card-title">Email</h1>
                                </div>

                                <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="tim-icons icon-email-85"></i>
                                        </div>
                                    </div>
                                    <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email">

                                    @include('alerts.feedback', ['field' => 'email'])
                                </div>

{{--                            <div class="form-group row">--}}
{{--                                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                                <div class="col-md-6">--}}
{{--                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>--}}

{{--                                    @error('email')--}}
{{--                                    <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}


                                <div class="card-footer">
                                    <button type="submit" href="" class="btn btn-primary btn-lg btn-block mb-3">Send Password Reset Link</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
