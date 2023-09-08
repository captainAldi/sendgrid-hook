@extends('layouts.dashboard')

@section('header')
  <h1 class="m-0 text-dark">
    Detail Data Delivery
  </h1>
@endsection

@section('breadcrumb')
  <li class="breadcrumb-item">
    <a href="{{ route('get.delivery-event') }}">Report Sendgrid</a>
  </li>
@endsection


@section('content')

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <h3 class="class-title">Event</h3>
      </div>

      <form id="form-filter" action="" method="get">
        <!-- Header Tab -->
        <ul class="nav nav-tabs" id="tab-users" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" id="filter-tab" data-toggle="tab" href="#filter" role="tab" aria-controls="filter" aria-selected="true">Filter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" id="sort-tab" data-toggle="tab" href="#sort" role="tab" aria-controls="sort" aria-selected="false">Sort</a>
          </li>
        </ul>
        <!-- /.header tab -->


        <!-- Tab Content -->
        <div class="tab-content" id="tab-usersContent">

          <!-- Filter Tab -->
          <div class="tab-pane fade show active" id="filter" role="tabpanel" aria-labelledby="filter-tab">


            <div class="row ml-2 mb-2">

              <div class="col-lg-2 col-md-6 col-xs-12">
                <label for="cari_sender_identity">Pengirim</label>
                <select name="cari_sender_identity" class="form-control select2bs4">
                  <option value="">Pilih Opsi</option> 
                  @foreach ($data_sender_identity as $sender)
                    <option value="{{ $sender->kode }}" {{ $cari_sender_identity == $sender->kode ? 'selected' : '' }}>{{ $sender->kode }}</option>
                  @endforeach
                </select>
              </div>

              <div class="col-lg-2 col-md-6 col-xs-12">
                <label for="cari_event">Event</label>
                <select name="cari_event" class="form-control">
                  <option value="">Pilih Opsi</option>
                  <option value="processed" {{ $cari_event == "processed" ? 'selected' : '' }}>Processed</option>
                  <option value="dropped" {{ $cari_event == "dropped" ? 'selected' : '' }}>Dropped</option>
                  <option value="delivered" {{ $cari_event == "delivered" ? 'selected' : '' }}>Delivered</option>
                  <option value="deferred" {{ $cari_event == "deferred" ? 'selected' : '' }}>Deferred</option>
                  <option value="bounce" {{ $cari_event == "bounce" ? 'selected' : '' }}>Bounce</option>
                  <option value="blocked" {{ $cari_event == "blocked" ? 'selected' : '' }}>Blocked</option>
                </select>
              </div>

              <div class="col-lg-2 col-md-6 col-xs-12" id="cari_tanggal_awal">
                <label for="cari_tanggal_awal">Tanggal Awal</label>

                <div class="input-group date" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input @error('cari_tanggal_awal') is-invalid @enderror" data-target="#cari_tanggal_awal" id="cari_tanggal_awal" name="cari_tanggal_awal" value="{{ $cari_tanggal_awal }}" autocomplete="off"/>
                  <div class="input-group-append" data-target="#cari_tanggal_awal" data-toggle="cari_tanggal_awal">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>

              </div>

              <div class="col-lg-2 col-md-6 col-xs-12" id="cari_tanggal_akhir">
                <label for="cari_tanggal_akhir">Tanggal Akhir</label>

                <div class="input-group date" data-target-input="nearest">
                  <input type="text" class="form-control datetimepicker-input @error('cari_tanggal_akhir') is-invalid @enderror" data-target="#cari_tanggal_akhir" id="cari_tanggal_akhir" name="cari_tanggal_akhir" value="{{ $cari_tanggal_akhir }}" autocomplete="off"/>
                  <div class="input-group-append" data-target="#cari_tanggal_akhir" data-toggle="cari_tanggal_akhir">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                  </div>
                </div>

              </div>

            </div>
              

            <div class="row m-2">
              <div class="col-lg-2 col-md-6 col-xs-12">
                <label for="set_pagination">Item per Page</label>

                <select name="set_pagination" class="form-control">
                  
                  <option value="10" {{ $set_pagination == "10" ? 'selected' : '' }}>10</option>
                  <option value="50" {{ $set_pagination == "50" ? 'selected' : '' }}>50</option>
                  <option value="100" {{ $set_pagination == "100" ? 'selected' : '' }}>100</option>
                </select>
              </div>
            </div>

          </div>
          <!-- /.filter tab -->


          <!-- Sorting Tab -->
          <div class="tab-pane fade" id="sort" role="tabpanel" aria-labelledby="sort-tab">
            
            <div class="row m-2">
              <div class="col-lg-2 col-md-6 col-xs-12"> 
                <label for="var_sort"><i class="fa fa-arrow-down"></i> Field</label>
                <select name="var_sort" class="form-control">
                  <option value="">Pilih Opsi</option>
                  <option value="timestamp" {{ $var_sort == "timestamp" ? 'selected' : '' }}>Timestamp</option>
                  <option value="name" {{ $var_sort == "name" ? 'selected' : '' }}>Sender</option>
                </select>
              </div>

              <div class="col-lg-2 col-md-6 col-xs-12">
                <label for="tipe_sort"><i class="fa fa-arrow-up"></i> Type</label>
                <select name="tipe_sort" class="form-control">
                  <option value="">Pilih Opsi</option>
                  <option value="desc" {{ $tipe_sort == "desc" ? 'selected' : '' }}>Desc</option>
                  <option value="asc" {{ $tipe_sort == "asc" ? 'selected' : '' }}>Asc</option>
                </select>
              </div>
            </div>

          </div>
          <!-- /.sorting tab -->

        </div>
        <!-- /.tab content -->

        <button class="btn btn-primary m-3" type="submit">
          Filter
        </button>
        <a class="btn btn-primary m-3 " href="{{ route('get.delivery-event') }}">
          Refresh
        </a>
      </form>


      <div class="card-body table-responsive">
        <table class="table table-bordered table-head-fixed">
          <thead>
            <tr>
              <th style="width: 10px">No</th>
              <th>Event</th>
              <th>To</th>
              <th>Sender</th>
              <th>Timestamp</th>
              <th class="text-nowrap">
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($data_semua_de as $event)
              <tr>

                <td>{{ $loop->iteration + $data_semua_de->firstItem() - 1 }}</td>

                @if ($event->event == 'processed')
                  <td>
                    <span class="badge badge-info">Processed</span>
                  </td>
                @elseif($event->event == 'dropped')
                  <td>
                    <span class="badge badge-danger">Dropped</span>
                  </td>
                @elseif($event->event == 'delivered')
                  <td>
                    <span class="badge badge-success">Delivered</span>
                  </td>
                @elseif($event->event == 'deferred')
                  <td>
                    <span class="badge badge-secondary">Deferred</span>
                  </td>
                @elseif($event->event == 'bounce')
                  <td>
                    <span class="badge badge-warning">Bounce</span>
                  </td>
                @elseif($event->event == 'blocked')
                  <td>
                    <span class="badge badge-dark">Blocked</span>
                  </td>
                @endif

                <td>{{ $event->email_to }}</td>
                @if ($event->sender_identity != null)
                  <td>{{ $event->sender_identity }}</td>
                @else
                  <td>Tidak Ada Data</td>
                @endif
                <td>{{ $event->timestamp }}</td>

                <td class="text-nowrap">
                  <!-- Detail -->
                  <a href="{{ route('get.delivery-event.detail', $event->message_id) }}" class="btn btn-warning" aria-disabled=""> 
                    <i class="fa fa-eye"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="card-footer clearfix">
        <h5>Jumlah Data : <span>{{ $data_semua_de->total() }}</span></h5>
        {{ $data_semua_de->links('vendor.pagination.adminlte-3') }}
      </div>

    </div>
  </div>
</div>

@endsection

@push('scripts')
<!-- Date Picker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js" integrity="sha512-T/tUfKSV1bihCnd+MxKD0Hm1uBBroVYBOYSk1knyvQ9VyZJpc/ALb4P0r6ubwVPSGB2GvjeoMAJJImBG12TiaQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $('#cari_tanggal_awal .input-group.date').datepicker({
      format: 'yyyy/mm/dd',
      todayHighlight: true,
      autoclose: true
  });

  $('#cari_tanggal_akhir .input-group.date').datepicker({
      format: 'yyyy/mm/dd',
      todayHighlight: true,
      autoclose: true
  });
</script>


<script>

  // Select 2
  $(document).ready(function() {
    $('.select2').select2();
  });
  $(document).ready(function() {
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });
  });

 
</script>
@endpush