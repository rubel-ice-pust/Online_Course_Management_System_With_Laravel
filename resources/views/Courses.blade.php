@extends('Layout.app')
@section('title','Courses')
@section('content')


<div id="mainDivCourse" class="container d-none">
<div class="row">
<div class="col-md-12 p-5">

<button id="addNewCourseBtnId" class="btn my-3 btn-danger">Add New</button>

<table id="CourseDataTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
  <thead>
    <tr>
	  <th class="th-sm">Name</th>
	  <th class="th-sm">Fee</th>
	  <th class="th-sm">Class</th>
	  <th class="th-sm">Enroll</th>
	  <th class="th-sm">Edit</th>
	  <th class="th-sm">Delete</th>


    </tr>
  </thead>
  <tbody id="course_table">
  
	
	

  </tbody>
</table>

</div>
</div>
</div>


<div id="loaderDivCourse" class="container">
<div class="row">
<div class="col-md-12  text-center p-5">

	<img class="loading-icon m-5" src="{{asset('images/loader.svg')}}">


</div>
</div>
</div>


<div id="WrongDivCourse" class="container d-none">
<div class="row">
<div class="col-md-12  text-center p-5">

	<h5>Something Went Wrong</h5>

</div>
</div>
</div>



<div class="modal" id="addCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Add New Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body  text-center">
       <div class="container">
       	<div class="row">
       		<div class="col-md-6">
             	<input id="CourseNameId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
          	 	<input id="CourseDesId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
    		 	<input id="CourseFeeId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
     			<input id="CourseEnrollId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
       		</div>
       		<div class="col-md-6">
     			<input id="CourseClassId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
     			<input id="CourseLinkId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
     			<input id="CourseImgId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
       		</div>
       	</div>
       </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
        <button  id="CourseAddConfirmBtn" type="button" class="btn  btn-sm  btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>



<div class="modal" id="updateCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">Update Course</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body  text-center">

       <h6 id="courseEditId" class="m-3 d-none"></h6>

       <div id="courseEditForm" class="container d-none">
        <div class="row">

          <div class="col-md-6">
          <input id="CourseNameUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Name">
          <input id="CourseDesUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Description">
          <input id="CourseFeeUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Fee">
          <input id="CourseEnrollUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Enroll">
          </div>
          <div class="col-md-6">
          <input id="CourseClassUpdateId" type="text" id="" class="form-control mb-3" placeholder="Total Class">      
          <input id="CourseLinkUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Link">
          <input id="CourseImgUpdateId" type="text" id="" class="form-control mb-3" placeholder="Course Image">
          </div>
        </div>
       </div>
           <img id="CourseEditLoaderId" class="loading-icon m-5" src="{{asset('images/loader.svg')}}">
            <h5 class="d-none" id="CourseEditWrongId">Something Went Wrong</h5>
        

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Cancel</button>
        <button id="CourseUpdateConfirmBtnId" type="button" class="btn  btn-sm  btn-danger">Save</button>
      </div>
    </div>
  </div>
</div>




<!-- Modal -->
<div class="modal" id="deleteCourseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
     
      <div class="modal-body p-3 text-center">
      	<h6 class="m-3">Do You Want To Delete?</h6>
      	<h6 id="CourseDeleteId" class="m-3 d-none"></h6>
      	
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">
          No
        </button>
        <button  id="CourseDeleteConfirmBtn" type="button" class="btn btn-sm btn-danger">Yes</button>
      </div>
    </div>
  </div>
</div>



@endsection



@section('script')

<script type="text/javascript">
	


getCoursesData();




function getCoursesData() {

    axios.get('/getcoursesData')
        .then(function(response) {
            if (response.status == 200) {

                $('#mainDivCourse').removeClass('d-none');
                $('#loaderDivCourse').addClass('d-none');


                $('#CourseDataTable').DataTable().destroy();
                $('#course_table').empty();

                var jsonData = response.data;

                $.each(jsonData, function(i, item) {

                    $('<tr>').html(
                        "<td>"+ jsonData[i].course_name + "</td>" +
                        "<td>" + jsonData[i].course_fee + "</td>" +
                        "<td>" + jsonData[i].course_totalclass + "</td>" +
                        "<td>" + jsonData[i].course_totalenroll  + "</td>" +
                        "<td><a class='courseEditBtn' data-id=" + jsonData[i].id + "><i class='fas fa-edit'></i></a> </td>" +
                        "<td> <a class='courseDeleteBtn' data-id=" + jsonData[i].id + " ><i class='fas fa-trash-alt'></i></a> </td>"
                    ).appendTo('#course_table');
                });

                $('.courseDeleteBtn').click(function(){
                     var id= $(this).data('id');
                     $('#CourseDeleteId').html(id);
                    $('#deleteCourseModal').modal('show');
                })

                 //Services Table Edit Icon Click
                $('.courseEditBtn').click(function(){
                    var id = $(this).data('id');
                    $('#courseEditId').html(id);
                    courseUpdateDetails(id);
                    $('#updateCourseModal').modal('show');
                })

                

                $('#CourseDataTable').DataTable({"order":false});
                $('.dataTables_length').addClass('bs-select');

            } else {
                $('#loaderDivCourse').addClass('d-none');
                $('#WrongDivCourse').removeClass('d-none');

            }


        })
        .catch(function(error) {
            $('#loaderDivCourse').addClass('d-none');
            $('#WrongDivCourse').removeClass('d-none');
        });


}


$('#addNewCourseBtnId').click(function(){
    $('#addCourseModal').modal('show');
});


 $('#CourseAddConfirmBtn').click(function(){

  var CourseName= $('#CourseNameId').val();
  var CourseDes= $('#CourseDesId').val();
  var CourseFee= $('#CourseFeeId').val();
  var CourseEnroll= $('#CourseEnrollId').val();
  var CourseClass= $('#CourseClassId').val();
  var CourseLink= $('#CourseLinkId').val();
  var CourseImg=$('#CourseImgId').val();


CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg);
 })


//Course Add method
function CourseAdd(CourseName,CourseDes,CourseFee,CourseEnroll,CourseClass,CourseLink,CourseImg) {

    if (CourseName.length==0) {
        toastr.error('Course Name is Empty !');
    }
    else if(CourseDes.length==0){
    toastr.error('Course Description is Empty !');
    }
    else if(CourseFee.length==0){
     toastr.error('Course Fee is Empty !');
    }
    else if(CourseEnroll.length==0){
     toastr.error('Course Enroll  is Empty !');
    }else if(CourseClass.length==0){
     toastr.error('Course Class is Empty !');
    }else if(CourseLink.length==0){
     toastr.error('Course Link is Empty !');
    }else if(CourseImg.length==0){
     toastr.error('Course Image is Empty !');
    }

    else{
        $('#CourseAddConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/coursesAdd', {
            course_name:CourseName,
            course_des:CourseDes,
            course_fee:CourseFee,
            course_totalenroll:CourseEnroll,
            course_totalclass:CourseClass,
            course_link:CourseLink,
            course_img:CourseImg,


        })
        .then(function(response) {
            $('#CourseAddConfirmBtn').html("Save");

            if (response.status==200) {

                if (response.data == 1) {
                $('#addCourseModal').modal('hide');
                toastr.success('Successfully Added');
                getCoursesData();
            } else {
                $('#addCourseModal').modal('hide');
                toastr.error('Add Failed');
                getCoursesData();
            }

          }
            else
            {
              $('#addCourseModal').modal('hide');
                toastr.error('Something Went Wrong !');
            }
              


          

        })
        .catch(function(error) {
            $('#addCourseModal').modal('hide');
                toastr.error('Something Went Wrong !');
             
    });

    }
}



       //Course Delete Modal Yes btn

         $('#CourseDeleteConfirmBtn').click(function() {

         var id = $('#CourseDeleteId').html();
          CourseDelete(id);
         })


//Course Delete
function CourseDelete(deleteID) {
    $('#CourseDeleteConfirmBtn').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

    axios.post('/coursesDelete', {
            id: deleteID
        })
        .then(function(response) {
             $('#CourseDeleteConfirmBtn').html("Yes");
            if (response.status==200) {
                 if (response.data == 1) {
                $('#deleteCourseModal').modal('hide');
                toastr.success('Successfully Deleted');
                getCoursesData();
            } else {
                $('#deleteCourseModal').modal('hide');
                toastr.error('Delete Failed');
                getCoursesData();

            }

           
            }
            else{
                $('#deleteCourseModal').modal('hide');
             toastr.error('Something Went Wrong !');

            }

        })
        .catch(function(error) {
              $('#deleteCourseModal').modal('hide');
             toastr.error('Something Went Wrong !');

        });
}



//Each course Update details
function courseUpdateDetails(detailsID) {
    axios.post('/coursesDetails', {
            id:detailsID
        })
        .then(function(response) {

            if (response.status==200) {
                $('#courseEditForm').removeClass('d-none');
                $('#CourseEditLoaderId').addClass('d-none');

                var jsonData=response.data;
                $('#CourseNameUpdateId').val(jsonData[0].course_name);
                $('#CourseDesUpdateId').val(jsonData[0].course_des);
                $('#CourseFeeUpdateId').val(jsonData[0].course_fee);
                $('#CourseEnrollUpdateId').val(jsonData[0].course_totalenroll);
                $('#CourseClassUpdateId').val(jsonData[0].course_totalclass);
                $('#CourseLinkUpdateId').val(jsonData[0].course_link);
                $('#CourseImgUpdateId').val(jsonData[0].course_img);




            }
            else{
                $('#CourseEditLoaderId').addClass('d-none');
                 $('#CourseEditWrongId').removeClass('d-none');

            }

           

        })
        .catch(function(error) {
             $('#CourseEditLoaderId').addClass('d-none');
             $('#CourseEditWrongId').removeClass('d-none');


    });
}




$('#CourseUpdateConfirmBtnId').click(function(){

    var courseID =$('#courseEditId').html();
    var courseName =$('#CourseNameUpdateId').val();
    var courseDes =$('#CourseDesUpdateId').val();
    var courseFee =$('#CourseFeeUpdateId').val();
    var courseEnroll =$('#CourseEnrollUpdateId').val();
    var courseClass =$('#CourseClassUpdateId').val();
    var courseLink =$('#CourseLinkUpdateId').val();
    var courseImg =$('#CourseImgUpdateId').val();

courseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg);
})



function courseUpdate(courseID,courseName,courseDes,courseFee,courseEnroll,courseClass,courseLink,courseImg) {

    if (courseName.length==0) {
     toastr.error('Course Name is Empty !');
    }
    else if(courseDes.length==0){
    toastr.error('Course Description is Empty !');
    }
    else if(courseFee.length==0){
    toastr.error('course Fee  is Empty !');
    }
    else if(courseEnroll.length==0){
    toastr.error('course Enroll  is Empty !');
    }
    else if(courseClass.length==0){
    toastr.error('course Class  is Empty !');
    }
    else if(courseLink.length==0){
     toastr.error('course Link is Empty !');
    }
    else if(courseImg.length==0){
    toastr.error('course Image  is Empty !');
    }
    else{
        $('#CourseUpdateConfirmBtnId').html("<div class='spinner-border spinner-border-sm text-light' role='status'></div>");

          axios.post('/coursesUpdate',{

            id: courseID,
            course_name: courseName,
            course_des: courseDes,
            course_fee: courseFee,
            course_totalenroll: courseEnroll,
            course_totalclass: courseClass,
            course_link: courseLink,
            course_img: courseImg,


        })
        .then(function(response) {
            $('#CourseUpdateConfirmBtnId').html("Save");

            if (response.status==200) {
                if (response.data == 1){
                $('#updateCourseModal').modal('hide');
                toastr.success('Successfully Updated');
                getCoursesData();
            } else {
                $('#updateCourseModal').modal('hide');
                toastr.error('Update Failed');
                getCoursesData();
            }

          }
            else{
              $('#updateCourseModal').modal('hide');
                toastr.error('Something Went Wrong !');
            }
              
        })
        .catch(function(error) {
            $('#updateCourseModal').modal('hide');
            toastr.error('Something Went Wrong !');
             
    });

    }
}



</script>



@endsection