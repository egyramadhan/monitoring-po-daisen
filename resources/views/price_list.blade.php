@extends('main')

@section('title', 'Price List - Daisen')

@section('content')
<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">History List Price - Procurement</strong>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th scope="col">Item Code</th>
                                <th scope="col">Description</th>
                                <th scope="col">Last Price Buying</th>
                                <th scope="col">Currency</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $dt)
                                  <tr>
                                    <td>{{ $dt->item_code}}</td>
                                    <td>{{ $dt->description}}</td>
                                    <td>{{ $dt->price_buying}}</td>
                                    <td>{{ $dt->currency}}</td>
                                    <td></td>
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