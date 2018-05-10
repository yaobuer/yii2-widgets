<?php
namespace sunnnnn\widgets\slider;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @use: http://seiyria.com/bootstrap-slider/
 * @date: 2018/5/9 13:56
 * @author: sunnnnn [http://www.sunnnnn.com] [mrsunnnnn@qq.com]
 */
class Slider extends InputWidget{
    /**
     * 纯净版，为true时，所有参数都需要自定义
     * @var boolean
     */
    public $_pure = false;
    /**
     * 当前slider唯一编号
     * @var string
     */
    public $_id = '';
    /**
     * 最小值
     * @var int
     */
    public $_min = 0;
    /**
     * 最大值
     * @var int
     */
    public $_max = 10;
    /**
     * 滑动最小间隔
     * @var int
     */
    public $_step = 1;
    /**
     * 小数点位数
     * @var int
     */
    public $_precision = 0;
    /**
     * 横向horizontal 竖向vertical
     * @var string
     */
    public $_orientation = 'horizontal';
    /**
     * 初始值
     * @var int， array
     */
    public $_value = 0;
    /**
     * 区间
     * @var bool
     */
    public $_range = false;
    /**
     * before, after, none
     * @var string
     */
    public $_selection = 'before';
    /**
     * 提示条show，hide，always
     * @var string
     */
    public $_tooltip = 'always';
    /**
     * 提示条显示位置 top/bottom, left/right
     * @var null
     */
    public $_tooltip_position = null;
    /**
     * 操作点的形状 round, square, triangle, custom
     * @var string
     */
    public $_handle = 'round';
    /**
     * 反转
     * @var bool
     */
    public $_reversed = false;
    /**
     * 是否启用
     * @var bool
     */
    public $_enabled = true;
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

        $value = isset($this->options['value']) ? $this->options['value'] : Html::getAttributeValue($this->model, $this->attribute);
        $this->_value = empty($value) ? $this->_value : $value;
        $this->_enabled = empty($this->options['disabled']) ? $this->_enabled : false;
        $this->_id = empty($this->_id) ? 'slider-'.$this->options['id'] : $this->_id;
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

        SliderAsset::register($view);

        if($this->_pure === true){
            $options = [];
        }else{
            $options = [
                'id' => $this->_id,
                'min' => $this->_min,
                'max' => $this->_max,
                'step' => $this->_step,
                'precision' => $this->_precision,
                'orientation' => $this->_orientation,
                'value' => $this->_value,
                'range' => $this->_range,
                'selection' => $this->_selection,
                'tooltip' => $this->_tooltip,
                'tooltip_position' => $this->_tooltip_position,
                'handle' => $this->_handle,
                'reversed' => $this->_reversed,
                'enabled' => $this->_enabled,
            ];
        }

        if(!empty($this->_options)){
            $options = $this->_optionsMerge === true ? array_merge($options, $this->_options) : $this->_options;
        }

        $jsonOptions = Json::encode($options);

        $js = <<<JS
            $('#{$this->options['id']}').slider({$jsonOptions});
JS;

        $view->registerJs($js, $view::POS_END);
    }

}