<?php
ob_start();
session_start();
if(isset($_SESSION['userId'])){
require_once('include/header.php');
require_once('connect.php');
?>
<script src="js/bootstrap.js"></script>
<script>
$(function(){
	
	var tabID = 0;
    $('#btn-add-tab').click(function () {
    	var count = $('#tab-list li').length;
    	//alert(count);
    	if(count == 0){
    		tabID = 1;
    	}else{
    		tabID++;
    	}
        
        var tabName = $('#tabName').val();
        $('#tab-list').append($('<li id="'+tabID+'" class="li'+tabID+'"><a href="#tab' + tabID + '" role="tab" data-toggle="tab">' + tabName + '&nbsp;<button class="close" type="button" title="Remove this page" aria-label="Close"><span aria-hidden="true">&times;</span></button></a></li>'));
        $('.tab-content').append($('<div class="tab-pane fade" id="tab' + tabID + '"><div class="row"><div class="col-md-5" style="text-align:center; font-size:12pt; font-weight:bold">Medicine Name</div><div class="col-md-7" style="text-align:left; font-size:12pt; font-weight:bold">&nbsp;&nbsp;&nbsp;&nbsp;Unit Price&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Unit&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Amount&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dis(%)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total</div></div><div id="inTab'+tabID+'"><div class="row box" id="medicineDetails_'+tabID+'_1"><div class="col-md-5"><input type="hidden" class="check_'+tabID+'" value="'+tabID+'_1"><input type="text" class="input-control i'+tabID+'" onfocus="this.select();" placeholder="Search Medicine" id="searchMedicine_'+tabID+'_1" name="searchMedicine_'+tabID+'[]" onkeydown="searchMedicine('+tabID+', 1)" autoComplete="off"></div><div class="col-md-7" style="width:50.333%"><input type="text" class="input-control" placeholder="Unit Price" disabled onfocus="this.select();" id="unitPrice_'+tabID+'_1" name="unitPrice_'+tabID+'" style="text-align:center; width:100px" onkeydown="unitPrice_('+tabID+', 1)" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Unit" onfocus="this.select();" id="unit_'+tabID+'_1" name="unit_'+tabID+'" style="text-align:center; width:100px" onkeyup="unit_('+tabID+', 1)" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control amount_'+tabID+'" placeholder="Amount" disabled onfocus="this.select();" id="amount_'+tabID+'_1" name="amount_'+tabID+'" style="text-align:center; width:100px" onkeydown="amount_('+tabID+', 1)" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Dis(%)" onfocus="this.select();" id="dis_'+tabID+'_1" name="dis_'+tabID+'" style="text-align:center; width:100px" onkeyup="dis_('+tabID+', 1)" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Total" disabled id="total_'+tabID+'_1" name="total_'+tabID+'" style="text-align:center; width:100px" onkeydown="total_('+tabID+', 1)" autoComplete="off">&nbsp;<button class="close c" id="medicineDetails_'+tabID+'_1" type="button" title="Remove this List" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div></div><div class="row"><div class="col-md-4 col-md-push-8"><div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Total Cost</span><input type="text" class="input-control" value="0.00" onfocus="this.select()" disabled id="totalCost_'+tabID+'" autoComplete="off"><span class="input-group-addon" style="width:50px;">Tk</span></div><div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Discount(%)</span><input type="text" class="input-control" value="0.00" onfocus="this.select()" id="discount_'+tabID+'" autoComplete="off"><span class="input-group-addon" style="width:50px;">%</span></div><div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Discount Amount</span><input type="text" class="input-control" id="discountAmount_'+tabID+'" value="0.00" onfocus="this.select()" autoComplete="off"><span class="input-group-addon" style="width:50px;">Tk</span></div><div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Net Total</span><input type="text" value="0.00" onfocus="this.select()" class="input-control" disabled id="netTotal_'+tabID+'" autoComplete="off"><span class="input-group-addon" style="width:50px;">Tk</span></div><div class="input-group" id="payment_'+tabID+'" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Payment</span><input type="text" class="input-control" value="0.00" onfocus="this.select()" autoComplete="off"><span class="input-group-addon" style="width:50px;">Tk</span></div><div class="input-group" style="margin-bottom:3px;"><span class="input-group-addon" style="width:150px; text-align:left">Due</span><input type="text" value="0.00" disabled id="due_'+tabID+'" class="input-control" autoComplete="off"><span class="input-group-addon" style="width:50px;">Tk</span></div></div></div></div></div>'));
        var nextTab = parseInt(tabID) + parseInt(1);
        $('#tabName').val('Invoice '+ nextTab);
        var tabLast = $('#tab-list a:last');
        tabLast.tab('show');
    });

    $('#tab-list').on('click','.close',function(){
        var tabID = $(this).parents('a').attr('href');
        var liID = $(this).parents('li').attr('id');


        var conf = confirm('Do you want to remove this?');
        if(conf){
          $(this).parents('li').remove();
          //$('.li'+liID).remove();
          $(tabID).remove();

          //display last tab
          var tabFirst = $('#tab-list a:first');
          tabFirst.tab('show');

          var count = $('#tab-list li').length;
          //alert(count);
          if(count == 0){
            $('#tabName').val('Invoice 1');
          }
        }
          
      

    });

    $('.tab-content').on('click', '.close', function(){

      var divId = this.id;
      var divIdArray = divId.split('_');

      var checkEmpty = $('#searchMedicine_'+divIdArray[1]+'_'+divIdArray[2]).val();
      
      if(checkEmpty.length > 0){
        
        var sum=0;
        $(".amount_"+divIdArray[1]).each(function(){
            if($(this).val() != "")
              sum += parseInt($(this).val());   
        });
        
        var conf = confirm('Do you want to remove this?');
        if(conf){
          $('#'+divId).remove();

            /////////// Start Total Calculation ///////////

            var fullId = '';
            var dividor = '';
            $(".check_"+tabID).each(function(){
                if($(this).val() != "")
                  fullId += dividor+ $(this).val();
                dividor = '/';
            });
            
            fullId = fullId.split('/');

            var totalCost=0;
            $(".amount_"+tabID).each(function(){
                if($(this).val() != "")
                  totalCost += parseInt($(this).val());   
            });

            //var countAmount = $('.amount_'+tabID).filter('[value!=""]').length;

            var totalAmount = 0;
            var totalDiscount = 0;
            for(var i=0; i < fullId.length-1; i++){

                var a = $('#amount_'+fullId[i]).val();
                var d = $('#dis_'+fullId[i]).val();
                
                var calDisP = (parseInt(d) * parseInt(a))/100;

                totalAmount += parseInt(a);
                totalDiscount += parseFloat(calDisP);

            }

            var valueAfterDiscount = parseFloat(totalDiscount)/parseFloat(totalAmount);
            var persent = parseFloat(valueAfterDiscount) * parseFloat(100);

            var discountValue = (parseFloat(persent) * parseFloat(totalAmount))/parseFloat(100);

            var netTotal = parseFloat(totalAmount) - parseFloat(discountValue);

            $('#discount_'+tabID).val(persent.toFixed(2));
            $('#discountAmount_'+tabID).val(discountValue.toFixed(2));
            $('#netTotal_'+tabID).val(netTotal.toFixed(2));
            $('#due_'+tabID).val(netTotal.toFixed(2));

            $('#totalCost_'+tabID).val(totalCost.toFixed(2));

            /////////// End Total Calculation ///////////
        }
        
      }else{
        alert('Cannot remove the row');
      }
      

    })

	
});
  
function searchMedicine(tabID, Id){
	//alert(tabID);
  
  var Id2 = Id;
	var medicineName = $('input[id="searchMedicine_'+tabID+'_'+Id+'"]');
	$(medicineName).typeahead({
		source:function(query, process){
			$.getJSON('get_medicine.php?query='+query, function(data){
				process(data);
			});
		},
    updater: function(item){
      var medicineKey;
      medicineKey = item.replace('&', '%26');

      $.getJSON('process_medicine.php?medicineKey='+medicineKey, function(data){
          $('#unitPrice_'+tabID+'_'+Id2).val(data.unitPrice);
          $('#unit_'+tabID+'_'+Id2).val(data.unit);
          $('#amount_'+tabID+'_'+Id2).val(data.amount);
          $('#dis_'+tabID+'_'+Id2).val(data.discount);
          $('#total_'+tabID+'_'+Id2).val(data.total);

          /////////// Start Total Calculation ///////////

          var fullId = '';
          var dividor = '';
          $(".check_"+tabID).each(function(){
              if($(this).val() != "")
                fullId += dividor+ $(this).val();
              dividor = '/';
          });
          
          fullId = fullId.split('/');


          var totalCost=0;
          $(".amount_"+tabID).each(function(){
              if($(this).val() != "")
                totalCost += parseInt($(this).val());   
          });

          //var countAmount = $('.amount_'+tabID).filter('[value!=""]').length;

          var totalAmount = 0;
          var totalDiscount = 0;
          for(var i=0; i < fullId.length-1; i++){

              var a = $('#amount_'+fullId[i]).val();
              var d = $('#dis_'+fullId[i]).val();

              var calDisP = (parseInt(d) * parseInt(a))/100;

              totalAmount += parseInt(a);
              totalDiscount += parseFloat(calDisP);

          }

          var valueAfterDiscount = parseFloat(totalDiscount)/parseFloat(totalAmount);
          var persent = parseFloat(valueAfterDiscount) * parseFloat(100);

          var discountValue = (parseFloat(persent) * parseFloat(totalAmount))/parseFloat(100);

          var netTotal = parseFloat(totalAmount) - parseFloat(discountValue);

          $('#discount_'+tabID).val(persent.toFixed(2));
          $('#discountAmount_'+tabID).val(discountValue.toFixed(2));
          $('#netTotal_'+tabID).val(netTotal.toFixed(2));
          $('#due_'+tabID).val(netTotal.toFixed(2));

          $('#totalCost_'+tabID).val(totalCost.toFixed(2));

          /////////// End Total Calculation ///////////
      });

      return item;

    }

	});

  

  var count = $('.i'+tabID).filter('[value=""]').length;
  if(count == 0){
    Id++;
    $('#inTab'+tabID).append($('<div class="row box" id="medicineDetails_'+tabID+'_'+Id+'"><div class="col-md-5"><input type="hidden" class="check_'+tabID+'" value="'+tabID+'_'+Id+'"><input type="text" class="input-control i'+tabID+'" placeholder="Search Medicine" onfocus="this.select();" id="searchMedicine_'+tabID+'_'+Id+'" name="searchMedicine_'+tabID+'[]" onkeydown="searchMedicine('+tabID+', '+Id+')" autoComplete="off"></div><div class="col-md-7" style="width:50.333%"><input type="text" class="input-control" placeholder="Unit Price" disabled onfocus="this.select();" id="unitPrice_'+tabID+'_'+Id+'" name="unitPrice_'+tabID+'" style="text-align:center; width:100px" onkeydown="unitPrice_('+tabID+', '+Id+')" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Unit" onfocus="this.select();" id="unit_'+tabID+'_'+Id+'" name="unit_'+tabID+'" style="text-align:center; width:100px" onkeyup="unit_('+tabID+', '+Id+')" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control amount_'+tabID+'" placeholder="Amount" disabled onfocus="this.select();" id="amount_'+tabID+'_'+Id+'" name="amount_'+tabID+'" style="text-align:center; width:100px" onkeydown="amount_('+tabID+', '+Id+')" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Dis(%)" onfocus="this.select();" id="dis_'+tabID+'_'+Id+'" name="dis_'+tabID+'" style="text-align:center; width:100px" onkeyup="dis_('+tabID+', '+Id+')" autoComplete="off">&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-control" placeholder="Total" disabled id="total_'+tabID+'_'+Id+'" name="total_'+tabID+'" style="text-align:center; width:100px" onkeydown="total_('+tabID+', '+Id+')" autoComplete="off">&nbsp;<button class="close c" id="medicineDetails_'+tabID+'_'+Id+'" type="button" title="Remove this List" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>'));
  }
}

function unit_(tabID, Id){

    var unitPrice = $('#unitPrice_'+tabID+'_'+Id).val();
    var unit = $('#unit_'+tabID+'_'+Id).val();

    if(unit.length > 0){
      unit = unit;
    }else{
      unit = 0;
    }
    var calAmount = parseInt(unitPrice) * parseInt(unit);
    var dis = $('#dis_'+tabID+'_'+Id).val();
    var calDisAmount = (parseInt(calAmount) * parseInt(dis))/100;
    var calTotal = parseFloat(calAmount) - parseFloat(calDisAmount);

    $('#amount_'+tabID+'_'+Id).val(calAmount);
    $('#total_'+tabID+'_'+Id).val(calTotal);


    /////////// Start Total Calculation ///////////

    var fullId = '';
    var dividor = '';
    $(".check_"+tabID).each(function(){
        if($(this).val() != "")
          fullId += dividor+ $(this).val();
        dividor = '/';
    });
    
    fullId = fullId.split('/');

    var totalCost=0;
    $(".amount_"+tabID).each(function(){
        if($(this).val() != "")
          totalCost += parseInt($(this).val());   
    });

    //var countAmount = $('.amount_'+tabID).filter('[value!=""]').length;

    var totalAmount = 0;
    var totalDiscount = 0;
    for(var i=0; i < fullId.length-1; i++){

        var a = $('#amount_'+fullId[i]).val();
        var d = $('#dis_'+fullId[i]).val();
        
        var calDisP = (parseInt(d) * parseInt(a))/100;

        totalAmount += parseInt(a);
        totalDiscount += parseFloat(calDisP);

    }

    var valueAfterDiscount = parseFloat(totalDiscount)/parseFloat(totalAmount);
    var persent = parseFloat(valueAfterDiscount) * parseFloat(100);

    var discountValue = (parseFloat(persent) * parseFloat(totalAmount))/parseFloat(100);

    var netTotal = parseFloat(totalAmount) - parseFloat(discountValue);
    
    $('#discount_'+tabID).val(persent.toFixed(2));
    $('#discountAmount_'+tabID).val(discountValue.toFixed(2));
    $('#netTotal_'+tabID).val(netTotal.toFixed(2));
    $('#due_'+tabID).val(netTotal.toFixed(2));

    $('#totalCost_'+tabID).val(totalCost.toFixed(2));

    /////////// End Total Calculation ///////////
}

function dis_(tabID, Id){

    var dis = $('#dis_'+tabID+'_'+Id).val();

    if(dis.length > 0){
      dis = dis;
    }else{
      dis = 0;
    }
    var amount = $('#amount_'+tabID+'_'+Id).val();

    var calDisAmount = (parseInt(amount) * parseInt(dis))/100;
    var calTotal = parseFloat(amount) - parseFloat(calDisAmount);

    $('#total_'+tabID+'_'+Id).val(calTotal);

    /////////// Start Total Calculation ///////////

    var fullId = '';
    var dividor = '';
    $(".check_"+tabID).each(function(){
        if($(this).val() != "")
          fullId += dividor+ $(this).val();
        dividor = '/';
    });
    
    fullId = fullId.split('/');

    var totalCost=0;
    $(".amount_"+tabID).each(function(){
        if($(this).val() != "")
          totalCost += parseInt($(this).val());   
    });

    //var countAmount = $('.amount_'+tabID).filter('[value!=""]').length;

    var totalAmount = 0;
    var totalDiscount = 0;
    for(var i=0; i < fullId.length-1; i++){

        var a = $('#amount_'+fullId[i]).val();
        var d = $('#dis_'+fullId[i]).val();
        
        var calDisP = (parseInt(d) * parseInt(a))/100;

        totalAmount += parseInt(a);
        totalDiscount += parseFloat(calDisP);

    }

    var valueAfterDiscount = parseFloat(totalDiscount)/parseFloat(totalAmount);
    var persent = parseFloat(valueAfterDiscount) * parseFloat(100);

    var discountValue = (parseFloat(persent) * parseFloat(totalAmount))/parseFloat(100);

    var netTotal = parseFloat(totalAmount) - parseFloat(discountValue);
    
    $('#discount_'+tabID).val(persent.toFixed(2));
    $('#discountAmount_'+tabID).val(discountValue.toFixed(2));
    $('#netTotal_'+tabID).val(netTotal.toFixed(2));
    $('#due_'+tabID).val(netTotal.toFixed(2));

    $('#totalCost_'+tabID).val(totalCost.toFixed(2));

    /////////// End Total Calculation ///////////
}
//function searchMedicine(tabID){
  //var checkbox = $('input[name="searchMedicine_'+tabID+'[]"').length;
  //alert(checkbox);
//}
</script>
<style>
#data-loading{
	font-size:14px;
	color:#000;
	position:absolute;
	left:320px;
	z-index:1000;
}
.box{
  margin-bottom: 5px;
}
.c{
  margin-top: 5px;
}
</style>
      <section id="main-content">
          <section class="wrapper">
          <div class="row">
            <?php print "MySQL server version: " . mysql_get_server_info(); ?>
          	<div class="displayDetails">
          		<div class="col-lg-4">
          			<div class="input-group">
          				<input type="" class="input-control" name="" id="tabName" onclick="this.select();" value="Invoice 1"><span class="input-group-addon"><a href="#" id="btn-add-tab"><i class="fa fa-plus"></i> Add</a></span>
          			</div>          			
          		</div>
          		<div class="col-lg-12">
		            <!-- Nav tabs -->
		            <ul id="tab-list" class="nav nav-tabs" role="tablist">
		                
		            </ul>

		            <!-- Tab panes -->
		            <div class="tab-content">
		                
		            </div>
          		</div>
          	</div>
          </div>             

          </section>
<?php
require_once('include/footer.php');
}else{
	header("Location:index.php");	
}
?>