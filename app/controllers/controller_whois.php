<?php

class Controller_whois extends Controller
{
    function action_index()
    {
        $this->view->generate('whois_view.php');
    }
}