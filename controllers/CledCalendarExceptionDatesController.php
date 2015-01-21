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

    public function actionGenerate($year){
        
        if($year<date('Y')+2 && $year>date('Y')-20){
            CledCalendarExceptionDates::model()->fillYear($year);
        }
        $this->redirect(array('admin'));
        
    }

    public function actionDeleteMonth($month){
        AmaiMainas::deleteMonth($month);
        $this->redirect(array('admin'));
    }

    public function actionEditableSaver()
    {
        $es = new EditableSaver('CledCalendarExceptionDates'); // classname of model to be updated
        $es->update();
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
