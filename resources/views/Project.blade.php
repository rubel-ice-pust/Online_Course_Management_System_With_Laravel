@extends('Layout.app')

@section('content')



<div id="mainDiv" class="container d-none">
<div class="row">
<div class="col-md-12 p-5">

<button id="addNewBtnId" class="btn my-3 btn-danger">Add New</button>	
<table id="ProjectDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
	  <th class="th-sm">Name</th>
	  <th class="th-sm">Description</th>
	  <th class="th-sm">Edit</th>
	  <th class="th-sm">Delete</th>
    </tr>
  </thead>
  <tbody id="Project_table">
  
		
	
	
	
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
      	<h6 id="ProjectDeleteId" class="m-3 d-none"></h6>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          No
        </button>
        <button  id="ProjectDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
        <h5 class="modal-title">Update Project</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
     
      <div class="modal-body p-5 text-center">
      	<h6 id="ProjectEditId" class="m-3 d-none"></h6>

      	<div id="ProjectEditForm" class="d-none w-100">
      	<input id="ProjectNameId" type="text" id="" class="form-control mb-4" placeholder="Project_name">
      	<input id="ProjectDesId" type="text" id="" class="form-control mb-4" placeholder="Project_Description">
      </div>
      	<img id="ProjectLoaderId" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
      	<h5 class="d-none" id="ProjectWrongId">Something Went Wrong</h5>
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="ProjectEditConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>




<div class="modal" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body p-5 text-center">

      	<div id="ProjectAddForm" class="w-100">
      		<h6 class="mb-4">Add New Services</h6>
      	<input id="ProjectNameAddId" type="text" id="" class="form-control mb-4" placeholder="Project_name">
      	<input id="ProjectDesAddId" type="text" id="" class="form-control mb-4" placeholder="Project_Description">
      	
      </div>
      	
      	
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          Cancel
        </button>
        <button  id="ProjectAddConfirmBtn" type="button" class="btn btn-sm btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>
@endsection


@section('script')
	
	<script type="text/javascript">
	

		getProjectData();




		//For services Table

function getProjectData() {

    axios.get('/getProjectData')
        .then(function(response) {
            if (response.status == 200) {

                $('#mainDiv').removeClass('d-none');
                $('#loaderDiv').addClass('d-none');


                $('#ProjectDataTable').DataTable().destroy();

                $('#Project_table').empty();

                var jsonData = response.data;

                $.each(jsonData, function(i, item) {

                    $('<tr>').html(
                        
                        "<td>" + jsonData[i].project_name + "</td>" +
                        "<td>" + jsonData[i].project_desc + "</td>" +
                        "<td><a class='ProjectEditBtn' data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a> </td>" +
                        "<td> <a class='ProjectDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>"
                    ).appendTo('#Project_table');
                });

                //Project Table Delete icon Click
                $('.ProjectDeleteBtn').click(function() {
                    var id = $(this).data('id');

                    $('#ProjectDeleteId').html(id);
                    $('#deleteModal').modal('show');

                })
                 
                //Project Table Edit Icon Click
                $('.ProjectEditBtn').click(function(){
                    var id = $(this).data('id');
                    $('#ProjectEditId').html(id);
                    ProjectUpdateDetails(id);
                    $('#editModal').modal('show');
                })


                $('#ProjectDataTable').DataTable({"order":false});
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



 //Project Delete Modal Yes btn
         $('#ProjectDeleteConfirmBtn').click(function() {

         var id = $('#ProjectDeleteId').html();
          ProjectDelete(id);
         })


//Project Delete
function ProjectDelete(deleteID) {
    $('#ProjectDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

    axios.post('/ProjectDelete', {
            id: deleteID
        })
        .then(function(response) {
             $('#ProjectDeleteConfirmBtn').html("Yes");
            if (response.status==200) {
                 if (response.data == 1) {
                $('#deleteModal').modal('hide');
                toastr.success('Successfully Deleted');
                getProjectData();
            } else {
                $('#deleteModal').modal('hide');
                toastr.error('Delete Failed');
                getProjectData();

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



//Each Project Update details
function ProjectUpdateDetails(detailsID) {
    axios.post('/ProjectDetails', {
            id:detailsID
        })
        .then(function(response) {

            if (response.status==200) {
                $('#ProjectEditForm').removeClass('d-none');
                $('#ProjectLoaderId').addClass('d-none');

                var jsonData=response.data;
                $('#ProjectNameId').val(jsonData[0].project_name);
                $('#ProjectDesId').val(jsonData[0].project_desc);


            }
            else{
                $('#ProjectLoaderId').addClass('d-none');
                 $('#ProjectWrongId').removeClass('d-none');

            }

           

        })
        .catch(function(error) {
             $('#ProjectLoaderId').addClass('d-none');
             $('#ProjectWrongId').removeClass('d-none');


    });
}



//Project Edit Modal Save btn
 $('#ProjectEditConfirmBtn').click(function() {

     var id = $('#ProjectEditId').html();
     var name = $('#ProjectNameId').val();
     var desc = $('#ProjectDesId').val();
                 
    ProjectUpdate(id,name,desc);

    })




function ProjectUpdate(projectID,projectName,projectDesc) {

    if (projectName.length==0) {
        toastr.error('Project Name is Empty !');
    }
    else if(projectDesc.length==0){
    toastr.error('Project Description is Empty !');
    }
   
    else{
        $('#ProjectEditConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ProjectUpdate', {
            id:projectID,
            name:projectName,
            desc:projectDesc,

        })
        .then(function(response) {
            $('#ProjectEditConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#editModal').modal('hide');
                toastr.success('Successfully Updated');
                getProjectData();
            } else {
                $('#editModal').modal('hide');
                toastr.error('Update Failed');
                getProjectData();
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
  

//Project Add New Btn Click

$('#addNewBtnId').click(function(){

    $('#addModal').modal('show');

});


$('#ProjectAddConfirmBtn').click(function() {

     var name = $('#ProjectNameAddId').val();
     var desc = $('#ProjectDesAddId').val();
                 
     ProjectAdd(name,desc);

    })


//Project Add method
function ProjectAdd(projectName,projectDesc) {

    if (projectName.length==0) {
        toastr.error('project Name is Empty !');
    }
    else if(projectDesc.length==0){
      toastr.error('project Description is Empty !');
    }
    
    else{
        $('#ProjectAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/ProjectAdd',{
            name:projectName,
            desc:projectDesc,

        })
        .then(function(response) {
            $('#ProjectAddConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#addModal').modal('hide');
                toastr.success('Successfully Added');
                getProjectData();
            } else {
                $('#addModal').modal('hide');
                toastr.error('Add Failed');
                getProjectData();
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