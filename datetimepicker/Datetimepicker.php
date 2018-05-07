<?php
namespace sunnnnn\widgets\datetimepicker;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget; 

/**
 * @use:日期控件（带时分秒）
 *
 * use sunnnnn\datetimepicker\Datetimepicker;
 *
 * <?= Datetimepicker::widget([
 *      'name' => 'datetime',
 * //   'model' => $model,
 * //   'attribute' => 'datetime'
 *      '_format' => 'YYYY-MM-DD HH:mm:ss',
 *      ...
 *  ]); ?>
 *
 *
 *  在ActiveForm中
 *  <?= $form->field($model, 'datetime')->widget(Datetimepicker::classname(), [
 *      '_format' => 'YYYY-MM-DD HH:mm:ss',
 *      ...
 *  ]); ?>
 *
 * @date: 2018/3/29 13:51
 * @author: sunnnnn [http://www.sunnnnn.com] [mrsunnnnn@qq.com]
 */
class DatetimePicker extends InputWidget{
    /**
     * 纯净版，为true时，所有参数都需要自定义
     * @var boolean
     */
    public $_pure = false;
    /**
     * language default english
     * @var string
     */
    public $_language = 'en';
    /**
     * 显示格式
     * @var string
     */
    public $_format = 'YYYY-MM-DD HH:mm';
    /**
     * 最小时间
     * @var bool
     */
    public $_minDate = false; //2018-03-29
    /**
     * 最大时间
     * @var bool
     */
    public $_maxDate = false;
    /**
     * 关闭按钮
     * @var bool
     */
    public $_close = false;
    /**
     * 清除按钮
     * @var bool
     */
    public $_clear = false;
    /**
     * 今日按钮
     * @var bool
     */
    public $_today = false;
    /**
     * 原生配置
     * @var array
     */
    public $_options = [];
    /**
     * 当前配置和原生配置合并
     * @var boolean
     */
    public $_optionsMerge = true;

    public function init(){
        parent::init();

        if(in_array($this->_language, ['zh', 'zh-cn', 'zh-CN'])){
            $this->_language = 'zh-cn';
        }
    }

    public function run(){
        parent::run();

        $this->renderWidget();
    }

    public function renderWidget(){

        if($this->hasModel()){
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        }else{
            $input = Html::textInput($this->name, null, $this->options);
        }


        $this->renderAsset();
        echo $input;
    }

    public function renderAsset(){
        $view = $this->getView();

        DatetimePickerAsset::register($view);

        if($this->_pure === true){
            $options = [];
        }else{
            $options = [
                'format' => $this->_format,
                'locale' => $this->_language,
                'minDate' => $this->_minDate,
                'maxDate' => $this->_maxDate,
                'showClose' => $this->_close,
                'showClear' => $this->_clear,
                'showTodayButton' => $this->_today,
            ];
        }

        if(!empty($this->_options)){
            $options = $this->_optionsMerge === true ? array_merge($options, $this->_options) : $this->_options;
        }

        $jsonOptions = Json::encode($options);

        $js = <<<JS
            $(function(){
                $('#{$this->options['id']}').datetimepicker({$jsonOptions});
        	});
JS;

        $view->registerJs($js, $view::POS_END);
    }

}