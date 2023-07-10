@extends('Layout.app')

@section('content')



<div id="mainDiv" class="container d-none">
<div class="row">
<div class="col-md-12 p-5">

<button id="addNewBtnId" class="btn my-3 btn-danger">Add New</button>	
<table id="ReviewDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
	  <th class="th-sm">Name</th>
	  <th class="th-sm">Description</th>
	  <th class="th-sm">Edit</th>
	  <th class="th-sm">Delete</th>
    </tr>
  </thead>
  <tbody id="Review_table">
  
		
	
	
	
  </tbody>
</table>

</div>
</div>
</div>



<div id="loaderDiv" class="container">
<div class="row">
<div class="col-md-12  text-center p-5">

	<img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">


</div>
</div>
</div>

<div id="WrongDiv" class="container d-none">
<div class="row">
<div class="col-md-12  text-center p-5">

	<h5>Something Went Wrong</h5>

</div>
</div>
</div>







<!-- Modal -->
<div class="modal" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body p-3 text-center">
      	<h6 class="m-3">Do You Want To Delete?</h6>
      	<h6 id="ReviewDeleteId" class="m-3 d-none"></h6>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          No
        </button>
        <button  id="ReviewDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title">Update Review</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body p-5 text-center">
      	<h6 id="ReviewEditId" class="m-3 d-none"></h6>

      	<div id="ReviewEditForm" class="d-none w-100">
      	<input id="ReviewNameId" type="text" id="" class="form-control mb-4" placeholder="Review_name">
      	<input id="ReviewDesId" type="text" id="" class="form-control mb-4" placeholder="Review_Description">
        <input id="ReviewImgId" type="text" id="" class="form-control mb-4" placeholder="Review_Image_link">
      </div>
      	<img id="ReviewLoaderId" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
      	<h5 class="d-none" id="ReviewWrongId">Something Went Wrong</h5>
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="ReviewEditConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>




<div class="modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body p-5 text-center">

      	<div id="ReviewAddForm" class="w-100">
      		<h6 class="mb-4">Add New Review</h6>
      	<input id="ReviewNameAddId" type="text" id="" class="form-control mb-4" placeholder="Review_name">
      	<input id="ReviewDesAddId" type="text" id="" class="form-control mb-4" placeholder="Review_Description">
        <input id="ReviewImgAddId" type="text" id="" class="form-control mb-4" placeholder="Review_image_link">
      	
      </div>
      	
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="ReviewAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('script')
	
	<script type="text/javascript">
	

		getReviewData();




		//For Review Table

function getReviewData() {

    axios.get('/getReviewData')
        .then(function(response) {
            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');


                $('#ReviewDataTable').DataTable().destroy();

                $('#Review_table').empty();

                var jsonData = response.data;

                $.each(jsonData, function(i, item) {

                    $('<tr>').html(
                   
                        "<td>" + jsonData[i].name + "</td>" +
                        "<td>" + jsonData[i].des + "</td>" +
                        "<td><a class='ReviewEditBtn' data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a> </td>" +
                        "<td> <a class='ReviewDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>"
                    ).appendTo('#Review_table');
                });

                
                //Review Table Delete icon Click

                $('.ReviewDeleteBtn').click(function() {
                    var id = $(this).data('id');

                    $('#ReviewDeleteId').html(id);
                    $('#deleteModal').modal('show');

                })
                 
                //Review Table Edit Icon Click
                $('.ReviewEditBtn').click(function(){
                    var id = $(this).data('id');
                    $('#ReviewEditId').html(id);
                    ReviewUpdateDetails(id);
                    $('#editModal').modal('show');
                })


                $('#ReviewDataTable').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select');


            } else {

                $('#loaderDiv').addClass('d-none');
                $('#WrongDiv').removeClass('d-none');

            }

        })
        .catch(function(error) {
            $('#loaderDiv').addClass('d-none');
            $('#WrongDiv').removeClass('d-none');
        });


}



 //Review Delete Modal Yes btn
         $('#ReviewDeleteConfirmBtn').click(function() {

         var id = $('#ReviewDeleteId').html();
          ReviewDelete(id);
         })


//Review Delete
function ReviewDelete(deleteID) {
    $('#ReviewDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

    axios.post('/ReviewDelete', {
            id: deleteID
        })
        .then(function(response) {
             $('#ReviewDeleteConfirmBtn').html("Yes");
            if (response.status==200) {
                 if (response.data == 1) {
                $('#deleteModal').modal('hide');
                toastr.success('Successfully Deleted');
                getReviewData();
            } else {
                $('#deleteModal').modal('hide');
                toastr.error('Delete Failed');
                getReviewData();

            }

           
            }
            else{
                $('#deleteModal').modal('hide');
             toastr.error('Something Went Wrong !');

            }

        })
        .catch(function(error) {
              $('#deleteModal').modal('hide');
             toastr.error('Something Went Wrong !');

        });
}



//Each Review Update details
function ReviewUpdateDetails(detailsID) {
    axios.post('/ReviewDetails', {
            id:detailsID,
        })
        .then(function(response) {

            if (response.status==200) {
                $('#ReviewEditForm').removeClass('d-none');
                $('#ReviewLoaderId').addClass('d-none');

                var jsonData=response.data;
                $('#ReviewNameId').val(jsonData[0].name);
                $('#ReviewDesId').val(jsonData[0].des);
                $('#ReviewImgId').val(jsonData[0].img);



            }
            else{
                $('#ReviewLoaderId').addClass('d-none');
                 $('#ReviewWrongId').removeClass('d-none');

            }

           

        })
        .catch(function(error) {
             $('#ReviewLoaderId').addClass('d-none');
             $('#ReviewWrongId').removeClass('d-none');


    });
}



//Review Edit Modal Save btn
 $('#ReviewEditConfirmBtn').click(function() {

     var id = $('#ReviewEditId').html();
     var name = $('#ReviewNameId').val();
     var desc = $('#ReviewDesId').val();
     var img = $('#ReviewImgId').val();
                 
    ReviewUpdate(id,name,desc,img);

    })




function ReviewUpdate(ReviewID,ReviewName,ReviewDesc,ReviewImg) {

    if (ReviewName.length==0) {
        toastr.error('Review Name is Empty !');
    }

    else if(ReviewDesc.length==0) {
    toastr.error('Review Description is Empty !');
    }
     else if(ReviewImg.length==0){
     toastr.error('Review Image is Empty !');
    }
   
    else{
        $('#ReviewEditConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ReviewUpdate', {
            id:ReviewID,
            name:ReviewName,
            desc:ReviewDesc,
            img:ReviewImg,

        })
        .then(function(response) {
            $('#ReviewEditConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#editModal').modal('hide');
                toastr.success('Successfully Updated');
                getReviewData();
            } else {
                $('#editModal').modal('hide');
                toastr.error('Update Failed');
                getReviewData();
            }

          }
            else
            {
              $('#editModal').modal('hide');
                toastr.error('Something Went Wrong !');
            }
              


          

        })
        .catch(function(error) {
            $('#editModal').modal('hide');
                toastr.error('Something Went Wrong !');
             
    });

    }
}
  

//Review Add New Btn Click

$('#addNewBtnId').click(function(){

    $('#addModal').modal('show');

});


$('#ReviewAddConfirmBtn').click(function() {

     var name = $('#ReviewNameAddId').val();
     var desc  = $('#ReviewDesAddId').val(); 
     var img = $('#ReviewImgAddId').val();       
     ReviewAdd(name,desc,img);

    })


//Review Add method
function ReviewAdd(ReviewName,ReviewDesc,ReviewImg) {

    if (ReviewName.length==0) {
        toastr.error('Review Name is Empty !');
    }
    else if(ReviewDesc.length==0){
      toastr.error('Review Description is Empty !');
    }
    else if(ReviewImg.length==0){
     toastr.error('Review Image is Empty !');
    }
    
    
    else{
        $('#ReviewAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ReviewAdd',{
            name:ReviewName,
            desc:ReviewDesc,
            img:ReviewImg,
        })
        .then(function(response) {
            $('#ReviewAddConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#addModal').modal('hide');
                toastr.success('Successfully Added');
                getReviewData();
            } else {
                $('#addModal').modal('hide');
                toastr.error('Add Failed');
                getReviewData();
            }

          }
            else
            {
              $('#addModal').modal('hide');
                toastr.error('Something Went Wrong !');
            }
              


          

        })
        .catch(function(error) {
            $('#addModal').modal('hide');
                toastr.error('Something Went Wrong !');
             
    });

    }
}
		
	</script>

@endsection