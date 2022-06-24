@extends('master.master')

@section('eventActive','active')
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
                <form action="{{ url('/event') }}" method="POST" enctype="multipart/form-data" id="my-form">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Region</label>
                            <div class="input-group">
                                <select class="form-control" id="region" name="region" onchange="actRegion()">
                                    <?= $region ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <div class="input-group">
                                <select class="form-control" id="kategori" name="kategori">
                                    <?= $kategori ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Speaker</label>
                            <input class="form-control" type="name" name="speaker">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal</label>
                            <input class="form-control" type="date" name="tanggal">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="">Kota</label>
                            <div class="input-group">
                                <select class="form-control" id="kota" name="kota">
                                    <option value="">Pilih Kota</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <textarea class="form-control" name="lokasi" rows="6"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Moderator</label>
                            <input class="form-control" type="name" name="moderator">
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-buttons-w">
                    {!! xButton('', 'tambah') !!}
                    {!! xButton('/event') !!}
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
        function actRegion() {
            let val = $('select[name="region"]').val();

            $.ajax({
                type: "POST",
                url: '{{ route('event.getKota') }}',
                data: {
                    "_token": "{{ csrf_token() }}",
                    id: val
                },
                dataType: 'json',
                success: function(data){
                    $('#kota').empty();
                    let tempKota = document.createElement('option');
                    tempKota.value = '';
                    tempKota.text = 'Pilih Kota';
                    document.getElementById('kota').options.add(tempKota);
                    data.forEach((value,index) => {
                        let optionKota = document.createElement('option');
                        optionKota.value = value.id_kota;
                        optionKota.text = value.nama_kota;
                        document.getElementById('kota').options.add(optionKota);
                    });
                }
            });
        }

    </script>
@endsection
