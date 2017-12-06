 <?php
include('../connection.php');

echo $shopName;
?>
 <div class="row sticky-top navbar-light bg-faded" id = 'mainDivToHide'>
	 <div class='col-xs-12 col-12'>  
		<div class="row">
				 <div class="col-xs-2 col-s-2">
						  <?php include('../menus/back.php');?>
				 </div>
			
			<div class="col-xs-12 col-s-12">
				<?PHP
					include('../classes/classAisles.php');
					$option = new aislesOptions();
					echo $option->getAisles($shopName,'aislesNo');
				?>
			</div>
				  
			
		</div>
 </div>
 </div>
	 
<div id="result"></div>

<script>
$( "#aislesNo" )
  .change(function () {
    var aisleNo = $("#aislesNo option:selected").text();
    $.post( "sqlActions/sqlProductsInAisles.php", { aisle: aisleNo })
		.done(function( data ) {
			$('#result').html(data);
		});
  })
  .change();
  
  function expand(id){
	var idToInsert = "#"+id;
	var min = 0;
	var max = 0;
	
	if ($("#"+id ).hasClass( "addedExtraRow" ) === true){
		$( ".addedExtraRow" ).remove();
	}else{
		$.post( "sqlActions/sqlMinMax.php", { name: id })
			.done(function( data ) {
				
				var result = JSON.parse(data);
				
				//min = data;
				min = result[0];
				max = result[1];
			//console.log("MIN: "+min);
			
			//var minQty = "<DIV class ='col-xs-2 col-s-2 col-1'></DIV>";
			var maxQty = "<DIV class ='col-xs-8 col-s-8 col-8'><input type ='text' id = 'min_"+id+"' value = '"+min+"' size ='3' onclick = 'focusMinMax(this.id);'/><input type ='text' id = 'max_"+id+"' value = '"+max+"' size ='3'/></DIV>";
			var saveBtn = "<DIV class = 'col-xs-2 col-s-2 col-2'><button type = 'button' class = 'btn btn-primary'><i class='fa fa-floppy-o' aria-hidden='true'></i></button></DIV>";
			var closeBtn = "<DIV class = 'col-xs-2 col-s-2 col-2'><button type = 'button' class = 'btn btn-primary'><i class='fa fa-times' aria-hidden='true'></i></button></DIV>";
			
			var divToInsert = "<DIV class = 'row addedExtraRow newDiv'>"+/*minQty+*/maxQty+saveBtn+closeBtn+"</DIV>";
			$( ".addedExtraRow" ).remove();
			$("div[id^='"+id+"']:last").after(divToInsert);
			console.log("ID: "+idToInsert);
		
		});
	}
  }
  
  function focusMinMax(id){
    
		console.log(id);
	   
	}
  
</script>
 

