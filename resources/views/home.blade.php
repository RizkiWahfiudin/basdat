@extends('master.master')

{{-- @section('page_title','::Beranda') --}}

@section('konten')
<div class="content-panel-toggler">
  </div>
  <div class="content-i">
    <div class="content-box">
      <div class="row">
        <div class="col-sm-12">
            <h6 class="element-header">
                Dashboard
            </h6>
            <br>

        </div>
      </div>

    </div>
    <!--------------------
    START - Sidebar
    -------------------->

    <!--------------------
    END - Sidebar
    -------------------->
  </div>
  <input type="hidden" name="_token" value="{{ csrf_token() }}">
@endsection

@section('my-script')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script> --}}

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
@endsection
