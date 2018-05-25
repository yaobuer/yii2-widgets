<?php
namespace sunnnnn\widgets\colorpicker;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @use: https://farbelous.io/bootstrap-colorpicker/
 * @date: 2018/5/6 20:29
 * @author: sunnnnn [http://www.sunnnnn.com] [mrsunnnnn@qq.com]
 */
class ColorPicker extends InputWidget{
    /**
     * 纯净版，为true时，所有参数都需要自定义
     * @var boolean
     */
    public $_pure = false;
    /**
     * 在输入框后面添加显示颜色对区域
     * @var bool
     */
    public $_addon = true;
    /**
     * addon 为true时，颜色显示区域宽度
     * @var string
     */
    public $_width = '45px';
    /**
     * 颜色显示格式，hex rbg false null
     * @var bool
     */
    public $_format = null;
    /**
     * 是否使用透明度
     * @var bool
     */
    public $_useAlpha = true;
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
    }

    public function run(){
        parent::run();

        $this->renderWidget();
    }

    public function renderWidget(){

        if($this->hasModel()){
            if($this->_addon === true){
                $input = Html::tag('div', Html::activeTextInput($this->model, $this->attribute, $this->options).'<span class="input-group-addon" style="min-width:'.$this->_width.';"><i style="width:100%;"></i></span>', [
                    'class' => 'input-group colorpicker-component',
                    'style' => 'z-index: 0;',
                    'id' => $this->options['id'].'-div'
                ]);
            }else{
                $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
            }
        }else{
            if($this->_addon === true){
                $input = Html::tag('div', Html::textInput($this->name, null, $this->options).'<span class="input-group-addon" style="min-width:'.$this->_width.';"><i style="width:100%;"></i></span>', [
                    'class' => 'input-group colorpicker-component',
                    'style' => 'z-index: 0;',
                    'id' => $this->options['id'].'-div'
                ]);
            }else{
                $input = Html::textInput($this->name, null, $this->options);
            }
        }


        $this->renderAsset();
        echo $input;
    }

    public function renderAsset(){
        $view = $this->getView();

        ColorPickerAsset::register($view);

        if($this->_pure === true){
            $options = [];
        }else{
            $options = [
                'format' => $this->_format,
                'useAlpha' => $this->_useAlpha,
            ];
        }

        if(!empty($this->_options)){
            $options = $this->_optionsMerge === true ? array_merge($options, $this->_options) : $this->_options;
        }

        $jsonOptions = Json::encode($options);

        $selector = $this->_addon === true ? $this->options['id'].'-div' : $this->options['id'];

        $js = <<<JS
            $(function(){
                $('#{$selector}').colorpicker({$jsonOptions});
        	});
JS;

        $view->registerJs($js, $view::POS_END);
    }

}