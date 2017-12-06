      function eanSearch() {
        var searchField = $( "#searchTxt" ).val();
        $.post( "sqlActions/productDetailsSQL.php", { searchField: searchField })
            .done(function( data ) {
              	$('#searchTxt').val("");
				$('#searchTxt').focus();
                $( "#result" ).html(data);
            });
      }
      
        function eanSearchBags() {
        var searchField = $( "#searchTxt" ).val();
        $.post( "sqlActions/preBaggedDetails.php", { searchField: searchField })
            .done(function( data ) {
              	$('#searchTxt').val("");
				$('#searchTxt').focus();
                $( "#result" ).html(data);
                $("#selectBigBagsPlace").load("data/bigBagsWeight.php");
                $("#selectSmallBagsPlace").load("data/smallBagsWeight.php");
                
            });
      }
      
      function calculateBagQty() {
        var smallBagsWeight = Number($( "#smallBagsWeight" ).val());
        var bigBagsWeight = Number($( "#bigBagsWeight" ).val());
        var fullBagsQty = Number($( "#fullBagsQty" ).val());
        var smallBagsQty = Number($( "#smallBagsQty" ).val());
        var selectSmallBagsPlace = Number($( "#selectSmallBagsPlace" ).val());
        
          $('#calculationResultLbl').html('Total QTY:  ');
          var result = fullBagsQty+(smallBagsQty*(smallBagsWeight/bigBagsWeight));
          var amt = parseFloat(result);
          
          
            if(result % 1 === 0){
               $('#calculationResult').html(result);
            } else{
               $('#calculationResult').html(amt.toFixed(2));
            }
            if (isNaN(result) == false) {
                var updateBtn = '<button type="button" name="searchBtn" id = "searchBtn" class = "btn btn-warning" onclick = "updateSearchBags();">';
                        updateBtn += '<i class="icon-upload" aria-hidden="true"></i> Update';
                    updateBtn += '</button>';
                    $('#updateQtyBtnPlace').html(updateBtn);
            }else{
                    $('#updateQtyBtnPlace').html('');
            }
      }
      
       function updateSearchBags() {
        var todayDate = $('#todayDate').val();
        var calculationResult = $('#calculationResult').html();
        var currentQty = $('#currentQty').html();
        var ean = $('#ean').html();
        
        
        $.post( "sqlActions/sqlPreBaggedUpdate.php", { todayDate: todayDate , calculationResult: calculationResult , currentQty: currentQty, ean: ean })
          .done(function( data ) {
            console.log("dane "+data);
            $('#result').html(data);
        });
      }