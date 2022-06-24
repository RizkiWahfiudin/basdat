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
                <form action="{{ url('/event',['event'=>$event->id_event]) }}" method="POST" enctype="multipart/form-data" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group hide-col">
                                <label for="">Region</label>
                                <div class="input-group">
                                    <select class="form-control region" id="region" name="region" onchange="actRegion()">
                                        <?= $region ?>
                                    </select>
                                    <input type="hidden" name="id" value="{{ $event->id_event }}">
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
                                <input class="form-control" type="name" name="speaker" value="{{$event->speaker}}">
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal</label>
                                <input class="form-control" type="date" name="tanggal" value="{{$event->tanggal}}">
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
                                <textarea class="form-control lokasi" name="lokasi" rows="6"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Moderator</label>
                                <input class="form-control" type="name" name="moderator" value="{{$event->moderator}}">
                            </div>
                        </div>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
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
        let region = '{{ $event->region_id }}';
        $('.region').val(region).change();
        let lokasi = '{{ $event->lokasi }}';
        $('.lokasi').val(lokasi).change();

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
                        let kota = '{{ $event->kota_id }}';
                        let optionKota = document.createElement('option');
                        optionKota.value = value.id_kota;
                        optionKota.text = value.nama_kota;
                        if(parseInt(kota) === value.id_kota) optionKota.selected = true;
                        document.getElementById('kota').options.add(optionKota);
                    });
                }
            });
        }

    </script>
@endsection
