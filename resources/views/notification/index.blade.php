@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Notification history</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary pusher"><i class="fas fa-plus fa-xs"></i> New Notification</a>
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
                        <th>Title</th>
                        <th>Description</th>
                        <th>Collection</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

 {{-- pusher modal start --}}
 <div class="modal fade" id="push_notification" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel">Push Notification</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="post" id="pusher_form" action="javascript.void(0)">
                @csrf
                <div class="form-group pb-3" id="currentPass-group">
                    <label for="current_pass">Title:</label>
                    <input class="form-control" type="text" name="title" value=''>
                    <span class="text-danger error_title"></span>
                </div>

                <div class="form-group pb-3">
                    <label for="new_pass">Description:</label>
                    <textarea class="form-control" name="description" ></textarea>
                    <span class="text-danger error_description"></span>
                </div>

                <div class="form-group pb-3">
                    <label for="new_pass">Which Screen Will Open:</label>
                    <select class="form-control" id="" name="collection">
                        <option value="HOME">Opne Home Screen</option>
                        @foreach ($collections as $v)
                        <option value={{$v->id}}>{{$v->name}}</option>
                        @endforeach
                      </select>
                    <span class="text-danger error_collection"></span>
                </div>


                <span class="push_status_error text-danger pb-3" style="display:block"></span>

                <div class="mt-0">
                    <button type="submit" name="submit" class="btn btn-success" id="pusher_form-submit" value="Save changes">Send</button>
                </div>

            </form>

        </div>
      </div>
    </div>
  </div>
{{-- pusher modal end --}}
@endsection

@push('scripts')

<script>

var productAjaxSource = "{{ route('notification-data') }}";


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

        },
        {
            "data": "title",
        },
        {
            "data": "description",

        },
        {
            "data":"collection",
            "render":(data, type, row)=>{
                if(data != 0){
                    return row.collection_name.name;
                }else{
                    return 'HOME';
                }
            }
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

    ],
});

$(document).on("click",".pusher",function(){
                $("#push_notification").modal("show");
            })

            $(document).on("click","#pusher_form-submit",function(e){
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "{{route('save-pusher')}}",
                    data: $("#pusher_form").serialize(),
                    success: function (response) {
                        const {status,message} = response
                            if(status == 'error'){
                                $(".push_status_error").html(message)
                                $.each(response['errors'], function (key, value) {
                                    console.log(key);
                                    $('.error_'+key).html(value);
                                });
                            }
                            if(status=='success'){
                                $("#pusher_form")[0].reset();
                                $("#push_notification").modal("hide");
                                tt.ajax.reload(null, false);
                            swal({
                                icon: 'success',
                                title: 'Success',
                                text: `${message}`,
                            })
                        }
                    }
                });

            })

</script>
@endpush
