@extends('layouts.app')
@section('title', 'Dashboard')

@push('css')
    {{-- Custom CSS for This Page --}}
    <link rel="stylesheet" href="{{asset('css/users/dahsboard.css')}}">
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
    </div>

    @if (auth()->user()->role == 'admin')
        <div class="row">
            @if (Session::has('status'))
                <div class="col-12">
                    <div class="alert alert-success border-left-success" role="alert">
                        {{ session('status') }}
                    </div>
                </div>
            @endif
            @if ($pemilu->isEmpty())
                <div class="col-12">
                    <div class="card p-bd">
                        <a data-target="#addPemiluModal"  data-toggle="modal" style="cursor:pointer;">
                        <div class="card-body">
                            <div class="p-5">
                                <h4 class="text-primary text-center">Tidak Ada Pemilu Yang Sedang Aktif</h4>
                                <p class="text-center" style="border-bottom: 1px solid #4A5568;">Buat Pemilu <span>Disini</span></p>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="row">
                        @foreach ($pemilu as $item)
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="card h-100">
                                    <div class="card-header bg-primary">
                                        <h4 class="card-title text-white">{{ $item->name }}</h4>
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text">{{ $item->description }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('admin.manage.pemilu') }}" class="btn btn-primary float-right"><i
                                                class="fa-regular fa-eye mr-1"></i>Detail</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" id="collapseVotingAktif">
                        <div class="row">
                            <div class="col">
                                <h4 class="text-primary card-title">Daftar Pemilu Yang Sedang Aktif</h4>
                            </div>
                            <div class="ml-auto">
                                <button class="btn btn-primary" data-toggle="collapse" data-target="#collapseBody"
                                    aria-expanded="true" aria-controls="collapseBody" onclick="toggleIcon()">
                                    <i class="fa-regular fa-plus" id="icon-button"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div id="collapseBody" class="collapse" aria-labelledby="collapseVotingAktif"
                        data-parent="#collapseVotingAktif">
                        <div class="card-body">
                            <div class="row">
                                @foreach ($pemilu as $item)
                                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                                        <div class="card h-100">
                                            <div class="card-header bg-primary">
                                                <h5 class="card-title text-white m">{{ $item->name }}</h5>
                                            </div>
                                            <div class="card-body">
                                                <p class="card-text">{{ $item->description }}</p>
                                            </div>
                                            <div class="card-footer">
                                                @if ($item->is_private)
                                                    <button onclick="verify('{{ $item->slug }}')"
                                                        class="btn btn-primary float-right"><i
                                                            class="fa-regular fa-door-open mr-1"></i>Masuk</button>
                                                @else
                                                    <a href="{{ route('user.pemilu.join', $item->slug) }}"
                                                        class="btn btn-primary float-right"><i
                                                            class="fa-regular fa-door-open mr-1"></i>Masuk</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="verifyPasswordModal" tabindex="-1" role="dialog"
            aria-labelledby="verifyPasswordModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyPasswordModalLabel">Verifikasi Password Pemilu</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="verifyPasswordForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" type="text" class="form-control" name="password"
                                    placeholder="Masukkan password">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-link" type="button" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success">Verifikasi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

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
                            placeholder="Masukkan nama pemilu" required>
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
@endsection

@push('js')
    {{-- Custom JS for This Page --}}
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
        const verify = (slug) => {
            console.log(slug)
            const verifyUrl = `{{ route('user.pemilu.verify-password.join', [':slug']) }}`

            $('#verifyPasswordForm').attr('action', verifyUrl.replace(':slug', slug))
            const myModal = new bootstrap.Modal(document.getElementById('verifyPasswordModal'));
            myModal.show();
        }
    </script>
@endpush
