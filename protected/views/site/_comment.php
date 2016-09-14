					<li>

						<?  
						$item = Item::model()->findByPk($data->pk); ?>
 	 

<div class="reviews_img">
							<div class="g_pop2" style="display: block;">								
								<a href="<? echo $item->createurl; ?>" class="g_to_view2"><img src="/img/g_to_view.png"></a>
							</div>
							<img src="/uploads/medium_<? echo $item->images[0]->filename; ?>">
						</div>

            <p class='reviews_title'><img src='/img/icon5.png'> <?=$data->name;?>   <span>( <?=date('d.m.Y',$data->created)?>)</span></p>
            <div class='reting'>
<?
  $this->widget('CStarRating',array( 
  'id' => 'ra'.$data->id,
  'name' => 'rnamea'.$data->id,
'model' => $data,
'attribute' => 'stars',
'minRating' => 1,
'maxRating' => 5,
'readOnly' => true,
    ));
?>

<span style='vertical-align: -2px;margin-left:4px; font-size: 10px;'> РЕЙТИНГ ОТЗЫВА</span>
            </div>

            <div class='reting_text'>
<?=$data->comment;?>
            </div>

          </li>



					</li>