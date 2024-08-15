@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Slider List <span class="badge rounded-pill alert-success"> {{ count($sliders) }} </span></h2>
        <div>
            <a href="{{ route('slider.create') }}" class="btn btn-primary"><i class="material-icons md-plus"></i> Create Slider</a>
        </div>
    </div>
    <div class="card mb-4">
        <!-- card-header end// -->
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                      <tr>
                        <th>Sl</th>
                        <th>Slider Img</th>
                        <th>Title (English)</th>
                        <th>Description (Bangla)</th>
                        <th>Description (English)</th>
                        <th>Status</th>
                        <th class="text-end">Action</th>
                      </tr>
                    </thead>
                        <tbody>
                            @foreach($sliders as $key => $slide)
                              <tr>
                                <td> {{ $key+1}} </td>
                                <td width="15%">
                                    <a href="#" class="itemside">
                                        <div class="left">
                                            <img src="{{ asset($slide->slider_img) }}" width="70px" height="70px;" class="img-sm img-avatar" alt="Userpic">
                                        </div>
                                    </a>
                                </td>
                                <td> {{ $slide->title_en ?? 'NULL' }} </td>
                                <td> {{ $slide->description_bn ?? 'NULL' }} </td>
                                <td> {{ $slide->description_en ?? 'NULL' }} </td>
                                 <td>
                                    @if($slide->status == 1)
                                      <a href="{{ route('slider.in_active',['id'=>$slide->id]) }}">
                                        <span class="badge rounded-pill alert-success">Active</span>
                                      </a>
                                    @else
                                      <a href="{{ route('slider.active',['id'=>$slide->id]) }}" > <span class="badge rounded-pill alert-danger">Disable</span></a>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <a class="btn btn-md rounded font-sm" href="{{ route('slider.edit',$slide->id) }}">Edit</a>
                                        <a class="btn btn-md rounded font-sm bg-danger" href="{{ route('slider.destroy',$slide->id) }}" id="delete">Delete</a>
                                    </div>
                                    <!-- dropdown //end -->
                                </td>
                              </tr>
                            @endforeach
                        </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- card end// -->
</section>
@endsection