@extends('master.master')

@section('pengaturanActive','active')
@section('page_title',$title)

@section('konten')
      <div class="row">
        <div class="col-sm-12">
          <div class="card">
            <h6 class="card-header">
              {{ $title }}
            </h6>
            <div class="card-body">
                <form action="{{ url('/user') }}" method="POST" enctype="multipart/form-data" id="my-form">
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input class="form-control" type="name" name="username">
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input class="form-control" type="name" name="nama">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input class="form-control" type="email" name="email">
                        </div>
                    </div>
                    <div class="col-sm-1"></div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input class="form-control" type="file" name="foto">
                        </div>
                        <div class="form-group">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Roles</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($roles as $item)
                                <tr>
                                    <td>{{ $item->nama }}</td>
                                    <td><input type="checkbox" name="roles[]" value="{{ $item->id }}"></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data tidak tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="form-buttons-w">
                    {!! xButton('', 'tambah') !!}
                    {!! xButton('/user') !!}
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
