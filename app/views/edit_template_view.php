<?php

/********************************************
 * PHP Newsletter 5.0.0 alfa
 * Copyright (c) 2006-2016 Alexander Yanitsky
 * Website: http://janicky.com
 * E-mail: janickiy@mail.ru
 * Skype: janickiy
 ********************************************/

defined('LETTER') || exit('NewsLetter: access denied.');

session_start();

// authorization
Auth::authorization();

$autInfo = Auth::getAutInfo($_SESSION['id']);

if (Pnl::CheckAccess($autInfo['role'], 'admin,moderator,editor')) exit();

//include template
core::requireEx('libs', "html_template/SeparateTemplate.php");
$tpl = SeparateTemplate::instance()->loadSourceFromFile(core::getTemplate() . core::getSetting('controller') . ".tpl");

if (Core_Array::getRequest('action')){
    $error = array();
    $name = trim(Core_Array::getPost('name'));
    $body = trim(Core_Array::getPost('body'));
    $id_template = (int)Core_Array::getPost('id_template');

    if (empty($name)) $error[] = core::getLanguage('error', 'empty_subject');
    if (empty($body)) $error[] = core::getLanguage('error', 'empty_content');

    if (count($error) == 0){
        $fields = array();
        $fields['name'] = $name;
        $fields['body'] = $body;
        $fields['prior'] = (int)Core_Array::getPost('prior');
        $fields['id_cat'] = (int)Core_Array::getPost('id_cat');

        if ($data->editTemplate($fields, $id_template)){
            header("Location: ./");
            exit();
        }else {
            $alert_error = core::getLanguage('error', 'web_apps_error');
        }
    }
}

if (Core_Array::getGet('remove')){
    if ($data->removeAttach(Core_Array::getGet('remove'))){
        header("Location: ./?task=edit_template&id_template=" . $_GET['id_template']);
        exit;
    }
}

$tpl->assign('TITLE_PAGE', core::getLanguage('title_page', 'edit_template'));
$tpl->assign('TITLE', core::getLanguage('title', 'edit_template'));
$tpl->assign('INFO_ALERT', core::getLanguage('info', 'edit_template'));

include_once core::pathTo('extra', 'top.php');

// menu
include_once core::pathTo('extra', 'menu.php');

// alert
if (isset($alert_error)) {
    $tpl->assign('ERROR_ALERT', $alert_error);
}

if (isset($error) && count($error) > 0){
    $errorBlock = $tpl->fetch('show_errors');
    $errorBlock->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));

    foreach($error as $row){
        $rowBlock = $errorBlock->fetch('row');
        $rowBlock->assign('ERROR', $row);
        $errorBlock->assign('row', $rowBlock);
    }

    $tpl->assign('show_errors', $errorBlock);
}

//form
$tpl->assign('STR_FORM_SUBJECT', core::getLanguage('str', 'form_subject'));
$tpl->assign('STR_FORM_CONTENT', core::getLanguage('str', 'form_content'));
$tpl->assign('STR_FORM_NOTE',  core::getLanguage('str', 'form_supported_tags'));
$tpl->assign('STR_REMOVE', core::getLanguage('str', 'remove'));
$tpl->assign('STR_SUPPORTED_TAGS_LIST', core::getLanguage('str', 'supported_tags_list'));
$tpl->assign('STR_FORM_ATTACH_FILE', core::getLanguage('str', 'form_attach_file'));
$tpl->assign('STR_FORM_CATEGORY_SUBSCRIBERS', core::getLanguage('str', 'form_category_subscribers'));
$tpl->assign('STR_FORM_PRIORITY_NORMAL', core::getLanguage('str', 'form_priority_normal'));
$tpl->assign('STR_FORM_PRIORITY_LOW', core::getLanguage('str', 'form_priority_low'));
$tpl->assign('STR_FORM_PRIORITY_HIGH', core::getLanguage('str', 'form_priority_high'));
$tpl->assign('STR_FORM_PRIORITY', core::getLanguage('str', 'form_priority'));

$template = $data->getTemplate(Core_Array::getGet('id_template'));

//value
$tpl->assign('NAME', empty(Core_Array::getPost('name')) ? Core_Array::getPost('name') : $template['name']);
$tpl->assign('CONTENT', empty(Core_Array::getPost('body')) ? Core_Array::getPost('body') : $template['body']);
$tpl->assign('ID_TEMPLATE', Core_Array::getGet('id_template'));

$arr = $data->getAttachmentsList(Core_Array::getGet('id_template'));

if ($arr){
    $attachBlock = $tpl->fetch('attach_list');
    $attachBlock->assign('STR_ATTACH_LIST', core::getLanguage('str', 'str_attach_list'));

    foreach($arr as $row)
    {
        $rowBlock = $attachBlock->fetch('row');
        $rowBlock->assign('ATTACHMENT_FILE', $row['name']);
        $rowBlock->assign('ID_TEMPLATE', Core_Array::getGet('id_template'));
        $rowBlock->assign('ID_ATTACHMENT', $row['id_attachment']);
        $rowBlock->assign('STR_REMOVE', core::getLanguage('str', 'remove'));
        $attachBlock->assign('row', $rowBlock);
    }

    $tpl->assign('attach_list', $attachBlock);
}

if (Core_Array::getPost('prior') == 1)
    $tpl->assign('PRIOR1_CHECKED', empty(Core_Array::getPost('prior')) ? Core_Array::getPost('prior') : $template['prior']);
else if (Core_Array::getPost('prior') == 2)
    $tpl->assign('PRIOR2_CHECKED', empty(Core_Array::getPost('prior')) ? Core_Array::getPost('prior') : $template['prior']);
else
    $tpl->assign('PRIOR3_CHECKED', $template['prior']);

$arr = $data->getCategoryOptionList();

if ($arr){
    $tpl->assign('POST_ID_CAT', empty(Core_Array::getPost('id_cat')) ? Core_Array::getPost('id_cat') : $row['id_cat']);
    $tpl->assign('STR_SEND_TO_ALL', core::getLanguage('str', 'send_to_all'));

    foreach($arr as $row){
        $rowBlock = $tpl->fetch('categories_row');
        $rowBlock->assign('ID_CAT', $row['id_cat']);
        $rowBlock->assign('NAME', $row['name']);
        $rowBlock->assign('POST_ID_CAT', empty(Core_Array::getPost('id_cat')) ? Core_Array::getPost('id_cat') : $row['id_cat']);
        $tpl->assign('categories_row', $rowBlock);
    }
}

$tpl->assign('BUTTON',core::getLanguage('button', 'edit'));

$tpl->assign('STR_SEND_TEST_EMAIL', core::getLanguage('str', 'send_test_email'));
$tpl->assign('BUTTON_SEND', core::getLanguage('button', 'send'));
$tpl->assign('STR_IDENTIFIED_FOLLOWING_ERRORS', core::getLanguage('str', 'identified_following_errors'));

//footer
include_once core::pathTo('extra', 'footer.php');

// display content
$tpl->display();