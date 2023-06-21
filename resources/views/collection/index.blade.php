@extends('layouts.app')



@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">Categories</h1>

    <div class="btn-toolbar mb-2 mb-md-0">

        <div class="btn-group me-2">

            <a href="{{ route('collections-new') }}" class="btn btn-sm btn-secondary"><i class="fas fa-plus fa-xs"></i> Add New Category</a>

        </div>

    </div>

</div>



@include('./../flash-messages')



<div class="container p-0">

    <div class="row">

        <div class="col-12">

            <table id="collection-table" class="table table-striped table-hover">

                <thead>

                    <tr>

                        <th>#</th>

                        <th></th>

                        <th>Name</th>

                        <th></th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>



@endsection



@push('scripts')

<script>

var collectionAjaxSource = "{{ route('collections-data') }}";

var collectionAjaxDelete = "{{ route('collections-delete') }}";



$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});



var tt = $('#collection-table').DataTable({

    "scrollX":false,

    "processing": true,

    "serverSide": false,

    "searching": true,

    "ajax": {

        "url": collectionAjaxSource,

        "type": "GET",

    },

    dom: 'Bfrtip',

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

            "data": "cover_photo",

            "title": "Cover Photo",

            "render": function(data, type, row, meta){

                return `<a target="_blank" href="{{ asset('images/collections/') }}/${data}"><img class="img-fluid img-thumbnail rounded table-product-image" src="{{ asset('images/collections/') }}/${data}"/></a>`;

            }

        },



        {

            "data": "name"

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

                url: collectionAjaxDelete,

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

    window.location = `${BASE_URL}/categories/edit/${id}`;

});

</script>

@endpush
