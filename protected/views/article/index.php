<?$this->pageTitle = "Статьи - ".$this->pageTitle; ?>
<? $this->widget('zii.widgets.CBreadcrumbs', array(
'homeLink'=>CHtml::link('Главная', array('site/index')),
		'separator' => ' / ',
    'links'=>array(
        'Статьи',
    ),
//	'tagName' => 'bread_crumbs',
));
?>
<article class="l-bg-box product">

<div class="h1-substrate">
<h1><strong>Статьи    <? if(Yii::app()->session->get("admin") == 1):?>                          
<a href = "/admin/article">    
<img src = "/images/edit.png">
</a>
<? endif; ?></strong></h1>
</div>


 

<ul class="news">

                <? foreach($news as $data) : ?>
<li>				

<a href="<?=$data->createurl;?>" class="news_link">  <?=$data->title;?> </a> <br><br>
<div class="news_text">
  <?=$data->short;?>
 </div>

</li>


<? endforeach; ?>

</ul>