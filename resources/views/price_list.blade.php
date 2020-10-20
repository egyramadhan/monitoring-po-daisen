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
                          <div class="modal fade" id="ajaxModel" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="container mt-5 mb-5">
                                    <div id="result"></div>
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
            {data: 'deviation', name: 'deviaion'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('body').on('click', '.showProduct', function () {

      var product_id = $(this).data('id');
      console.log(product_id)
      $.get("{{ route('prices.index') }}" +'/'+ product_id, function (data) {
        
          $('#ajaxModel').on('hidden.bs.modal', function (e) {
            e.preventDefault();
            location.reload()
            })

          $('#ajaxModel').modal('show');
          buildDatas(data)
          function buildDatas(data){
            var logHistory = document.getElementById('result')
            for (var i = 0; i < data.length; i++){
              console.log(data[i])
              var showLog = `<div class="row"><div class="col-md-6 offset-md-3">
                              <ul class="timeline">
                                <li><a target="_blank" href="/show/${data[i].no_po}"><strong>${data[i].no_po}</strong></a>
                                <a href="#" class="float-right">${data[i].creation}</a><p>${data[i].item_code}<br>${data[i].description}<br><strong>Rp. ${data[i].price_buying}</strong></p>
                                </li>
                              </ul>
                            </div>
                            </div>`
              logHistory.innerHTML += showLog
            }
          }
      })
   });
  });
</script>
@endsection