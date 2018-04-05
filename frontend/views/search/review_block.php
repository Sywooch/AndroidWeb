<?php
use kartik\rating\StarRating;
?>
<?php foreach ($review_details as $review): ?>
<div class="review-block">
							<div class="row">
								<div class="col-sm-3">
									<img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
									<div class="review-block-name"><a href="#"><?= $full_name[$review['u_id']]?></a></div>
									<div class="review-block-date"><?= Yii::$app->formatter->asDatetime($review['created_at'], 'd LLL yyyy')?></div>
								</div>
								<div class="col-sm-9">
									<div class="review-block-rate">
										<?=
										StarRating::widget([
										    'name' => 'rating_1',
										    'value'=>$review['rating'],
										    'pluginOptions' => ['displayOnly' => true,'size'=>'xs']
										])
										?>
									</div>
									<div class="review-block-title"><?= $review['review']?></div>
								</div>
							</div>
						</div>
<?php endforeach ?>