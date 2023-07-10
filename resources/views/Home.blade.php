@extends('Layout.app')
@section('title','Home')
@section('content')


 <div class="container">
 	<div class="row">
 		
 		<div class="col-md-3 p-2">
 			<div class="card">
 				<div class="card-body">
 					<h3 class="count-card-title">{{$TotalVisitor}}</h3>
 					<h3 class="count-card-title">Total Visitor</h3>
 				</div>
 			</div>
 			
 		</div>
 		<div class="col-md-3 p-2">
 			<div class="card">
 				<div class="card-body">
 					<h3 class="count-card-title">{{$TotalServices}}</h3>
 					<h3 class="count-card-title">Total Services</h3>
 				</div>
 			</div>
 			
 		</div>
 		<div class="col-md-3 p-2">
 			<div class="card">
 				<div class="card-body">
 					<h3 class="count-card-title">{{$TotalProjects}}</h3>
 					<h3 class="count-card-title">Total Projects</h3>
 				</div>
 			</div>
 			
 		</div>
 		<div class="col-md-3 p-2">
 			<div class="card">
 				<div class="card-body">
 					<h3 class="count-card-title">{{$TotalContact}}</h3>
 					<h3 class="count-card-title">Total Contacts</h3>
 				</div>
 			</div>
 			
 		</div>
 		<div class="col-md-3 p-2">
 			<div class="card">
 				<div class="card-body">
 					<h3 class="count-card-title">{{$TotalReview}}</h3>
 					<h3 class="count-card-title">Total Reviews</h3>
 				</div>
 			</div>
 			
 		</div>
 	</div>
 	
 </div>

 @endsection