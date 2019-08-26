<?php include "includes/admin_header.php" ?>


	<div id="wrapper">





        <!-- Navigation -->

        <?php include "includes/admin_navigation.php" ?>




<div id="page-wrapper">

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">


            <h1 class="page-header">
                Welcome to admin
                <small>Author</small>
            </h1>

                 <br />
                 <br />
                 <h2 align="center">Add New Project</h2>
                 <div class="form-group">
                      <form name="add_name" id="add_name" action="addProject.php" method="post" enctype="multipart/form-data">
                           <div class="table-responsive">
                                <table class="table table-bordered" id="dynamic_field">
 									<tr>
                                          <td><input type="text" name="team[]" placeholder="Enter your Name" class="form-control name_list" /></td>
                                          <td><button type="button" name="add" id="add" class="btn btn-success">Add More Names</button></td>
                                     </tr>

 								 </table>
 								 <table class="table table-bordered" id="dynamic_field_tag">
 									<tr>
                                          <td><input type="text" name="name[]" placeholder="Enter your tag" class="form-control name_list" /></td>
                                          <td><button type="button" name="add" id="add_tag" class="btn btn-success">Add More Tags</button></td>
                                     </tr>

 								 </table>
 								 <table class="table table-bordered">

 									<tr>
 										<td>Title of the project</td><td><input type="text" name="title" placeholder="Enter the full title" required></td>
 									</tr>
 									<tr>
 										<td>Description of project</td><td><input type="text" name="description" placeholder="Enter the description" required></td>
 									</tr>
 									<tr>
 			                            <td>Current Status </td><td><input type="radio" name="status" label="ongoing" value="ongoing" required>Ongoing</td><td><input type="radio" name="status" label ="completed" value="completed" required>Completed</td>
 		                            </tr>
 									<tr>
 			<td>Date: </td><td><input type="date" name="date_1" required></td>
 		</tr>


 		<tr>
 			<td>Githublink:</td><td><input type="text" name="link" ></td>
 		</tr>
 		<tr>
 			<td>Photo:</td><td><input type="file" name="img" ></td>
 		</tr>
                                </table>
                                <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />

                      </form>
                 </div>
            </div>
			<!--     Add ur code here         -->





        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->


</div>








        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
		<script>
	  $(document).ready(function(){
	       var i=1;
	       var j=1;
	 	  $('#add').click(function(){
	            i++;
	            $('#dynamic_field').append('<tr id="row'+i+'"><td><input type="text" name="team[]" placeholder="Enter your Name" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
	       });
	 		$('#add_tag').click(function(){
	            j++;
	            $('#dynamic_field_tag').append('<tr id="row'+j+'"><td><input type="text" name="name[]" placeholder="Enter your tag" class="form-control name_list" /></td></tr>');
	       });
	       $(document).on('click', '.btn_remove', function(){
	            var button_id = $(this).attr("id");
	            $('#row'+button_id+'').remove();
	       });
	 	$(document).on('click', '.btn_remove_tag', function(){
	            var button_id = $(this).attr("id");
	            $('#row'+button_id+'').remove();
	       });
	       $('#submit').click(function(){
	            $.ajax({
	                 url:"name.php",
	                 method:"POST",
	                 data:$('#add_name').serialize(),
	                 success:function(data)
	                 {
	                      alert(data);
	                      $('#add_name')[0].reset();
	                 }
	            });
	       });
	  });
	  </script>
    <?php
     if(isset($_POST['submit']))
    	{

    		$id3=uniqid();

    		$title=$_POST['title'];
    		$status=$_POST['status'];
    		$description=$_POST['description'];
    		$link=$_POST['link'];
    		$date=$_POST['date_1'];
    		$imgname=$_FILES['img']['name'];
    		$tempname=$_FILES['img']['tmp_name'];
    		$str="";
    		$string="";
    		$i1=0;
    		while(TRUE)
    		{

    			if(isset($_POST["name"][$i1]))
    			{
    		$tag=$_POST["name"][$i1];

    		$query="SELECT * FROM `tags` WHERE `name`='$tag'";

    		$rn=mysqli_query($connection,$query);
    		$row=mysqli_num_rows($rn);
    		if ($row>0)
    		{
    			$number=0;
    			while($row=mysqli_fetch_assoc($rn))
    			{$number++;
    				$id=$row['id'];

    			$str=$str.$id.',';

    			}


    		}

    		else{
    			echo "<script>alert('$tag' +' not found in database')</script>";
    		}

    			}
    		else
    		{

    		 break;
    		}
    		$i1++;
    		}





    		for($i=0;$i<6;$i++)
    		{

    			if(isset($_POST["team"][$i]))
    			{

    			$member=$_POST["team"][$i];
    			$qry="SELECT * FROM `users` WHERE `username`='$member'";
    			$run=mysqli_query($connection,$qry);
    			$row1=mysqli_num_rows($run);

    			if ($row1>0)
    		{
    			$count=0;
    			while($rw=mysqli_fetch_assoc($run))
    			{
    			$count++;
    			$mid=$rw['user_id'];

    			$string=$string.$mid.',';
    			}


    		}


    		else{
    			echo "<script>alert('$member' +' not found in database')</script>";

    		}
    			}

    		}
    		if($str!="" AND $string!="")
    		{
          $str=rtrim($str,',');
          $string=rtrim($string,',');
    		move_uploaded_file($tempname,"./images/$imgname");
    		$q1="INSERT INTO `project`(`id`, `title`,`Description`, `status`, `githubLink`, `photo`,`teamdid`,`date`,`tags`) VALUES ('$id3','$title','$description','$status','$link','$imgname','$string','$date','$str')";

    		$r1=mysqli_query($connection,$q1);
        if($r1==TRUE)
          header("location:searchProject.php");


    		}
    		else
    			echo "Please enter the values";
    	}

    	?>
