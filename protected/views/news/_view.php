 
<li>				

<a href="<?=$data->createurl;?>" class="news_link">  <?=$data->title;?> </a>
<div class="news_date"><?php echo Yii::app()->dateFormatter->formatDateTime($data->date, 'long', false); ?></div>
<div class="news_text">
  <?=$data->short;?>
 </div>

</li>