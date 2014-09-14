<?php
namespace bablo\layout;
/**
 * Description of Layout
 *
 * @author andrii
 */
class Layout {
    //put your code here
    private $layoutName='default';
    private $viewName;
    private $view;
    
    private $disableLayout = 0;
    
    public function getDisableLayout() {
        return $this->disableLayout;
    }

    public function setDisableLayout($disableLayout) {
        $this->disableLayout = $disableLayout;
    }
    
    public function getView() {
        return $this->view;
    }

    public function setView($view) {
        $this->view = $view;
    }

        public function getLayoutName() {
        return $this->layoutName;
    }

    public function setLayoutName($layoutName) {
        $this->layoutName = $layoutName;
    }

    public function render($viewName){
        if ($this->disableLayout) {
            require "view/$viewName.php";
        } else {
            $fileName = "layout/{$this->layoutName}.php";
            if (!file_exists($fileName)){
                throw new \RuntimeException('Нэту такого файла!');
            }
            $this->viewName = $viewName;
            require $fileName;
        }
    }
    public function view() {
        $fileName = "view/{$this->viewName}.php";
        require $fileName;
    }
}
