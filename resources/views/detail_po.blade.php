@extends('main')

@section('title', 'Material Receipt  - Daisen')

<style>


</style>
@section('content')
    <div class="content mt-3">
        <div class="animated fadeIn">

            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Purchase Order NO</strong>
                            <small>{{ $parent_po->naming_series }}</small>
                        </div>
                        <div class="card-body">
                            supplier : {{ $parent_po->supplier }}
                            <br>
                            po no : {{ $parent_po->naming_series }}
                            <br>
                            po date : {{ $parent_po->posting_date }}
                            <br>
                            required by : {{ $parent_po->requested_by_date }}
                            <br>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <strong>Item List</strong>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped table-bordered">
                                <thead>
                                  <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Uom</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Qty Receipt</th>
                                    <th scope="col">Balance</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($po as $p)
                                      <tr>
                                        <td></td>
                                        <td>{{ $p->code}}</td>
                                        <td>{{ $p->description}}</td>
                                        <td>{{ $p->po_qty ?? $p->qty}}</td>
                                        <td>{{ $p->uom}}</td>
                                        <td>{{ $p->currency ?? $p->price}}</td>
                                        <td>{{ $p->qty_receipt ?? ''}}</td>
                                        <td>{{ $p->balance ?? ''}}</td>
                                      </tr>
                                    @endforeach
                                </tbody>
                              </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <strong class="card-title">Material Reciept</strong>
                            <small></small>
                        </div>
                        <div class="card-body">
                          <table class="table table-striped table-bordered">
                              <tr>
                                <td>#</td>
                                <td>No Material Receipt</td>
                                <td>Supplier</td>
                                <td>No Delivery Order</td>
                                <td>Time Delivery Order</td>
                                <td>Date</td>
                              </tr>
                              @foreach ($material_receipt as $mr)
                              <tr>
                                <td></td>
                                <td>{{ $mr->naming_series}}</td>
                                <td>{{ $mr->supplier}}</td>
                                <td>{{ $mr->no_delivery_order}}</td>
                                <td>{{ $mr->time_delivery_order}}</td>
                                <td>{{ $mr->posting_date}}</td>
                              </tr>
                              <tr>
                                <td></td>
                                <td colspan="6">
                                        <div class="row">
                                          <p>{{$mr->code}} <br>
                                             {{ $mr->description}} <br>
                                             {{ $mr->qty_receipt}}
                                             {{ $mr->unit}} <br>
                                             {{ $mr->price}}</p>
                                        </div>
                                </td>
                            </tr>
                              @endforeach
                          </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <div class="card">
                      <div class="card-header">
                          <strong class="card-title">Material Return</strong>
                          <small></small>
                      </div>
                      <div class="card-body">
                        <table class="table table-striped table-bordered">
                          <tr>
                            <td>#</td>
                            <td>No Material Receipt</td>
                            <td>Supplier</td>
                            <td>No Delivery Order</td>
                            <td>Time Delivery Order</td>
                            <td>Date</td>
                          </tr>
                          @foreach ($material_return as $mreturn)
                          <tr>
                            <td></td>
                            <td>{{ $mreturn->naming_series ?? ''}}</td>
                            <td>{{ $mreturn->supplier ?? ''}}</td>
                            <td>{{ $mreturn->no_delivery_order ?? ''}}</td>
                            <td>{{ $mreturn->time_delivery_order ?? ''}}</td>
                            <td>{{ $mreturn->posting_date ?? ''}}</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td colspan="6">
                                    <div class="row">
                                      <p>{{$mreturn->code ?? ''}} <br>
                                         {{ $mreturn->description ?? ''}} <br>
                                         {{ $mreturn->qty_return ?? ''}}
                                         {{ $mreturn->unit ?? ''}} <br>
                                         {{ $mreturn->price ?? ''}}</p>
                                    </div>
                            </td>
                        </tr>
                          @endforeach
                      </table>
                      </div>
                  </div>
              </div>
            </div>
        </div>
    </div> 
    <script>
      $(function() {
        $("td[colspan=3]").find("p").hide();
        $("table").click(function(event) {
            event.stopPropagation();
            var $target = $(event.target);
            if ( $target.closest("td").attr("colspan") > 1 ) {
                $target.slideUp();
            } else {
                $target.closest("tr").next().find("p").slideToggle();
        }                    
    });
});
    </script>
@endsection