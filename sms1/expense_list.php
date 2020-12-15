<?php
ob_start();
session_start();
if(isset($_SESSION['userId']) && $_SESSION['userType'] == 'Administrator'){
	require_once('include/header.php');
	require_once('connect.php');
?>
<script>
$(document).ready(function() {
	$('#myTable').DataTable();
} );
</script>
 <section id="main-content">
          <section class="wrapper">   

              <!--overview start-->
			  <div class="row">
					<h1>&nbsp&nbspAll Inventory Details</h1>
				</div>

<div class="table-responsive">
    <div class="panel panel-white no-radius">
                                        <div class="panel-body">   
                                            <br>
    <table id="myTable" class="table table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th><center>SN</center></th>
                <th><center>Date</center></th>
                <th><center>Title</center></th>
                
                <th><center>Amount</center></th>
               
          <!--      <th>Action</th>   -->          
            </tr>
        </thead>
     

        <?php
        $query = $mysqli->query("select * from expense_details order by Id desc");
        if($query->num_rows > 0){
        	$sn=1;
        	while($rows = $query->fetch_array()){?>
         
        		<tr>
        			<td><center><?php echo $sn; ?></center></td>
                	<td><center><?php echo $rows['date']; ?></center></td>
                	<!--<td>
                        <?php
                            
                            echo $rows['expense_title'];
                        ?>
                    </td>-->
                   <td><center><?php echo $rows['details']; ?></center></td>
                	<td><center><?php echo $rows['amount']; ?></center></td>
                	
                  <!--  <td><?php echo $rows['submitby']; ?></td>-->
               <!-- 	<td>
                		<?php $id = $rows['Id'];?>
                		
                	<a rel="tooltip"  title="Delete" id="<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete?')" href="delete_expense.php?active=delete_expense && id=<?php echo $id;?>" data-toggle="modal" class="btn btn-danger"><i class="fa fa-trash" ></i></a>

         			<a  rel="tooltip"  title="Edit" id="e<?php echo $id; ?>" href="edit_expense.php?active=edit_expense && id=<?php echo $id;?>" class="btn btn-success"><i class="fa fa-pencil" "></i></a>
          
         			</td>-->
            	</tr>


            <?php

            	$sn++;
        	}

        }?>

        </table>
        </section>
        <?php
require_once('include/footer.php');	
}else{
	header("Location:index.php");	
}
?>

