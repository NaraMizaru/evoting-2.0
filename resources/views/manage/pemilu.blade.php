@extends('layouts.app')
@section('title', 'Manage Pemilu')

@push('css')
    {{-- Custom CSS for This Page --}}
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($errors->any())
                <div class="alert alert-danger border-left-danger" role="alert">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif

            @if (Session::has('success'))
                <div class="alert alert-success border-left-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if (Session::has('error'))
                <div class="alert alert-success border-left-success" role="alert">
                    {{ Session::get('error') }}
                </div>
            @endif
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h4 class="text-primary card-title">Kelola Pemilu</h4>
                        </div>
                        <button data-target="#addPemiluModal" data-toggle="modal" class="btn btn-success mr-1"><i
                                class="fa-regular fa-plus"></i></button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered w-100 nowrap" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Nama Pemilu</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pemilu as $item)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->status ? 'Aktif' : 'Nonaktif' }}</td>
                                    <td>
                                        <a href="{{ route('admin.manage.pemilu.kandidat', $item->slug) }}" class="btn btn-success"><i class="fa-regular fa-ranking-star"></i></a>
                                        <button href="" class="btn btn-primary"><i class="fa-regular fa-edit"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPemiluModal" tabindex="-1" role="dialog" aria-labelledby="addPemiluModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPemiluModalLabel">Tambah Pemilu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('admin.manage.pemilu.add') }}" method="POST" id="pemilu-form">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pemilu</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Masukkan nama pemilu">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" id="decription" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Private</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private" id="radio-private-yes"
                                    value="1" checked>
                                <label class="form-check-label" for="is_private1">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private" id="radio-private-no"
                                    value="0">
                                <label class="form-check-label" for="is_private2">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="add-pemilu-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="password" class="form-control"
                                placeholder="Masukan password">
                        </div>
                        <div class="form-group" id="add-pemilu-group">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    id="status-checkbox" checked>
                                <label class="form-check-label" for="status-checkbox">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    {{-- Custom JS for This Page --}}
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#table-1').DataTable({
                responsive: true
            });

            $('#radio-private-yes, #radio-private-no').on('change', function() {
                if ($('#radio-private-yes').is(':checked')) {
                    $('#add-pemilu-group').removeClass('d-none');
                } else {
                    $('#add-pemilu-group').addClass('d-none');
                }
            });

            $('#pemilu-form').on('submit', function() {
                if (!$('#status-checkbox').is(':checked')) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'status',
                        value: '0'
                    }).appendTo('#pemilu-form');
                }
            });
        })
    </script>
@endpush
