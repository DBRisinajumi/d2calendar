<?php


class CledCalendarExceptionDatesController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "d2calendar/cledCalendarExceptionDates";      


public function filters()
{
    return array(
        'accessControl',
    );
}

public function accessRules()
{
     return array(

        array(
            'allow',
            'actions' => array('generate', 'admin', 'deleteMonth', 'editableSaver'),
            'roles' => array('d2calendarAdmin'),
        ),
        array(
            'deny',
            'users' => array('*'),
        ),
    );
}

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = array('/' . $this->module->Id);
        }
        return true;
    }

    public function actionView($cled_id, $ajax = false)
    {
        $model = $this->loadModel($cled_id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    array(
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        )
                    );
        }else{
            $this->render('view', array('model' => $model,));
        }
    }

    public function actionGenerate($year){
        CledCalendarExceptionDates::model()->fillYear($year);
        $this->redirect(array('admin'));
        
    }

    public function actionDeleteMonth($month){
        AmaiMainas::deleteMonth($month);
        $this->redirect(array('admin'));
    }

    public function actionCreate()
    {
        $model = new CledCalendarExceptionDates;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'cled-calendar-exception-dates-form');

        if (isset($_POST['CledCalendarExceptionDates'])) {
            $model->attributes = $_POST['CledCalendarExceptionDates'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'cled_id' => $model->cled_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('cled_id', $e->getMessage());
            }
        } elseif (isset($_GET['CledCalendarExceptionDates'])) {
            $model->attributes = $_GET['CledCalendarExceptionDates'];
        }

        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($cled_id)
    {
        $model = $this->loadModel($cled_id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'cled-calendar-exception-dates-form');

        if (isset($_POST['CledCalendarExceptionDates'])) {
            $model->attributes = $_POST['CledCalendarExceptionDates'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(array('view', 'cled_id' => $model->cled_id));
                    }
                }
            } catch (Exception $e) {
                $model->addError('cled_id', $e->getMessage());
            }
        }

        $this->render('update', array('model' => $model,));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('CledCalendarExceptionDates'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new CledCalendarExceptionDates;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($cled_id)
    {
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($cled_id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(array('admin'));
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('D2calendarModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin()
    {
        $model = new CledCalendarExceptionDates('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['CledCalendarExceptionDates'])) {
            $model->attributes = $_GET['CledCalendarExceptionDates'];
        }

        $this->render('admin', array('model' => $model,));
    }

    public function loadModel($id)
    {
        $m = CledCalendarExceptionDates::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('D2calendarModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cled-calendar-exception-dates-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
