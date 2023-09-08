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
@endsection


@section('content')
<div class="card">
  <div class="card-header">
    <h3 class="class-title">Table</h3>
  </div>

  <!-- Button Add -->
  <div class="row">
    <div class="col-md-2">
      <a class="btn btn-primary ml-3 mb-2 mt-2 " href="{{ route('sender-identity.create') }}" >
        <i class="fa fa-plus-circle">

        </i>
      </a>
    </div>
  </div>
  <!-- /.button add -->

  <div class="card-body table-responsive">
    <table class="table table-bordered table-head-fixed">
      <thead>
        <tr>
          <th style="width: 10px">No</th>
          <th>Kode</th>
          <th>Deskripsi</th>
          <th class="text-nowrap">
            Action
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach($data_sender_identity as $sender)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $sender->kode }}</td>
            <td>{{ $sender->deskripsi }}</td>
            <td class="text-nowrap">

              <!-- Edit -->
              <a href="{{ route('sender-identity.edit', $sender->id) }}" class="btn btn-info" > 
                <i class="fa fa-edit"></i>
              </a>

              <!-- Hapus -->
              <form hidden action="{{ route('sender-identity.destroy', $sender->id) }}" method="post" id="data-ke-{{ $sender->id }}">
                @csrf
                @method('DELETE')
              </form>
              <button type="submit" class="btn btn-danger" onclick="deleteRow( {{ $sender->id }} )">
                <i class="fa fa-trash"></i>
              </button>


            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<!-- Delete Row -->
<script >
  function deleteRow(id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
        $('#data-ke-'+id).submit()
      }
    })
  }
</script>
@endpush