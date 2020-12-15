<script>
$(document).ready(function() {
	$('#myTable').DataTable();
} );
</script>
<div class="table-responsive" style="margin:0 20px;">
         <table id="myTable" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>SN</th>
                <th>Expense time</th>
                <th>Expense Title</th>
                <th>Details</th>
                <th>Amount</th>              
            </tr>
        </thead>
        

        <?php
        date_default_timezone_set('Asia/Dhaka');
        $today_date = date('Y-m-d');
        
        $query = $mysqli->query("select * from expense_details order by Id desc");
        if($query->num_rows > 0){
        	$sn=1;
            $amount=0;
            $consumption=0;
            $revenue=0;
        	while($rows = $query->fetch_array()){

                $expense_date = date('Y-m-d',strtotime($rows['date']));

                if ($today_date==$expense_date) {?>

                    <tr>
                        <td><?php echo $sn; ?></td>
                        <td><?php echo $rows['date']; ?></td>
                        <td>
                            <?php
                                
                                echo $rows['expense_title'];?>
                        </td>
                     
                        <td><?php echo $rows['details']; ?></td>
                        <td><?php echo $rows['amount']; ?></td>
                    </tr>
                    
                <?php 
                    /*if($rows['exp_type']=='Consumption')
                        $consumption = $consumption+$rows['amount'];
                
                    else
                        $revenue = $revenue+$rows['amount'];*/
                    
                        $amount=$amount+$rows['amount'];
            	   $sn++;
        	   }
            }
        }
        //$net_inc=$revenue-$consumption;?>
        <tfoot>
          
            <tr>
                <th>Total Expense</th>
                <th> </th>
                <th> </th>
                <th> </th>
           
                <th><span style="color:#ea6d12;"><?php echo $amount; ?></span></th>               
            </tr>
        </tfoot>
    </table>