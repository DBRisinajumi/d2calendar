<?php
$this->setPageTitle(Yii::t('D2calendarModule.model', 'Kalendārs'));
?>


<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group">
        <?php 
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>Yii::t('D2calendarModule.crud','Create'),
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('create'),
             'visible'=>false
        ));  
        ?>
</div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2calendarModule.model', 'Kalendārs');?> 
            </h1>
        </div>
        <div class="btn-group">
        <?php 
        $next_year = CledCalendarExceptionDates::getNextYear();
        $this->widget('bootstrap.widgets.TbButton', array(
             'label'=>'Ģenerēt '.$next_year . ' gada dienas',
             'icon'=>'icon-plus',
             'size'=>'large',
             'type'=>'success',
             'url'=>array('generate','year'=>$next_year),
             'visible'=>Yii::app()->user->checkAccess('d2calendarAdmin')
        ));  

        ?>
</div>        
    </div>
</div>
<div class="row">
    <div class="span5">
<?php 

Yii::beginProfile('CledCalendarExceptionDates.view.grid'); 

Yii::app()->clientScript->registerScript('init_grid_filter', "
    function init_grid_filter(){
        filter_CledCalendarExceptionDates_cled_date_range_init();
    }
    ");


$this->widget('TbGridView',
    array(
        'id' => 'cled-calendar-exception-dates-grid',
        'dataProvider' => $model->search(),
        'filter' => $model,
        #'responsiveTable' => true,
        'template' => '{pager}{items}{pager}',
        'pager' => array(
            'class' => 'TbPager',
            'displayFirstAndLast' => true,
        ),
        'afterAjaxUpdate' => 'init_grid_filter',        
        'columns' => array(
            array(
                'name' => 'cled_date',
                'value' => 'date("d.m.Y",strtotime($data->cled_date))',
                'filter' => $this->widget('vendor.dbrisinajumi.DbrLib.widgets.TbFilterDateRangePicker', 
                                        array(
                                            'model' => $model,
                                            'attribute' => 'cled_date_range',
                                            'format' => 'DD.MM.YYYY',
                                            'options' => array(     
                                                'ranges' => array('this_week','last_week','this_month','last_month','this_year'),   

                                            ),    
                                         ), TRUE ),
                
            ),
            array(
                    'class' => 'editable.EditableColumn',
                    'name' => 'cled_type',
                    'editable' => array(
                        'type' => 'select',
                        'url' => $this->createUrl('/d2calendar/cledCalendarExceptionDates/editableSaver'),
                        'source' => $model->getEnumFieldLabels('cled_type'),
                        //'placement' => 'right',
                    ),
                   'filter' => $model->getEnumFieldLabels('cled_type'),
                ),
            array(
                //tinytext
                'class' => 'editable.EditableColumn',
                'name' => 'cled_notes',
                'editable' => array(
                    'url' => $this->createUrl('/d2calendar/cledCalendarExceptionDates/editableSaver'),
                    //'placement' => 'right',
                )
            ),

        )
    )
);

Yii::endProfile('CledCalendarExceptionDates.view.grid'); 
?>
</div></div>