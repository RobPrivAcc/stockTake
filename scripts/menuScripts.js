function menuItem(itemMenu) {
    switch(itemMenu) {
        case 'productCheck':
            $('#mainContainer').load('pages/productCheck.php');
        break;
        
        case 'stockTake':
            var content = '<nav class="navbar sticky-top navbar-light bg-faded">';
            content += '<div class="row">';
            content += '<div class="col-xs-7">';
            content += '<div class="dropdown">';
            content += '<button type="button" class="btn btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
            content += '<i class="fa fa-bars" aria-hidden="true"></i>';
            content += '</button>';
              content += '<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">';
                content += '<li><a href="#">Action</a></li>';
                content += '<li><a href="#">Another action</a></li>';
                content += '<li><a href="#">Something else here</a></li>';
                content += '<li role="separator" class="divider"></li>';
                content += '<li><a href="#">Separated link</a></li>';
              content += '</ul>';
            content += '<input type="text" name="searchTxt" id="searchTxt" class="input-text input-lg"/>';
            content += '<button type="button" name="searchBtn" id = "searchBtn" class = "btn btn-primary" onclick="eanSearch();">';
            content += '<i class="fa fa-search" aria-hidden="true"></i>';
            content += '</button>';
            content += '</div>';
            content += '</div>';
            content += '</div>';
            content += '</nav>';
            content += '<div id="result"></div>';
    
            $('#mainContainer').html(content);
            break;

        case 'aislesUpdate':
            $('#mainContainer').load('pages/aislesUpdate.php');
            //$('#searchBtn').attr("onclick", "eanSearch();");
        break;
        
        case 'preBagged':
            $('#mainContainer').load('pages/preBaggedProduct.php');
            //$('#searchBtn').attr("onclick", "eanSearch();");
        break;
    
        case 'productsInAisles':
            $('#mainContainer').load('pages/productsInAisles.php');
            //$('#searchBtn').attr("onclick", "eanSearch();");
        break;
            
        case 'productsMissingAisles':
            $('#mainContainer').load('pages/productsMissingAisles.php');
        break;
                
        case 'Min_Max':
            $('#mainContainer').load('pages/minMax.php');
        break;
    }
}