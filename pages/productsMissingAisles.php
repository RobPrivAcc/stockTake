<div class="row sticky-top navbar-light bg-faded">
    <div class="col-xs-2 col-s-2 col-2">
                        <?php include('../menus/back.php');?>
    </div>
  
    <div class="col-xs-10 col-s-10 col-10">
        <div class="input-group">
            <input type="text" name="searchTxt" id="searchTxt" class="input-text input-lg" placeholder="Type order No"/>
                <div class="input-group-btn">
                    <button type="button" name="searchBtn" id = "searchBtn" class = "btn btn-primary" onclick = "searchOrder();">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </button>
                </div>
        </div>
    </div>
  
</div>

<div class='row'>
    <div class="col-xs-12 col-s-12 col-12">
        <div><br/></div>        
    </div>
</div>

<div class='row'>
    <div class="col-xs-12 col-s-12 col-12">
        <div id="warning"></div>        
    </div>
</div>

<div class='row'>
    <div class="col-xs-12 col-s-12 col-12">
        <div id="result"></div>        
    </div>
</div>


<script type = "text/javascript">
    function searchOrder() {
        var searchTxt = $('#searchTxt').val();
    
        $.post( "sqlActions/sqlMissingAisles.php", { orderNo: searchTxt })
          .done(function( data ) {
           // console.log("dane "+data);
            $('#result').html(data);
        });
    }    
</script>

<script type = "application/javascript">
    function updateAisle(id) {
        var optionAisles = "#option_"+id;
        var aisle = $(optionAisles+' option:selected').text();
        //$('#result').html(id+'<br>'+$('#result').html());
        if(aisle != '---'){ 
            $.post( "sqlActions/sqlMissingAislesUpdate.php", { id: id, aisle: aisle })
                .done(function( data ) {
                    $('#warning').html("");
                    searchOrder();
                })
                .fail(function() {
                    alert( "error" );
                });
        }else{
             $('#warning').html("<div class='alert alert-danger text-center' role='alert'>Choose proper <strong>Aisle</strong></div>");
        
        }
    }    
</script>