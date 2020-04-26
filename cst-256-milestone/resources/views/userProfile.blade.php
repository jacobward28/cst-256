

@extends('layouts.appmaster') 
@section('title','Profile') 

@section('style')
<style>
#card-item {
	background-color: rgb(60, 63, 65) !important;
}
</style>
@endsection 

@section('content') 

@if($errors->count() != 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger" role="alert" style="width:30%;">{{$error}}</div>
	@endforeach
@endif

<!-- The card div holds the user's overall profile information -->
<div class="card" style="width: 18rem; float: left !important; margin-left: 20px;" >
	<!-- Contains the user's first and last name as well as their profile description -->
	<div class="card-body">
		<h5 class="card-title">{{$user['FIRSTNAME']}} {{$user['LASTNAME']}}</h5>
		<p class="card-text">{{$info['DESCRIPTION']}}</p>
	</div>
	<!-- Contains all the rest of the user's pertenant information -->
	<ul class="list-group list-group-flush">
		<li  class="list-group-item">Age: {{$info['AGE']}}<br>Gender: {{$info['GENDER']}}
		</li>
		<li  class="list-group-item">Phone: {{$info['PHONE']}}<br>Email: {{$user['EMAIL']}}
		</li>
		<li  class="list-group-item">{{$address['CITY']}}, {{$address['STATE']}}</li>
	</ul>
	<!-- If statement to ensure that only the profile's owner can click the button to be able to edit their profile -->
	@if(Session::get('ID') == $ID)
	<!-- Modal for editing the user's address and info -->
	<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header" >
					<h5 class="modal-title" id="ModalLabel">Update Your Profile Information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" >
					<div class="card">
						<div class="card-header" >
							<ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
								<li class="nav-item"  style="border-top-left-radius: 5px; border-top-right-radius: 5px;"><a class="nav-link active"
									id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profile Info</a></li>
								<li class="nav-item"  style="border-top-left-radius: 5px; border-top-right-radius: 5px;"><a class="nav-link"
									id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Address</a></li>
							</ul>
						</div>
						<div class="card-body" >
							<div class="tab-content" id="myTabContent">
								<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
									<!-- Form for editing the user's userInfo -->
									<form action="editUserInfo" method="post">
										<input type="hidden" name="_token" value="{{csrf_token()}}"> 
										<input type="hidden" name="userID" value="{{Request::get('ID')}}">
										<div class="form-group">
											<label for="phone">Phone: </label> <input type="text" class="form-control" id="phone" name="phone"
												value="@if($info['PHONE'] != null){{$info['PHONE']}}@endif" />
										</div>
										<div class="form-group">
											<label for="age">Age: </label> <input type="text" class="form-control" id="age" name="age"
												value="@if($info['AGE'] != null){{$info['AGE']}}@endif" />
										</div>
										<div class="form-group">
											<label for="gender">Gender: </label> <input type="text" class="form-control" id="gender" name="gender"
												value="@if($info['GENDER'] != null){{$info['GENDER']}}@endif" />
										</div>
										<div class="form-group">
											<label for="description">Description: </label>
											<textarea class="form-control" id="description" name="description" rows="5" style="width: 70%;">@if($info['DESCRIPTION'] != null){{$info['DESCRIPTION']}}@endif</textarea>
										</div>
										<button type="submit" class="btn btn-primary">Update</button>
									</form>
								</div>
								<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
									<!-- Form for editing the user's address information -->
									<form action="editUserAddress" method="post">
										<input type="hidden" name="_token" value="{{csrf_token()}}" /> 
										<input type="hidden" name="userID" value="{{Session::get('ID')}}">
										<input type="hidden" name="modalName" value="editProfileModal"/>
										<div class="form-group">
											<label for="street">Street Address: </label> <input type="text" class="form-control" id="street" name="street"
												value="@if($address['STREET'] != null){{$address['STREET']}}@endif" />
										</div>
										<div class="form-group">
											<label for="city">City: </label> <input type="text" class="form-control" id="city" name="city"
												value="@if($address['CITY'] != null){{$address['CITY']}}@endif" />
										</div>
										<div class="form-group">
											<label for="state">State: </label> <input type="text" class="form-control" id="state" name="state"
												value="@if($address['STATE'] != null){{$address['STATE']}}@endif" />
										</div>
										<div class="form-group">
											<label for="zip">Zip Code: </label> <input type="text" class="form-control" id="zip" name="zip"
												value="@if($address['ZIP'] != null){{$address['ZIP']}}@endif" />
										</div>
										<button type="submit" class="btn btn-primary">Update</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-body">
		<button type="button" class="btn btn-primary" data-toggle="modal" href="#editProfileModal">Update Profile</button>
	</div>
	@endif
</div>

<!-- Tabbed card for displaying all of a user's e-portfolio information -->
<div class="card" style="width:73%; float: left !important; margin-left: 20px; margin-bottom:20px; border-color:rgb(43, 43, 43);">
	<div class="card-header" >
		<ul class="nav nav-tabs card-header-tabs pull-right" id="myTab" role="tablist">
			<li class="nav-item"  style="border-top-left-radius: 5px; border-top-right-radius: 5px;"><a class="nav-link active"
				id="home-tab" data-toggle="tab" href="#education" role="tab" aria-controls="home" aria-selected="true">Education</a></li>
			<li class="nav-item"  style="border-top-left-radius: 5px; border-top-right-radius: 5px;"><a class="nav-link" id="profile-tab"
				data-toggle="tab" href="#workExperience" role="tab" aria-controls="profile" aria-selected="false">Work Experience</a></li>
			<li class="nav-item"  style="border-top-left-radius:5px; border-top-right-radius:5px;"><a class="nav-link"
				id="skills-tab" data-toggle="tab" href="#skills" role="tab" aria-controls="skill" aria-selected="false">Skills</a></li>
		</ul>
	</div>
	<div class="card-body" >
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="education" role="tabpanel" aria-labelledby="home-tab">
				<div class="card-deck"">
				@if(count($educations) > 0)
					@foreach($educations as $education)
						<div class="card" >
							<div class="card-body">
								<h3 class="card-title">School: {{$education['SCHOOL']}}</h3>
							</div>
							<ul class="list-group list-group-flush">
								<li  class="list-group-item">Field: {{$education['FIELD']}}</li>
								<li  class="list-group-item">Degree: {{$education['DEGREE']}}</li>
								<li  class="list-group-item">GPA: {{$education['GPA']}}</li>
								<li  class="list-group-item">{{$education['STARTYEAR']}}-{{$education['ENDYEAR']}}</li>
							</ul>
							<div class="card-body">
								@if(Session::get('ID') == $ID)
								<button type="button" class="btn btn-primary" data-toggle="modal" href="#editEducationModal{{$education['IDEDUCATION']}}">Edit</button>
								
								<div class="modal fade" id="editEducationModal{{$education['IDEDUCATION']}}" tabindex="-1" role="dialog" aira-labelledby="{{$education['IDEDUCATION']}}dLabel" aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header" >
												<h5 class="modal-title" id="ModalLabel">Edit Education</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body" >
												<form id="editEducation{{$education['IDEDUCATION']}}" action="editEducation" method="post"></form>
                    							<div class="form-group">
                    								<input type="hidden" form="editEducation{{$education['IDEDUCATION']}}" name="_token" value="{{csrf_token()}}">
                    								<input type="hidden" form="editEducation{{$education['IDEDUCATION']}}" name="id" value="{{$education['IDEDUCATION']}}">
                    								<label class="formLabel" for="school">School:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="school" value="{{$education['SCHOOL']}}" name="school">
                    								<label class="formLabel" for="degree">Degree:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="degree" value="{{$education['DEGREE']}}" name="degree">
                    								<label class="formLabel" for="field">Field:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="field" value="{{$education['FIELD']}}" name="field">
                    								<label class="formLabel" for="gpa">GPA:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="gpa" value="{{$education['GPA']}}" name="gpa">
                    								<label class="formLabel" for="startyear">Start Year:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="startyear" value="{{$education['STARTYEAR']}}" name="startyear">
                    								<label class="formLabel" for="endyear">End Year:</label>
                    								<input form="editEducation{{$education['IDEDUCATION']}}" type="text" class="form-control" id="endyear" value="{{$education['ENDYEAR']}}" name="endyear">
            									</div>
											</div>
											<div class="modal-footer" >
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        										<button form="editEducation{{$education['IDEDUCATION']}}" type="submit" class="btn btn-primary">Save changes</button>
											</div>
										</div>
									</div>
								</div>
								<!-- edit modal -->
								<button type="button" class="btn btn-primary" data-toggle="modal" href="#removeModal{{$education['IDEDUCATION']}}">Delete</button>
<!-- 				Delete confirmation modal -->
                				<div class="modal fade" id="removeModal{{$education['IDEDUCATION']}}" tabindex="-1" role="dialog" aria-labelledby="{{$education['IDEDUCATION']}}dLabel" aria-hidden="true">
                  					<div class="modal-dialog" role="document">
                    					<div class="modal-content">
                      						<div class="modal-header" >
                        						<h5 class="modal-title" id="ModalLabel">Warning!</h5>
                        						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
                          							<span aria-hidden="true">&times;</span>
                        						</button>
                      						</div>
                      						<div class="modal-body" >
                      							<p>
                      							Are you sure that you want to delete this education record?
                      							</p>
                        						<form id="remove{{$education['IDEDUCATION']}}" action="removeEducation" method="post"></form>
                									<input form="remove{{$education['IDEDUCATION']}}" type="hidden" name="_token" value="{{csrf_token()}}"/>
                									<input form="remove{{$education['IDEDUCATION']}}" type="hidden" name="ID" value="{{$education['IDEDUCATION']}}"/>
                      						</div>
                      						<div class="modal-footer" >
                <!--       							Button to close the modal -->
                        						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <!--         						Button that submits delete form -->
                       	 						<button form="remove{{$education['IDEDUCATION']}}" type="submit" class="btn btn-primary">Remove</button>
                      						</div>
                    					</div>
                  					</div>
                				</div>
                				@endif
							</div>
						</div>
					@endforeach
				@endif
				</div>
				<!-- Button to add education card -->
				@if(Session::get('ID') == $ID)
				<button type="button" class="btn btn-primary" data-toggle="modal" href="#addEducation" style="margin-top:10px;">Add Education Card</button>			
					<div class="modal fade" id="addEducation" tabindex="-1" role="dialog" aira-labelledby="addEducationdLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header" >
									<h5 class="modal-title" id="ModalLabel">Add Education</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body" >
									<form id="addEducationForm" action="addEducation" method="post"></form>
                    				<div class="form-group">
                   						<input type="hidden" form="addEducationForm" name="_token" value="{{csrf_token()}}">
                 						<input type="hidden" form="addEducationForm" name="userID" value="{{Session::get('ID')}}">
                    					<label class="formLabel" for="school">School:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="school" name="school">
                    					<label class="formLabel" for="degree">Degree:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="degree" name="degree">
                   						<label class="formLabel" for="field">Field:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="field" name="field">
                    					<label class="formLabel" for="gpa">GPA:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="gpa" name="gpa">
                    					<label class="formLabel" for="startyear">Start Year:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="startyear" name="startyear">
                    					<label class="formLabel" for="endyear">End Year:</label>
                    					<input form="addEducationForm" type="text" class="form-control" id="endyear" name="endyear">
            						</div>
								</div>
								<div class="modal-footer" >
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        							<button form="addEducationForm" type="submit" class="btn btn-primary">Create Education Card</button>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			<div class="tab-pane fade" id="workExperience" role="tabpanel" aria-labelledby="profile-tab">
				<div class="card-deck">
					@if(count($experiences) > 0)
    					@foreach($experiences as $experience)
    						<div class="card" >
    							<div class="card-body">
    								<h3 class="card-title">Job Title: {{$experience['TITLE']}}</h3>
    							</div>
    							<ul class="list-group list-group-flush">
    								<li  class="list-group-item">Company: {{$experience['COMPANY']}}</li>
    								@if($experience['CURRENT'])
    									<li  class="list-group-item">Current job since {{$experience['STARTYEAR']}}</li>
    								@else
    									<li  class="list-group-item">Employed: {{$experience['STARTYEAR']}}-{{$experience['ENDYEAR']}}</li>
    								@endif
    								<li  class="list-group-item">{{$experience['DESCRIPTION']}}</li>
    							</ul>
    							<div class="card-body">
    								@if(Session::get('ID') == $ID)
    								<button type="button" class="btn btn-primary" data-toggle="modal" href="#editExperienceModal{{$experience['IDEXPERIENCE']}}">Edit</button>
    								
    								<div class="modal fade" id="editExperienceModal{{$experience['IDEXPERIENCE']}}" tabindex="-1" role="dialog" aira-labelledby="{{$experience['IDEXPERIENCE']}}dLabel" aria-hidden="true">
    									<div class="modal-dialog" role="document">
    										<div class="modal-content">
    											<div class="modal-header" >
    												<h5 class="modal-title" id="ModalLabel">Edit Experience</h5>
    												<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
    													<span aria-hidden="true">&times;</span>
    												</button>
    											</div>
    											<div class="modal-body" >
    												<form id="editExperience{{$experience['IDEXPERIENCE']}}" action="editExperience" method="post"></form>
                        							<div class="form-group">
                        								<input type="hidden" form="editExperience{{$experience['IDEXPERIENCE']}}" name="_token" value="{{csrf_token()}}">
                        								<input type="hidden" form="editExperience{{$experience['IDEXPERIENCE']}}" name="id" value="{{$experience['IDEXPERIENCE']}}">
                        								<label class="formLabel" for="title">Job Title:</label>
                        								<input form="editExperience{{$experience['IDEXPERIENCE']}}" type="text" class="form-control" id="title" value="{{$experience['TITLE']}}" name="title">
                        								<label class="formLabel" for="company">Company:</label>
                        								<input form="editExperience{{$experience['IDEXPERIENCE']}}" type="text" class="form-control" id="company" value="{{$experience['COMPANY']}}" name="company">
                        								<label class="formLabel" for="startyear">Start Year:</label>
                        								<input form="editExperience{{$experience['IDEXPERIENCE']}}" type="text" class="form-control" id="startyear" value="{{$experience['STARTYEAR']}}" name="startyear">
                        								<label class="formLabel" for="endyear">End Year:</label>
                        								<input form="editExperience{{$experience['IDEXPERIENCE']}}" type="text" class="form-control" id="endyear" value="{{$experience['ENDYEAR']}}" name="endyear">
                        								<label class="formLabel" for="current">Status: </label>
                										<select form="editExperience{{$experience['IDEXPERIENCE']}}" class="form-control" id="current" name="current" style="width:40%;">
                											<option value="1" <?php if($experience['CURRENT']==1){echo "selected";}?>>Current</option>
                											<option value="0" <?php if($experience['CURRENT']==0){echo "selected";}?>>Not Current</option>
                										</select>
                        								<label class="formLabel" for="description">Job Description:</label>
														<textarea form="editExperience{{$experience['IDEXPERIENCE']}}" class="form-control" id="description" name="description" rows="5" style="width: 70%;">@if($experience['DESCRIPTION'] != null){{$experience['DESCRIPTION']}}@endif</textarea>
                									</div>
    											</div>
    											<div class="modal-footer" >
    												<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            										<button form="editExperience{{$experience['IDEXPERIENCE']}}" type="submit" class="btn btn-primary">Save changes</button>
    											</div>
    										</div>
    									</div>
    								</div>
    								<!-- edit modal -->
    								<button type="button" class="btn btn-primary" data-toggle="modal" href="#removeExperienceModal{{$experience['IDEXPERIENCE']}}">Delete</button>
    <!-- 				Delete confirmation modal -->
                    				<div class="modal fade" id="removeExperienceModal{{$experience['IDEXPERIENCE']}}" tabindex="-1" role="dialog" aria-labelledby="{{$experience['IDEXPERIENCE']}}dLabel" aria-hidden="true">
                      					<div class="modal-dialog" role="document">
                        					<div class="modal-content">
                          						<div class="modal-header" >
                            						<h5 class="modal-title" id="ModalLabel">Warning!</h5>
                            						<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
                              							<span aria-hidden="true">&times;</span>
                            						</button>
                          						</div>
                          						<div class="modal-body" >
                          							<p>
                          							Are you sure that you want to delete this experience record?
                          							</p>
                            						<form id="removeExperience{{$experience['IDEXPERIENCE']}}" action="removeExperience" method="post"></form>
                    									<input form="removeExperience{{$experience['IDEXPERIENCE']}}" type="hidden" name="_token" value="{{csrf_token()}}"/>
                    									<input form="removeExperience{{$experience['IDEXPERIENCE']}}" type="hidden" name="ID" value="{{$experience['IDEXPERIENCE']}}"/>
                          						</div>
                          						<div class="modal-footer" >
                    <!--       							Button to close the modal -->
                            						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <!--         						Button that submits delete form -->
                           	 						<button form="removeExperience{{$experience['IDEXPERIENCE']}}" type="submit" class="btn btn-primary">Remove</button>
                          						</div>
                        					</div>
                      					</div>
                    				</div>
                    				@endif
    							</div>
    						</div>
    					@endforeach
					@endif
				</div>
				<!-- Button to add education card -->
				@if(Session::get('ID') == $ID)
				<button type="button" class="btn btn-primary" data-toggle="modal" href="#addExperience" style="margin-top:10px;">Add Experience Card</button>			
					<div class="modal fade" id="addExperience" tabindex="-1" role="dialog" aira-labelledby="addEducationdLabel" aria-hidden="true">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header" >
									<h5 class="modal-title" id="ModalLabel">Add Job Experience</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body" >
									<form id="addExperienceForm" action="addExperience" method="post"></form>
                    				<div class="form-group">
                       					<input type="hidden" form="addExperienceForm" name="_token" value="{{csrf_token()}}">
                       					<input type="hidden" form="addExperienceForm" name="userID" value="{{Session::get('ID')}}">
                     					<label class="formLabel" for="title">Job Title:</label>
                        				<input form="addExperienceForm" type="text" class="form-control" id="title" name="title">
                        				<label class="formLabel" for="company">Company:</label>
                        				<input form="addExperienceForm" type="text" class="form-control" id="company" name="company">
                        				<label class="formLabel" for="startyear">Start Year:</label>
                        				<input form="addExperienceForm" type="text" class="form-control" id="startyear" name="startyear">
                        				<label class="formLabel" for="endyear">End Year:</label>
                        				<input form="addExperienceForm" type="text" class="form-control" id="endyear" name="endyear">
                        				<label class="formLabel" for="current">Status: </label>
                						<select form=addExperienceForm class="form-control" id="current" name="current" style="width:40%;">
                							<option value="1" selected>Current</option>
                							<option value="0">Not Current</option>
                						</select>
                        				<label class="formLabel" for="description">Job Description:</label>
                        				<label for="description">Description: </label>
										<textarea form="addExperienceForm" class="form-control" id="description" name="description" rows="5" style="width: 70%;"></textarea>
									</div>
									<div class="modal-footer" >
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        								<button form="addExperienceForm" type="submit" class="btn btn-primary">Create Experience Card</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			<div class="tab-pane fade" id="skills" role="tabpanel" aria-labelledby="skills-tab">
				<div class="row">
					<div class="col-4">
						<div class="list-group" id="list-tab" role="tablist">
    						@foreach($skills as $skill)
    							@if($skill == $skills[0])
    								<a class="list-group-item list-group-item-action active list-group-item-primary" id="list-{{$skill['SKILL']}}-list>" data-toggle="list" href="#list-{{$skill['SKILL']}}" role="tab" aria-controls="{{$skill['SKILL']}}">{{$skill['SKILL']}}</a>
    							@else
    								<a class="list-group-item list-group-item-action list-group-item-primary" id="list-{{$skill['SKILL']}}-list>" data-toggle="list" href="#list-{{$skill['SKILL']}}" role="tab" aria-controls="{{$skill['SKILL']}}">{{$skill['SKILL']}}</a>	
    							@endif
    						@endforeach
						</div>
					</div>
					<div class="col-8">
						<div class="tab-content" id="nav-tabContent">
							@foreach($skills as $skill)
								@if($skill == $skills[0])
									<div class="tab-pane fade show active" id="list-{{$skill['SKILL']}}" role="tabpanel">{{$skill['DESCRIPTION']}}
								@else
									<div class="tab-pane fade" id="list-{{$skill['SKILL']}}" role="tabpanel">{{$skill['DESCRIPTION']}}
								@endif
									@if(Session::get('ID') == $ID)
										<br><br>
    									<form id="removeSkill{{$skill['IDSKILLS']}}" action="removeSkill" method="post" style="display:none;"></form>
  										<input form="removeSkill{{$skill['IDSKILLS']}}" type="hidden" name="_token" value="{{csrf_token()}}">
   										<input form="removeSkill{{$skill['IDSKILLS']}}" type="hidden" name="ID" value="{{$skill['IDSKILLS']}}">
										<button form="removeSkill{{$skill['IDSKILLS']}}" type="submit" class="btn btn-primary">Remove</button>
									@endif
								</div>
							@endforeach
						</div>
					</div>
				</div>
				@if(Session::get('ID') == $ID)
    				<button type="button" class="btn btn-primary" data-toggle="modal" href="#addSkill" style="margin-top:10px;">Add Skill</button>			
    				<div class="modal fade" id="addSkill" tabindex="-1" role="dialog" aira-labelledby="addSkillLabel" aria-hidden="true">
    					<div class="modal-dialog" role="document">
    						<div class="modal-content">
    							<div class="modal-header" >
    								<h5 class="modal-title" id="ModalLabel">Add Skill</h5>
    								<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
    									<span aria-hidden="true">&times;</span>
    								</button>
    							</div>
    							<div class="modal-body" >
    								<form id="addSkillForm" action="addSkill" method="post">
    									<div class="form-group">
    										<input type="hidden" name="_token" value="{{csrf_token()}}">
    										<input type="hidden" name="userID" value="{{Session::get('ID')}}">
    										<label class="formLabel" for="skill">Skill:</label>
    										<input type="text" class="form-control" id="skill" name="skill">
    										<label class="formLabel" for="description">Description:</label>
    										<textarea class="form-control" id="description" name="description" row="5" style="width:70%;"></textarea>
    									</div>
    								</form>
    							</div>
    							<div class="modal-footer" >
    								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
           							<button form="addSkillForm" type="submit" class="btn btn-primary">Add Skill</button>
    							</div>
    						</div>
    					</div>
    				</div>
				@endif
			</div>
		</div>
	</div>
</div>

@endsection
