@extends('layouts.app')
@section('title', 'Dashboard')

@push('css')
<link rel="stylesheet" href="{{ asset('css/Clients/join-pemilu.css') }}">
{{-- Custom CSS for This Page --}}
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-primary">Daftar Kandidat | {{ $pemilu->name }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($kandidat as $item)
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="card h-500">
                                    <div class="card-header">
                                        <div class="row kandidat">
                                            <div class="col">
                                                <h6 class="card-title text-primary">{{ $item->name }}</h6>
                                            </div>
                                            <button class="btn btn-warning btn-sm">Visi & Misi</button>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-center bx-img">
                                            <img src="{{ asset('storage/upload/' . $item->image) }}" alt=""
                                                class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Custom JS for This Page --}}
@endpush
