<?php
bu::lib("opt/html_form_persister/lib/HTML/SemiParser");
bu::lib("opt/html_form_persister/lib/HTML/FormPersister"); 
Class Form{
    public static function fillFromArray($htmlForm, $array = array()){
        $savedPOST = $_POST;
        $_POST = $array;
        $data = HTML_FormPersister::ob_formPersisterHandler($htmlForm);
        $_POST = $savedPOST;
        return $data;
    }
    public static function fillFromLastPost($htmlForm){
        return self::fillFromArray($htmlForm, bu::flash('last_post'));
    }
    public static function fillFromModel($htmlForm, $model){
        return self::fillFromArray($htmlForm, $model->attributes());
    }
}
