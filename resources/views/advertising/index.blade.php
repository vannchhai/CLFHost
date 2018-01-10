@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="block-header">
            <h2>ADVERTISINGS</h2>
        </div>
        <div class="row clearfix">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="header">
                            <div class="row clearfix">
                                <div class="col-xs-12 col-sm-6">
                                    <h2>ADVERTISINGS CONFIGURE</h2>
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
                                            <th>Slug</th>
                                            <th>Provider Name</th>
                                            <th>Date</th>
                                            <th>Active</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; ?>
                                        @foreach($listAdvertising as $key)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key->slug }}</td>
                                            <td>{{ $key->provider_name }}</td>
                                            <td>{{ $key->created_at }}</td>
                                            <td>{{ ($key->active == 1) ? "On" : "Off" }}</td>
                                            <td class="text-nowap">
                                                <a href="{{ url('/ads_edit') . '/' . $key->id }}" title="Edit" class="btn btn-info"><i class="material-icons">open_in_new</i></a>
                                                @if($key->active == 1)
                                                <a href="{{ url('/ads_block') . '/' . $key->id }}" class="btn btn-danger"><i class="material-icons" title="Block Ads">block</i></a>
                                                @else
                                                <a href="{{ url('/ads_reblock') . '/' . $key->id }}" class="btn btn-info"><i class="material-icons" title="Undo Block">undo</i></a>
                                                @endif
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

