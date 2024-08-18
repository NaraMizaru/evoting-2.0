@extends('layouts.app')
@section('title', 'Dashboard')

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
            <h4 class="text-primary text-center">No Elections Are Currently Active</h4>
            <p class="text-center">make an election <a href="">here</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection