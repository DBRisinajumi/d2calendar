<?php
    $this->setPageTitle(
        Yii::t('D2calendarModule.model', 'Cled Calendar Exception Dates')
        . ' - '
        . Yii::t('D2calendarModule.crud', 'View')
        . ': '   
        . $model->getItemLabel()            
);    
$cancel_buton = $this->widget("bootstrap.widgets.TbButton", array(
    #"label"=>Yii::t("D2calendarModule.crud","Cancel"),
    "icon"=>"chevron-left",
    "size"=>"large",
    "url"=>(isset($_GET["returnUrl"]))?$_GET["returnUrl"]:array("{$this->id}/admin"),
    "visible"=>Yii::app()->user->checkAccess("d2calendarAdmin"),
    "htmlOptions"=>array(
                    "class"=>"search-button",
                    "data-toggle"=>"tooltip",
                    "title"=>Yii::t("D2calendarModule.crud","Back"),
                )
 ),true);
    
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2calendarModule.model','Cled Calendar Exception Dates');?>  
            </h1>
        </div>
        <div class="btn-group">
            <?php
            
            $this->widget("bootstrap.widgets.TbButton", array(
                "label"=>Yii::t("D2calendarModule.crud","Delete"),
                "type"=>"danger",
                "icon"=>"icon-trash icon-white",
                "size"=>"large",
                "htmlOptions"=> array(
                    "submit"=>array("delete","cled_id"=>$model->{$model->tableSchema->primaryKey}, "returnUrl"=>(Yii::app()->request->getParam("returnUrl"))?Yii::app()->request->getParam("returnUrl"):$this->createUrl("admin")),
                    "confirm"=>Yii::t("D2calendarModule.crud","Do you want to delete this item?")
                ),
                "visible"=> false
            ));
            ?>
        </div>
    </div>
</div>



<div class="row">
    <div class="span12">
        <?php
        $this->widget(
            'TbDetailView',
            array(
                'data' => $model,
                'attributes' => array(
                

            array(
                'name' => 'cled_date',
                'type' => 'raw',    
                'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'date',
                            'url' => $this->createUrl('/d2calendarAdmin/cledCalendarExceptionDates/editableSaver'),
                            'attribute' => 'cled_date',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
            ),

            array(
                'name' => 'cled_type',
                'type' => 'raw',    
                'value' => $this->widget(
                        'EditableField', 
                        array(
                            'model' => $model,
                            'type' => 'select',
                            'url' => $this->createUrl('/d2calendarAdmin/cledCalendarExceptionDates/editableSaver'),
                            'source' => $model->getEnumFieldLabels('cled_type'),
                            'attribute' => 'cled_type',
                            //'placement' => 'right',                                
                        ), 
                        true
                    )                   
            ),
            array(
                    'name' => 'cled_notes',
                    'type' => 'raw',
                    'value' => $this->widget(
                        'EditableField',
                        array(
                            'model' => $model,
                            'attribute' => 'cled_notes',
                            'url' => $this->createUrl('/d2calendarAdmin/cledCalendarExceptionDates/editableSaver'),
                        ),
                        true
                    )
                ),                    
           ),
        )); ?>
    </div>

    </div>
    <div class="row">

    <div class="span12">
        <div class="well">
            <?php $this->renderPartial('_view-relations_grids',array('modelMain' => $model, 'ajax' => false,)); ?>        </div>
    </div>
</div>

<?php echo $cancel_buton; ?>