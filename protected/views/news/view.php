<?$this->pageTitle = "$model->title - Новости - ".$this->pageTitle; ?>
<? 
if(!empty($model->keywords))
$this->pageKeywords = $model->keywords;

if(!empty($model->description))
$this->pageDescription = $model->description;
?>


<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Новости' => '/news',
        $model->titleText,
    ),

));
?>
<style>
ul.news li {
  list-style: none;
}
.news_link {
  font-size: 19px;
  color: #333;
  padding: 2px;
}
</style>


<div class="h1-substrate">
<h1><strong><?php echo $model->titleText; ?>     <? if(Yii::app()->session->get("admin") == 1):?>

                          
                       <a href = "/admin/news/update/id/<?=$model->id?>" target= "_blank">     
                        <img src = "/images/edit.png">
                       </a>
                       <? endif; ?></strong></h1>
                       <div class="news_date" style='margin-top:-13px'><?php echo Yii::app()->dateFormatter->formatDateTime($model->date, 'long', false); ?></div><br>
</div>
 
<? if($model->image):?>
<a class="img_news" ><img class="fancyzoom" style = "max-width: 300px;" src="/uploads/<?=$model->image?>" alt=""></a>
<? endif; ?>          
            <div class = "text"><?=$model->long?>
</div>

