<?php
ob_start();
@session_start();
if(isset($_SESSION['userId']) && ($_SESSION['userType'] == 'Administrator'|| $_SESSION['userType'] == 'Pathology')){
require_once('include/header.php');
require_once('connect.php');
date_default_timezone_set('UTC');
$mkdate = mktime(date('H') + 6, date('i'), date('s'));
$todaydate = date('Y-m-d', $mkdate);
?>

<script>
    
$(function(){
    var countLIActive = $('li a.t').length;
    if ( $('.displayDetails').children().length > 0 ) {
        $('#demotab').hide();
 
    }
    if(countLIActive > 0){
        var activePN = $('li.active a.t').html();
        var activeM = $('li.active span.m').html();
        $('#patientName').val(activePN);
        if(activeM != '-'){
            $('#mobile').val(activeM);
        }else{
            $('#mobile').val('');
        }
        $('#searchTest').focus();
    }else{
        $('#patientName').val('');
        $('#mobile').val('');
    }
    
    $("#searchTest").typeahead({
        source:function(query, process){
            $('.loading_test').css('display','');
            $.getJSON('search_test.php?query='+query, function(data){
                process(data);
                $('.loading_test').css('display','none');
            });
        },
        updater: function(item){
            var testKey;
            testKey = item.replace('&', '%26');
            var patientName = $('#patientName').val();
            var mobileCheck = $('#mobile').val();
            var mobile;
            if(mobileCheck.length > 0){
                mobile = mobileCheck;
            }else{
                mobile = '-';
            }

            if(patientName.length > 0){
                $('.loading_test').css('display','');
                $.get('cart_process.php?testKey='+testKey+'&patientName='+patientName+'&mobile='+mobile, function(data){
                    $('#demotab').hide();
                    $('.displayDetails').html(data);
                    $('.loading_test').css('display','none');
                });
            }else{
                alert('Patient name must be filled out.');
            }
            
        }
    });
    
    $(".discountPerTest").change(function(){
        var value = this.value;
        var id = this.id;
        //alert(value);
        $('.loading_test').css('display','');
        $.get('discount_process.php?id='+id+'&value='+value, function(data){
            $('.displayDetails').html(data);
            $('.loading_test').css('display','none');
        });
    });
    
});

function active(patientName, mobile){
        
    $('#patientName').val(patientName);
    if(mobile != '-'){
        $('#mobile').val(mobile);
    }else{
        $('#mobile').val('');
    }
    $('#searchTest').focus();
}
function co(index){
    var coName = $('input[name="co_'+index+'"]');
    var setIndex = index.split('/');
    var firstIndex = setIndex[0];
    var secondIndex = setIndex[1];

    $(coName).typeahead({
        source:function(query, process){
            $.getJSON('get_co.php?query='+query, function(data){
                process(data);
            });
        },
        updater: function(item){

            $.ajax({
                type: 'POST',
                url: 'set_cookie_co.php',
                data: 'firstIndex='+firstIndex+'&secondIndex='+secondIndex+'&co='+item,
                success:function(data){

                }
            });
            return item;
        }
    });
}
function refdby(index){
    var refdName = $('input[name="refdby_'+index+'"]');
    var setIndex = index.split('/');
    var firstIndex = setIndex[0];
    var secondIndex = setIndex[1];

    $(refdName).typeahead({
        source:function(query, process){
            $.getJSON('get_refdby.php?query='+query, function(data){
                process(data);
            });
        },
        updater: function(item){

            $.ajax({
                type: 'POST',
                url: 'set_cookie_refdby.php',
                data: 'firstIndex='+firstIndex+'&secondIndex='+secondIndex+'&refdby='+item,
                success:function(data){

                }
            });
            return item;
        }
    });
}
function confirmInvoice(index){

    var sex = $('input[name="sex_'+index+'"]').is(':checked');
    var sexValue = $('input[name="sex_'+index+'"]:checked').val();
    var age = $('input[name="age_'+index+'"]').val();
    var ageType = $('select[name="ageType_'+index+'"]').val();

    if(sex == false){
        alert("Please Select Petient's sex Male or Female or Others");
        return false;
    }

    if(age == ''){
        alert("Please Enter Petient's age");
        return false;
    }
    
    var conf = confirm('Are you sure want to Confirm this?');
    if(conf){
        var coName = $('input[name="co_'+index+'"]').val();
        var refdName = $('input[name="refdby_'+index+'"]').val();
        var totalDisP = $('input[name="totalDisP_'+index+'"]').val();
        var totalAmount = $('input[name="totalAmount_'+index+'"]').val();
        var discountP = $('input[name="discountP_'+index+'"]').val();
        var discountAmount = $('input[name="discountAmount_'+index+'"]').val();
        var netTotal = $('input[name="netTotal_'+index+'"]').val();
        var payment = $('input[name="payment_'+index+'"]').val();
        var due = $('input[name="due_'+index+'"]').val();
        var totalRefdFee = $('input[name="totalRefdFee_'+index+'"]').val();
        var deli_time = $('textarea[name="deli_time_'+index+'"]').val();

        
        //alert('CN-'+coName+'RN-'+refdName+'TA-'+totalAmount+'DP-'+discountP+'DA-'+discountAmount+'P-'+payment);
        
        
        var myBars = 'directories=no,location=no,menubar=yes,status=no';
        
        myBars += ',titlebar=yes,toolbar=no';
        
        var myOptions = 'scrollbars=no,width=750,height=500,resizeable=no,top=10, left=300,';
        var myFeatures = myBars + ',' + myOptions;
        
        refdName = refdName.replace("&","%26");
        
        var win = window.open('confirm_invoice.php?index='+index+'&sex='+sexValue+'&age='+age+'&ageType='+ageType+'&coName='+coName+'&refdName='+refdName+'&totalDisP='+totalDisP+'&totalAmount='+totalAmount+'&discountP='+discountP+'&discountAmount='+discountAmount+'&netTotal='+netTotal+'&payment='+payment+'&due='+due+'&totalRefdFee='+totalRefdFee+'&deli_time='+deli_time, 'myDoc', myFeatures);
        
        var timer = setInterval(function() {   
            if(win.closed) {  
                clearInterval(timer);  
                $.post('remove_cart2.php?index='+index, function(data){
                    $('.displayDetails').html(data);
                }); 
            }  
        }, 1000);  

        return true;
        
    }else{
        return false;
    }
    

}

function removeOne(index){
    var conf = confirm('Are you sure want to remove this?');
    //alert(index);
    
    if(conf){
        $.post('remove_cart.php?index='+index, function(data){
            $('.displayDetails').html(data);
        }); 
        return true;
    }else{
        return false;
    }
}
function cancelInvoice(index){
    var conf = confirm('Are you sure want to cancel this?');
    
    if(conf){
        $.post('remove_cart2.php?index='+index, function(data){
            $('.displayDetails').html(data);
        }); 
        return true;
    }else{
        return false;
    }
}
function discountPer(index){
    //alert(index);
    var setIndex = index.split('/');
    var firstIndex = setIndex[0];
    var secondIndex = setIndex[1];

    var zero = 0;
    var value = document.getElementById('discountP_'+index).value;
    var totalAmount = document.getElementById('totalAmount_'+index).value;
    var payment = document.getElementById('payment_'+index).value;
    var per;
    if(value.length > 0){
        per = parseFloat(value);
    }else{
        per = parseFloat(zero);
        document.getElementById('discountP_'+index).value = zero.toFixed(2);
        document.getElementById('discountP_'+index).select();
    }
    var discountValue = (parseFloat(per) * parseFloat(totalAmount)) / parseFloat(100);
    var calTotalAmount = parseFloat(totalAmount) - parseFloat(discountValue);
    calTotalAmount = Math.ceil(calTotalAmount);
    document.getElementById('discountAmount_'+index).value = discountValue.toFixed(2);
    document.getElementById('netTotal_'+index).value = calTotalAmount.toFixed(2);
    var calDueAmount = calTotalAmount - parseFloat(payment);
    document.getElementById('due_'+index).value = calDueAmount.toFixed(2);

    $.ajax({
        type: 'POST',
        url: 'set_cookie_discount.php',
        data: 'firstIndex='+firstIndex+'&secondIndex='+secondIndex+'&discountP='+per.toFixed(2)+'&discountVal='+discountValue.toFixed(2),
        success:function(data){
            
        }
    });
    
}

function discountVal(index){

    var setIndex = index.split('/');
    var firstIndex = setIndex[0];
    var secondIndex = setIndex[1];

    var zero = 0;
    var value = document.getElementById('discountAmount_'+index).value;
    var totalAmount = document.getElementById('totalAmount_'+index).value;
    var payment = document.getElementById('payment_'+index).value;

    var dis;
    if(value.length > 0){
        dis = parseFloat(value);
    }else{
        dis = parseFloat(zero);
        document.getElementById('discountAmount_'+index).value = zero.toFixed(2);
        document.getElementById('discountAmount_'+index).select();
    }

    var calDiscountPer = (parseFloat(100) * parseFloat(dis)) / parseFloat(totalAmount);
    var calTotalAmount = parseFloat(totalAmount) - parseFloat(dis);
    calTotalAmount = Math.ceil(calTotalAmount);
    document.getElementById('discountP_'+index).value = calDiscountPer.toFixed(2);
    document.getElementById('netTotal_'+index).value = calTotalAmount.toFixed(2);
    var calDueAmount = calTotalAmount - parseFloat(payment);
    document.getElementById('due_'+index).value = calDueAmount.toFixed(2);


    $.ajax({
        type: 'POST',
        url: 'set_cookie_discount.php',
        data: 'firstIndex='+firstIndex+'&secondIndex='+secondIndex+'&discountP='+calDiscountPer.toFixed(2)+'&discountVal='+dis.toFixed(2),
        success:function(data){
            
        }
    });

}

function payment(index){
    
    var setIndex = index.split('/');
    var firstIndex = setIndex[0];
    var secondIndex = setIndex[1];

    var zero = 0;
    var value = document.getElementById('payment_'+index).value;
    var netTotal = document.getElementById('netTotal_'+index).value;
    var pay;
    if(value.length > 0){
        pay = parseFloat(value);
    }else{
        pay = parseFloat(zero);
        
        document.getElementById('payment_'+index).value = zero.toFixed(2);
        var calDue = parseFloat(netTotal) - parseFloat(pay);
        document.getElementById('due_'+index).value = calDue.toFixed(2);
        document.getElementById('payment_'+index).select();
        return false;
    }
    if(parseInt(pay) <= parseInt(netTotal)){
        pay = parseFloat(value);
        
        var calDue = parseFloat(netTotal) - parseFloat(pay);
        document.getElementById('due_'+index).value = calDue.toFixed(2);
    }else{
        alert('Sorry! Payment over limit. Please try again.');
        pay = parseFloat(zero);
        
        document.getElementById('payment_'+index).value = pay.toFixed(2);
        var calDue = parseFloat(netTotal) - parseFloat(pay);
        document.getElementById('due_'+index).value = calDue.toFixed(2);
    }

    $.ajax({
        type: 'POST',
        url: 'set_cookie_payment.php',
        data: 'firstIndex='+firstIndex+'&secondIndex='+secondIndex+'&pay='+pay.toFixed(2),
        success:function(data){
            
        }
    });
    
}
$(function(){
    $('#idNo').typeahead({
        source:function(query, process){
            $.getJSON('search_id_no.php?query='+query, function(data){
                process(data);
            })
        },
        updater:function(item){
            document.location='pathology.php?active=pathology&idNo='+item;
            
        }
    });
    if ($(".row").hasClass("report-info")) {
        $(".report-table").hide();
    }
})
</script> 
<script>
$(document).ready(function() {
    $('#ReportTable').DataTable();
} );
</script>
<style>
body{
    color:#000;
}
.form-control{
    color:#000;
    border:1px solid;
}
.control-label{
    color:#000;
    font-weight:bold;
    cursor:pointer;
}
.control-label:hover{
    color:#00C;
}
.category{
    background:#666;
    padding:5px 0px;
    color:#FFF;
    font-weight:bold
}
.result-field{
    border:1px solid;
    padding:0px;
}
</style>

<!--main content start-->
      <section id="main-content">
          <section class="wrapper">
              <div class="row">
                <h1>&nbsp&nbsp&nbspAdd New Test</h1>
                    <!--ol class="breadcrumb">
                        <li><i class="fa fa-angle-double-right"></i><a href="index.php">&nbsp; Home</a></li>
                        <li style="color:#1a1a1a;">
                        <?php
                          if(isset($_GET['active'])){ 
                            $active = explode("_",$_GET['active']);
                            
                            foreach($active as $name){
                              echo ucfirst($name);
                              echo " ";
                            }
                          }
                        ?>
                        </li>                             
                    </ol-->
                </div> 
                <!--div class="row">
            <div class="col-lg-4 col-lg-offset-3">
                <input type="text" class="input-control" id="idNo" name="idNo" placeholder="ID No" autoFocus>
            </div-->
        </div>
        <div class="container-fluid container-fullw bg-white">
                            <!--div class="row"--s-->
                            <!--    <div class="col-sm-4">-->
                                    <div class="panel panel-white no-radius ">
                                        <div class="panel-body">
                                            <br>
              
            
            
           <?php
            
            if(isset($_GET['idNo']) && $_GET['idNo'] <> ''){
            
                $query = $mysqli->query("select * from invoice where idNo = '$_GET[idNo]'");            
                
                if($query->num_rows > 0){
                    
                    $array = $query->fetch_array();
                    
                    $getCO = $mysqli->query("select * from co where coId = '$array[coId]'");
                    $coArray = $getCO->fetch_array();
                    
                    $getRefd = $mysqli->query("select * from doctor where id = '$array[refdId]'");
                    $refdArray = $getRefd->fetch_array();
                    
                ?>
                <div class="row  report-info">
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                        <!--  <div class="pull-left" style="color:#000; font-weight:bold">Refd. Prof./Dr./C/O Information</div>-->
                        <div class="pull-left" style="color:#000; font-weight:bold">Patient Information</div>
                        </div>
                        <!--<div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Refd By</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['doctor_name']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">C/O</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $coArray['coName']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>-->
                         <div class="panel-body">
                          <div class="padd">
                              <div class="form">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="100px" style="padding:2px 3px; border-bottom:1px solid #999">Patient Name</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientName']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Contact</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientMobile']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Age</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientAge']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">Sex</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['patientSex']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Lab Information</div>
                        </div>
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form" style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Patient SL</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['labDailySl']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">ID</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $array['idNo']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                        <div class="panel-heading">
                          <div class="pull-left" style="color:#000; font-weight:bold">Referred  Information</div>
                        </div>
                       
                        <div class="panel-body">
                          <div class="padd">
                              <div class="form"  style="min-height:100px;">
                                <table border="0" width="100%" style="color:#000">
                                <tr>
                                    <td width="70px" style="padding:2px 3px; border-bottom:1px solid #999">Refd. Prof./Dr./C/O Information</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $refdArray['doctor_name']; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding:2px 3px; border-bottom:1px solid #999">C/O</td>
                                    <td width="5px" style="border-bottom:1px solid #999">:</td>
                                    <td style="padding:2px 5px; border-bottom:1px solid #999"><?php echo $coArray['coName']; ?></td>
                                </tr>
                                </table>
                              </div>
                         </div>
                        </div>
                        </div>
                    </div>
                </div>
               
                    <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-stethoscope"></i></span>
                    <input type="text" style="width:100%;" class="input-control" placeholder="Search Test" id="searchTest" autoComplete="off"><span class="input-group-addon loading_test" style="display:none"><img src="img/broken_circle.gif" width="18" height="18" /></span>
                </div>
                <br>
                <br>
                <br>


                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <div class="pull-left" style="color:#333; font-weight:bold">
                                                Test Information
                                              </div>
                                            </div>
                                            <div class="panel-body">
                                              <div class="padd">
                                                  <div class="form">
                                                    <table border="0" width="100%" style="color:#333">
                                                    <tr>
                                                        <td width="6%" align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">&times;</td>
                                                        <td width="8%" align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Sl No.</td>
                                                        <td align="center" width="55%" style="font-weight:bold; padding:2px; border-bottom:4px double">Test Name</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Amount</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Dis(%)</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double;">Total</td>
                                                    </tr>
                                                    
                                                            <tr>
                                                                <td width="6%" align="center" style="padding:2px; border-bottom:1px solid"><a onclick="return removeOne('')" href="#" class="removebtn">&times;</a></td>
                                                                <td width="6%" align="center" style="padding:2px; border-bottom:1px solid"></td>
                                                                <td align="center" width="55%" style="padding:2px; border-bottom:1px solid"></td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid"></td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid">
                                                                    <input type="text" style="width: 50px; text-align: center; padding: 3px"  name="" id="" class="input-control discountPerTest" value="">%
                                                                    </td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid">
                                                                    
                                                                    </td>
                                                            </tr>
                                                            
                                                    </table>
                                                  </div>
                                                </div><br>
                                                
                                            </div>
                                        </div>


                <div class="row">
                    <div class="col-lg-12" align="center">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
                <?php
                }else{
                    echo "<center><font color='#FF0000' size='+1'><b>Data Not Found</b></center>";  
                }
            }
            ?>
            </div>
            <div class="col-lg-4">
                                        <!-- Right Top -->
                                        
                                        <!-- Right Bottom -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <div class="pull-left" style="color:#333; font-weight:bold">
                                                Payment Information
                                              </div>
                                            </div>
                                            <div class="panel-body">
                                              <div class="padd">

                                                  <div class="form">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:2px">
                                                            <div class="form-group">
                                                                <input type="hidden" class="input-control" name="totalRefdFee_" id="totalRefdFee_" value="">
                                                                <input type="hidden" class="input-control" name="totalDisP_" id="totalDisP_" value="">
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width: 50%; text-align: left">Total Amount</span>
                                                                    <input type="text" class="input-control" name="totalAmount_" id="totalAmount_" value=""  autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Discount (%)</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="discountPer('');" value="" name="discountP_" id="discountP_" autoComplete="off"><span class="input-group-addon" style="width: 13%">%</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Discount Amount</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="discountVal('');" value="" name="discountAmount_" id="discountAmount_" autoComplete="off"><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Net Total</span>
                                                                    <input type="text" class="input-control" value="" name="netTotal_" id="netTotal_" autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Payment</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="payment('');" value="" name="payment_" id="payment_" autoComplete="off"><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Due</span>
                                                                    <input type="text" class="input-control" style="color:red;" value="" name="due_" id="due_" autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab right inner -->
                                </div>
                        
             
                </div>

                 <div class="row">

            <div class="displayDetails">

                <!-- Start Tab Navigetion -->
                <?php
                if(array_key_exists('dms1', $_COOKIE)){

                        $getIndex = $_COOKIE['dms1'];

                        if(array_key_exists('pdetails', $_COOKIE)){
                            $getIndex2 = $_COOKIE['pdetails'];
                        }
                        
                ?>
                <div class="col-lg-12">
                    <ul class="nav nav-tabs">
                        <?php
                        $active = 'class = "active"';
                        $activeId = 1;
                        foreach ($getIndex as $key1 => $value1) {
                            if(is_array($value1)){
                                foreach ($value1 as $key2 => $value2) {
                                    $patientName = explode('_', $key1);
                                    $convertPN = '';
                                    $space = '';
                                    foreach ($patientName as $Pkey => $Pvalue) {
                                        $convertPN .= $space.$Pvalue;
                                        $space = ' ';
                                    }
                                ?>
                                    <li <?php echo $active; ?>><a class="t" onclick="active('<?php echo $convertPN ?>', '<?php echo $key2 ?>')" data-toggle="tab" href="#<?php echo $activeId; ?>"><?php echo $convertPN; ?></a><span class="m" style="display: none;"><?php echo $key2; ?></span></li>
                                <?php
                                    $active = "";
                                    $activeId++;
                                }
                            }
                        }
                        ?>
                    </ul>
                </div>
                <!-- End Tab Navigetion -->


                <!-- Start Tab Content -->
                <div class="tab-content">
                    <?php
                    $active = 'in active';
                    $activeId = 1;
                    foreach ($getIndex as $key1 => $value1) {

                        if(is_array($value1)){
                            foreach ($value1 as $key2 => $value2) {
                                $mainIndex = $key1.'/'.$key2;
                            ?>
                            <div id="<?php echo $activeId; ?>" class="tab-pane fade <?php echo $active; ?>">
                                    <!-- Start Tab left inner -->
                                    <?php
                                        if(array_key_exists('pdetails', $_COOKIE)){
                                            
                                            if(array_key_exists($key1, $_COOKIE['pdetails'])){
                                                $sex = isset($getIndex2[$key1][$key2][0]) ? $getIndex2[$key1][$key2][0] : NULL;
                                                $age = isset($getIndex2[$key1][$key2][1]) ? $getIndex2[$key1][$key2][1]: NULL;
                                                $ageType = isset($getIndex2[$key1][$key2][2]) ? $getIndex2[$key1][$key2][2] : NULL;
                                                $co = isset($getIndex2[$key1][$key2][3]) ? $getIndex2[$key1][$key2][3] : NULL;
                                                $refdby = isset($getIndex2[$key1][$key2][4]) ? $getIndex2[$key1][$key2][4] : NULL;
                                                $discountPerCookie = isset($getIndex2[$key1][$key2][5]) ? $getIndex2[$key1][$key2][5] : 0.00;
                                                $discountValCookie = isset($getIndex2[$key1][$key2][6]) ? $getIndex2[$key1][$key2][6] : 0.00;
                                                $payCookie = isset($getIndex2[$key1][$key2][7]) ? $getIndex2[$key1][$key2][7] : 0.00;
                                                $invoiceType = isset($getIndex2[$key1][$key2][8]) ? $getIndex2[$key1][$key2][8] : 'new';
                                            }else{
                                                $sex = '';
                                                $age = '';
                                                $ageType = '';
                                                $co = '';
                                                $refdby = '';
                                                $discountPerCookie = 0.00;
                                                $discountValCookie = 0.00;
                                                $payCookie = 0.00;
                                                $invoiceType = 'new';
                                            }

                                        }else{
                                            $sex = '';
                                            $age = '';
                                            $ageType = '';
                                            $co = '';
                                            $refdby = '';
                                            $discountPerCookie = 0.00;
                                            $discountValCookie = 0.00;
                                            $payCookie = 0.00;
                                            $invoiceType = 'new';
                                        }
                                        
                                        //echo 'Key-'.$sex;
                                    ?>
                                    <div class="col-lg-12">
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <div class="pull-left" style="color:#333; font-weight:bold">
                                                Patient Information
                                              </div>
                                            </div>
                                            <div class="panel-body">
                                              <div class="padd">

                                                  <div class="form">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:2px">
                                                            <div class="form-group">
                                                             <div class="row">
                                                             <input type="hidden" name="invoiceType_<?php echo $mainIndex; ?>" id="invoiceType_<?php echo $mainIndex; ?>" value="<?php echo $invoiceType; ?>">
                                                             <div class="row-div">
                                                             <p> <span>Name of Patient: </span> <?php echo $key1;?></p>
                                                             
                                                            
                                                             
                                                                
                                                                <p>
                                                                 <span>Sex : </span> 
                                                                 <label>
                                                                    <input type="radio" name="sex_<?php echo $mainIndex; ?>" id="male" value="Male" <?php if($sex== 'Male'){echo "checked";} ?> onclick="function_sex('<?php echo $mainIndex;?>', 'Male')">
                                                                    Male  
                                                                
                                                                
                                                                    <input type="radio" name="sex_<?php echo $mainIndex; ?>" id="female" value="Female" <?php if($sex=='Female'){echo "checked";} ?> onclick="function_sex('<?php echo $mainIndex;?>', 'Female')">
                                                                    Female 
                                                                
                                                                
                                                                    <input type="radio"  name="sex_<?php echo $mainIndex; ?>" id="others" value="Others" <?php if($sex=='Others'){echo "checked";} ?> onclick="function_sex('<?php echo $mainIndex;?>', 'Others')">
                                                                    Others
                                                                
                                                                   </label>
                                                                   </p>
                                                                  <p>
                                                                    <span style="">Age :</span> 
                                                                    
                                                                    <input type="text"  class="input-control" style="width: 50%; text-align: center; padding: 4px 0px; height:30px !important;;" placeholder="Age" id="age_<?php echo $mainIndex; ?>" name="age_<?php echo $mainIndex; ?>" autoComplete="off" onchange="function_age('<?php echo $mainIndex;?>', this.value)" value="<?php echo $age; ?>" onfocus="this.select()">
                                                                    
                                                                     
                                                                    <select name="ageType_<?php echo $mainIndex; ?>" id="ageType_<?php echo $mainIndex; ?>" class="input-control" style="padding: 4px 0px;margin: 0; width: 48%;" onchange="function_ageType('<?php echo $mainIndex;?>', this.value)">
                                                                        <option value="Years" <?php if($ageType=='Years'){ echo 'selected="selected"';} ?>>Years</option>
                                                                        <option value="Months" <?php if($ageType=='Months'){ echo 'selected="selected"';} ?>>Months</option>
                                                                        <option value="Days" <?php if($ageType=='Days'){ echo 'selected="selected"';} ?>>Days</option>
                                                                    </select>
                                                                    
                                                                </p>
                                                                <p><span>Contact No:</span> <?php echo $key2;?></p>
                                                              </div>
                                                              
                                                          </div>
                                                               
                                                       
                                                    </div>
                                                  </div>

                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-lg-12  " style="margin:0;padding:0;">
                                    <div class="col-lg-8">
                                        


                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <div class="pull-left" style="color:#333; font-weight:bold">
                                                Test Information
                                              </div>
                                            </div>
                                            <div class="panel-body">
                                              <div class="padd">
                                                  <div class="form">
                                                    <table border="0" width="100%" style="color:#333">
                                                    <tr>
                                                        <td width="6%" align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">&times;</td>
                                                        <td width="8%" align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Sl No.</td>
                                                        <td align="center" width="55%" style="font-weight:bold; padding:2px; border-bottom:4px double">Test Name</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Amount</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double">Dis(%)</td>
                                                        <td align="center" style="font-weight:bold; padding:2px; border-bottom:4px double;">Total</td>
                                                    </tr>
                                                    <?php 

                                                        if(is_array($value2)){
                                                            $sl = 1;
                                                            $totalAmount = 0;
                                                            $totalDisPersent = 0;
                                                            $totalDiscount = 0;
                                                            $totalRefdFee = 0;
                                                            foreach ($value2 as $key3 => $value3) {
                                                                $getTestDetails = $mysqli->query("select * from tests where testId = $value3[0]");
                                                                $testArray = $getTestDetails->fetch_array();
                                                                $index = $key1.'/'.$key2.'/'.$key3;
                                                            ?>
                                                            <tr>
                                                                <td width="6%" align="center" style="padding:2px; border-bottom:1px solid"><a onclick="return removeOne('<?php echo $index; ?>')" href="#" class="removebtn">&times;</a></td>
                                                                <td width="6%" align="center" style="padding:2px; border-bottom:1px solid"><?php echo $sl; ?></td>
                                                                <td align="center" width="55%" style="padding:2px; border-bottom:1px solid"><?php echo $testArray['testName']; ?></td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid"><?php echo sprintf('%.2f',$testArray['rate']); ?></td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid">
                                                                    <input type="text" style="width: 50px; text-align: center; padding: 3px" onfocus="this.select();" name="" id="<?php echo $key1.'/'.$key2.'/'.$key3; ?>" class="input-control discountPerTest" value="<?php echo $value3[1]; ?>">%
                                                                    </td>
                                                                <td align="center" style="padding:2px; border-bottom:1px solid">
                                                                    <?php
                                                                        $calDisPersent = ($value3[1] * $testArray['rate'])/100;
                                                                        $total = $testArray['rate'] - $calDisPersent;
                                                                        echo sprintf('%.2f',$total);
                                                                    ?>
                                                                    </td>
                                                            </tr>
                                                            <?php
                                                            $totalAmount += $testArray['rate'];
                                                            $totalDisPersent += $value3[1];
                                                            $totalDiscount += $calDisPersent;
                                                            $totalRefdFee += $testArray['refdFeeAmount'];
                                                            $sl++;
                                                            }
                                                            
                                                        }
                                                        if($totalDisPersent > 0){
                                                            $valueAfterDiscount = $totalDiscount/$totalAmount;
                                                            $persent = $valueAfterDiscount * 100;
                                                            $discountValue = ($persent * $totalAmount)/100;
                                                            $netTotal = ceil($totalAmount - $discountValue);
                                                        }else{

                                                            //$persent = $discountPerCookie;
                                                            $persent = (100 * $discountValCookie) / $totalAmount;
                                                            $discountValue = $discountValCookie;
                                                            $netTotal = ceil($totalAmount - $discountValue);
                                                        }

                                                        $payment = $payCookie;
                                                        $paymentDue = $netTotal - $payment;

                                                    ?>
                                                    </table>
                                                  </div>
                                                </div><br>
                                                
                                            </div>
                                        </div>
                                        <div class="panel panel-default">
                                            <div class="panel-body">
                                               
                                               <div align="center">
                                                    
                                                    <button class="btn btn-primary" onclick="return confirmInvoice('<?php echo $mainIndex; ?>')">Print and Save</button>
                                                    <button class="btn btn-primary" onclick="return confirm('<?php echo $mainIndex; ?>')">Add Patient</button>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <!-- End Tab left inner -->
                                    
                                    <!-- Start Tab right inner -->
                                    <div class="col-lg-4">
                                        <!-- Right Top -->
                                        
                                        <!-- Right Bottom -->
                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                              <div class="pull-left" style="color:#333; font-weight:bold">
                                                Payment Information
                                              </div>
                                            </div>
                                            <div class="panel-body">
                                              <div class="padd">

                                                  <div class="form">
                                                    <div class="row">
                                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:2px">
                                                            <div class="form-group">
                                                                <input type="hidden" class="input-control" name="totalRefdFee_<?php echo $mainIndex; ?>" id="totalRefdFee_<?php echo $mainIndex; ?>" value="<?php echo sprintf('%.2f',$totalRefdFee); ?>">
                                                                <input type="hidden" class="input-control" name="totalDisP_<?php echo $mainIndex; ?>" id="totalDisP_<?php echo $mainIndex; ?>" value="<?php echo $totalDisPersent; ?>">
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width: 50%; text-align: left">Total Amount</span>
                                                                    <input type="text" class="input-control" name="totalAmount_<?php echo $mainIndex; ?>" id="totalAmount_<?php echo $mainIndex; ?>" value="<?php echo sprintf('%.2f',$totalAmount); ?>"  autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Discount (%)</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="discountPer('<?php echo $mainIndex; ?>');" value="<?php echo sprintf('%.2f',$persent); ?>" name="discountP_<?php echo $mainIndex; ?>" id="discountP_<?php echo $mainIndex; ?>" autoComplete="off"><span class="input-group-addon" style="width: 13%">%</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Discount Amount</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="discountVal('<?php echo $mainIndex; ?>');" value="<?php echo sprintf('%.2f',$discountValue); ?>" name="discountAmount_<?php echo $mainIndex; ?>" id="discountAmount_<?php echo $mainIndex; ?>" autoComplete="off"><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Net Total</span>
                                                                    <input type="text" class="input-control" value="<?php echo sprintf('%.2f', $netTotal); ?>" name="netTotal_<?php echo $mainIndex; ?>" id="netTotal_<?php echo $mainIndex; ?>" autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Payment</span>
                                                                    <input type="text" class="input-control" onfocus="this.select()" onkeyup="payment('<?php echo $mainIndex; ?>');" value="<?php echo sprintf('%.2f', $payment) ?>" name="payment_<?php echo $mainIndex; ?>" id="payment_<?php echo $mainIndex; ?>" autoComplete="off"><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                <div class="input-group" style="padding-bottom: 7px">
                                                                    <span class="input-group-addon" style="width:50%; text-align: left">Due</span>
                                                                    <input type="text" class="input-control" style="color:red;" value="<?php echo sprintf('%.2f', $paymentDue); ?>" name="due_<?php echo $mainIndex; ?>" id="due_<?php echo $mainIndex; ?>" autoComplete="off" disabled><span class="input-group-addon" style="width: 13%">Tk</span>
                                                                </div>
                                                                
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
</div>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Tab right inner -->
                                </div>
                            <?php
                                $active = '';
                                $activeId++;
                            }
                        }
                    }
                    ?>
             
                </div>
                <!-- End Tab Content -->
                <?php
                }
                ?>
            </div>

          </div>             
            </div>
            
            </form>
        </div>
        <!--/div-->
        <!--/div-->
        </div>
        
        
             

        </section>
<?php
require_once('include/footer.php'); 
}else{
    header("Location:index.php");   
}
?>