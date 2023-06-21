@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Wallpapers</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('products-new') }}" class="btn btn-sm btn-secondary"><i class="fas fa-plus fa-xs"></i> Add New Wallpaper</a>
        </div>
    </div>
</div>

@include('./../flash-messages')

<div class="container p-0">
    <div class="row">
        <div class="col-12">
            <table id="product-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th></th>
                        <th>Name</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>

var productAjaxSource = "{{ route('products-data') }}";
var productAjaxDelete = "{{ route('products-delete') }}";
var collectionNameAjax = "{{ route('products-collection-name') }}";

$(document).ready(function () {
    $('.parent-c-d').magnificPopup({
        delegate: 'a',
        type: 'image'
    })
});



$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

var tt = $('#product-table').DataTable({
    "scrollX":false,
    "processing": true,
    "serverSide": true,
    "searching": true,
    "ajax": {
        "url": productAjaxSource,
        "type": "GET",
    },

    "columns": [
        {
            "className": 'index-td',
            "orderable": false,
            "searchable": false,
            "data": null,
            "defaultContent": '#',
            "width": "5%",
            "render" : function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {
            "data": "photo",
            "title": "Photo",
            "render": function(data, type, row, meta){
                return `<div class="parent-c-d"><a target="_blank" class="magnify_image" href="{{ asset('images/products/') }}/${data}"><img class="img-fluid img-thumbnail rounded table-product-image" src="{{ asset('images/products/webp/') }}/${data}.webp"/></a></div>`;
            }
        },
        {
            "data": "name",
            "render": function(data,type,row,meta){
                let dd = `<strong>${data}</strong>`;
                if(row.collections_name!=null){
                    dd += `<br><span class='colName'><i>${row.collections_name}</i></span>`;
                }
                if(row.colors_name!=null){
                    dd += `<br><span class='colName'><i>${row.colors_name}</i></span>`;
                }
                if(row.tags!=null){
                    dd += `<br><span class='tagName'><i>${row.tags.replaceAll(",", ", ")}</i></span>`;
                }
                return dd;
            }
        },
        {
            "data": "total_heart_count",
            "title": "Heart Count"
        },
        {
            "data": "total_download_count",
            "title": "Download Count"
        },
        {
            "data": "total_view_count",
            "title": "View Count"
        },
        {
            "data": "created_at",
            "title": "Created At",
            "render": function(data){
                let today = new Date(data);
                let dd = today.getDate();

                let mm = today.getMonth()+1;
                const yyyy = today.getFullYear();
                if(dd<10)
                {
                    dd=`0${dd}`;
                }

                if(mm<10)
                {
                    mm=`0${mm}`;
                }
                today = `${dd}-${mm}-${yyyy}`;
                return today;
            }
        },
        {
            "orderable": false,
            "searchable": false,
            "data": null,
            "width": "15%",
            "title":"Action",
            "render":function(data,type,row){
                var pay_button ="";
                pay_button =`<button class='btn btn-sm btn-info edit-collection' title='Edit' data-id='${data.id}'>Edit</button> <button class='btn btn-sm btn-danger delete-collection' title='Delete' data-id='${data.id}'>DEL</button>`;
                return pay_button;
            }

        },
    ],
});

$(document).on('click', '.delete-collection', function(){

    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            $.ajax({
                type: "post",
                url: productAjaxDelete,
                data: {"id":$(this).data('id')},
                success: function (response) {
                    let {status} = response;
                    if (status == "success") {
                        tt.ajax.reload(null, false);
                    }
                }
            });
        }
    });
});

$(document).on('click', '.edit-collection', function(){
    let id = $(this).data('id');
    window.location = `${BASE_URL}/wallpapers/edit/${id}`;
});
</script>
@endpush
