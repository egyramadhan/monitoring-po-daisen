@extends('main')

@section('title', 'Monitoring Purchase Order - Daisen')

@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">

            <div class="row">

                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Monitoring PO - Procurement</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">PR</th>
                                    <th scope="col">PO</th>
                                    <th scope="col">Requested By</th>
                                    <th scope="col">Supplier Name</th>
                                    <th scope="col">Date Ordered</th>
                                    <th scope="col">Required By</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt)
                                      <tr>
                                        <td>{{ $dt->material_request}}</td>
                                        <td>{{ $dt->naming_series}}</td>
                                        <td>{{ $dt->request_by}}</td>
                                        <td>{{ $dt->supplier}}</td>
                                        <td>{{ $dt->posting_date}}</td>
                                        <td>{{ $dt->requested_by_date}}</td>
                                        <td><span class="badge badge-warning">To Receive</span></td>
                                        <td><a href="/show/{{ $dt->naming_series }}" class="btn btn-primary"><i class="fa fa-info"></i></a></td>
                                      </tr>
                                    @endforeach
                                </tbody>
                              </table>
                              {{ $data->links() }}
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div> 
@endsection