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
  <li class="breadcrumb-item">
    <a href="{{ route('get.delivery-event.detail', $data_event[0]->message_id) }}">Detail</a>
  </li>
  <li class="breadcrumb-item">
    {{ $data_event[0]->id }}
  </li>
@endsection


@section('content')

{{-- Detail --}}
<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-header">
        <h3 class="class-title">Event</h3>
      </div>

      <div class="card-body">

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>SG Message ID :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->message_id }}</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>e-Mail to :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->email_to }}</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>Timestamp :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->timestamp }}</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>Last Event:</h5>
          </div>
          <div class="col">
            @if ($data_event[$data_event->keys()->last()]->event == 'processed')
              <label class="badge badge-info">Processed</label>
            @elseif($data_event[$data_event->keys()->last()]->event == 'dropped')
              <label class="badge badge-danger">Dropped</label>
            @elseif($data_event[$data_event->keys()->last()]->event == 'delivered')
              <label class="badge badge-success">Delivered</label>
            @elseif($data_event[$data_event->keys()->last()]->event == 'deferred')
              <label class="badge badge-secondary">Deferred</label>
            @elseif($data_event[$data_event->keys()->last()]->event == 'bounce')
              <label class="badge badge-warning">Bounce</label>
            @elseif($data_event[$data_event->keys()->last()]->event == 'blocked')
              <label class="badge badge-dark">Blocked</label>
            @endif
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>Response :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->response ?? "Data Tidak Ada" }}</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>Attempt :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->attempt ?? "Data Tidak Ada"  }}</label>
          </div>
        </div>

        <div class="row">
          <div class="col-md-3 text-md-right">
            <h5>Type :</h5>
          </div>
          <div class="col">
            <label>{{ $data_event[0]->type ?? "Data Tidak Ada"  }}</label>
          </div>
        </div>

      </div>

      <div class="card-footer clearfix">
      
      </div>

    </div>
  </div>
</div>

{{-- History --}}
<div class="row">
  <div class="col">

    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3 class="card-title">Riwayat</h3>
      </div>
      
      <div class="card-body">
        <!-- Main node for this component -->
          <div class="timeline">
            
            @foreach($data_event as $riwayat)
              <!-- Timeline time label -->
              <div class="time-label">

                @if ($riwayat->event == 'processed')
                  <span class="bg-info">Processed</span>
                @elseif($riwayat->event == 'dropped')
                  <span class="bg-danger">Dropped</span>
                @elseif($riwayat->event == 'delivered')
                  <span class="bg-success">Delivered</span>
                @elseif($riwayat->event == 'deferred')
                  <span class="bg-secondary">Deferred</span>
                @elseif($riwayat->event == 'bounce')
                  <span class="bg-warning">Bounce</span>
                @elseif($riwayat->event == 'blocked')
                  <span class="bg-dark">Blocked</span>
                @endif

              </div>

              <div>
                <!-- Before each timeline item corresponds to one icon on the left scale -->
                <i class="fas fa-envelope bg-blue"></i>
                <!-- Timeline item -->
                <div class="timeline-item">
                  <!-- Time -->
                  <span class="time"><i class="fas fa-clock"></i> {{ date('H:i:s', strtotime($riwayat->timestamp)) }}</span>
                  <!-- Header. Optional -->
                  <h3 class="timeline-header"><a href="#">{{ date('Y-m-d', strtotime($riwayat->timestamp)) }}</a>
                  <!-- Body -->
                  <div class="timeline-body">
                    <strong>Response: </strong> {{ $riwayat->response }}
                    @if ($riwayat->reason != null)
                      <br/>
                      <strong>Reason: </strong> {{ $riwayat->reason }}
                    @endif
                  </div>
                  
                </div>
              </div>
            @endforeach

            <!-- The last icon means the story is complete -->
            <div>
              <i class="fas fa-clock bg-gray"></i>
            </div>
          </div>
      </div>
    </div>    

  </div>
</div>

@endsection

@push('scripts')


@endpush