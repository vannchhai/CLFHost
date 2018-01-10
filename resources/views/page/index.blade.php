@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>PAGES</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>PAGE</h2>
                                </div>
                            </div>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div class="table-responsive">
                                @if(Session::has('msg'))
                                   <div class="alert bg-green alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        {{Session::get('msg')}}
                                    </div>
                                @endif
                                <br>
                                <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Page Name</th>
                                            <th>Description</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($listPage as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->name }}</td>
                                            <td>{{ $key->description }}</td>
                                            <td>{{ $key->active }}</td>
                                            <td class="text-nowap">
                                                <a href="{{ url('/page_detail') . '/' . $key->id }}" class="btn btn-warning"><i class="material-icons" title="Detail">list</i></a>
                                                <a href="{{ url('/page_edit') . '/' . $key->id }}" title="Edit" class="btn btn-info"><i class="material-icons">open_in_new</i></a>
                                                <a href="{{ url('/page_block') . '/' . $key->id }}" title="Block" class="btn btn-danger"><i class="material-icons">block</i></a>
                                                <!-- <a href="#" class="btn btn-danger"><i class="material-icons" title="Block user">block</i></a> -->
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection

