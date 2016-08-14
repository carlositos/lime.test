<?php
use yii\helpers\Url;
$ids = implode(",", array_keys($siteUrls));
?>

<ul>
	<li>General Xml (<a href="<?=Url::to(['site/rss-one', 'ids'=>urlencode($ids)])?>" target="_blank">download</a>)</li>
</ul>