@extends('layouts.master')

@section('title')
    <title>Management Users</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Manajemen User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        @card
                            @slot('title')
                                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit mr-1"></i>
                                    Tambah Baru
                                </a>
                            @endslot

                            @if (session('success'))
                                @alert['type' => 'success']
                                    {!! sesion('success') !!}
                                @endalert
                            @endif

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($users as $user)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    @foreach ($user->getRoleNames() as $role)
                                                        <label for="" class="badge bagde-info">{{ $role }}</label>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                    @if ($user->status)
                                                        <label for="" class="badge bagde-success">Aktif</label>
                                                    @else
                                                        <label for="" class="badge bagde-default">Suspend</label>
                                                    @endif
                                                </td>
                                                <td>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <a href="{{ route('users.roles', $user->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Secret" data-placement="top">
                                                            <i class="fas fa-user-secret"></i>
                                                        </a>
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit" data-placement="top">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-danger btn-sm" data-toggle="tooltip" title="Delete" data-placement="top">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>
                                        @endforelse
                                    </tbody>

                                </table>
                            </div>
                            @slot('footer')
                                
                            @endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('javascript')
    <script>
        $(function () {
          $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endpush