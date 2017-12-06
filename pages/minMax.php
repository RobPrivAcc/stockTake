<?php
include('../connection.php');

    $pdo = new PDO($server, $user, $password);
    
    $sql = "SELECT [Supplier]
            ,[UserDefinedField1]
            FROM [Suppliers] WHERE ([Supplier] != '-' AND [Supplier] != '') ORDER BY Supplier ASC";
    
    $query = $pdo->prepare($sql);
    $query->execute();

?>
<div>
	
	<div class="row sticky-top navbar-light bg-faded">
		<div class="col-xs-2 col-s-2 col-2">
			<?php include('../menus/back.php');?>
		</div>
	  
		<div class="col-xs-10 col-s-10 col-10">
			   <Div class="form-group">
				<select id= "supplierList" class="selectpicker form-control">
					<option>--</option>
					<?php
						for($i=0; $row = $query->fetch(); $i++){
							echo "<option>".$row['Supplier']."</option>";   
						}
					
					?>
			   </select>
			   </Div>
		</div>
	  
	</div>
	
	

	
	<div id="result"></div>
</div>
<script type = "application/javascript">
$( "#supplierList" )
  .change(function () {
	var spinner = "<div class='loading'><div class='spinner'><i class='fa fa-spinner fa-spin fa-5x fa-fw'></i>Loading...</div></div>";
			$('#result').html(spinner);
    var supplierList = $("#supplierList option:selected").text();
    $.post( "sqlActions/sqlProductsPerSupplier.php", { supplierList: supplierList })
		.done(function( data ) {
			$('#result').html(data);
		});
  });
</script>


<script type = "application/javascript">
    function minMaxUpdateValues() {
//spinner();
		var supplierList = $('#minMaxArray').val();
		spinner();
		//alert(supplierList);//var supplierList = "ll";
		$.post( "sqlActions/sqlMinMaxUpdate.php", { supplierList: supplierList })
			.done(function( data ) {
				$('#result').html(data);
		});
    }
	
	function spinner(){
		var spinner = "<div class='loading'><div class='spinner'><i class='fa fa-spinner fa-spin fa-5x fa-fw'></i>Updating...</div></div>";
		$('#result').html(spinner);	
	}
</script>
