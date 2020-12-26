<?php echo CHtml::link('Create New Task', $this->createUrl('/tasks/save?Tasks[project_id]=' . $project->id), array('class' => 'btn btn-primary pull-right')); ?>
<div class="clearfix"></div>
<h1>View Tasks for Project: <?php echo $project->name; ?></h1>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(),
    'itemView'=>'_tasks',
));
?>