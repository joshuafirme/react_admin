@extends('layouts.app')
@php

@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card"style="background: #2d3b40;border: none;">
                <!-- <div class="card-header">{{ __('Login') }}</div> -->

                <div class="card-body" style="margin-top:50px;">
                    <form method="POST" action="/loginUser">
                        @csrf
                        
                        <div class="form-group row">

                            <div class="col-md-5 offset-md-4">
                                <h2 style="color:#f15a22;text-align:center;">{{ settings()->app_name }}</h2>
                                <!-- <h6 style="color:#f15a22;text-align:center;"> Community Awareness for Resiliency, Efficiency & Safety</h6> -->
                                <img style="width:100%" src="{{ asset(settings()->logo) }}" class="mb-4">
                                <input id="email" type="email"  placeholder="Email Address/Username" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">

                            <div class="col-md-5 offset-md-4">
                                <input id="password" placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-md-5 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->

                         <div class="form-group row">
                            <div class="col-md-5 offset-md-4" style="text-align:center">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                       Forgot Your Password?
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-5 offset-md-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>
                        </div><br><br>
                        <div class="form-group row mb-0">
                            <div class="col-md-5 offset-md-4">
                                <a href="https://incidentapp.sassy.ph/apk/demoapp.apk" class="btn btn-success btn-block">
                                    {{ __('Download Demo') }}
                                </a>
                            </div>
                        </div>
                    </form>
                     <br>
                    <div class="text-center">
                        
                    <code style="color:#000;">Super Admin</code><br>
                    <code>superadmin@incidentapp.com</code><br>
                    <code>test1234</code><br><br>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
