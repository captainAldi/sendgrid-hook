@extends('layouts.dashboard')

@section('header')
  <h1 class="m-0 text-dark">
    Data Pengirim
  </h1>
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('sender-identity.index') }}">Pengirim</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('sender-identity.edit', $data_sender_identity->id) }}">Edit</a>
  </li>
  <li class="breadcrumb-item">
    {{ $data_sender_identity->id }}
  </li>
@endsection


@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Edit Data</h3>
  </div>

  <div class="card-body">

    <form action="{{ route('sender-identity.update', $data_sender_identity->id) }}" method="post">
      @csrf
      @method('PATCH')

      <!-- Kode -->
      <div class="form-group row">
        <label for="kode" class="col-sm-2 col-form-label">Kode</label>

        <div class="col-sm-10">
          <input type="text" autofocus class="form-control @error('kode') is-invalid @enderror" name="kode" value="{{ old('kode', $data_sender_identity->kode) }}" autocomplete="kode" placeholder="kode Lengkap ...">

          @error('kode')
          <span class="error invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

      </div>

      <!-- Deskripsi -->
      <div class="form-group row">
        <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>

        <div class="col-sm-10">
          <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="10" placeholder="Deskripsi Lengkap ...">{{ old('deskripsi', $data_sender_identity->deskripsi) }}</textarea>

          @error('deskripsi')
          <span class="error invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

      </div>

      <div class="form-group row">
        <div class="offset-sm-2 col-sm-10">
          <button class="btn btn-success" type="submit">
            Proses
          </button>
        </div>
      </div>

    </form>

  </div>
</div>
@endsection