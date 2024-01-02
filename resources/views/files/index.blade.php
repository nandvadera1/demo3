@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Files</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/home">Home</a></li>
                    <li class="breadcrumb-item active">Files</li>
                </ol>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2 class="card-title">Files</h2>
                        <a class="btn btn-primary float-right" href="/admin/files/create" role="button">Add File</a>
                    </div>
                    <div class="card-body">
                        <x-adminlte-datatable id="table1" :heads="$heads" :config="$config" bordered>
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#table1').on('click', '.btn_delete', function () {
                var id = $(this).data('id');
                var url = "/admin/files/" + id;
                var deleteConfirm = confirm("Are you sure you want to delete this File?");
                if (deleteConfirm === true) {
                    var token = $("meta[name='csrf-token']").attr("content");
                    $.ajax(
                        {
                            url: url,
                            type: 'DELETE',
                            data: {
                                "id": id,
                                "_token": token,
                            },
                            success: function (response) {
                                console.log("File deleted successfully");
                            }
                        });
                    $('#table1').DataTable().ajax.reload();
                }
            });
        });
    </script>
@stop
