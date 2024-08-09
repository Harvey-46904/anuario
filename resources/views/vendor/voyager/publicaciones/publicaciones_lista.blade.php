@extends('voyager::master')

@section('page_title', __('Anuario Users'))
@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop


@section('page_header')
    <div class="container-fluid">
        <h1 class="page-title">
            <i class="voyager-person"></i> {{ __('Aqui estan tus mejores recuerdos') }}
        </h1>
        <a href="{{ route('publicaciones.create', ['id_anuario' => $anuario]) }}" class="btn btn-success btn-add-new">
            <i class="voyager-plus"></i> <span>{{ __('Publicar en este anuario') }}</span>
        </a>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
            publicacion agregada correctamente al anuario
        </div>
    @endif
        
        <div class="panel panel-bordered">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-hover">
                        <thead>
                            <tr>
                                @if($showCheckboxColumn)
                                    <th class="dt-not-orderable">
                                        <input type="checkbox" class="select_all">
                                    </th>
                                @endif
                               
                                <th>Nombre</th>
                                <th>Recuerdo</th>
                               
                                <th class="actions text-right dt-not-orderable">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dataTypeContent as $item)
                                <tr>
                                    @if($showCheckboxColumn)
                                        <td>
                                            <input type="checkbox" name="row_id" class="select_row" value="{{ $item->id }}">
                                        </td>
                                    @endif
                                    <td>{{ $item->descripcion }}</td>
                                    <td>
                                        <img src="{{ filter_var($item->foto, FILTER_VALIDATE_URL) ? $item->foto : Voyager::image( $item->foto ) }}" style="width:200px; height:auto; clear:both; display:block; padding:2px; border:1px solid #ddd; margin-bottom:10px;" />
                                    </td>
                                    
                                  
                                    <td class="no-sort no-click bread-actions">
                                    <!-- <a href="javascript:;" class="btn btn-sm btn-danger pull-right delete" data-id="{{ $item->id }}">
                                            <i class="voyager-trash"></i> {{ __('Delete') }}
                                        </a> -->
                                       
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $dataTypeContent->links() }}
            </div>
        </div>
    </div>

    {{-- Bulk delete modal --}}
    <div class="modal modal-danger fade" tabindex="-1" id="bulkDeleteModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> {{ __('Delete Selected') }}?</h4>
                </div>
                <div class="modal-footer">
                    <form action="" id="bulk-delete-form" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="ids" class="selected_ids" value="">
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="{{ __('Confirm') }}">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">{{ __('Cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script>
        $(document).ready(function () {
            $('.select_all').on('click', function(e) {
                $('input[name="row_id"]').prop('checked', $(this).prop('checked')).trigger('change');
            });

            $('input[name="row_id"]').on('change', function () {
                var ids = [];
                $('input[name="row_id"]:checked').each(function() {
                    ids.push($(this).val());
                });
                $('.selected_ids').val(ids);
            });

            $('td').on('click', '.delete', function (e) {
                var id = $(this).data('id');
                var form = $('#bulk-delete-form');
                form.find('.selected_ids').val(id);
                form.submit();
            });
        });
    </script>
@stop
