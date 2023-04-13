@extends('layouts.main')

@section('title', 'Contact App | Add new company')

@section('content')
    <main class="py-5">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-title">
                            <strong>Add New Company</strong>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('companies.store') }}" method="POST">
                                @csrf
                                @include('companies._from')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
