@extends('main')

@section('title', 'Price List - Daisen')
<style>
  ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 12px 0;
    padding-left: 50px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
</style>
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
                                <th scope="col">Supplier</th>
                                <th scope="col">Last Price</th>
                                <th scope="col">Deviation</th>
                                <th scope="col">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $dt)
                                  <tr>
                                    <td>{{ $dt->item_code}}</td>
                                    <td>{{ $dt->description}}</td>
                                    <td>{{ $dt->supplier}}</td>
                                    <td>{{ $dt->price_buying}}</td>
                                    <td></td>
                                    <td> 
                                      {{-- <a href="/show_history/{{ $dt->item_code }}" value="{{ $dt->item_code }}" class="btn btn-primary btn-sm btn_history" data-toggle="modal" data-target="#mediumModal"><span class="fa fa-eye"></span></a> --}}
                                      <button class="btn btn-primary btn-sm btn_history" data-toggle="modal" data-target="#mediumModal" value="{{ $dt->item_code }}"><span class="fa fa-eye"></span></button>
                                    </td>
                                  </tr>
                                @endforeach 
                            </tbody>
                          </table>
                          {{-- {{ $data->links() }} --}}

                          <div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="container mt-5 mb-5">
                                    <div class="row">
                                      <div class="col-md-6 offset-md-3">
                                        <h4>Latest News</h4>
                                        <ul class="timeline">
                                          <li>
                                            <a target="_blank" href="https://www.totoprayogo.com/#">New Web Design</a>
                                            <a href="#" class="float-right"></a>
                                            <p name="item_code"></p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque scelerisque diam non nisi semper, et elementum lorem ornare. Maecenas placerat facilisis mollis. Duis sagittis ligula in sodales vehicula....</p>
                                          </li>
                                          {{-- <li>
                                            <a href="#">21 000 Job Seekers</a>
                                            <a href="#" class="float-right">4 March, 2014</a>
                                            <p>Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
                                          </li>
                                          <li>
                                            <a href="#">Awesome Employers</a>
                                            <a href="#" class="float-right">1 April, 2014</a>
                                            <p>Fusce ullamcorper ligula sit amet quam accumsan aliquet. Sed nulla odio, tincidunt vitae nunc vitae, mollis pharetra velit. Sed nec tempor nibh...</p>
                                          </li> --}}
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
{{-- <script>
      $(document).on('click','.btn_history',function(){
        var url = "http://localhost:8000/show_history";
        var tour_id= $(this).val();
        $.get(url + '/' + tour_id, function (data) {
            //success data
            console.log(data);
            $('#item_code').val(data);
            $('#name').val(data.name);
            $('#details').val(data.details);
            $('#btn-save').val("update");
            $('#mediumModal').modal('show');
        }) 
    });
</script> --}}
<script>
  $(document).ready(function() {
    $('#example').DataTable({
      "processing": true
      // "serverSide": true
    });
} );
</script>
@endsection