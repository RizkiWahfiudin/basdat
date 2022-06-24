@extends('master.master')

@section('kotaActive','active')
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
                <form action="{{ url('/kota',['kota'=>$kota->id_kota]) }}" method="POST" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Region</label>
                                    <select class="form-control region" name="region">
                                        <?= $region ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Nama Kota</label>
                                    <input class="form-control" type="name" name="nama" value="{{ $kota->nama_kota }}">
                                    <input type="hidden" name="id" value="{{ $kota->id_kota }}">
                                </div>
                            </div>
                        </div>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
                    {!! xButton('/kota') !!}
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

    <script>
      let region = '{{ $kota->region_id }}';
      $('.region').val(region).change();
    </script>
@endsection
