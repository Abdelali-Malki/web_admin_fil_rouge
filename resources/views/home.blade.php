@extends('layouts.app')



@section('content')

{{-- card start --}}

<div class="row pt-3 mb-3 d-flex justify-content-center">

    <div class="col-lg-3 mb-3">

            <div class="card bg-primary cursor-pointer" onclick="window.location='{{ route('collections') }}'">

                <div class="card-block text-center">

                    <div class="inline-block m-2 text-light">

                        <h1 class="no-mrg-vertical">{{$cat}}</h1>

                        <p>Total Categories</p>

                    </div>

                </div>

            </div>

    </div>

    <div class="col-lg-3 mb-3">

        <div class="card bg-info cursor-pointer" onclick="window.location='{{ route('products') }}'">

            <div class="card-block text-center">

                <div class="inline-block m-2 text-light">

                    <h1 class="no-mrg-vertical">{{$products}}</h1>

                    <p>Total Wallpapers</p>

                </div>

            </div>

        </div>
    </div>

</div>
<div class="row pt-3 mb-3 d-flex justify-content-center">

    <div class="col-2 mb-3">

            <div class="card bg-success" >

                <div class="card-block text-center">

                    <div class="inline-block m-2 text-light">

                        <h1 class="no-mrg-vertical">{{$tv}}</h1>

                        <p>Total Views</p>

                    </div>

                </div>

            </div>

    </div>

    <div class="col-2 mb-3">

            <div class="card bg-secondary" >

                <div class="card-block text-center">

                    <div class="inline-block m-2 text-light">

                        <h1 class="no-mrg-vertical">{{$td}}</h1>

                        <p>Total Download</p>

                    </div>

                </div>

            </div>

    </div>

    <div class="col-2 mb-3">

        <div class="card bg-danger" >

            <div class="card-block text-center">

                <div class="inline-block m-2 text-light">

                    <h1 class="no-mrg-vertical">{{$tf}}</h1>

                    <p>Total Favourites</p>

                </div>

            </div>

        </div>

    </div>

    <div class="col-2 mb-3">

        <div class="card bg-warning">

            <div class="card-block text-center">

                <div class="inline-block m-2 text-light">

                    <h1 class="no-mrg-vertical">{{$active_cat}}</h1>

                    <p >Active Categories</p>

                </div>

            </div>

        </div>

    </div>

    <div class="col-2 mb-3">

            <div class="card bg-dark">

                <div class="card-block text-center">

                    <div class="inline-block m-2 text-light">

                        <h1 class="no-mrg-vertical">{{$inactive_active_cat}}</h1>

                        <p>Inactive Categories</p>

                    </div>

                </div>

            </div>

    </div>

</div>

<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="col py-2">Wallpaper Statistics</div>

                <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check chart_data_type" name="chart_data_type" id="btnradio1" autocomplete="off" value="month" checked>
                    <label class="btn btn-outline-primary" for="btnradio1">
                        This Month
                        <div class="spinner-border spinner-border-custom d-none" role="status" data-rel="month">
                            <span class="sr-only"></span>
                        </div>
                    </label>

                    <input type="radio" class="btn-check chart_data_type" name="chart_data_type" id="btnradio2" value="year" autocomplete="off">
                    <label class="btn btn-outline-primary" for="btnradio2">
                        Current Year
                        <div class="spinner-border spinner-border-custom d-none" role="status" data-rel="year">
                            <span class="sr-only"></span>
                        </div>
                    </label>

                    <button class="btn btn-outline-primary dropdown-toggle chart_data_type" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Custom
                        <div class="spinner-border spinner-border-custom d-none" role="status" data-rel="custom">
                            <span class="sr-only"></span>
                        </div>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <input name="from_date" type="date" class="form-control" placeholder="From" value="<?=date('Y-m-01')?>">
                        </li>
                        <li>
                            <input name="to_date" type="date" class="form-control" placeholder="To" value="<?=date('Y-m-t')?>">
                        </li>
                        <li class="text-center">
                            <button class="btn btn-primary btn-sm submit-custom-date">Submit</button>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="card-body">
                <div id="view_line" data-url="{{ route('viewline') }}"></div>
            </div>
        </div>

{{-- card start --}}

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>


    $(document).ready(function(){

        var chart_data_type = 'month';

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let vieline_chart = $('#view_line');
        let viewline_url =  vieline_chart.attr('data-url');
        let timess = 0;

        let opt = {"chart":{"type":"area","height":350},"series":[{"name":"View","data":[]}],"markers":{"size":[6]},"xaxis":{"date":[]}};

        var chart = new ApexCharts(document.querySelector("#view_line"), opt);
        chart.render();

        callChart();

        window.setInterval(function () {
            callChart()
        },10000);

        function callChart(){
            var from_date = $('input[name="from_date"]').val();
            var to_date = $('input[name="to_date"]').val();

            $("[data-rel='"+chart_data_type+"']").removeClass('d-none');
            $("[data-rel='"+chart_data_type+"']").addClass('d-inline-block');

            $.ajax(viewline_url, {
                method: 'GET',
                data: {chart_data_type: chart_data_type, from_date: from_date, to_date: to_date},
                contentType: false,
                success(response) {
                    var options = response;
                    chart.updateOptions(options);
                    $("[data-rel='"+chart_data_type+"']").addClass('d-none');
                    $("[data-rel='"+chart_data_type+"']").removeClass('d-inline-block');
                },
                error() {
                    
                },
            });
        }

        $(document).on('change', '.chart_data_type[type="radio"]', function(){
            chart_data_type = $('.chart_data_type[type="radio"]:checked').val();
            $('.chart_data_type[type="button"]').removeClass('active');
            callChart();
        });

        $(document).on('click', '.submit-custom-date', function(){
            $('.chart_data_type[type="radio"]').prop('checked', false);
            $('.chart_data_type[type="button"]').addClass('active');
            chart_data_type = 'custom';
            callChart();
        });

    });
      </script>
@endpush
