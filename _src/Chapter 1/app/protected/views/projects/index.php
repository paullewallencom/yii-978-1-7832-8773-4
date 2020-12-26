<?php echo CHtml::link('Create New Project', $this->createUrl('/projects/save'), array('class' => 'btn btn-primary pull-right')); ?>
<div class="clearfix"></div>
<h1>Projects</h1>
<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$model->search(),
    'itemView'=>'_project',
)); ?>