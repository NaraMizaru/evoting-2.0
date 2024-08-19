@extends('layouts.app')
@section('title', 'Dashboard')

@push('css')
  {{-- Custom CSS for This Page --}}
@endpush

@section('content')
  <div class="row">
    @if (Session::has('status'))
      <div class="col-12">
        <div class="alert alert-success border-left-success" role="alert">
          {{ session('status') }}
        </div>
      </div>
    @endif
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="p-5">
            <h4 class="text-primary text-center">Tidak Ada Pemilu Yang Sedang Aktif</h4>
            <p class="text-center">Buat Pemilu <a href="">Disini</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  {{-- Custom JS for This Page --}}
@endpush