<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf8" />

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" type="image/png" href="images/favicon.ico" />
      <title>WEB搜索服务引擎</title>
      <!-- Bootstrap core CSS -->
      <link href='http://fonts.useso.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700&amp;subset=latin,cyrillic-ext,greek-ext,vietnamese,latin-ext' rel='stylesheet' type='text/css'>
      <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet"/>
      <link type="text/css" href="css/font-awesome.min.css" rel="stylesheet"/>
      <link type="text/css" href="css/component.css" rel="stylesheet" />
      <link type="text/css" href="css/base.css" rel="stylesheet"/>
      <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/style.css" media="screen" type="text/css" />
      <style>
.demo_search {
    display:inline-block;
    position:relative;
    height:27px;
    margin:60px;
}
 
.demo_search:hover {
    -webkit-box-shadow:0 0 3px #999;
    -moz-box-shadow:0 0 3px #999
}
 
.demo_search .demo_sinput {
    float:left;
    width:130px;
    height:19px;
    line-height:19px;
    padding:3px 5px;
    border:#A7A7A7 1px solid;
    background:white;
    color:#888;
    font-size:12px;
    -webkit-transition:.3s;
    -moz-transition:.3s;
    outline: none;
}
 
.demo_search .demo_sinput:focus {
    width:200px;
}
 
.demo_search .demo_sbtn {
    cursor:pointer;
    height:27px;
    font-size:12px;
    float:left;
    width:50px;
    margin-left:-1px;
    background:#eee;
    display:inline-block;
    padding:0 12px;
    vertical-align:middle;
    border:#A7A7A7 1px solid;
    color:#666;
}
 
.demo_search .demo_sbtn:hover {
    background:#ddd;
}</style>
      <script src="js/modernizr.custom.js"></script>
      <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>
      <div class="cover-all cover-body">
         <div class="loading-place">
            <div class="windows8">
               <img alt="loading" src="images/loading.gif"/>
            </div>
            <div>
               <p class="load-text">Please wait</p>
            </div>
         </div>
      </div>
      <!--fixed navigation-->

      <!--main container-->
      <div id="cbp-so-scroller" class="cbp-so-scroller cbp-scroller-main container-fluid">
         <section id="intro" class="cbp-so-section text-center ss-style-triangles">
            <div class="container-fluid text-center banner-main">
               <div class="ban-text-middle">
                  <div class="webdesigntuts-workshop">
                     <form method="get" action="search.php" name="search">  
                     <input name="search" type="text" placeholder="输入IP或网站名" size="15">   
                     <button>Search</button> 
                     </form>
                  </div>
            </div>
            <a class="scroll-down"><i class=" fa  fa-chevron-down"></i></a>
         </section>
         
         
         
      </div>
      <!--main container-->
      <!-- Bootstrap core JavaScript
         ================================================== -->
      <script src="js/jquery-1.10.2.min.js"></script>
      <script src="js/jquery-migrate-1.2.1.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      <script type="text/javascript" src="js/jquery.parallax-1.1.3.js"></script>
      <script src="js/cbpScroller.js"></script>
      <script src="js/classie.js"></script>
      <script src="js/jquery.scrollTo.js"></script>
      <script src="js/jquery.nav.js"></script>
     
      <script src="js/base.js"></script>
     
   </body>
</html>