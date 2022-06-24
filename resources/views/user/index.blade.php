@extends('master.master')

@section('pengaturanActive','active')
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
                        {{-- <form action="{{ url('/ajaxUser') }}" method="POST" id="cari-form">
                        @csrf --}}
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" name="cari" class="form-control" placeholder="Cari nama/username">
                            </div>
                            <div class="col-sm-2">
                                <a href="#" class="btn btn-sm btn-warning" onclick="getList()">GO</a>
                                <a href="#" class="btn btn-sm btn-default" onclick="reset()"><i class="feather-rotate-ccw"></i></a>
                            </div>
                        </div>
                        {{-- </form> --}}
                    </div>
                    <div class="col-md-2">
                        @if (hakAksesMenu('users','create'))
                            {!! xButton('/user/create', 'tambah_view') !!}
                        @endif
                    </div>
                </div>

                <hr>

                <div class="">
                    <table class="table table-hover data-list">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Roles</th>
                                <th>Status</th>
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
                url  : "/ajaxUser",
                type : "POST",
                data : function(d){
                    d._token = $("input[name=_token]").val();
                    d.cari = $('input[name="cari"]').val();
                    d.cluster = $('select[name="cluster"]').val();
                },
            },
            columns: [
                { data: 'nomor'},
                { data: 'username'},
                { data: 'nama'},
                { data: 'roles'},
                { data: 'status'},
                { data: 'aksi'},
            ]
        });
    }


</script>
@endsection
