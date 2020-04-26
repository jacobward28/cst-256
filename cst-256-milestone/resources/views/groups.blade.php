@extends('layouts.appmaster')
@section('title','Affinity Groups')

@section('style')
<style>

.table .text-center {
    text-align:center;
}  

.form-control{
    display:inline-block;
}
</style>
@endsection

@section('content')

<!-- Echos out any validation errors -->
@if($errors->count() != 0)
	@foreach($errors->all() as $error)
		<div class="alert alert-danger" role="alert" style="width:30%;">{{$error}}</div>
	@endforeach
@endif

	<h2>Affinity Groups</h2>
	
	<!-- Bootstrap Accordion that contains all affinity group information -->
	<div class="accordion" id="affinityGroups" style="width:85%;">
      <div class="card">
        <div class="card-header" id="headingOne">
          <h2 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
              My Affinity Groups
            </button>
          </h2>
        </div>
        <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#affinityGroups">
          <div class="card-body">
          <!-- Table to display all owned affinity groups if the user owns any -->
          	@if(count($owned) != 0)
          		<h3>Owned Groups: </h3>
              	<table class="table text-center" align="center">
              	<thead>
              		<tr>
              			<th scope="col">#</th>
              			<th scope="col">Name</th>
              			<th scope="col">Description</th>
              			<th scope="col">Focus</th>
              			@if(Session::get('ID') == $ID)
              				<th scope="col">Edit</th>
              				<th scope="col">Delete</th>
              			@endif
              		</tr>
              	</thead>
              	
              	<tbody>
              		<?php $i = 0;?>
              		@foreach($owned as $group)
              		<?php $i++;?>
              		<tr>
              			<th scope="row">{{$i}}</th>
              			<td>
              				<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse{{$group['IDAFFINITYGROUPS']}}" aria-expanded="false" aria-controls="collapseExample">
   								 {{$group['NAME']}}
  							</button>
  						</td>
              			<td>{{$group['DESCRIPTION']}}</td>
              			<td>{{$group['FOCUS']}}</td>
              			@if(Session::get('ID') == $ID)
                  			<td>
                  				<button type="button" class="btn btn-primary" data-toggle="modal" href="#editGroup{{$group['IDAFFINITYGROUPS']}}">Edit</button>
                  				
                  				<div class="modal fade" id="editGroup{{$group['IDAFFINITYGROUPS']}}" tabindex="-1" role="dialog" aria-labelledby="editGroup" aria-hidden="true">
                            		<div class="modal-dialog modal-lg" role="document">
                            			<div class="modal-content">
                            				<div class="modal-header">
                            					<h5 class="modal-title" id="ModalLabel">Edit Group</h5>
                            					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
                            						<span aria-hidden="true">&times;</span>
                            					</button>
                            				</div>
                            				<div class="modal-body">
                            					<div class="card" align="center">
                            						<!-- Form for editing owned affinity groups -->
                            						<form action="editGroup" method="post" style="width:70%; text-align:center !important;">
                            							<input type="hidden" name="_token" value="{{csrf_token()}}">
                            							<input type="hidden" name="ID" value="{{$group['IDAFFINITYGROUPS']}}">
                            							<label for="name" class="formLabel">Group Name: </label><br>
                            							<input type="text" id="name" name="name" class="form-control" value="{{$group['NAME']}}">
                            							<label for="description" class="formLabel">Description: </label><br>
                            							<textarea class="form-control" id="description" name="description" rows="5" style="width: 70%;">{{$group['DESCRIPTION']}}</textarea><br>
                            							<label for="focus" class="formLabel">Focus: </label><br>
                            							<select class="form-control" id="focus" name="focus" style="width:40%;" value="{{$group['FOCUS']}}"><br>
                            								@foreach($skills as $skill)
                            									<option value="{{$skill['SKILL']}}">{{$skill['SKILL']}}</option>
                            								@endforeach
                            							</select><br>    
                            							<button type="submit" class="btn btn-primary">Edit Group</button> 								
                    								</form>
                            					</div>
                            				</div>
                            			</div>
                            		</div>
                				</div>
                  			</td>
                  			<td>
                  				<!-- Form for deleting owned affinity groups -->
                  				<form action="deleteGroup" method="post">
                  					<input type="hidden" name="_token" value="{{csrf_token()}}">
                  					<input type="hidden" name="groupID" value="{{$group['IDAFFINITYGROUPS']}}">
                  					<button type="submit" class="btn btn-primary">Delete Group</button>
                  				</form>
                  			</td>
              			@endif
              		</tr>
              		<div class="collapse" id="collapse{{$group['IDAFFINITYGROUPS']}}">
              			<div class="card card-body">
              				<!-- Prints out all members of an affinity group with buttons linking to the user's profile -->
              				Users in This Group:
              				@if(count($group['members']) != 0)
              					@foreach($group['members'] as $member)
                  					<form action="userProfile" method="get">
                  						<input type="hidden" name="_token" value="{{csrf_token()}}">
                  						<input type="hidden" name="ID" value="{{$member['ID']}}">
                  						<button type="submit" class="btn btn-primary" style="width:20%;">{{$member['USERNAME']}}</button>
                  					</form>
              					@endforeach
              				@endif
             			</div>
              		</div>
              	@endforeach
              	</tbody>
			</table>
			@endif
				
				<!-- Displays all joined affinity groups -->
				@if(count($joined) != 0)
				<h3>Joined Groups:</h3>
				<table class="table text-center">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">Name</th>
							<th scope="col">Discription</th>
							<th scope="col">Focus</th>
							<th scope="col">Leave</th>
						</tr>
					</thead>
					<tbody>
						<?php $n = 0;?>
						@foreach($joined as $group)
    						<?php $n++;?>
    						
    						<tr>
    							<th scope="row">{{$n}}</th>
    							<td>
    								<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseJoined{{$group['IDAFFINITYGROUPS']}}" aria-expanded="false" aria-controls="collapseExample">
    									{{$group['NAME']}}
      								</button>
    							</td>
    							<td>{{$group['DESCRIPTION']}}</td>
    							<td>{{$group['FOCUS']}}</td>
    							<td>
    								<!-- Form/button for leaving a joined affinity group -->
    								<form action="leaveGroup" method="post">
    									<input type="hidden" name="_token" value="{{csrf_token()}}">
    									<input type="hidden" name="groupID" value="{{$group['IDAFFINITYGROUPS']}}">
    									<input type="hidden" name="userID" value="{{Session::get('ID')}}">
    									<button type="submit" class="btn btn-primary">Leave Group</button>
    								</form>
    							</td>
    						</tr>
						@endforeach
					</tbody>
					<div class="collapse" id="collapseJoined{{$group['IDAFFINITYGROUPS']}}">
              		<div class="card card-body">
              			Users in This Group:
              			<!-- Lists all the users in a group -->
           				@if(count($group['members']) != 0)
              				@foreach($group['members'] as $member)
								<form action="userProfile" method="get">
                  					<input type="hidden" name="_token" value="{{csrf_token()}}">
                  					<input type="hidden" name="ID" value="{{$member['ID']}}">
                  					<button type="submit" class="btn btn-primary" style="width:20%;">{{$member['USERNAME']}}</button>
                				</form>
							@endforeach
              			@endif
             		</div>
              	</div>
				</table>
			@endif
				
          
          	<!-- Allows people to create a new affinity group as long as they have skills on their profile -->
          	@if(Session::get('ID') == $ID)
                @if(count($skills) != 0)
                    <button type="button" class="btn btn-primary" data-toggle="modal" href="#createGroup">New Group</button>
                    
                    <div class="modal fade" id="createGroup" tabindex="-1" role="dialog" aria-labelledby="createGroup" aria-hidden="true">
                		<div class="modal-dialog modal-lg" role="document">
                			<div class="modal-content">
                				<div class="modal-header">
                					<h5 class="modal-title" id="ModalLabel">Create an Affinity Group</h5>
                					<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 0.6;">
                						<span aria-hidden="true">&times;</span>
                					</button>
                				</div>
                				<div class="modal-body">
                					<div class="card">
                						<!-- Form for creating affinity group -->
                						<form action="createGroup" method="post" style="width:70%;">
                							<input type="hidden" name="_token" value="{{csrf_token()}}">
                							<input type="hidden" name="ID" value="{{Session::get('ID')}}">
                							<label for="name" class="formLabel">Group Name: </label>
                							<input type="text" id="name" name="name" class="form-control">
                							<label for="description" class="formLabel">Description: </label><br>
                							<textarea class="form-control" id="description" name="description" rows="5" style="width: 70%;"></textarea><br>
                							<label for="focus" class="formLabel">Focus: </label><br>
                							<select class="form-control" id="focus" name="focus" style="width:40%;"><br>
                								@foreach($skills as $skill)
                									<option value="{{$skill['SKILL']}}">{{$skill['SKILL']}}</option>
                								@endforeach
                							</select><br>    
                							<button type="submit" class="btn btn-primary">Create Group</button> 								
        								</form>
                					</div>
                				</div>
                			</div>
                		</div>
                	</div>
            	@endif
        	@endif
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="headingTwo">
          <h2 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
              Joinable Affinity Groups
            </button>
          </h2>
        </div>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#affinityGroups">
          <div class="card-body">
          <!-- Displays suggested affinity groups if the user has any suggested affinity groups -->
          @if(count($suggested) != 0)
          	<h3>Suggested Groups:</h3>
          	<table class="table text-center">
          		<thead>
          			<tr>
          				<th scope="col">#</th>
          				<th scope="col">Name</th>
          				<th scope="col">Description</th>
          				<th scope="col">Focus</th>
          				@if(Session::get('ID') == $ID)
          					<th scope="col">Join</th>
          				@endif
          			</tr>
          		</thead>
          		<tbody>
          			<?php $x = 0;?>
          			<!-- Displays all suggested affinity groups -->
          			@foreach($suggested as $group)
              			<?php $x++;?>
              			<tr>
              				<th scope="row">{{$x}}</th>
              				<td>
              					<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseSuggested{{$group['IDAFFINITYGROUPS']}}" aria-expanded="false" aria-controls="collapseExample">
    								{{$group['NAME']}}
      							</button>
              				</td>
              				<td>{{$group['DESCRIPTION']}}</td>
              				<td>{{$group['FOCUS']}}</td>
              				@if(Session::get('ID') == $ID)
                  				<td>
                  					<!-- Form/button for joining an affinity group -->
                  					<form action="joinGroup" method="post">
        								<input type="hidden" name="_token" value="{{csrf_token()}}">
        								<input type="hidden" name="groupID" value="{{$group['IDAFFINITYGROUPS']}}">
        								<input type="hidden" name="userID" value="{{Session::get('ID')}}">
        								<button type="submit" class="btn btn-primary">Join Group</button>
        							</form>
                  				</td>
              				@endif
              			</tr>
              			<div class="collapse" id="collapseSuggested{{$group['IDAFFINITYGROUPS']}}">
                      		<div class="card card-body">
                      		Users in This Group:
                      			@if(count($group['members']) != 0)
                      				<!-- Displays all members in a group along with links to their profiles -->
                     				@foreach($group['members'] as $member)
                          				<form action="userProfile" method="get">
                          					<input type="hidden" name="_token" value="{{csrf_token()}}">
                          					<input type="hidden" name="ID" value="{{$member['ID']}}">
                          					<button type="submit" class="btn btn-primary" style="width:20%;">{{$member['USERNAME']}}</button>
                          				</form>
                      				@endforeach
                      			@endif
                  			</div>
                		</div>
          			@endforeach
          		</tbody>
          	</table>
          	@else
          		<h4>You currently do not have any joinable groups</h4>
          	@endif
          </div>
        </div>
      </div>
    </div>
@endsection