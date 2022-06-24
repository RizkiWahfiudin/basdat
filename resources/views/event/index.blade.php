@extends('master.master')

@section('eventActive','active')
@section('page_title', $title)

@section('konten')

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                @if (session()->has('pesan'))
                    {!! session('pesan') !!}
                @endif

                <div class="row">
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-sm-3">
                                <select class="form-control select2 cari-region">
                                    <?= $region ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control select2 cari-kota">
                                    <?= $kota ?>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control select2 cari-kategori">
                                    <?= $kategori ?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                                <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        @if (hakAksesMenu('event','create'))
                            {!! xButton('/event/create', 'tambah_view', 'Buat Event') !!}
                        @endif
                    </div>
                </div>

                <hr>

                <div class="table-responsive">
                    <table class="table table-sm table-hover data-list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Region</th>
                                <th>Kota</th>
                                <th>Kategori</th>
                                <th>Lokasi</th>
                                <th>Speaker</th>
                                <th>Moderator</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
          </div>
        </div>

      </div>

@endsection

@section('my-script')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script>

    getList();

    function getList(){
        var data_list = $('.data-list').DataTable({
            processing: true,
            serverSide: true,
            searching : false,
            lengthChange : false,
            pageLength  : 10,
            bDestroy: true,
            ajax: {
                url  : "/ajaxEvent",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.region = $('select.cari-region').val();
                    d.kota = $('select.cari-kota').val();
                    d.kategori = $('select.cari-kategori').val();
                    d.status = $('input[name="_status"]').val();
                },
            },
            columns: [
                { data: 'id_event'},
                { data: 'region'},
                { data: 'kota'},
                { data: 'kategori'},
                { data: 'lokasi'},
                { data: 'speaker'},
                { data: 'moderator'},
                { data: 'tanggal'},
                { data: 'aksi'},
            ],
            "fnRowCallback" : function(nRow, aData, iDisplayIndex){
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            }
        });
    }

</script>
@endsection
