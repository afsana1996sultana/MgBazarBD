@extends('admin.admin_master')
@section('admin')
<section class="content-main">
    <div class="content-header">
        <h3 class="content-title">Career list <span class="badge rounded-pill alert-success"> {{ count($career) }} </span></h3>
    </div>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive-sm">
                <table id="example" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>
                            <th scope="col">Sl</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Name (English)</th>
                            <th scope="col">Name (Bangla)</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Address</th>
                            <th scope="col">Status</th>
                            <th scope="col" class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($career as $key => $val)
                        <tr>
                            <td> {{ $key+1}} </td>
                            <td width="15%">
                                <a href="#" class="itemside">
                                    <div class="left">
                                        <img src="{{ asset($val->image) }}" class="img-sm img-avatar" alt="Userpic" />
                                    </div>
                                </a>
                            </td>
                            <td> {{ $val->name_english ?? 'NULL' }} </td>
                            <td> {{ $val->name_bangla ?? 'NULL' }} </td>
                            <td> {{ $val->email ?? 'NULL' }} </td>
                            <td> {{ $val->phone ?? 'NULL' }} </td>
                            <td> {{ $val->present_add ?? 'NULL' }} </td>
                            <td>
                                @if($val->status == 1)
                                  <a href="{{ route('career.in_active',['id'=>$val->id]) }}">
                                    <span class="badge rounded-pill alert-success">Active</span>
                                  </a>
                                @else
                                  <a href="{{ route('career.active',['id'=>$val->id]) }}" > <span class="badge rounded-pill alert-danger">Pending</span></a>
                                @endif
                            </td>
                            <td class="text-end">
                                <a class="btn btn-md rounded font-sm" href="{{ route('career.view', $val->id) }}">View</a>
                                <a class="btn btn-md rounded font-sm" href="{{ route('career.edit', $val->id) }}">Edit</a>
                                <a class="btn btn-md rounded font-sm bg-danger" href="{{ route('career.delete',$val->id) }}" id="delete">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- table-responsive //end -->
        </div>
        <!-- card-body end// -->
    </div>
</section>
@endsection
