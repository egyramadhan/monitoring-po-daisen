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
                          <div class="card-body card-block">
                            <div class="col-sm-1">
                                <a class="btn btn-success btn-sm" href="/list-prices">History List Price</a>
                            </div>
                            <div class="col-sm-1">
                              <a class="btn btn-warning btn-sm header-left" href="">Material Return</a>
                          </div>
                            <div class="col-sm-1">
                                <a class="btn btn-secondary btn-sm header-left" href="">Import</a>
                            </div>
                          </div>
                          <div class="card-body card-block">
                            <form action="/monitoring-po" method="get">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <input type="text" name="po_number" placeholder="Po Number" class="typeahead2 form-control">
                                </div>
                              </div>
                              <div class="col-md-3">
                                {{-- <div class="form-group">
                                 
                                  
                                  <input type="text" name="from_date" id="from_date" placeholder="From Order" class="form-control">
                                  to
                                  <input type="text" name="to_date" id="to_date" placeholder="To Order" class="form-control">
                                </div> --}}
                                <div class="row input-daterange">
                                  <div class="col-md-4">
                                      <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date"
                                          readonly />
                                  </div>
                                  <div class="col-md-4">
                                      <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date"
                                          readonly />
                                  </div>
                              </div>
                              </div>
  
                              <div class="col-md-3">
                                <div class="form-group">
                                  <input class="typeahead1 form-control" name="supplier" placeholder="Supplier" type="text">
                                </div>
                              </div>

                              <div class="col-md-3">
                                <div class="form-group">
                                  <input type="text" name="statues" placeholder="Status" class="form-control">
                                </div>
                              </div>
                              {{-- <div class="col-md-3"> --}}
                                <div class="form-group">
                                  <button class="btn btn-primary" type="submit">Search</button>
                                </div>
                              {{-- </div> --}}
                            </form>
                          </div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">PRequest</th>
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
                                        @if ( $dt->status  == 'to receipt')
                                        <td><span class="badge badge-warning">to receipt</span>
                                          <br>
                                          <span class="badge badge-danger">{{ $dt->status_close}}</span>
                                          <br>
                                          <span class="badge badge-info">{{ $dt->percentage}}%</span>
                                        </td>
                                        @elseif ( $dt->status == 'partial')
                                        <td><span class="badge badge-warning">partial</span>
                                          <br>
                                          <span class="badge badge-danger">{{ $dt->status_close}}</span>
                                          <br>
                                          <span class="badge badge-info">{{ $dt->percentage}}%</span>
                                        </td>  
                                        @else 
                                        <td><span class="badge badge-success">completed</span>
                                          <br>
                                          <span class="badge badge-danger">{{ $dt->status_close}}</span>
                                          <br>
                                          <span class="badge badge-info">{{ $dt->percentage}}%</span>
                                        </td>
                                        @endif
                                        <td><a href="/show/{{ $dt['naming_series'] }}" class="btn btn-primary"><i class="fa fa-info"></i></a></td>
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
    <script>
//  $(function () {
//     $('.input-daterange').datepicker({
//                 todayBtn: 'linked',
//                 format: 'yyyy-mm-dd',
//                 autoclose: true
//             });
//     });
         
      $(function() {
          $('input[name="from_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2015,
            maxYear: parseInt(moment().format('YYYY'),10)
          });
          $('input[name="to_date"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 2015,
            maxYear: parseInt(moment().format('YYYY'),10)
          });
        });
        
    //  $(function() {
         
    //     });
    
  </script>
@endsection