<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;
use nirvana\showloading\ShowLoadingAsset;
ShowLoadingAsset::register($this);

/* @var $this yii\web\View */

$this->title = 'WP sql db to RSS';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Wordpress databases files</p>
			
		<?php
		$gridColumns = [
		    ['class' => 'kartik\grid\SerialColumn'],

	        'filename',
			[
		        'class' => 'kartik\grid\ActionColumn',
		        'template' => '{delete}',
		        'vAlign'=>'middle'
		    ],
		    ['class' => 'kartik\grid\CheckboxColumn']
		];
		echo GridView::widget([
		    'dataProvider' => $dataProvider,
		    'filterModel' => $searchModel,
		    'columns' => $gridColumns,

		    'export' => false,
		]);
		?>
		
		<div class="pull-right">
			<a href="#" id="generateFiles" class="btn btn-primary">
				<i class="glyphicon glyphicon-download-alt"></i>
				Generate XML files
			</a>
		</div>
    </div>

</div>

<?php
$this->registerJs("
    $(document).ready(function(){
    	
    	$('#generateFiles').click(function(){
    		var keys = $('#w0').yiiGridView('getSelectedRows');
    		
    		if(keys.length == 0)
    		{
    			BootstrapDialog.alert('Please select at least one database to parse');
    			return false;
    		}
    		
    		$.ajax({
			  type: 'POST',
		      url: '/ajax/generate-xml-links',
		      data: {keys: keys},
		      beforeSend: function(){
		      	  $('#w0').showLoading()
			  },
		      success: function(data){
		          BootstrapDialog.alert(data);
		      },
		      complete: function(){
		      	  $('#w0').hideLoading()
			  }
		  	});
    	})
    	
 	});
", 
View::POS_END, 'my-options');
?> 	
    	

