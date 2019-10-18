<?php
/**
 * Description of View
 *
 * View base class.
 * 
 * @author Gabriel
 */
class View {

    protected $viewFile;
    protected $viewData;

    public function __construct($viewFile, $viewData) {
        $this->viewFile = $viewFile;
        $this->viewData = $viewData;
    }
    public function render() {
        if (file_exists(VIEW . $this->viewFile . '.phtml')) {
            include VIEW . $this->viewFile . '.phtml';
        }
    }
    public function getAction() {
        return (explode('\\', $this->viewFile)[1]);
    }

}
