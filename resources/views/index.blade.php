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
                            <form action="/monitoring-po" method="get">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <input type="text" name="po_number" placeholder="Po Number" class="typeahead2 form-control">
                                </div>
                              </div>
  
                              <div class="col-md-2">
                                <div class="form-group">
                                  <input type="date" name="dates" placeholder="Date Order" class="form-control">
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
                                        <td><span class="badge badge-warning">to receipt</span></td>
                                        @elseif ( $dt->status == 'partial')
                                        <td><span class="badge badge-warning">partial</span></td>  
                                        @else 
                                        <td><span class="badge badge-primary">completed</span></td>
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
    {{-- <script type="text/javascript">
      var path = "{{ route('autocomplete') }}";
      $('input.typeahead1').typeahead({
          source:  function (supp, process) {
          return $.get(path, { supp: supp }, function (sup_data) {
                  return process(sup_data);
              });
          }
      });
    </script>
    <script type="text/javascript">
      var path = "{{ route('autocomplete_po') }}";
      $('input.typeahead2').typeahead({
          source:  function (po_no, process) {
          return $.get(path, { po_no: po_no }, function (data) {
                  return process(data);
              });
          }
      });
  </script> --}}
@endsection