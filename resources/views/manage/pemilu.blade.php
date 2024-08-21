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
                <div class="alert alert-danger border-left-danger" role="alert">
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
                                        <a href="{{ route('admin.manage.pemilu.kandidat', $item->slug) }}"
                                            class="btn btn-success"><i class="fa-regular fa-ranking-star"></i></a>
                                        <button onclick="edit('{{ $item->slug }}')" class="btn btn-primary"><i
                                                class="fa-regular fa-edit"></i></button>
                                        <button data-target="#resultPemiluModal" data-toggle="modal"
                                            class="btn btn-secondary"><i
                                                class="fa-regular fa-square-poll-vertical"></i></button>
                                        <a href="{{ route('admin.manage.pemilu.delete', $item->slug) }}" data-confirm-delete="true" class="btn btn-danger"><i class="fa-regular fa-trash"></i></a>
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
                <form action="{{ route('admin.manage.pemilu.add') }}" method="POST" id="add-pemilu-form">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pemilu</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Masukkan nama pemilu">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" id="description" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Private</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private" id="add-radio-private-yes"
                                    value="1" checked>
                                <label class="form-check-label" for="is_private1">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private" id="add-radio-private-no"
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
                                    id="add-status-checkbox" checked>
                                <label class="form-check-label" for="add-status-checkbox">
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

    <div class="modal fade" id="editPemiluModal" tabindex="-1" role="dialog" aria-labelledby="editPemiluModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPemiluModalLabel">Edit Pemilu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="POST" id="edit-pemilu-form">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Pemilu</label>
                            <input type="text" class="form-control" name="name" id="edit-name"
                                placeholder="Masukkan nama pemilu">
                        </div>
                        <div class="form-group">
                            <label for="description">Deskripsi</label>
                            <textarea class="form-control" name="description" id="edit-description" cols="30" rows="5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Private</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private"
                                    id="edit-radio-private-yes" value="1" checked>
                                <label class="form-check-label" for="is_private1">
                                    Ya
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="is_private"
                                    id="edit-radio-private-no" value="0">
                                <label class="form-check-label" for="is_private2">
                                    Tidak
                                </label>
                            </div>
                        </div>
                        <div class="form-group" id="edit-pemilu-group">
                            <label for="password">Password</label>
                            <input type="text" name="password" id="edit-password" class="form-control"
                                placeholder="Masukan password">
                        </div>
                        <div class="form-group" id="edit-pemilu-group">
                            <label for="status">Status</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="status" value="1"
                                    id="edit-status-checkbox" checked>
                                <label class="form-check-label" for="status-checkbox">
                                    Aktif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="resultPemiluModal" tabindex="-1" role="dialog"
        aria-labelledby="resultPemiluModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultPemiluModalLabel">Hasil Pemilu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" id="collapseDetailVoting">
                                    <div class="row">
                                        <div class="col">
                                            <h4 class="text-primary card-title">Detail Voting</h4>
                                        </div>
                                        <button class="btn btn-primary" data-toggle="collapse"
                                            data-target="#collapseBody" aria-expanded="true" aria-controls="collapseBody"
                                            onclick="toggleIcon()">
                                            <i class="fa-regular fa-plus" id="icon-button"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="collapseBody" class="collapse" aria-labelledby="collapseDetailVoting"
                                    data-parent="#collapseDetailVoting">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-md-6 col-sm-12">
                                                {{-- <canvas id="statusVote" data-voted="0" data-no-vote="201"
                                                    style="display: block; height: 0px; width: 0px;" height="0"
                                                    width="0" class="chartjs-render-monitor"></canvas> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-link" type="button" data-dismiss="modal">Tutup</button>
                </div>
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

            $('#add-radio-private-yes, #add-radio-private-no').on('change', function() {
                if ($('#add-radio-private-yes').is(':checked')) {
                    $('#add-pemilu-group').removeClass('d-none');
                } else {
                    $('#add-pemilu-group').addClass('d-none');
                }
            });

            $('#add-pemilu-form').on('submit', function() {
                if (!$('#add-status-checkbox').is(':checked')) {
                    $('<input>').attr({
                        type: 'hidden',
                        name: 'status',
                        value: '0'
                    }).appendTo('#add-pemilu-form');
                }
            });
        })
    </script>
    <script>
        const edit = (slug) => {
            $.getJSON(`${window.location.origin}/api/pemilu/${slug}`, (data) => {
                const updateUrl = '{{ route('admin.manage.pemilu.edit', ':slug') }}'
                $('#edit-pemilu-form').attr('action', updateUrl.replace(':slug', slug));

                $("#edit-name").val(data.name)
                $("#edit-description").val(data.description)

                if (data.is_private == 1) {
                    $("#edit-radio-private-yes").prop("checked", true);
                    $('#edit-pemilu-group').removeClass('d-none');
                    $("#edit-password").val(data.password);
                } else {
                    $("#edit-radio-private-no").prop("checked", true);
                    $('#edit-pemilu-group').addClass('d-none');
                }

                if (data.status == 1) {
                    $('#edit-status-checkbox').prop('checked', true)
                } else {
                    $('#edit-status-checkbox').prop('checked', false)
                }

                $('#edit-radio-private-yes, #edit-radio-private-no').on('change', function() {
                    if ($('#edit-radio-private-yes').is(':checked')) {
                        $('#edit-pemilu-group').removeClass('d-none');
                    } else {
                        $('#edit-pemilu-group').addClass('d-none');
                    }
                });

                $('#edit-pemilu-form').on('submit', function() {
                    if (!$('#edit-status-checkbox').is(':checked')) {
                        $('<input>').attr({
                            type: 'hidden',
                            name: 'status',
                            value: '0'
                        }).appendTo('#edit-pemilu-form');
                    }
                });

                const myModal = new bootstrap.Modal(document.getElementById('editPemiluModal'));
                myModal.show();
            })
        }
    </script>
    <script>
        const toggleIcon = () => {
            const iconButton = document.getElementById('icon-button');
            const collapseBody = document.getElementById('collapseBody');
            const isExpanded = collapseBody.classList.contains('show');

            if (isExpanded) {
                iconButton.classList.remove('fa-minus');
                iconButton.classList.add('fa-plus');
            } else {
                iconButton.classList.remove('fa-plus');
                iconButton.classList.add('fa-minus');
            }
        }
    </script>
@endpush
