<!-- resources/views/result.blade.php -->

@extends('layouts.app')

@section('title', __('messages.employee_pair_title'))

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg border-0 rounded-4 w-100" style="max-width: 700px;">
            <div class="card-header text-center bg-gradient text-white rounded-top py-4">
                <h2 class="fw-bold mb-0">{{ __('messages.employee_pair_title') }}</h2>
                <p class="mb-0">{{ __('messages.employee_pair_details') }}</p>
            </div>

            <div class="card-body p-4">
                <!-- Longest Working Pair Information -->
                @if(!$longestPair)
                    <div class="alert alert-warning text-center mb-4">
                        <p>{{ __('messages.no_pair_found') }}</p>
                    </div>
                @endif

                <!-- Employee Pairs Table -->
                <h3 class="text-center my-4">{{ __('messages.all_employee_pairs') }}</h3>
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>{{ __('messages.employee_id_1') }}</th>
                        <th>{{ __('messages.employee_id_2') }}</th>
                        <th>{{ __('messages.project_id') }}</th>
                        <th>{{ __('messages.days_worked') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($employeePairs as $pair => $days)
                        <tr>
                            <td>{{ explode('-', $pair)[0] }}</td>
                            <td>{{ explode('-', $pair)[1] }}</td>
                            <td>{{ explode('-', $pair)[2] }}</td>
                            <td>{{ $days }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

