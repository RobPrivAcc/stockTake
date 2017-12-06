<?php
include('../connection.php');

$shopName = $shopName;
?>

 <div class="row sticky-top navbar-light bg-faded" id = 'mainDivToHide'>
	 <div class='col-xs-12 col-12'>  
		<div class="row">
				 <div class="col-xs-2 col-2">
						  <?php include('../menus/back.php');?>
				 </div>

				 <div class="col-xs-2 col-10">
					
					  <input id="scannMode" data-toggle="toggle" checked type="checkbox" data-on="Update Mode" data-off="Check Mode" data-onstyle="success" data-offstyle="warning" data-size="small">
						 <script type='text/javascript' >
							$(function() {
								$('#scannMode').bootstrapToggle();
								
								$('#scannMode').change(function() {
									if ($(this).prop("checked")){
										$('#rapidMode').bootstrapToggle('enable');
										$('#rapidMode').removeClass('disabledBtn');
									}else{
										$('#rapidMode').bootstrapToggle('off');
										$('#rapidMode').bootstrapToggle('disable');
									}
								});
							});
						</script>
					
					  <input id="rapidMode" type="checkbox" data-on="Rapid Mode ON" data-off="Rapid Mode OFF" data-onstyle="success" data-offstyle="warning" data-size="small" data-toggle="toggle">
						 <script type='text/javascript' >
							$(function() {
								$('#rapidMode').bootstrapToggle();
							});
						</script>
						 
				 </div>
		</div>
	   
		<div class="row">
			<div class="col-xs-2 col-2">
				<button type="button" class="btn btn-info" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="hideMainDiv();">
					<i class="fa fa-info-circle fa-1" aria-hidden="true"></i>
				</button>
			</div>
			
			<div class="col-xs-2 col-2">
				
				<?PHP
				include('../classes/classAisles.php');
					$option = new aislesOptions();
					echo $option->getAisles($shopName,'aislesNo');
				?>
				
			</div>
				  
			<div class="col-xs-8 col-8">
				<div class="input-group">
					<input type="text" name="eanSearch" id="eanSearch"  class="input-text"/>
					 <div class="input-group-btn">
						 <button type="button" name="searchBtn" id = "searchBtn" class = "btn btn-primary" onclick="searchProduct();">
							<i class="fa fa-search" aria-hidden="true"></i>
						 </button>
					 </div>
				</div>
			</div>
			
		</div>
 </div>
 </div>
	 
<div id="aislesInfo" style="display:none">
	
	<div class = "row">
		<div class="col">
			<button type="button" name="closeBtn" id = "closehBtn" class = "btn btn-primary" onclick="hideImageDiv();">
				<i class="fa fa-times" aria-hidden="true"></i>
			</button>
		</div>
	</div>
	
	<div class = "row">
		<div class="col" id = 'imagePlace'>
			<img id ='aislesLocationImg' class="imageFill" src=''/>
		</div>
	</div>
	
</div>	 

<div id="result"></div>

<script type='text/javascript' >
	function hideMainDiv() {
		var aisleImg = $("#aislesNo option:selected").text();
		$("#aislesLocationImg").attr("src","aislesLocation/"+aisleImg+".jpg");
        $('#mainDivToHide').hide();
		$('#aislesInfo').show();
    }

	function hideImageDiv() {
        $('#aislesInfo').hide();
		$('#mainDivToHide').show();
		$('#eanSearch').focus();
    }
	
	function searchProduct(){
		var ean = $('#eanSearch').val();
				  var aisle = $("#aislesNo option:selected").text();
                  var mode = '';
                  
                  if($("#scannMode").is(':checked'))
                        mode = 'update';
                  else
                        mode = 'check';

                  if($("#rapidMode").is(':checked')){
                        rapidMode = 'rapidOn';

				  }else{
                        rapidMode = 'rapidOFF';
				  }

				if (rapidMode == 'rapidOFF') {
					rapidModeOff(rapidMode, ean, aisle, mode);
				}else{
					rapidModeOn(rapidMode, ean, aisle, "updateConfirm");
				}
				
				$('#eanSearch').val("");
				$('#eanSearch').focus();
				$( '#searchBtn').attr( "clicked",false);
				return false;    //<---- Add this line
			  
	}
	

	function rapidModeOff(rapidMode, ean, aisle, mode){
	

			
			$.post( "sqlActions/sqlAislesUpdate.php", { ean: ean, aisle: aisle, mode: mode })
				.done(function( data ) {
					if (mode=="update") {
						/****/
								if(aisle != '---'){
						/****/
								if (data.length <= 3){
									$.confirm({
										title: 'Confirm!',
										content: 'This product is already assigned to '+data+'.<br/> Do you want to move it to <strong>'+aisle+'</strong>?',
										buttons: {
											confirm: function () {
												$.post( "sqlActions/sqlAislesUpdate.php", { ean: ean, aisle: aisle, mode: "updateConfirm" })
												.done(function( data ) {
													$('#result').html(data);
												});
											},
											cancel: function () {
											}
										}
									});
								}else{
									$('#result').html(data);
								}
								/****/
								
								}else{
			$('#result').html("<div class='alert alert-danger text-center' role='alert'>Choose proper <strong>Aisle</strong></div>");
		}
								/****/
								
					}else{
						$('#result').html(data);
					}
				});
	
		
		
	}

	function rapidModeOn(rapidMode, ean, aisle, mode){
		if(aisle != '---'){
			$.post( "sqlActions/sqlAislesUpdate.php", { ean: ean, aisle: aisle, mode })
			
				.done(function( data ) {
					
						$('#result').html(data);
				});
		}else{
			
						$('#result').html("<div class='alert alert-danger text-center' role='alert'>Choose proper <strong>Aisle</strong></div>");
		}
	}
	
	


</script>

<script type='text/javascript' >
		$( document ).ready(function() {
			
            $('#scannMode').change(function () {
                $('#eanSearch').focus();
            });
			
			$('#rapidMode').change(function () {
			   if($("#rapidMode").is(':checked'))
							$.confirm({
							title: 'Warning!',
							content: 'In this mode confirm window is OFF<br/>Use it when redoing aisles.',
								   buttons: {
									   ok: function () {
										  $('#eanSearch').focus();
									   }
								   }
							});						
                $('#eanSearch').focus();
            });
            
			$('#eanSearch').focus();
			$('#eanSearch').keypress(function (e) {
			  if (e.which == 13) {
				searchProduct();
			  }
			
			});
			
		});
</script> 
 

