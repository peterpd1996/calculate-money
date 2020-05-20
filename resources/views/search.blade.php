<!DOCTYPE html>
<html>
 <head>
  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
  <br />
  <div class="container">

   <div class="row">
    <div class="col-md-9">

    </div>
    <div class="col-md-3">
     <div class="form-group">
      <input type="text" name="serach" id="serach" class="form-control" />
     </div>
    </div>
   </div>
   <div class="table-responsive">
    <table class="table table-striped table-bordered">
     <thead>
      <tr>
       <th>ID</th>
       <th>Name</th>
       <th>Subject</th>
       
      </tr>
     </thead>
     <tbody id="body"> 
         @include('navigation');
     </tbody>
    </table>
    <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
    
   </div>
  </div>
   
 </body>
</html>
<script>
   $(document).ready(function(){
      $(document).on('keyup', '#serach', function(){
         var query = $('#serach').val();
         var page = $('#hidden_page').val();
         fetch_data(page,query);
         
         });
   });
   $(document).on('click', '.pagination a', function(event){
               event.preventDefault();
               var page = $(this).attr('href').split('page=')[1];
               $('#hidden_page').val(page);
               var query = $('#serach').val();
               $('li').removeClass('active');
               $(this).parent().addClass('active');
               fetch_data(page,query);
 });
   function fetch_data(page,query)
   {
      
      $.ajax({
         url:"/search/fetch_data?query="+query+"&page="+page+"",
         success:function(data)
         {
            if(data!='')
            {
               $('#body').html('');
               $('#body').html(data);
            }
         }
         
      })
   }
</script>