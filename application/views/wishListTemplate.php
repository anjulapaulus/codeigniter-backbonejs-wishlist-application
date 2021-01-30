<!doctype html>
<html lang="en">
<?php include("header.php"); ?>
<style>
	.container {
		/*background-color: #9b59b6;*/
		max-width: 100%;
		padding-right: 0;
		padding-left: 0;
		margin-top: -24px;
		height: 100%;
	}
	.nav-btn{
		border: 2px solid black;
		width: 150px;
		margin-left: 20px;
		margin-top: 10px;
	}
	.nav-btn:hover {
		background-color: black;
		color: white;
	}
</style>

<body>
<nav class="navbar navbar-darkjustify-content-between" style="padding-bottom: 13px; background-color: #0d0d29;">
		<div class="navbar-header">
			<a class="navbar-brand" style="color:white; margin-left:30px;">Wisher</a>
		</div>
</nav>

<script type="text/template" class="login-temp" id="login-template">
		<div id="loginbox" style="margin: auto; width: 50%;  padding: 180px 0;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
        <form class="login-form">
            <div class="form-outline mb-4">
                <h2 >LOGIN</h2>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Email address</label>
                <input type="email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">Password</label>
                <input type="password" id="password" class="form-control" />
            </div>
            <span id="errors" style="color:red;font-size: small;"></span>
            <button type="submit" class="btn btn-primary btn-block">Sign in</button>
            <div style="margin-top:10px;">
                 Want to create an account? <a href="#register">Create a Account</a>
            </div>
        </form>
    </div>
</script>

	<script type="text/template" class="login-temp" id="register-template">
		<div id="loginbox" style="margin: auto; width: 50%;  padding: 150px 0;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">   
        <form class="register-form">
            <div class="form-outline mb-4">
                <h2>REGISTER</h2>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Name</label>
                <input type="text" id="name" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Email address</label>
                <input type="email" id="email" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">Password</label>
                <input type="password" id="password" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example2">Password</label>
                <input type="password" id="confPassword" class="form-control" />
            </div>
            <span id="errors" style="color:red;font-size: small;"></span>
            <button type="submit" class="btn btn-primary btn-block">Create an account</button>
            <div style="margin-top:10px;">
                 Have an account? <a href="#">Login</a>
            </div>
        </form>
    </div>
</script>

	<script type="text/template" id="create-list-template">
		<div id="loginbox" style="margin: auto; width: 50%;  padding: 150px 0;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">   
        <form class="create-list-form">
            <div class="form-outline mb-4">
                <h2>CREATE LIST</h2>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">List Name</label>
                <input type="text" id="listName" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">List Description</label>
                <input type="text" id="listDesc" class="form-control" />
            </div>
            <span id="errors" style="color:red;font-size: small;"></span>
            <button type="submit" class="btn btn-primary btn-block">Create a list</button>
        </form>
    </div>
</script>

<script type="text/template" id="list-template">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarTogglerDemo03">
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
			<li class="nav-item active">
			<button id="btn-add" class="btn default nav-btn">Add Item</button>
			</li>
			<li class="nav-item">
				<button id="btn-share" class="btn default nav-btn">Share</button>
			</li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
				<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
					<li class="nav-item dropdown" style="margin-right:50px;">
						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<%=name%>
						</a>
						<div class="dropdown-menu" aria-labelledby="navbarDropdown">
							<button id="btn-logout" class="btn default">Logout</button>
						</div>
					</li>
				</ul>
			</form>
		</div>
	</nav>
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
			 aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body text-center">
						localhost/wishlist-app/#share/<%=id%>
					</div>

				</div>
			</div>
		</div>
	<div id="loginbox" style="" class="container-fluid">
		<div style="text-align: center">
			<h1 class="list-name"><%=list_name%></h1>
			<h2 class="list-des"><%=list_description%></h2>
			<br>
		</div>
		<h1 id="#no-items"></h1>
		<div id="item_position" >
		<table class="table">
				<thead class="thead-dark">
					<tr class="d-flex">
						<th class="col-3">Item Name</th>
						<th class="col-3">URL</th>
						<th class="col-1">Price</th>
						<th class="col-1">Quantity</th>
						<th class="col-1">Priority</th>
						<th class="col-3"></th>
					</tr>
				</thead>
			<tbody>
			</tbody>
		</table>
		</div>
	</div>
</script>

<script type="text/template" id="item-template">
	<tr class="d-flex" style="margin-top:20px;">
				<td class="col-3 col-md-3" style="font-size: 15px;"><%=item_name%></td>
				<td class="col-3 col-md-3" style="font-size: 15px;"><a><%=item_url%></a></td>
				<td class="col-1 col-md-1" style="font-size: 15px;"><%=item_price%></td>
				<td class="col-1 col-md-1" style="font-size: 15px;"><%=item_quantity%></td>
				<td class="col-1 col-md-1" style="font-size: 15px;">
				<%if(item_priority =='1'){%>
							Must Have
							<%}else if(item_priority =='2'){%>
							Would be Nice to Have
							<%}else{%>
							Not needed<%}%></td></td>
				<td class="col-3 col-md-3" style="font-size: 15px;">
					<button class='btn btn-info' value="<%=item_id%>" id="btn-update-item">Edit</button>
					<button class="btn btn-danger" value="<%=item_id%>" id="btn-delete-item">Delete</button>
				</td>
	</tr>
</script>

<script type="text/template" id="add-item-template">
	<div id="loginbox" style="margin: auto; width: 50%;  padding: 150px 0;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">   
        <form class="create-item-form">
            <div class="form-outline mb-4">
                <h2>CREATE ITEM</h2>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Name</label>
                <input type="text" id="itemName" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item URL</label>
                <input type="text" id="url" class="form-control" />
			</div>
			<div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Price</label>
                <input type='number' class='form-control text-left' id='itemPrice'/>
			</div>
			<div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Quantity</label>
                <input type='number' class='form-control text-left' id='itemQuantity'/>
			</div>
			<div class="form-group">
					<label for='ItemPriority'> Item Priority </label>
					<select class='form-control text-left' id="itemPriority">
						<option selected="selected" value="1">Must Have</option>
						<option value="2">Would be Nice to Have</option>
						<option value="3">If You Can</option>
					</select>
			</div>
            <span id="errors" style="color:red;font-size: small;"></span>
			<button id= 'btnAdd' class="btn btn-primary btn-block">Add Item</button>
			<button id = 'btnBack' class="btn btn-primary btn-block">Back</button>
        </form>
    </div>
</script>

<script type="text/template" id="update-item-template">
	<div id="loginbox" style="margin: auto; width: 50%;  padding: 150px 0;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">   
        <form class="create-item-form">
            <div class="form-outline mb-4">
                <h2>UPDATE ITEM</h2>
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Name</label>
                <input type="text" id="itemName" value="<%=item_name%>" class="form-control" />
            </div>
            <div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item URL</label>
                <input type="text" id="url" value="<%=item_url%>" class="form-control" />
			</div>
			<div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Price</label>
                <input type='number' class='form-control text-left' value="<%=item_price%>" id='itemPrice'/>
			</div>
			<div class="form-outline mb-4">
                <label class="form-label" for="form1Example1">Item Quantity</label>
                <input type='number' class='form-control text-left' id='itemQuantity' value="<%=item_quantity%>"/>
			</div>
			<div class="form-group">
					<label for='ItemPriority'> Item Priority </label>
					<select class='form-control text-left' id="itemPriority">
						<option selected="selected" value="<%=item_priority%>">
							<%if(item_priority =='1'){%>
							Must Have
							<%}else if(item_priority =='2'){%>
							Would be Nice to Have
							<%}else{%>
							Not needed<%}%>
						</option>
						<option value="1">Must Have</option>
						<option value="2">Would be Nice to Have</option>
						<option value="3">If You Can</option>
					</select>
			</div>
            <span id="errors" style="color:red;font-size: small;"></span>
			<button id= 'btnAdd' class="btn btn-primary btn-block">Update Item</button>
			<button id = 'btnBack' class="btn btn-primary btn-block">Back</button>
        </form>
    </div>
</script>

<script type="text/template" id="list-template-share">
	<div id="placing">
		<br>
		<div style="text-align: center">
			<h1 class="list-name"><%=wish_list_name%></h1>
			<h2 class="list-des"><%=wish_list_description%></h2>
		</div>
		<span id="show_url"></span>
		<br>
		<div style="" class="d-none">
			<h1 class="list-name"><%=wish_list_name%></h1>
			<h2 class="list-des"><%=wish_list_description%></h2>
		</div>
		<h1 id="#no-items"></h1>
		<div style="margin-left:20px;margin-right:20px;">
		<p>User : <b><%=name%></b></p>
		<p>Email : <b><%=email%></b></p>
			<table class="table">
					<thead class="thead-dark">
						<tr class="d-flex">
							<th class="col-4">Item Name</th>
							<th class="col-4">URL</th>
							<th class="col-1">Price</th>
							<th class="col-1">Quantity</th>
							<th class="col-2">Priority</th>
						</tr>
					</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>

</script>

<script type="text/template" id="item-template-share">
<div style="margin:20px;">
	<table class="table">
		<tr class="d-flex">
				<td class="col-4 col-md-4" style="font-size: 15px;"><%=item_name%></td>
				<td class="col-4 col-md-4" style="font-size: 15px;"><a><%=item_url%></a></td>
				<td class="col-1 col-md-1" style="font-size: 15px;"><%=item_price%></td>
				<td class="col-1 col-md-1" style="font-size: 15px;"><%=item_quantity%></td>
				<td class="col-2 col-md-2" style="font-size: 15px;">
				<%if(item_priority =='1'){%>
							Must Have
							<%}else if(item_priority =='2'){%>
							Would be Nice to Have
							<%}else{%>
							Not needed<%}%></td>
		</tr>
	</table>
</div>
</script>

	<div class="container"></div>

	<div class="container-create-list"></div>

	<div class="container-main"></div>

	<div class="container-add"></div>

	<div class="container-update"></div>

	<div class="container-share"></div>

	<nav class="navbar fixed-bottom navbar-dark" style="background-color: #0d0d29;">
		<div class="container-fluid" style="display: flex; justify-content: center; align-items: center;">
			<p style="color: white; margin-top:10px;">Anjula Paulus | 2016350 | w1673640</p>
		</div>
	</nav>
</body>

</html>