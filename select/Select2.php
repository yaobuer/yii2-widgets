<?php
namespace sunnnnn\widgets\select;

use yii\helpers\Html; 
use yii\helpers\Json; 
use yii\widgets\InputWidget; 

/**
 * https://select2.org
 * 
 * 
 * <?= $form->field($model, 'level')->widget(Select2::className(), [
 *      '_items' => ['aaa', 'bbb', 'ccc'],
 *      '_placeholder' => '请选择',
 *      '_multiple' => true,
 *  ]); ?>
 *  
 *  
 *  
 *  <?= Select2::widget([
 *      'name' => 'select',
 *      '_items' => ['aaa', 'bbb', 'ccc'],
 *      '_placeholder' => '请选择',
 *  ]); ?>
 * 
* @use: 
* @date: 2017年11月30日 下午3:12:40
* @author: sunnnnn [www.sunnnnn.com] [mrsunnnnn@qq.com]
 */
class Select2 extends InputWidget{
    
    /**
     * 样式
     * @var string
     */
    public $_class = 'form-control';
    /**
     * 选项数据
     * @var array
     */
    public $_items = [];
    /**
     * 默认选中
     * @var unknown
     */
    public $_selection = null;
    /**
     * 语言，默认中文
     * @var string
     */
    public $_language  = 'zh-CN';
    /**
     * 是否多选
     * @var string
     */
    public $_multiple  = false;
    /**
     * 占位符
     * @var unknown
     */
    public $_placeholder = null;
    /**
     * 是否允许清楚当前选中项
     * @var string
     */
    public $_clear = false;
    /**
     * 原生配置项
     * @var array
     */
    public $_options   = [];
    /**
     * 当前配置和原生配置合并
     * @var boolean
     */
    public $_optionsMerge = true;
    
    public function run(){
        parent::run();
        $this->renderWidget();
    }
    
    public function renderWidget(){
        if(!empty($this->_class)){
            $this->options['class'] = empty($this->options['class']) ? $this->_class : $this->_class.' '.$this->options['class'];
        }
        
        if($this->_multiple === true){
            $this->options['multiple'] = 'multiple';
        }
        
        if($this->hasModel()){
            $input = Html::activeDropDownList($this->model, $this->attribute, $this->_items, $this->options);
        }else{
            $input = Html::dropDownList($this->name, $this->_selection, $this->_items, $this->options);
        }
        
        $this->renderAsset();
        echo $input;
    }
    
    public function renderAsset(){
        $view = $this->getView();

        Select2Asset::register($view);
        
        $options = [
            'language' => $this->_language,
            'placeholder' => $this->_placeholder,
            'allowClear' => $this->_clear,
        ];
        
        if(!empty($this->_options)){
            $options = $this->_optionsMerge === true ? array_merge($options, $this->_options) : $this->_options;
        }
        
        $js = <<<JS
            $(function(){
                $('#{$this->options['id']}').select2({$this->jsonEncode($options)});
        	});
JS;
        
        $view->registerJs($js, $view::POS_END);
    }
    
    private function jsonEncode($array){
        return Json::encode($array);
    }
    
}
