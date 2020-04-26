


<!-- This is the form for going to the user profile put outside of the navbar so that it doesn't interfer with the 
rest of the navbar -->
<form action="userProfile" id="userProfile" style="margin:0px;" method="get"></form>
<form action="displayJobsHome" id="Jobs" style="margin:0px;" method="get"></form>
<form action="groups" id="Affinity" style="margin:0px;" method="get"></form>
<input form="userProfile" type="hidden" name="_token" value="{{csrf_token()}}">
<input form="userProfile" type="hidden" name="ID" value="{{Session('ID')}}">
<form action="groups" id="groups" style="margin:0px;" method="get"></form>
<input form="Affinity" type="hidden" name="_token" value="{{csrf_token()}}">
<input form="Affinity" type="hidden" name="ID" value="{{Session('ID')}}">
<!-- Bootstrap navbar that will be included at the top of all pages for the purpose of navigation -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(60, 63, 65); margin-bottom:20px;">
  <a class="navbar-brand" href="https://clc-256.azurewebsites.net/cst-256-milestone/">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <!-- If the user is logged in a link with they're name to take them to their profile is included here -->
      <?php if(Session::has('USERNAME')){?>
      <li class="nav-item active">
			<input type="submit" form="userProfile" class="nav-link" style="cursor:pointer; background:none; border:none; width:100% !important;" value="{{Session('USERNAME')}}">
      </li>
      <li class="nav-item active">
			<input type="submit" form="Jobs" class="nav-link" style="cursor:pointer; background:none; border:none; width:100% !important;" value="Jobs">
      </li>
      <li class="nav-item active">
			<input type="submit" form="Affinity" class="nav-link" style="cursor:pointer; background:none; border:none; width:100% !important;" value="Affinity">
      </li>      
      <!-- If the currently logged in user is an admin then the admin menu is linked after the user profile -->
      <?php if(session('ROLE')){?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Admin
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <!-- Link to take the user to the user admin page -->
          <a class="dropdown-item" href="userAdmin">User Admin</a>
          <a class="dropdown-item" href="jobAdmin">Job Admin</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="createJob">New Job</a>
        </div>
      </li>
      <?php }?>
      <!-- Link to let the user sign out if they're currently logged in -->
      <li class="nav-item">
      	<a class="nav-link" href="SignOut">Sign Out</a>
      </li>
      <?php } else {?>
      <!-- Link to let the user login if they are not currently logged in -->
      <li class="nav-item">
        <a class="nav-link" href="Login">Login</a>
      </li>
      <?php }?>
    </ul>
  </div>
  <form action="jobSearch" class="form-inline my-2 my-lg-0">
      <input type="hidden" name="token" value="{{csrf_token()}}">
      <input class="form-control mr-sm-2" name="searchString" type="search" placeholder="Job Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>
