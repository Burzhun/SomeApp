
<ul class="goods">
	<?foreach ($categoryes as $data) {?>
		<li class="disItem" >
			<div class="goodsImg">
				<a href="<?=$data->full_url?>" class="disItemImg">
					<img src="<?=$data->getChildrenImage()?>">
				</a>
			</div>
			<a href="<?=$data->full_url?>" class="disItemTitle"><?=$data->name?></a>
		</li>
	<?}?>
</ul>