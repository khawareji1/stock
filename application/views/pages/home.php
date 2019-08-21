<head> 
      <meta charset = "utf-8"> 
      
     
    <link rel="stylesheet" type="text/css"  href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css"  href="assets/css/style.css" />
   
    <link rel="stylesheet" type="text/css"  href="assets/css/animate.min.css" />
    <link rel="stylesheet" type="text/css"  href="assets/css/awesomplete.css" />
<!--    <link rel="stylesheet" type="text/css"  href="assets/css/fontawesome-all.min.css" />-->
    <link rel="icon" href="assets/images/web-req/logo2.png" type="image/gif">
   </head>

<div  class="container"> 
    <h1 style="text-align:center;">StockHUB</h1>
</div>

<div class="container"> 
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search" name="homesearch" id="homesearch" class="awesomplete" list="mylist" autofocus>

                <datalist id="mylist">
                <?php foreach($products as $product) : ?>
                    <option><?php echo($product['product_cat_name']);?></option>
                <?php endforeach; ?>
                </datalist>

                <!-- <span class="input-group-btn">
                    <button class="btn btn-default" type="button" ><i class="glyphicon glyphicon-search"></i></button>
                </span>    -->
            </div>

            <!-- <div class="list-group" id="finalResult2"></div> -->

            <!-- <h2 id="homeSearchResultH2">Table</h2>
            <h4 id="homeSearchResultH4">Raw Materials Required : </h4></br>
            <a href="#" class="well well-sm" id="homeSearchResultA">Wood</a> -->

            
            
            <!-- <h2 id="homeSearchResultH2"></h2>
            <h4 id="homeSearchResultH4"></h4></br>
            <a href="#" class="well well-sm" id="homeSearchResultA"></a> -->

        </div>
    </div>
        <div class="list-group" id="finalResult2">
        </div>
        
</div>

<div name="container titleHomeDiv" id="titleHomeDiv" style="text-align:center;" class="hidden-xg"> 
    <div > 
        Raw Material 
    </div>
    <div class="container inverseColor"> 
        <span> Search &amp; Procure</span>
    </div>
</div>


<div id="howitworks" class="howitworks bgimg-2 animated fadeIn">
     <div class="container">
					<div class="col-lg-3 col-md-4 text-center">
                        <i class="fa fa-search" style="font-size:40px;color:#19BC9C; background-color:#2c3e50; padding:15px;  width:80px; border-style:none; height:80px; border-radius:50%;  "></i>
						<h3>Search &amp; find <br>Raw materials <br>according to business needs</h3>
					</div>
					<div class="col-lg-3 col-md-4 text-center">
						<i class="far fa-file-alt" style="font-size:40px;color:#19BC9C; background-color:#2c3e50; padding:15px;  width:80px; border-style:none; height:80px; border-radius:50%;"></i>
						<h3>Create a Tender for<br>the material</h3>
					</div>
					<div class="col-lg-3 col-md-4 text-center">
						<i class="fas fa-users" style="font-size:40px;color:#19BC9C; background-color:#2c3e50; padding:15px;  width:80px; border-style:none; height:80px; border-radius:50%;  "></i>
						<h3>All the vendors<br>selling that material<br>will be notified</h3>
                    </div>
                    <div class="col-lg-3 col-md-4 text-center">
						<i class="fas fa-truck" style="font-size:40px;color:#19BC9C; background-color:#2c3e50; padding:15px;  width:80px; border-style:none; height:80px; border-radius:50%;  "></i>
						<h3>After the preffered vendor<br>is selected<br>the material will be delivered</h3>
					</div>
                </div>
        </div>  


<!-- <div id="container">
<input type="text" name="search" id="search" />
<ul id="finalResult"></ul>
</div> -->

