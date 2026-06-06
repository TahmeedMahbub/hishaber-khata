@extends('contents.body')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')
    <div class="row gy-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="mdi mdi-notebook-outline text-primary mb-3" style="font-size: 3rem;"></i>
                    <h5 class="mb-1">স্বাগতম, {{ auth()->user()->name }}!</h5>
                    <p class="text-muted mb-0">
                        আপনার ব্যবসার হিসাব এখান থেকে দেখতে পারবেন।
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
