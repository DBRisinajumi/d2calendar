<div class="crud-form">
    <?php  ?>    
    <?php
        Yii::app()->bootstrap->registerPackage('select2');
        Yii::app()->clientScript->registerScript('crud/variant/update','$("#cled-calendar-exception-dates-form select").select2();');


        $form=$this->beginWidget('TbActiveForm', array(
            'id' => 'cled-calendar-exception-dates-form',
            'enableAjaxValidation' => true,
            'enableClientValidation' => true,
            'htmlOptions' => array(
                'enctype' => ''
            )
        ));

        echo $form->errorSummary($model);
    ?>
    
    <div class="row">
        <div class="span12">
            <div class="form-horizontal">

                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php  ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2calendarModule.model', 'tooltip.cled_id')) != 'tooltip.cled_id')?$t:'' ?>'>
                                <?php
                            ;
                            echo $form->error($model,'cled_id')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'cled_date') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2calendarModule.model', 'tooltip.cled_date')) != 'tooltip.cled_date')?$t:'' ?>'>
                                <?php
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                         array(
                                 'model' => $model,
                                 'attribute' => 'cled_date',
                                 'language' =>  strstr(Yii::app()->language.'_','_',true),
                                 'htmlOptions' => array('size' => 10),
                                 'options' => array(
                                     'showButtonPanel' => true,
                                     'changeYear' => true,
                                     'changeYear' => true,
                                     'dateFormat' => 'yy-mm-dd',
                                     ),
                                 )
                             );
                    ;
                            echo $form->error($model,'cled_date')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                                    
                    <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'cled_type') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2calendarModule.model', 'tooltip.cled_type')) != 'tooltip.cled_type')?$t:'' ?>'>
                                <?php
                            echo CHtml::activeDropDownList($model, 'cled_type', $model->getEnumFieldLabels('cled_type'));
                            echo $form->error($model,'cled_type')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>
                   <?php  ?>
                    <div class="control-group">
                        <div class='control-label'>
                            <?php echo $form->labelEx($model, 'cled_notes') ?>
                        </div>
                        <div class='controls'>
                            <span class="tooltip-wrapper" data-toggle='tooltip' data-placement="right"
                                 title='<?php echo (($t = Yii::t('D2calendarModule.model', 'tooltip.cled_notes')) != 'tooltip.cled_notes')?$t:'' ?>'>
                                <?php
                            echo $form->textArea($model, 'cled_notes', array('rows' => 6, 'cols' => 50));
                            echo $form->error($model,'cled_notes')
                            ?>                            </span>
                        </div>
                    </div>
                    <?php  ?>                
                
            </div>
        </div>
        <!-- main inputs -->

            </div>
    <div class="row">
        
    </div>

    <p class="alert">
        
        <?php 
            echo Yii::t('D2calendarModule.crud','Fields with <span class="required">*</span> are required.');
                
            /**
             * @todo: We need the buttons inside the form, when a user hits <enter>
             */                
            echo ' '.CHtml::submitButton(Yii::t('D2calendarModule.crud', 'Save'), array(
                'class' => 'btn btn-primary',
                'style'=>'visibility: hidden;'                
            ));
                
        ?>
    </p>


    <?php $this->endWidget() ?>    <?php  ?></div> <!-- form -->
