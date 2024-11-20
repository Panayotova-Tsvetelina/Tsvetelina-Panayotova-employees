<!-- resources/views/upload.blade.php -->

@extends('layouts.app')

@section('title', __('messages.upload_employee_data')) <!-- Example for the page title -->

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <!-- Card with the upload form -->
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 500px; margin: 0 auto;">
            <div class="card-header bg-gradient text-white rounded-top py-4 d-flex flex-column justify-content-center align-items-center">
                <h2 class="fw-bold mb-0">{{ __('messages.pair_employees') }}</h2>
                <p class="mb-0">{{ __('messages.choose_file') }}</p>
            </div>
            <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">

                @if ($errors->any())
                    <div class="alert alert-danger w-100">
                        <h4 class="alert-heading">{{ __('messages.went_wrong') }}</h4>
                        <p class="mb-0">{{ __('messages.check_errors') }}</p>
                        <ul class="mb-0 list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ url('/results') }}" method="POST" enctype="multipart/form-data" class="w-100">
                    @csrf
                    <div class="mb-4 text-center">
                        <label for="file" class="form-label fs-5">{{ __('messages.choose_csv') }}</label>
                        <input type="file" name="file" id="file" class="form-control form-control-lg" accept=".csv" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary w-100 py-3 fs-5 btn-hover-effect">{{ __('messages.upload') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
