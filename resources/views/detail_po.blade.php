@extends('main')

@section('title', 'Material Receipt  - Daisen')

<style>
tr.hide-table-padding td {
  padding: 0;
}

.expand-button {
	position: relative;
}

.accordion-toggle .expand-button:after
{
  position: absolute;
  left:.75rem;
  top: 50%;
  transform: translate(0, -50%);
  content: '-';
}

.accordion-toggle.collapsed .expand-button:after
{
  content: '+';
}

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
                              <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">No Material Receipt</th>
                                      <th scope="col">Supplier</th>
                                      <th scope="col">No Delivery Order</th>
                                      <th scope="col">Time Delivery Order</th>
                                      <th scope="col">Date</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      @foreach ($material_receipt as $mr)
                                      <tr class="accordion-toggle collapsed" id='accordion1' data-toggle="collapse" data-parent="#accordion1" href="#collapseOne{{ $counter_parent++ }}">
                                        <td class="expand-button"></td>
                                        <td>{{ $mr->naming_series}}</td>
                                        <td>{{ $mr->supplier}}</td>
                                        <td>{{ $mr->no_delivery_order}}</td>
                                        <td>{{ $mr->time_delivery_order}}</td>
                                        <td>{{ $mr->posting_date}}</td>
                                      </tr>
                                        <tr class="hide-table-padding">
                                            <td></td>
                                            <td colspan="6">
                                            <div id="collapseOne{{ $counter_child++ }}" class="collapse in p-3">
                                                    <div class="row">
                                                        <div class="col-2">Code : <strong>{{$mr->code}}</strong></div>
                                                        <div class="col-2">Description : <strong>{{ $mr->description}}</strong></div>
                                                        <div class="col-2">Qty : <strong>{{ $mr->qty_receipt}}</strong></div>
                                                        <div class="col-2">UOM : <strong>{{ $mr->unit}}</strong></div>
                                                        <div class="col-2">Price : <strong>{{ $mr->price}}</strong></div>
                                                    </div>
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
    </div> 
    <script>
        $('.accordion-toggle').click(function(){
	$('.hiddenRow').hide();
	$(this).next('tr').find('.hiddenRow').show();
});
    </script>
@endsection