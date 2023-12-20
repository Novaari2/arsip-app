@extends('layouts.app')

@section('content')
      <style>
         td img {
            width: 30% !important;
            height: auto !important;
         }
         .card {
          margin: 1rem auto;
         }
      </style>
      <div class="page-header">
        <h3 class="page-title">
          <span class="page-title-icon text-white mr-2 red-text">
            <i class="mdi mdi-home"></i>
          </span> Dashboard
        </h3>
        <nav aria-label="breadcrumb">
          <ul class="breadcrumb">
            <li class="breadcrumb-item active" aria-current="page">
              <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm align-middle" style="color: #EF5350"></i>
            </li>
          </ul>
        </nav>
      </div>

        <div class="col-md-4 stretch-card grid-margin">
          <div class="card bg-red card-img-holder text-white">
            <div class="card-body">
              <img src="{{asset('assets/images/dashboard/circle.svg')}}" class="card-img-absolute" alt="circle-image">
              <h4 class="font-weight-normal mb-3">User <i class="mdi mdi-account-check mdi-24px float-right"></i>
              </h4>
              <h2 class="mb-5"></h2>
            </div>
          </div>
        </div>
    </div>
@endsection
@section('script')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/2.1.0/chartjs-plugin-datalabels.min.js"></script>
@endsection
