<?php

class home
{

    public function index ()
    {
        cliprz::system(view)->display('static/header',NULL,TRUE);
        cliprz::system(view)->display('home/home',NULL);
        cliprz::system(view)->display('static/footer',NULL,TRUE);
    }

}

?>