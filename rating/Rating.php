<?php
namespace sunnnnn\widgets\rating;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;

/**
 * @use: http://plugins.krajee.com/star-rating#top
 * @date: 2018/5/9 13:56
 * @author: sunnnnn [http://www.sunnnnn.com] [mrsunnnnn@qq.com]
 */
class Rating extends InputWidget{
    /**
     * 纯净版，为true时，所有参数都需要自定义
     * @var boolean
     */
    public $_pure = false;
    /**
     * 默认5颗星星
     * @var int
     */
    public $_stars = 5;
    /**
     * 最小值
     * @var int
     */
    public $_min = 0;
    /**
     * 最大值
     * @var int
     */
    public $_max = 5;
    /**
     * 间隔
     * @var int
     */
    public $_step = 1;
    /**
     * 语言
     * @var int
     */
    public $_language = 'zh';
    /**
     * 默认星星图标
     * @var string
     */
    public $_emptyStar = '<i class="fa fa-star-o"></i>';
    /**
     * 点击后星星图标
     * @var string
     */
    public $_filledStar = '<i class="fa fa-star"></i>';
    /**
     * disabled
     * @var bool
     */
    public $_disabled = false;
    /**
     * readonly
     * @var bool
     */
    public $_readonly = false;
    /**
     * 右对齐
     * @var bool
     */
    public $_rtl = false;
    /**
     * 显示清除按钮
     * @var bool
     */
    public $_showClear = false;
    /**
     * 大小，xl, lg, md, sm, xs
     * @var string
     */
    public $_size = 'md';
    /**
     * 显示描述
     * @var bool
     */
    public $_showCaption = false;
    /**
     * 描述格式
     * @var string
     */
    public $_defaultCaption = '{rating} Stars';
    public $_starCaptions = [
        0.5 => 'Half Star',
        1 => 'One Star',
        1.5 => 'One & Half Star',
        2 => 'Two Stars',
        2.5 => 'Two & Half Stars',
        3 => 'Three Stars',
        3.5 => 'Three & Half Stars',
        4 => 'Four Stars',
        4.5 => 'Four & Half Stars',
        5 => 'Five Stars'
    ];
    public $_starCaptionClasses = [
        0.5 => 'badge badge-danger',
        1 => 'badge badge-danger',
        1.5 => 'badge badge-warning',
        2 => 'badge badge-warning',
        2.5 => 'badge badge-info',
        3 => 'badge badge-info',
        3.5 => 'badge badge-primary',
        4 => 'badge badge-primary',
        4.5 => 'badge badge-success',
        5 => 'badge badge-success'
    ];
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
        if(in_array($this->_language, ['zh', 'zh-CN', 'zh-cn'])){
            $this->_language = 'zh';
        }else{
            $this->_language = 'en';
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

        RatingAsset::register($view);

        if($this->_pure === true){
            $options = [];
        }else{
            $options = [
                'language' => $this->_language,
                'emptyStar' => $this->_emptyStar,
                'filledStar' => $this->_filledStar,
                'stars' => $this->_stars,
                'min' => $this->_min,
                'max' => $this->_max,
                'step' => $this->_step,
                'disabled' => $this->_disabled,
                'readonly' => $this->_readonly,
                'rtl' => $this->_rtl,
                'animate' => true,
                'showClear' => $this->_showClear,
                'showCaption' => $this->_showCaption,
                'size' => $this->_size,
                'defaultCaption' => $this->_defaultCaption,
                'starCaptions' => $this->_starCaptions,
                'starCaptionClasses' => $this->_starCaptionClasses
            ];
        }

        if(!empty($this->_options)){
            $options = $this->_optionsMerge === true ? array_merge($options, $this->_options) : $this->_options;
        }

        $jsonOptions = Json::encode($options);

        $js = <<<JS
            $('#{$this->options['id']}').rating({$jsonOptions});
JS;

        $view->registerJs($js, $view::POS_END);
    }

}