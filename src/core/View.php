<?php
/**
 *
 * View base class.
 *
 * @author Gabriel
 * 
 * Last updated: 09/20/2019
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

    /**
     * Prints the viewData in JSON String format.
     */
    public function printViewData() {
        echo json_encode($this->viewData);
    }
    

}
