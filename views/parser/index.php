<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\web\View;

/* @var $this yii\web\View */

$this->title = 'WP sql db to RSS';
?>
<div class="site-index">

    <div class="jumbotron">

        <p class="lead">Upload wordpress databases files</p>
			
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
    		
    		$.ajax({
			  type: 'POST',
		      url: '/ajax/generate-xml-links',
		      data: {keys: keys},
		      success: function(data){
		          BootstrapDialog.alert(data);
		      }    
		  });
    		
    		console.log(keys);

    		
    	})
    	
 	});
", 
View::POS_END, 'my-options');
?> 	
    	

