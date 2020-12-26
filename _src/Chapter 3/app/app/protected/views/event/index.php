<?php echo CHtml::link('Create New Event', $this->createUrl('/event/save'), array('class' => 'pull-right btn btn-primary')); ?>

<div class="clearfix"></div>

<?php $this->widget('application.components.EventListView', array(
    'dataProvider'=>$model->search(true),
    'template' => '{items}',
    'enableSorting' => true,
    'itemsTagName' => 'ul',
    'sortableAttributes' => array(
    	'time',
    	'title'
    ),
    'itemView'=>'_event'
));

Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/calendar.css');