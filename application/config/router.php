<?php

/**
 * Here you can routing your project URLs
 *
 * @author    Your name
 * @copyright copyrights (c) 2012 - 2013 By your name or company name
 * @license   http://example/Project/license
 * @link      http://projecturl/
 */

cliprz::system(router)->index('home');

cliprz::system(router)->rule(array(
    'regex' => 'home',
    'class' => 'home',
    'path'  => 'home'
));

?>