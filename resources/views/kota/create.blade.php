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
                <form action="{{ url('/kota') }}" method="POST" enctype="multipart/form-data" id="my-form">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Region</label>
                            <select class="form-control" name="region">
                                <?= $region ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Nama Kota</label>
                            <input class="form-control" type="name" name="nama">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-buttons-w">
                    {!! xButton('', 'tambah') !!}
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

@endsection
