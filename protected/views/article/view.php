<? if(!empty($model->seotitle))
$this->pageTitle = $model->seotitle;
else
$this->pageTitle = "$model->title / Статьи / ".$this->pageTitle;
if(!empty($model->seokeywords))
$this->pageKeywords = $model->seokeywords;
if(!empty($model->seodescription))
$this->pageDescription = $model->seodescription;
?>


<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Статьи' => '/article',
        $model->title,
    ),

));
?>

<div class="h1-substrate">
<h1><strong><?php echo $model->title; ?>     <? if(Yii::app()->session->get("admin") == 1):?>
                          
                       <a href = "/admin/news/article/id/<?=$model->id?>">    
                        <img src = "/images/edit.png">
                       </a>
                       <? endif; ?></strong></h1>
</div>
 <?=$model->content?>

