@extends('layouts.master')
@section('title')
    <title>Page Categories</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Management Kategori</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4">
                    @card
                        @slot('title')
                            Tambah
                        @endslot
                        <form role="form" action="{{ route('kategori.store') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="name">Kategori</label>
                                <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea name="description" id="description" cols="5" rows="5" class="form-control {{ $errors->has('description') ? 'is-invalid':'' }}"></textarea>
                            </div>
                        @slot('footer')
                            <div class="card-footer">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                        @endslot
                    @endcard
                    </div>
                    <div class="col-md-8">
                        @card
                            @slot('title')
                                Tambah
                            @endslot
                            @if (session('success'))
                                @alert(['type'=>'success'])
                                    {!! session('success') !!}
                                @endalert
                            @endif
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <div class="thead">
                                        <tr>
                                            <th>#</th>
                                            <th>Kategori</th>
                                            <th>Deskripsi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </div>
                                    <div class="tbody">
                                        @forelse ($categories as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->description }}</td>
                                            <td>
                                                <form action="{{ route('kategori.destroy', $row->id) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <a href="{{ route('kategori.edit', $row->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                                                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                         <tr>
                                            <td colspan="4" class="text-center">Tidak ada data</td>
                                        </tr>   
                                        @endforelse
                                    </div>
                                </table>
                            </div>
                            @slot('footer')@endslot
                        @endcard
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection