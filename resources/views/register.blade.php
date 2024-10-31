@extends('layout')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Register</div>

            <div class="card-body">
                <form action="{{ route('register') }}" method="post">
                    @csrf

                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end text-start">{{ __('Name') }}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>

                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end text-start">{{ __('Email Address') }}</label>

                        <div class="col-md-6">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="faculty" class="col-md-4 col-form-label text-md-end text-start">{{ __('Faculty') }}</label>

                        <div class="col-md-6">
                            <input type="text" class="form-control @error('faculty') is-invalid @enderror" id="faculty" name="faculty" value="{{ old('faculty') }}" required>

                            @if ($errors->has('faculty'))
                                <span class="text-danger">{{ $errors->first('faculty') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-md-4 col-form-label text-md-end text-start">{{ __('Password') }}</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>

                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-end text-start">{{ __('Confirm Password') }}</label>

                        <div class="col-md-6">
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Register') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
