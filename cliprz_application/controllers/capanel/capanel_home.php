<?php

class capanel_home
{

    /**
     * Create new CAPanel.
     *
     * @access public.
     */
    public function index ()
    {
        global $_config;

        cliprz::system(cap)->set_title("Welcome to CAP");

        cliprz::system(cap)->display('header','capanel');
        cliprz::system(cap)->display('content','capanel');
        cliprz::system(cap)->display('create','capanel');
        cliprz::system(cap)->display('footer','capanel');
        //cliprz::system(cap)->display('login','capanel');
    }

    public function get_tables ()
    {
        global $_config;

        if (isset($_POST['create']) && $_POST['create'] == 'new')
        {
            $query = cliprz::system(database)->query("SHOW TABLES FROM `".$_config['db']['name']."`");

            if (cliprz::system(database)->num_rows($query))
            {
                echo '<select name="table" id="table">';
                echo '<option>Choose a table</option>';
                while ($row = cliprz::system(database)->fetch_array($query))
                {
                    echo '<option value="'.$row[0].'">'.$row[0].'</option>';
                }
                echo '</select>';
                cliprz::system(database)->free_result($query);
            }
            else
            {
                echo "No tables in database ".$_config['db']['name'];
            }
        }
        else
        {
            echo "Unknown error";
        }
    }

    /**
     * Create a select tag for table Primary key.
     *
     * @access public.
     */
    public function get_primary_key ()
    {
        // Check if post create and value is new.
        if (isset($_POST['create']) && $_POST['create'] == 'new')
        {
            // Get post table value.
            $table = (isset($_POST['table']))
                ? cliprz::system(database)->res($_POST['table'])
                : '';

            // Query to show all columns in table.
            $query = cliprz::system(database)->query("SHOW COLUMNS FROM `".$table."`");

            // If table have columns show columns as HTML tag select with options
            if (cliprz::system(database)->num_rows($query))
            {
                echo '
                <select name="primary_key" id="primary_key">
                    <option value="">Primary key is</option>
                    ';
                    while ($row = cliprz::system(database)->fetch_array($query))
                    {
                    echo '<option value="'.$row[0].'">'.$row[0].'</option>';
                    }
                    cliprz::system(database)->free_result($query);
                echo '
                </select>&nbsp;
                ';
            }
            else // If table dose not have columns show errors.
            {
                echo "No COLUMNS in ".$table." Table.";
            }
        }
    }

    /**
     * Create new settings in CAPanel.
     *
     * @access public.
     */
    public function create ()
    {
        // If isset create and create value is new.
        if (isset($_POST['create']) && $_POST['create'] == 'new')
        {

            $data = array(
                'table'               => (isset($_POST['table'])) ? cliprz::system(database)->res($_POST['table']) : '',
                'use_primary_key'     => (isset($_POST['use_primary_key'])) ? intval($_POST['use_primary_key']) : 0,
                'primary_key'         => (isset($_POST['primary_key'])) ? cliprz::system(database)->res($_POST['primary_key']) : '',
                'use_add_action'      => (isset($_POST['use_add_action'])) ? intval($_POST['use_add_action']) : 0,
                'use_edit_action'     => (isset($_POST['use_edit_action'])) ? intval($_POST['use_edit_action']) : 0,
                'use_delete_action'   => (isset($_POST['use_delete_action'])) ? intval($_POST['use_delete_action']) : 0,
                'use_repair_action'   => (isset($_POST['use_repair_action'])) ? intval($_POST['use_repair_action']) : 0,
                'use_optimize_action' => (isset($_POST['use_optimize_action'])) ? intval($_POST['use_optimize_action']) : 0);

            if (cliprz::system(cap)->create($data))
            {
                echo 1;
            }
            else
            {
                echo cliprz::system(cap)->get_error();
            }

            unset($data);
        }
    }

}

?>