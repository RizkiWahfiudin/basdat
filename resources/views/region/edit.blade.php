@extends('master.master')

@section('regionActive','active')
@section('page_title',$title)

@section('konten')

      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif
                <form action="{{ url('/region',['region'=>$region->id_region]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Nama Region</label>
                                    <input class="form-control" type="name" name="nama" value="{{ $region->nama_region }}">
                                    <input type="hidden" name="id" value="{{ $region->id_region }}">
                                </div>
                            </div>
                        </div>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
                    {!! xButton('/region') !!}
                  </div>
                </form>
              </div>
          </div>
        </div>
      </div>
@endsection

@section('my-script')
    <!-- Laravel Javascript Validation -->
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! $validator->selector('#my-form') !!}
@endsection
