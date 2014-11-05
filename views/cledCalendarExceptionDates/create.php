<?php
$this->setPageTitle(
    Yii::t('D2calendarModule.model', 'Cled Calendar Exception Dates')
    . ' - '
    . Yii::t('D2calendarModule.crud', 'Create')
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
                    "title"=>Yii::t("D2calendarModule.crud","Cancel"),
                )
 ),true);
    
?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            <h1>
                <i class=""></i>
                <?php echo Yii::t('D2calendarModule.model','Create Cled Calendar Exception Dates');?>            </h1>
        </div>
    </div>
</div>

<?php $this->renderPartial('_form', array('model' => $model, 'buttons' => 'create')); ?>
<div class="clearfix">
    <div class="btn-toolbar pull-left">
        <div class="btn-group"><?php echo $cancel_buton;?></div>
        <div class="btn-group">
            
                <?php  
                    $this->widget("bootstrap.widgets.TbButton", array(
                       "label"=>Yii::t("D2calendarModule.crud","Save"),
                       "icon"=>"icon-thumbs-up icon-white",
                       "size"=>"large",
                       "type"=>"primary",
                       "htmlOptions"=> array(
                            "onclick"=>"$('.crud-form form').submit();",
                       ),
                       "visible"=> Yii::app()->user->checkAccess("d2calendarAdmin")
                    )); 
                    ?>
                  
        </div>
    </div>
</div>