
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
               <h1>&nbsp&nbsp&nbspToday's Expense Details</h1>
                   <br>
                </div>

<div class="table-responsive">
     <div class="panel panel-white no-radius">
                                        <div class="panel-body">   
                                            <br>
    <table id="myTable" class="table  table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>Date</th>
                <th>Inventory Item</th>
                <th>Quantity</th>
                
                <th>Cost</th>              
            </tr>
        </thead>
        

        <?php
        date_default_timezone_set('Asia/Dhaka');
        $today_date = date('Y-m-d');
        
        $query = $mysqli->query("select * from expense_details order by Id desc");
        if($query->num_rows > 0){
            $sn=1;
            $amount=0;
            while($rows = $query->fetch_array()){

                $expense_date = date('Y-m-d',strtotime($rows['date']));

                if ($today_date==$expense_date) {?>

                    <tr>
                        <td><?php echo $sn; ?></td>
                        <td><?php echo $rows['date']; ?></td>
                        <td>
                            <?php
                    
                                echo $rows['details'];?>
                        </td>
                        <td><?php echo $rows['quantity']; ?></td>
                       
                        <td><?php echo $rows['amount']; ?></td>
                    </tr>
                    
             <?php $amount=$amount+$rows['amount'];   }?>

            <?php
                $sn++;
            }
        }?>
        <tfoot>
            <tr>
                <th>Total</th>
                <th> </th>
                <th> </th>
                <th> </th>
               
                <th><span style="color:#ea6d12;"><?php echo $amount ?></span></th>               
            </tr>
        </tfoot>
    </table>
    </div>
</section>
</section>

<?php
require_once('include/footer.php'); 
}
else
    header("Location:index.php");   

?>

