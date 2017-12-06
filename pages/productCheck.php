<div class="row sticky-top navbar-light bg-faded">
    <div class="col-xs-2">
            <?php include('../menus/back.php');?>
    </div>
  
    <div class="col-xs-10">
        <div class="input-group">
            <input type="text" name="searchTxt" id="searchTxt" class="input-text input-lg" placeholder="Scan barcode"/>
                <div class="input-group-btn">
                    <button type="button" name="searchBtn" id = "searchBtn" class = "btn btn-primary" onclick = "eanSearch();">
						<i class="fa fa-search" aria-hidden="true"></i>
					</button>
                </div>
        </div>
    </div>
  
</div>
<div id="result">ii</div>

<script>
		$( document ).ready(function() {
			console.log( "document loaded" );
			$('#searchTxt').focus();
			$('#searchTxt').keypress(function (e) {
			  if (e.which == 13) {
                eanSearch();
				return false;    //<---- Add this line
			  }
			});
			
		});
	</script> 