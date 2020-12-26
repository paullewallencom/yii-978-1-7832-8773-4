<!DOCTYPE html>
<html>
	<head>
        <title><?php echo CHtml::encode(Yii::app()->name); ?></title>

        <?php Yii::app()->clientScript
        				->registerMetaTag('text/html; charset=UTF-8', 'Content-Type')
        				->registerCssFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css')
        				->registerCssFile('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css')
        				->registerCssFile('//fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300italic,700')
        				->registerScriptFile('//code.jquery.com/jquery.js')
        				->registerScriptFile('//netdna.bootstrapcdn.com/bootstrap/3.0.3/js/bootstrap.min.js');
        ?>
	</head>
	<body>
		<div class="row">
			<div class="container">
				<nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
					<div class="navbar-header">
					    <a class="navbar-brand" href="/"><?php echo CHtml::encode(Yii::app()->name); ?></a>
					</div>
				</nav>
			</div>
		</div>
		<div class="row" style="margin-top: 100px;">
			<div class="container">
				<?php echo $content; ?>
			</div>
		</div>
	</body>
</html>