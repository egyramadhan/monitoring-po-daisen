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
                          <table class="table table-striped table-boldered nowrap data-table" id="datatable" style="width:100%;">
                            <thead>
                              <tr>
                                <th>Item Code</th>
                                <th>Description</th>
                                <th>Supplier</th>
                                <th>Price</th>
                                <th></th>
                                <th>Deviation</th>
                                <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>

                            </tbody>
                          </table>
                          {{-- {!! $dataTable->table() !!} 
                          {!! $dataTable->scripts() !!} --}}
                          {{-- <div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
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
                                          <li>
                                            <a href="#">21 000 Job Seekers</a>
                                            <a href="#" class="float-right">4 March, 2014</a>
                                            <p>Curabitur purus sem, malesuada eu luctus eget, suscipit sed turpis. Nam pellentesque felis vitae justo accumsan, sed semper nisi sollicitudin...</p>
                                          </li>
                                          <li>
                                            <a href="#">Awesome Employers</a>
                                            <a href="#" class="float-right">1 April, 2014</a>
                                            <p>Fusce ullamcorper ligula sit amet quam accumsan aliquet. Sed nulla odio, tincidunt vitae nunc vitae, mollis pharetra velit. Sed nec tempor nibh...</p>
                                          </li> 
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                         </div> --}}
                         <div class="modal fade" id="ajaxModel" aria-hidden="true">
                          <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h4 class="modal-title" id="modelHeading"></h4>
                                  </div>
                                  <div class="modal-body">
                                      <form id="productForm" name="productForm" class="form-horizontal">
                                         <input type="hidden" name="product_id" id="product_id">
                                          <div class="form-group">
                                              <label for="name" class="col-sm-2 control-label">Name</label>
                                              <div class="col-sm-12">
                                                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" maxlength="50" required="">
                                              </div>
                                          </div>
                           
                                          <div class="form-group">
                                              <label class="col-sm-2 control-label">Details</label>
                                              <div class="col-sm-12">
                                                  <textarea id="detail" name="detail" required="" placeholder="Enter Details" class="form-control"></textarea>
                                              </div>
                                          </div>
                            
                                          <div class="col-sm-offset-2 col-sm-10">
                                           <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                                           </button>
                                          </div>
                                      </form>
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
<script>
      
</script>
<script type="text/javascript">
  $(document).ready(function () {
    
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        dom: 'Blfrtip',
            buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "{{ route('prices.index') }}",
        columns: [
            {data: 'item_code', name: 'item_code'},
            {data: 'description', name: 'description'},
            {data: 'supplier', name: 'supplier'},
            {data: 'price_buying', name: 'price_buying'},
            {data: 'indicator', name: 'indicator'},
            {data: 'deviation', name: 'deviation'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('body').on('click', '.showProduct', function () {
      var product_id = $(this).data('id');
      console.log(product_id)
      $.get("{{ route('prices.index') }}" +'/'+ product_id, function (data) {
        console.log(data)
          // $('#modelHeading').html("Edit Product");
          // $('#saveBtn').val("edit-user");
          $('#ajaxModel').modal('show');
          // $('#product_id').val(data.id);
          // $('#name').val(data.name);
          // $('#detail').val(data.detail);
      })
   });

  });
</script>
@endsection