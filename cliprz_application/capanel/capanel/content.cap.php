<table>
    <thead>
    <tr>
        <td colspan="2">Information</td>
    </tr>
    </thead>
    <tbody>
        <tr>
            <td class="tbl1" style="width: 50%;">PHP version : <?php echo phpversion(); ?></td>
            <td class="tbl2" style="width: 50%;">Cliprz framework version : <?php echo cliprz::get_framework('version'); ?></td>
        </tr>
        <tr>
            <td class="tbl2" style="width: 50%;">Safe mode : <?php echo (ini_get('safe_mode') == true) ? 'On' : 'Off'; ?></td>
            <td class="tbl1" style="width: 50%;">Magic Quotes : <?php echo (get_magic_quotes_gpc() == true) ? 'On' : 'Off'; ?></td>
        </tr>
    </tbody>
</table>
<div class="br">&nbsp;</div>