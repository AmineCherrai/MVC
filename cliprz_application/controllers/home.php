<?php

class home
{

    public function index ()
    {
        cliprz::system(view)->display("home");
    }

	public function info ()
	{
		cliprzinfo();
	}
	
}

?>