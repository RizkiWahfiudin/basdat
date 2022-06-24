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
                <form action="{{ url('/user',['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data" id="my-form">
                    @csrf
                    @method('PATCH')

                    <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="">Username</label>
                            <input class="form-control" type="name" name="username" value="{{ $user->username }}">
                        </div>
                        <div class="form-group">
                            <label for="">Nama</label>
                            <input class="form-control" type="name" name="nama" value="{{ $user->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="">Email</label>
                            <input class="form-control" type="email" name="email" value="{{ $user->email }}">
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
                                    <td><input type="checkbox" name="roles[]" {{ $item->user_id !== NULL ? 'checked' : '' }} value="{{ $item->id }}"></td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data tidak tersedia</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        </div>
                        <div class="form-group">
                            <label for="">Ganti Sandi</label>
                            <input class="form-control" type="password" name="password">
                            <small>Biarkan kosong jika tidak ingin mengganti sandi</small>
                        </div>
                        <div class="form-group">
                            <label for="">Konfirmasi Sandi</label>
                            <input class="form-control" type="password" name="password_confirmation">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <img src="{{ url('/storage/foto/'.$user->foto) }}" alt="" width="80">
                    </div>
                    </div>

                  <hr>

                  <div class="form-buttons-w">
                    {!! xButton('', 'edit') !!}
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
