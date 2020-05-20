@extends('layouts.app')
@section('content')
<div class="container">
{{-- model --}}
<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Modal Heading</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <form id="createResource" action="">
          @csrf
          <div class="modal-body">
             <div class="form-group">
                <label for="exampleInputPassword1">Total</label>
                <input type="number" id="price" class="form-control" name="money"  placeholder="money">
              </div>
              <div class="form-group">
                <label for="exampleInputPassword1">Note</label>
                <input type="text" id="note" class="form-control" name ="note" placeholder="note">
              </div>
              @foreach($users as $user)
              <div class="form-check">
                <input class=" check-box" type="checkbox" name ="check" value="{{ $user->id }}">
                <label class="form-check-label " for="defaultCheck1">
                  {{ $user->name }}
                </label>
              </div>
              @endforeach
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal" id="addNewCook">Add</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </form>
    </div>
  </div>
</div>
{{-- end model --}}
    <div class="row justify-content-center">
        <div class="col-md-10">
           <button type="button" class="btn btn-success mb-4" data-toggle="modal" data-target="#myModal">Thêm mới</button>
           <table class="table">
                  <thead class="thead-dark">
                    <tr>
                      <th scope="col">Dương</th>
                      <th scope="col">Đàm</th>
                      <th scope="col">Đức</th>
                      <th scope="col">Dũng</th>
                      <th scope="col">Note</th>
                      <th scope="col">Cook</th>
                      <th scope="col">Total</th>
                      <th scope="col">Ngày nấu</th>

                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>10000</td>
                      <td>10000</td>
                      <td>10000</td>
                      <td>0</td>
                      <td>Dầu ăn 50k</td>
                      <td>Đức</td>
                    </tr>
                    <tr>
                      <td>10000</td>
                      <td>10000</td>
                      <td>10000</td>
                      <td>0</td>
                      <td>Dầu ăn 50k</td>
                      <td>Đức</td>
                    </tr>
                  </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
   $(document).ready(function(){
    $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
      });
       let id = [];
       $('#addNewCook').click(function(event){
           event.preventDefault();
           $('.check-box:checked').each(function () {
               id.push($(this).val());
           });
           let price = $('#price').val();
           let note = $('#note').val();
           let data = {who_eat:id,price:price,note:note};
           let url = '/cook/store';

           callApi(data, url, "post")
               .done(response => {
                   $("#createResource")[0].reset();
                   console.log(response);
               })
               .fail(error => {
                   console.log(error);
               })
       }) ;
    function callApi(data, url, type, dataType = 'json') {
    return $.ajax({
        type: type,
        url: url,
        dataType: dataType,
        data: data,
    })
}
    })
</script>
@endsection

