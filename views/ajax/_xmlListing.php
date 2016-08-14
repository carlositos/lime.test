<?php
use yii\helpers\Url;
?>

<ul>
	<?php foreach($siteUrls as $key => $url):?>
	<li><?=$url?> (<a href="<?=Url::to(['site/rss', 'id'=>$key])?>" target="_blank">download xml</a>)</li>
	<?php endforeach;?>
</ul>