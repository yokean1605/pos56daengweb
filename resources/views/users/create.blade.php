@extends('layouts.master')

@section('title')
    <title>Add New Users</title>
@endsection

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Add New Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
                            <li class="breadcrumb-item active">Add New</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <form action="{{ route('users.store') }}" method="post">
                        @card
                            @slot('title')
                                Form Tambah User
                            @endslot
                            @if (session('error'))
                                @alert(['type' => 'danger'])
                                    {!! session('error') !!}
                                @endalert
                            @endif

                                @csrf
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required placeholder="Name" value="{{ old('name') }}">
                                    <small id="helpId" class="text-danger">{{ $errors->first('name') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" required placeholder="Email" value="{{ old('email') }}">
                                    <small id="helpId" class="text-danger">{{ $errors->first('email') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Password</label>
                                    <input type="password" name="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" required placeholder="****" value="{{ old('password') }}">
                                    <small id="helpId" class="text-danger">{{ $errors->first('password') }}</small>
                                </div>
                                <div class="form-group">
                                    <label for="">Level User</label>
                                    <select class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" name="role" id="role">
                                        <option>--Pilih--</option>
                                        @foreach ($role as $row)
                                            <option value="{{ $row->name }}">{{ $row->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @slot('footer')
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save mr-2"></i>
                                            Save
                                        </button>
                                    </div>
                                @endslot
                            @endcard
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection