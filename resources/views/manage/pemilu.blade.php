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
                        <div class="ml-auto">
                            <button data-target="#addPemiluModal" data-toggle="modal" class="btn btn-success mr-1"><i
                                    class="fa-regular fa-plus"></i></button>
                        </div>
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
                                        <button onclick="result('{{ $item->slug }}')" class="btn btn-warning"><i
                                                class="fa-regular fa-square-poll-vertical"></i></button>
                                        <button class="btn btn-secondary"><i
                                                class="fa-regular fa-clock-rotate-left"></i></button>
                                        <a href="{{ route('admin.manage.pemilu.delete', $item->slug) }}"
                                            data-confirm-delete="true" class="btn btn-danger"><i
                                                class="fa-regular fa-trash"></i></a>
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

    <div class="modal fade" id="resultVotingModal" tabindex="-1" role="dialog"
        aria-labelledby="resultVotingModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resultVotingModalLabel">Hasil Pemilu</h5>
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
                                            <h4 class="text-primary card-title" id="resultTitle">Detail Voting</h4>
                                        </div>
                                        <div class="ml-auto">
                                            <button class="btn btn-primary" data-toggle="collapse"
                                                data-target="#collapseBody" aria-expanded="true"
                                                aria-controls="collapseBody" onclick="toggleIcon()">
                                                <i class="fa-regular fa-plus" id="icon-button"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div id="collapseBody" class="collapse" aria-labelledby="collapseDetailVoting"
                                    data-parent="#collapseDetailVoting">
                                    <div class="card-body">
                                        <div class="row d-flex align-items-center justify-content-center">
                                            <div class="col-md-6 col-sm-12">
                                                <canvas id="statusVote" style="display: block; height: 0px; width: 0px;"
                                                    height="0"nwidth="0" class="chartjs-render-monitor"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="text-primary card-title">Statistik</h4>
                                </div>
                                <div class="card-body h-100 d-flex align-items-center justify-content-center">
                                    <canvas id="statistikVote" style="display: block; height: 0px; width: 0px;"
                                        height="0"nwidth="0" class="chartjs-render-monitor"></canvas>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <script>
        let pieChartIstance;
        let barChartIstance;

        const result = (slug) => {
            const ctx = document.getElementById('statusVote');

            if (pieChartIstance) {
                pieChartIstance.destroy();
            }

            const pieChart = (data) => {
                pieChartIstance = new Chart(ctx, {
                    type: 'pie',
                    data: {
                        datasets: [{
                            data: [data.voted, data.not_voted],
                            backgroundColor: [
                                '#6777ef',
                                '#cdd3d8',
                            ],
                            label: 'Status'
                        }],
                        labels: [
                            'Voted',
                            'No Vote',
                        ],
                    },
                    options: {
                        responsive: true,
                        legend: {
                            position: 'right',
                        },
                    }
                });
            }

            const barChart = (data) => {
                const ctx = document.getElementById('statistikVote');

                if (barChartIstance) {
                    barChartIstance.destroy();
                }

                barChartIstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Count Vote',
                            data: data.data,
                            borderWidth: 2,
                            backgroundColor: '#6777ef',
                            borderColor: '#6777ef',
                            borderWidth: 2.5,
                            pointBackgroundColor: '#ffffff',
                            pointRadius: 4
                        }]
                    },
                    options: {
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [{
                                gridLines: {
                                    drawBorder: false,
                                    color: '#f2f2f2',
                                },
                                ticks: {
                                    beginAtZero: true,
                                    stepSize: 150
                                }
                            }],
                            xAxes: [{
                                ticks: {
                                    display: false
                                },
                                gridLines: {
                                    display: false
                                }
                            }]
                        },
                    }
                });
            }

            $.getJSON(`${window.location.origin}/api/pemilu/${slug}/result`, (data) => {
                $('#resultTitle').text(`Detail Voting | Total Users : ${data.total_users}`)
                pieChart(data.pie_charts)
                barChart(data.bar_charts);

                const myModal = new bootstrap.Modal(document.getElementById('resultVotingModal'));
                myModal.show();
            });
        }
    </script>
@endpush
