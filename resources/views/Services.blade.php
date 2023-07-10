@extends('Layout.app')

@section('content')



<div id="mainDiv" class="container d-none">
<div class="row">
<div class="col-md-12 p-5">

<button id="addNewBtnId" class="btn my-3 btn-danger">Add New</button>	
<table id="serviceDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th class="th-sm">Image</th>
	  <th class="th-sm">Name</th>
	  <th class="th-sm">Description</th>
	  <th class="th-sm">Edit</th>
	  <th class="th-sm">Delete</th>
    </tr>
  </thead>
  <tbody id="service_table">
  
		
	
	
	
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
      	<h6 id="serviceDeleteId" class="m-3 d-none"></h6>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          No
        </button>
        <button  id="serviceDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title">Update Service</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body p-5 text-center">
      	<h6 id="serviceEditId" class="m-3 d-none"></h6>

      	<div id="serviceEditForm" class="d-none w-100">
      	<input id="serviceNameId" type="text" id="" class="form-control mb-4" placeholder="Service_name">
      	<input id="serviceDesId" type="text" id="" class="form-control mb-4" placeholder="Service_Description">
      	<input id="serviceImgId" type="text" id="" class="form-control mb-4" placeholder="Service_image_link">
      </div>
      	<img id="serviceLoaderId" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
      	<h5 class="d-none" id="serviceWrongId">Something Went Wrong</h5>
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="serviceEditConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>




<div class="modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body p-5 text-center">

      	<div id="serviceAddForm" class="w-100">
      		<h6 class="mb-4">Add New Services</h6>
      	<input id="serviceNameAddId" type="text" id="" class="form-control mb-4" placeholder="Service_name">
      	<input id="serviceDesAddId" type="text" id="" class="form-control mb-4" placeholder="Service_Description">
      	<input id="serviceImgAddId" type="text" id="" class="form-control mb-4" placeholder="Service_image_link">
      </div>
      	
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="serviceAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('script')
	
	<script type="text/javascript">
	

		getServicesData();








		//For services Table

function getServicesData() {

    axios.get('/getServicesData')
        .then(function(response) {
            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');


                $('#serviceDataTable').DataTable().destroy();

                $('#service_table').empty();

                var jsonData = response.data;

                $.each(jsonData, function(i, item) {

                    $('<tr>').html(
                        "<td><img class='table-img' src=" + jsonData[i].service_img + "> </td>" +
                        "<td>" + jsonData[i].service_name + "</td>" +
                        "<td>" + jsonData[i].service_des + "</td>" +
                        "<td><a class='serviceEditBtn' data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a> </td>" +
                        "<td> <a class='serviceDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>"
                    ).appendTo('#service_table');
                });

                //Services Table Delete icon Click
                $('.serviceDeleteBtn').click(function() {
                    var id = $(this).data('id');

                    $('#serviceDeleteId').html(id);
                    $('#deleteModal').modal('show');

                })
                 
                //Services Table Edit Icon Click
                $('.serviceEditBtn').click(function(){
                    var id = $(this).data('id');
                    $('#serviceEditId').html(id);
                    ServiceUpdateDetails(id);
                    $('#editModal').modal('show');
                })


                $('#serviceDataTable').DataTable({"order":false});
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



 //Sevices Delete Modal Yes btn
         $('#serviceDeleteConfirmBtn').click(function() {

         var id = $('#serviceDeleteId').html();
          ServiceDelete(id);
         })


//Service Delete
function ServiceDelete(deleteID) {
    $('#serviceDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

    axios.post('/ServiceDelete', {
            id: deleteID
        })
        .then(function(response) {
             $('#serviceDeleteConfirmBtn').html("Yes");
            if (response.status==200) {
                 if (response.data == 1) {
                $('#deleteModal').modal('hide');
                toastr.success('Successfully Deleted');
                getServicesData();
            } else {
                $('#deleteModal').modal('hide');
                toastr.error('Delete Failed');
                getServicesData();

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



//Each Services Update details
function ServiceUpdateDetails(detailsID) {
    axios.post('/ServiceDetails', {
            id:detailsID
        })
        .then(function(response) {

            if (response.status==200) {
                $('#serviceEditForm').removeClass('d-none');
                $('#serviceLoaderId').addClass('d-none');

                var jsonData=response.data;
                $('#serviceNameId').val(jsonData[0].service_name);
                $('#serviceDesId').val(jsonData[0].service_des);
                $('#serviceImgId').val(jsonData[0].service_img);


            }
            else{
                $('#serviceLoaderId').addClass('d-none');
                 $('#serviceWrongId').removeClass('d-none');

            }

           

        })
        .catch(function(error) {
             $('#serviceLoaderId').addClass('d-none');
             $('#serviceWrongId').removeClass('d-none');


    });
}



//Sevice Edit Modal Save btn
 $('#serviceEditConfirmBtn').click(function() {

     var id = $('#serviceEditId').html();
     var name = $('#serviceNameId').val();
     var des = $('#serviceDesId').val();
     var img = $('#serviceImgId').val();
                 
     ServiceUpdate(id,name,des,img);

    })




function ServiceUpdate(serviceID,serviceName,serviceDes,serviceImg) {

    if (serviceName.length==0) {
        toastr.error('Service Name is Empty !');
    }
    else if(serviceDes.length==0){
    toastr.error('Service Description is Empty !');
    }
    else if(serviceImg.length==0){
     toastr.error('Service Image is Empty !');
    }
    else{
        $('#serviceEditConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ServiceUpdate', {
            id:serviceID,
            name:serviceName,
            des:serviceDes,
            img:serviceImg,

        })
        .then(function(response) {
            $('#serviceEditConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#editModal').modal('hide');
                toastr.success('Successfully Updated');
                getServicesData();
            } else {
                $('#editModal').modal('hide');
                toastr.error('Update Failed');
                getServicesData();
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
  

//Service Add New Btn Click

$('#addNewBtnId').click(function(){

    $('#addModal').modal('show');

});


$('#serviceAddConfirmBtn').click(function() {

     var name = $('#serviceNameAddId').val();
     var des = $('#serviceDesAddId').val();
     var img = $('#serviceImgAddId').val();
                 
     ServiceAdd(name,des,img);

    })


//Service Add method
function ServiceAdd(serviceName,serviceDes,serviceImg) {

    if (serviceName.length==0) {
        toastr.error('Service Name is Empty !');
    }
    else if(serviceDes.length==0){
    toastr.error('Service Description is Empty !');
    }
    else if(serviceImg.length==0){
     toastr.error('Service Image is Empty !');
    }
    else{
        $('#serviceAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ServiceAdd', {
            name:serviceName,
            des:serviceDes,
            img:serviceImg,

        })
        .then(function(response) {
            $('#serviceAddConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#addModal').modal('hide');
                toastr.success('Successfully Added');
                getServicesData();
            } else {
                $('#addModal').modal('hide');
                toastr.error('Add Failed');
                getServicesData();
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