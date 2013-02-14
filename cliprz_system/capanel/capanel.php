<?php

/**
 * Copyright :
 *  Cliprz model view controller framework.
 *  Copyright (C) 2012 - 2013 By Yousef Ismaeil.
 *
 * Framework information :
 *  Version 1.1.0 - Stability Beta.
 *  Official website http://www.cliprz.org .
 *
 * File information :
 *  File path BASE_PATH/cliprz_system/capanel/ .
 *  File name capanel.php .
 *  Created date 05/02/2013 03:39 AM.
 *  Last modification date 14/02/2013 04:48 PM.
 *
 * Description :
 *  CAPanel class to create admin panel, in MVC named (scaffold).
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_capanel
{

    /**
     * @var (string) $capanel_extension - CAPanel file extension.
     * @access protected.
     */
    protected static $capanel_extension = '.cap.php';

    /**
     * @var (string) $capanel_prefix - CAPanel prefix.
     * @access protected.
     */
    protected static $capanel_prefix = 'capanel_';

    /**
     * @var (string) $document_title - Document title.
     * @access protected.
     */
    protected static $document_title;

    /**
     * @var (string) $errors - Errors messages.
     * @access protected.
     */
    protected static $errors;

    /**
     * Cliprz Admin Panel constructor.
     *
     * @access public.
     */
    public function __construct()
    {

        global $_config;

        // Check if database is true.
        if ($_config['db']['use_database'] === false)
        {
            exit('You cannot use CAPanel you must use database.');
        }

        // Check if pagination Library not loaded try to use loaded.
        if (!cliprz::is_library_loaded('pagination'))
        {
            cliprz::library_use("pagination","pagination");
        }

        $paths = array(
            self::get_info('public_path'),
            self::get_info('theme_path'),
            self::get_info('controller_path'),
            self::get_info('view_path'),
            self::get_info('data_path'));

        $files = array(
            APP_PATH.'config'.DS.'cap_router.php',
            self::get_info('theme_path').'styles.css',
            self::get_info('theme_path').'tipsy.css',
            self::get_info('theme_path').'capenl.js',
            self::get_info('theme_path').'jquery.tipsy.js');

        // Check main paths.
        self::checking($paths,'paths');

        // Check main files.
        self::checking($files,'files');

        unset($paths,$files);

        self::home_router_rules();
    }

    /**
     * Checking main paths and files, to run CAPanel as will.
     *
     * @param (array) $data - Data as array.
     * @param (array) $type - Checking type.
     *  $type :
     *   'paths' Checking main paths.
     *   'files' Checking main files.
     * @access protected.
     */
    protected static function checking ($data,$type)
    {
        foreach ($data as $value)
        {
            if (!is_dir($value) && $type == 'paths')
            {
                break;
                exit($value.' not found so you can not use CAPanel.');
            }
            else if (!file_exists($value) && $type == 'files')
            {
                break;
                exit($value.' not found so you can not use CAPanel.');
            }
        }
    }

    /**
     * Get CAPanel information.
     *
     * @param (string) $data - You can get some data about CAPanel information.
     *  $data :
     *   'name'            - CAPanel static name.
     *   'router'          - Router urls starting with capanel name you can cahnge routing name from $_config['cap']['name'].
     *   'theme_path'      - CAPanel theme path in BASE_PATH/public/capanel/{theme name}/ .
     *   'public_path'     - CAPanel public path BASE_PATH/public/capanel/ .
     *   'controller_path' - CAPanel controllers path, BASE_PATH/cliprz_application/controllers/capanel/ .
     *   'view_path'       - CAPanel view path, BASE_PATH/cliprz_application/capanel/ .
     *   'theme_url'       - CAPanel get theme url, http://www.example.com/public/capanel/{theme name} .
     *   'data_path'       - CAPanel get data path, BASE_PATH/cliprz_system/capanel/data/ .
     * @access public.
     */
    public static function get_info ($data)
    {
        global $_config;

        $information = array(
            'name'            => $_config['cap']['name'],
            'router'          => $_config['cap']['name'].DS,
            'theme_path'      => PUBLIC_PATH.'capanel'.DS.$_config['cap']['theme'].DS,
            'public_path'     => PUBLIC_PATH.'capanel'.DS,
            'controller_path' => APP_PATH.'controllers'.DS.'capanel'.DS,
            'view_path'       => APP_PATH.'capanel'.DS,
            'theme_url'       => C_URL.'public'.DS.'capanel'.DS.$_config['cap']['theme'].DS,
            'data_path'       => SYS_PATH.'capanel'.DS.'data'.DS
        );

        if (array_key_exists($data,$information))
        {
            return $information[$data];
        }
        else
        {
            return 'No data';
        }
    }

    /**
     * Get file from public/capanel path.
     *
     * @param (string) $file - File name.
     * @access public.
     */
    public static function get_file ($file)
    {
        if (is_dir(self::get_info('theme_path')))
        {
            if (file_exists(self::get_info('theme_path').$file))
            {
                return self::get_info('theme_url').$file;
            }
            else
            {
                trigger_error($file." file not found in ".self::get_info('theme_path'));
            }
        }
        else
        {
            trigger_error(self::get_info('theme_path')." not exists.",E_WARNING);
        }
    }

    /**
     * Get image from public/cpanel/theme name/images path.
     *
     * @param (string) $image - Image name.
     * @access public.
     */
    public static function get_image ($image)
    {
        if (is_dir(self::get_info('theme_path').'images'.DS))
        {
            if (file_exists(self::get_info('theme_path').'images'.DS.$image))
            {
                return self::get_info('theme_url').'images'.DS.$image;
            }
            else
            {
                trigger_error($image." image not found in ".self::get_info('theme_path').'images');
            }
        }
        else
        {
            trigger_error(self::get_info('theme_path').'images'.DS." not exists.",E_WARNING);
        }
    }

    /**
     * Set a document title.
     *
     * @param (string) $title - Document title.
     * @access public.
     */
    public static function set_title ($title)
    {
        self::$document_title = ((isset($title)) ? $title : null);
    }

    /**
     * Get document title from self::set_title() method.
     *
     * @access public.
     */
    public static function get_title ()
    {
        return (is_null(self::$document_title)) ? 'CAP | Cliprz Admin Panel' : self::$document_title;
    }

    /**
     * display file from capanel folder.
     *
     * @param (string) $file - file name.
     * @param (string) $folder - if capanel file in folder but the folder name.
     * @param (array) $data - put data in capanel files.
     * @access public.
     */
    public static function display($file,$folder='',$data=null)
    {
        $cap_path = null;

        // check path for capanel file
        if ($folder == '')
        {
            $cap_path = APP_PATH.'capanel'.DS.$file.self::$capanel_extension;
        }
        else
        {
            $cap_path = APP_PATH.'capanel'.DS.c_trim_path($folder).DS.$file.self::$capanel_extension;
        }

        // extract data if exsists
        if (!is_null($data) && is_array($data))
        {
            extract($data);
        }

        // include and show capanel file
        if (file_exists($cap_path))
        {
            require_once $cap_path;
        }
        else
        {
            if (C_DEVELOPMENT_ENVIRONMENT == true)
            {
                trigger_error($cap_path." file not exists.");
            }
            else
            {
                cliprz::system(error)->show_404();
            }
        }

        // unset data
        unset($data,$cap_path,$folder);

    }

    /**
     * Set errors message.
     *
     * @param (string) $message - Error Message.
     * @access protected.
     */
    protected static function set_error ($message)
    {
        self::$errors = $message;
    }

    /**
     * Get errors message.
     *
     * @access public.
     */
    public static function get_error ()
    {
        return self::$errors;
    }

    /**
     * Filter column name.
     *
     * @param (string) $column_name - Column name in database.
     * @access public.
     */
    public static function filter_column_name ($column_name)
    {
        return str_replace("_"," ",ucfirst($column_name));
    }

    /**
     * Remove database prefix from table name.
     *
     * @param (string) $table_name - Table name.
     * @access public.
     */
    public static function remove_database_prefix ($table_name)
    {
        return ltrim($table_name,C_DATABASE_PREFIX);
    }

    /**
     * Set a page that show for user a success message.
     * This function get redirecting.cap.php from BASE_PATH/cliprz_application/capanel and put some data inside file.
     *
     * @param (array) $data - Redirecting data.
     *  $data :
     *   'title'   - Document title and redirecting heading.
     *   'message' - Redirecting message.
     *   'time'    - Time to refresh redirecting page.
     *   'page'    - Redirecting page, that refreshing redirecting page after finish time.
     * @access public.
     */
    public static function success ($data)
    {
        self::display('redirecting','capanel',$data);
    }

    /**
     * Get CAPanel name as url as in example http://www.example.com/capanel/{name here}.
     * You must know this function will get $_config['cap']['name'] value from Configuration file.
     *
     * @param (string) $name - page name.
     * @access public..
     */
    public static function url ($name="")
    {
        return C_URL.self::get_info('name').DS.$name;
    }

    /**
     * Get to router prefix value from $_config['cap']['name'].
     * This function set a new name for capanel url,
     * as in exmaple if $_config['cap']['name'] value is 'Admin' you will get a urls that beginning with http://example/Admin.
     *
     * @param (string) $name - Regex string.
     * @access public.
     */
    public static function router ($name)
    {
        return self::get_info('router').$name;
    }

    /**
     * Set a home router rule.
     *
     * @access protected.
     */
    protected static function home_router_rules ()
    {
        cliprz::system(router)->rule(array(
            "regex" => self::router('home'),
            "class" => 'capanel_home',
            "path"  => 'capanel'
        ));

        cliprz::system(router)->rule(array(
            "regex"    => self::router('get_tables'),
            "class"    => 'capanel_home',
            "path"     => 'capanel',
            "function" => "get_tables",
            "method"   => "POST"
        ));

        cliprz::system(router)->rule(array(
            "regex"    => self::router('get_primary_key'),
            "class"    => 'capanel_home',
            "path"     => 'capanel',
            "function" => "get_primary_key",
            "method"   => "POST"
        ));

        cliprz::system(router)->rule(array(
            "regex"    => self::router('create'),
            "class"    => 'capanel_home',
            "path"     => 'capanel',
            "function" => "create",
            "method"   => "POST"
        ));
    }

    /**
     * Goto list, The side panel lists.
     *
     * @param (string) $title - Goto list title.
     * @param (string) $data  - Goto list data key = URL and value => title as in example array("users/add"=>"Add new user").
     * @access public.
     */
    public static function go2 ($title,$list)
    {
        if (is_array($list))
        {
            $goto = C_CRNL;
            $goto .= '<div class="goto">';
            $goto .= C_CRNL.C_T;
            $goto .= '<div class="goto-title">';
            $goto .= C_CRNL.C_T;
            $goto .= '<div class="goto-suject">'.$title.'</div>';
            $goto .= C_CRNL.C_T;
            $goto .= '<div class="goto-chevron"><a class="shown" href=""><img src="'.self::get_image('chevron-expand.png').'" alt="" /></a></div>';
            $goto .= C_CRNL.C_T;
            $goto .= '<div class="clear"></div>';
            $goto .= C_CRNL.C_T;
            $goto .= '</div>';
            $goto .= C_CRNL.C_T;
            $goto .= '<div class="goto-list">';
            $goto .= C_CRNL.C_T.C_T;
            $goto .= '<ul>';

            foreach ($list as $key => $value)
            {
                $goto .= C_CRNL.C_T.C_T.C_T;
                $goto .= '<li><a href="'.self::url($key).'">'.$value.'</a></li>';
            }

            $goto .= C_CRNL.C_T.C_T;
            $goto .= '</ul>';
            $goto .= C_CRNL.C_T;
            $goto .= '</div>';
            $goto .= C_CRNL;
            $goto .= '</div>';
            $goto .= C_CRNL;
            return $goto;
        }
    }

    /**
     * Add data to goto.cap.php (List).
     *
     * @param (string) $title - List title.
     * @param (array)  $data  - Create posts data.
     * @access protected.
     */
    protected static function add_to_go2 ($title,$data)
    {
        if (is_array($data))
        {
            $list = array();

            $goto = C_CRNL;
            $goto .= 'echo cliprz::system(cap)->go2("'.$title.'",array(';
            //$goto .= C_CRNL.C_T;

            if ($data['use_primary_key'] == 1)
            {
                $goto .= C_CRNL.C_T;
                $goto .= '\''.$title.'/show\' => \'Show results\',';
            }
            else
            {
                $goto .= C_CRNL.C_T;
                $goto .= '\''.$title.'/update\' => \'Update\',';
            }

            if ($data['use_add_action'] == 1)
            {
                $goto .= C_CRNL.C_T;
                $goto .= '\''.$title.'/add\' => \'Add new\',';
            }

            if ($data['use_repair_action'] == 1)
            {
                $goto .= C_CRNL.C_T;
                $goto .= '\''.$title.'/repair\' => \'Repair '.$title.' table\',';
            }

            if ($data['use_optimize_action'] == 1)
            {
                $goto .= C_CRNL.C_T;
                $goto .= '\''.$title.'/optimize\' => \'Optimize '.$title.' table\',';
            }

            $goto .= C_CRNL;
            $goto .= '));';
            $goto .= C_CRNL;

            // Add now for cap_goto
            $go2_path = self::get_info('view_path').'capanel'.DS.'goto'.self::$capanel_extension;

            if (file_exists($go2_path))
            {

                c_file_put_contents($go2_path,$goto,FILE_APPEND);
            }
            else
            {
                trigger_error($go2_path.' Not founded.');
            }
        }
    }

    /**
     * Add a new data to controller.
     *
     * @param (string) $filename   - Data file name, this files founded in BASE_PATH/cliprz_system/capanel/data/{$filename}
     * @param (string) $controller - Controller name that you want to add data inside him.
     * @param (mixed)  $search     - Search for some data to replace with {$replace} parameter.
     * @param (mixed)  $replace    - Replace data as string or array.
     * @access protected.
     */
    protected static function add_to_controller ($filename,$controller,$search=null,$replace=null)
    {
        $data = self::get_info('data_path').$filename.'.cliprz';

        if (file_exists($data))
        {
            $contents = c_file_get_contents($data);

            if ($search != null || $replace != null)
            {
                $filter_data = str_replace($search,$replace,$contents);
                c_file_put_contents($controller,$filter_data,FILE_APPEND);
            }
            else
            {
                c_file_put_contents($controller,$contents,FILE_APPEND);
            }
        }
    }

    /**
     * Add a new data to file.
     *
     * @param (string) $filename   - Data file name, this files founded in BASE_PATH/cliprz_system/capanel/data/{$filename}
     * @param (string) $viewfile   - View file name that you want to add data inside him.
     * @param (mixed)  $search     - Search for some data to replace with {$replace} parameter.
     * @param (mixed)  $replace    - Replace data as string or array.
     * @access protected.
     */
    protected static function add_to_file ($filename,$viewfile,$search=null,$replace=null)
    {
        $data = self::get_info('data_path').$filename.'.cliprz';

        if (file_exists($data))
        {
            $contents = c_file_get_contents($data);

            if ($search != null || $replace != null)
            {
                $filter_data = str_replace($search,$replace,$contents);
                c_file_put_contents(self::get_info('view_path').$viewfile.self::$capanel_extension,$filter_data,FILE_APPEND);
            }
            else
            {
                c_file_put_contents(self::get_info('view_path').$viewfile.self::$capanel_extension,$contents,FILE_APPEND);
            }
        }
    }


    /**
     * Create new CAPanel data.
     *
     * @param (array) $data - Posts data from create form.
     * @access public.
     */
    public static function create ($data)
    {
        // Check if data array or not.
        if (is_array($data))
        {
            // Get table name from database without prefix.
            $name = self::remove_database_prefix($data['table']);
            $name = c_mb_strtolower($name);

            // Get primary key if exists.
            $primary_key = (isset($data['primary_key'])) ? c_mb_strtolower($data['primary_key']) : NULL;

            // Set a new controller folder path with name variable to use it in this function.
            $controller_folder_name = self::get_info('controller_path').$name.DS;

            // Set new view folder path with name variable to use it in this function.
            $view_folder_name = self::get_info('view_path').$name.DS;

            // Check if is folders with same names
            if (is_dir($controller_folder_name) || is_dir($view_folder_name))
            {
                self::set_error('We cannot create new CAPanel settings because there a controller beofre.');
                return false;
            }
            else
            {
                // Create controller path and files.
                if (c_mkdir($controller_folder_name,0777))
                {
                    // Controller file name.
                    $controller = $controller_folder_name.self::$capanel_prefix.$name.'.php';

                    // Create index.php and new controller php file.
                    c_file_put_contents($controller,'');

                    // add to controller new class that names like table name in database without prefix.
                    self::add_to_controller(
                        'starting.controller',
                        $controller,
                        array('{tablename}','{date}'),
                        array($name,date("d/m/Y h:s A",TIME_NOW))
                    );

                    // Create index.php
                    c_create_index($controller_folder_name);

                    // Create a view path and files. by the way CAPanel view folder is (cliprz_cliprz_application/capanel/) path.
                    if (c_mkdir($view_folder_name,0777))
                    {
                        // Create index.php
                        c_create_index($view_folder_name);

                        // Now create the main files.

                        // Create show page if $data['use_primary_key'] == 1
                        if ($data['use_primary_key'] == 1)
                        {
                            // Create a show.cap.php in capanel view folder.
                            c_file_put_contents($view_folder_name.'show'.self::$capanel_extension,'');

                            // Create show tables inside show.cap.php
                            self::create_show_tables ($name,$primary_key,$data['use_edit_action'],$data['use_delete_action']);

                            // Add show method to controller.
                            self::add_to_controller(
                                'methods/show',
                                $controller,
                                array('{tablename}'),
                                array($name)
                            );

                            // Add to capanel router new show rules.
                            self::add_to_router ($name,array(
                                "regex"      => "show/page/:INT",
                                "function"   => "show",
                                "parameters" => "array(4)"
                            ));

                            self::add_to_router ($name,array(
                                "regex"    => "show",
                                "function" => "show"
                            ));

                        }

                        // Create add form if $data['use_primary_key'] == 1 and $data['use_add_action'] == 1.
                        if ($data['use_primary_key'] == 1 && $data['use_add_action'] == 1)
                        {
                            // Create a add.cap.php file in capanel view folder.
                            c_file_put_contents($view_folder_name.'add'.self::$capanel_extension,'');

                            // Add add method to controller.
                            self::add_to_controller('methods/add',$controller,'{tablename}',$name);

                            // Create add form.
                            self::create_add_form ($name,$primary_key);

                            // Add show rules to router.
                            self::add_to_router ($name,array(
                                "regex"    => "add",
                                "function" => "add"
                            ));

                            self::add_to_router ($name,array(
                                "regex"    => "add/check",
                                "function" => "add",
                                "method"   => "POST"
                            ));
                        }

                        // Create edit form.
                        if ($data['use_primary_key'] == 1 && $data['use_edit_action'] == 1)
                        {
                            c_file_put_contents($view_folder_name.'edit'.self::$capanel_extension,'');

                            self::add_to_controller(
                                'methods/edit',
                                $controller,
                                array('{tablename}','{primarykey}'),
                                array($name,$primary_key)
                            );

                            self::create_edit_form($name,$primary_key);

                            self::add_to_router ($name,array(
                                "regex"      => "edit/:ANY/check",
                                "function"   => "edit",
                                "parameters" => "array(3)",
                                "method"     => "POST"
                            ));

                            self::add_to_router ($name,array(
                                "regex"      => "edit/:ANY",
                                "function"   => "edit",
                                "parameters" => "array(3)"
                            ));

                        }

                        // If primary key value is false create a update forum only.
                        if ($data['use_primary_key'] == 0)
                        {
                            c_file_put_contents($view_folder_name.'update'.self::$capanel_extension,'');

                            self::add_to_controller('methods/update',$controller,'{tablename}',$name);

                            self::create_update_form($name);

                            self::add_to_router ($name,array(
                                "regex"      => "update/check",
                                "function"   => "update",
                                "method"     => "POST"
                            ));

                            self::add_to_router ($name,array(
                                "regex"      => "update",
                                "function"   => "update"
                            ));

                        }

                        // Create delete method.
                        if ($data['use_delete_action'] == 1)
                        {
                            self::add_to_router ($name,array(
                                "regex"      => "delete/:ANY",
                                "function"   => "delete",
                                "parameters" => "array(3)",
                            ));

                            self::add_to_controller(
                                'methods/delete',
                                $controller,
                                array('{tablename}','{primarykey}'),
                                array($name,$primary_key)
                            );
                        }

                        if ($data['use_repair_action'] == 1)
                        {
                            self::add_to_router ($name,array(
                                "regex"      => "repair",
                                "function"   => "repair"
                            ));

                            self::add_to_controller('methods/repair',$controller,'{tablename}',$name);
                        }

                        if ($data['use_optimize_action'] == 1)
                        {
                            self::add_to_router ($name,array(
                                "regex"      => "optimize",
                                "function"   => "optimize"
                            ));

                            self::add_to_controller('methods/optimize',$controller,'{tablename}',$name);
                        }

                        // Add posts
                        c_file_put_contents($controller,self::create_posts_method($name,$primary_key),FILE_APPEND);
                        self::add_to_controller('ending.controller',$controller);

                        self::add_to_go2($name,$data);

                        unset($data);

                        return true;

                    }
                    else
                    {
                        self::set_error('Cannot create '.$view_folder_name.' folder.');
                        return false;
                    }

                }
                else
                {
                    self::set_error('Cannot create '.$controller_folder_name.' folder.');
                    return false;
                }
            }
        }
        else
        {
            self::set_error('Data not array.');
            return false;
        }
    }

    /**
     * Add new rules in cap_router.php file.
     *
     * @param (string) $name - Regex,path and controller name.
     * @param (array)  $data - data array like router system data.
     * @access protected.
     */
    protected static function add_to_router ($name,$data)
    {
        if (is_array($data))
        {
            $router = C_CRNL.C_CRNL;
            $router .= 'cliprz::system(router)->rule(array(';
            $router .= C_CRNL.C_T;
            $router .= '"regex" => cliprz::system(cap)->router("'.$name.DS.c_trim_path($data['regex']).'"),';
            $router .= C_CRNL.C_T;
            $router .= '"class" => "'.self::$capanel_prefix.$name.'",';
            $router .= C_CRNL.C_T;
            $router .= '"path"  => "capanel/'.$name.'",';

            if (isset($data['method']) && !empty($data['method']))
            {
                $router .= C_CRNL.C_T;
                $router .= '"method"  => "'.$data['method'].'",';
            }

            if (isset($data['parameters']) && !empty($data['parameters']))
            {
                $router .= C_CRNL.C_T;
                $router .= '"parameters" => '.$data['parameters'].',';
            }

            $router .= C_CRNL.C_T;
            $router .= '"function"  => "'.$data['function'].'"';

            $router .= C_CRNL;
            $router .= '));';

            c_file_put_contents(APP_PATH.'config/cap_router.php',$router,FILE_APPEND);

            unset($router);
        }
        else
        {
            return false;
        }
    }

    /**
     * Create a add new data form.
     *
     * @param (string) $table       - Table name without prefix.
     * @param (string) $primary_key - Primary key.
     * @access protected.
     */
    protected static function create_add_form ($table,$primary_key)
    {
        self::add_to_file ('forms/starting.add',$table.DS.'add','{tablename}',$table);

        // Query to show all columns in table.
        $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".C_DATABASE_PREFIX.$table."`");

        $tbl = 1;

        $form = '';

        while ($row = cliprz::system(database)->fetch_array($query))
        {

            if ($tbl > 2)
            {
                $tbl = 1;
            }

            if ($row[0] == $primary_key)
            {
                continue;
            }

            self::add_to_file ('forms/data.add',$table.DS.'add',
                array('{filterrowname}','{rowname}','{tbl}'),
                array(self::filter_column_name($row[0]),$row[0],$tbl));

            ++$tbl;
        }

        cliprz::system(database)->free_result($query);

        self::add_to_file ('forms/ending.add',$table.DS.'add');

    }

    /**
     * Create a edit data form.
     *
     * @param (string) $table       - Table name without prefix.
     * @param (string) $primary_key - Primary key.
     * @access protected.
     */
    protected static function create_edit_form ($table,$primary_key)
    {
        self::add_to_file ('forms/starting.edit',$table.DS.'edit',
            array('{tablename}','{where}'),
            array($table,$primary_key));

        // Query to show all columns in table.
        $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".C_DATABASE_PREFIX.$table."`");

        $tbl = 1;

        $form = '';

        while ($row = cliprz::system(database)->fetch_array($query))
        {

            if ($tbl > 2)
            {
                $tbl = 1;
            }

            if ($row[0] == $primary_key)
            {
                continue;
            }

            self::add_to_file ('forms/data.edit',$table.DS.'edit',
                array('{filterrowname}','{rowname}','{tbl}'),
                array(self::filter_column_name($row[0]),$row[0],$tbl));

            ++$tbl;
        }

        cliprz::system(database)->free_result($query);

        self::add_to_file ('forms/ending.edit',$table.DS.'edit','{tablename}',$table);

    }

    /**
     * Create a update data form.
     *
     * @param (string) $table - Table name without prefix.
     * @access protected.
     */
    protected static function create_update_form ($table)
    {
        self::add_to_file ('forms/starting.update',$table.DS.'update','{tablename}',$table);

        // Query to show all columns in table.
        $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".C_DATABASE_PREFIX.$table."`");

        $tbl = 1;

        $form = '';

        while ($row = cliprz::system(database)->fetch_array($query))
        {

            if ($tbl > 2)
            {
                $tbl = 1;
            }

            self::add_to_file ('forms/data.edit',$table.DS.'update',
                array('{filterrowname}','{rowname}','{tbl}'),
                array(self::filter_column_name($row[0]),$row[0],$tbl));

            ++$tbl;
        }

        cliprz::system(database)->free_result($query);

        self::add_to_file ('forms/ending.update',$table.DS.'update','{tablename}',$table);

    }

    /**
     * Create s show table, to display results as table.
     *
     * @param (string) $table       - Table name without prefix.
     * @param (string) $primary_key - Primary key.
     * @access protected.
     */
    protected static function create_show_tables ($table,$primary_key,$use_edit_action,$use_delete_action)
    {
        self::add_to_file ('tables/starting.show',$table.DS.'show',
            array('{tablename}','{colspan}','{filtertablename}','{filterprimarykey}','{filterstartingrow}'),
            array($table,3,self::filter_column_name($table),self::filter_column_name($primary_key),'Data'));

        $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".C_DATABASE_PREFIX.$table."`");

        $loop_time = 1;

        if ($use_edit_action == 1)
        {
            $edit_link = '<a class="edit show_tipsy" title="Edit" href="<?php echo cliprz::system(cap)->url("'.$table.'/edit/".$row[\''.$primary_key.'\']); ?>"><img src="<?php echo cliprz::system(cap)->get_image(\'edit.png\'); ?>" alt="Edit" /></a>&nbsp;';
        }
        else
        {
            $edit_link = '';
        }

        if ($use_delete_action == 1)
        {
            $delete_link = '&nbsp;<a onclick="return confirm(\'Are you sure about deleting ?\');" class="delete show_tipsy" title="Delete" href="<?php echo cliprz::system(cap)->url("'.$table.'/delete/".$row[\''.$primary_key.'\']); ?>"><img src="<?php echo cliprz::system(cap)->get_image(\'trash.png\'); ?>" alt="Delete" /></a>';
        }
        else
        {
            $delete_link = '';
        }

        while ($row = cliprz::system(database)->fetch_array($query))
        {

            if ($loop_time > 1) { break; }

            if ($row[0] == $primary_key)
            {
                continue;
            }

            self::add_to_file ('tables/data.show',$table.DS.'show',
                array('{primarykey}','{startingrow}','{editlink}','{deletelink}'),
                array($primary_key,$row[0],$edit_link,$delete_link));

            ++$loop_time;

        }

        cliprz::system(database)->free_result($query);

        self::add_to_file ('tables/ending.show',$table.DS.'show','{colspan}',3);

    }

    /**
     * Create a $_POST(s) for the new controller, thats help you to handling posts with databases.
     *
     * @param (string) $table       - Table name without prefix.
     * @param (string) $primary_key - Primary key.
     * @access protected.
     */
    protected static function create_posts_method ($table,$primary_key)
    {
        // Query to show all columns in table.
        $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".C_DATABASE_PREFIX.$table."`");

        $method = C_CRNL.C_T;
        $method .= '/**';
        $method .= C_CRNL.C_T;
        $method .= ' * '.self::filter_column_name($table).' Posts.';
        $method .= C_CRNL.C_T;
        $method .= ' *';
        $method .= C_CRNL.C_T;
        $method .= ' * @access public.';
        $method .= C_CRNL.C_T;
        $method .= ' */';
        $method .= C_CRNL.C_T;
        $method .= 'public function '.$table.'_posts ()';
        $method .= C_CRNL.C_T;
        $method .= '{';
        $method .= C_CRNL.C_T.C_T;
        $method .= 'return array(';

        while ($row = cliprz::system(database)->fetch_array($query))
        {

            if ($row[0] == $primary_key)
            {
                continue;
            }

            $method .= C_CRNL.C_T.C_T.C_T;
            $method .= '\''.$row[0].'\' => (isset($_POST[\''.$row[0].'\'])) ? $_POST[\''.$row[0].'\'] : NULL,';

        }

        $method .= C_CRNL.C_T.C_T;
        $method .= ');';
        $method .= C_CRNL.C_T;
        $method .= '}';
        $method .= C_CRNL.C_CRNL;

        cliprz::system(database)->free_result($query);

        return $method;
    }

}

?>