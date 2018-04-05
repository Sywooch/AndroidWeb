<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'About Us';
$this->params['breadcrumbs'][] = $this->title;

$path = Yii::$app->request->baseUrl;

?>
<style>
    .selected{
        color:#3f2c7b !important;
        font-weight: bolder;
    }
</style>
<div class="columns-container">
    <div class="container" id="columns">
       
        <!-- row -->
        <div class="col-md-3 col-xs-3 col-sm-3">
            <!-- Left colunm -->
          <div class="block-sidebar block-sidebar-categorie">
                <div class="block-title">
                    <strong>Information</strong>
                </div>
                <div class="block-content">
                    <ul class="items" id="service">
                    <?php foreach($data as $x):?>
                      <li><span></span><a href="<?= Url::toRoute(['pages/'.$x['slug']])?>" <?= ($x['slug']==$current_slug)?'class="selected"':'' ?> ><?= $x['name']?></a></li>
                    <?php endforeach;?>
                    </ul>
                </div>
            </div><!-- Block  bestseller products-->
                <!-- ./block category  -->
        </div>
            <!-- ./left colunm -->
            <!-- Center colunm-->
            <div class="center_column col-md-9 col-xs-9 col-sm-9" id="center_column">
                <!-- page heading-->
                <h2 class="page-heading">
                    <span class="page-heading-title2"><b><?= $page_details->title;?></b></span>
                </h2>
                <!-- Content page -->
                <div class="content-text clearfix">
                    <?= html_entity_decode($page_details->details);?>
                </div>
                <!-- ./Content page -->
            </div>
            <!-- ./ Center colunm -->
        </div>
        <!-- ./row-->
    </div>
</div>