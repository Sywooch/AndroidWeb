<?php
use yii\helpers\Url;
$sub_category=$this->params['sub_category'][$cat_id['cat_id']];
$path = Yii::$app->request->baseUrl;

if($seo != null){
$seo->title();
$seo->description();
$seo->keywords();
$seo->meta_title();
}
?>

<style>
a:hover, a:focus {
  color: #fff;
  text-decoration: none;
}
.square-service-block{
	position:relative;
	overflow:hidden;
	margin:15px auto;
	}
.square-service-block a {
  background-image: url('https://thumbs.dreamstime.com/z/vector-set-icons-auto-spare-parts-tools-flat-long-shadow-sparkplug-accumulator-gear-wrench-transportation-icon-car-service-63738670.jpg');
  background-color: #000;
  border-radius: 5px;
  display: block;
  padding: 40px 20px;
  text-align: center;
  width: 100%;
  background-attachment: fixed;
}
.square-service-block a:hover{
  background-color: #000 !important;
  opacity: 0.4;
  border-radius: 5px;
}

.ssb-icon {
  color: #fff;
  display: inline-block;
  font-size: 28px;
  margin: 0 0 20px;
}

h2.ssb-title {
  color: #fff;
  font-size: 20px;
  font-weight: 200;
  margin:0;
  padding:0;
  text-transform: uppercase;
}
#xx{
	background-image: url('https://www.twinlakesautosalvage.com/');
}
@import url('https://fonts.googleapis.com/css?family=Lato:100,300,400,700,900');

h1{
    font-size:30px;
    color:#5db4c0;
    font-family: 'Lato', sans-serif; 
}

h2{
    font-size:20px;
    color:#5db4c0;
    font-family: 'Lato', sans-serif;
}

.service{
    font-family: 'Lato', sans-serif;
    background:#f6f6f6;
    padding:60px 0px;
}

.service-icons{
    margin:40px 0px;
}

.service .square-feature{
	width: 130px;
	height: 130px;
	background:#5db4c0;
	border: 2px solid #eee;
    box-shadow: 3px 3px 2px rgba(0, 0, 0, 0.2);  
	margin:0 auto;
}

.service .square-feature:hover{
	-moz-transform: rotate(360deg);
    -webkit-transform: rotate(360deg);
    -o-transform: rotate(360deg);
    -ms-transform: rotate(360deg);
    transform: rotate(360deg);
	-webkit-transition: all 2s ease-in-out;
	-moz-transition: all 2s ease-in-out;
	-ms-transition: all 2s ease-in-out;
	-o-transition: all 2s ease-in-out;
	transition: all 2s ease-in-out;
	background:#6b6b6b;
}

.service .square-feature span{
	font-size:30px;
	margin:0 auto;
	padding-top:50px;
}

.service .fa{
	color:#FFF;
}

</style>
<div class="service">
	<div class="container">
            
            <div class="row">
                <div class="col-lg-6 col-lg-offset-3 text-center">  
                    <h1>Our Services</h1>
                    <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis  dis parturient montes, nascetur ridiculus </p><br>
                </div> 
            </div>   
                
            <div class="service-icons">
                	<?php foreach ($sub_category as $x):?>
				    <a href="<?= Url::ToRoute(['shop/'.$slug.'/'.$x['slug']])?>"><div class="col-lg-3 col-md-3 col-sm-6 col-xs-12  text-center" style="margin-bottom: 20px;">
					    <div class="square-feature">
							<span class="fa fa-laptop"></span>
						</div>
						<h2><strong><?= $x['name']?></strong></h2>
						
					</div></a>
					<?php endforeach;?>				
			</div>
                   
   </div>
</div>