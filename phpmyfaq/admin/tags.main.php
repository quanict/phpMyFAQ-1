<?php
/**
 * Frontend for Backup and Restore
 *
 * PHP Version 5.4
 *
 * This Source Code Form is subject to the terms of the Mozilla Public License,
 * v. 2.0. If a copy of the MPL was not distributed with this file, You can
 * obtain one at http://mozilla.org/MPL/2.0/.
 *
 * @category  phpMyFAQ
 * @package   Administration
 * @author    Thorsten Rinne <thorsten@phpmyfaq.de>
 * @copyright 2003-2014 phpMyFAQ Team
 * @license   http://www.mozilla.org/MPL/2.0/ Mozilla Public License Version 2.0
 * @link      http://www.phpmyfaq.de
 * @since     2003-02-24
 */

if (!defined('IS_VALID_PHPMYFAQ')) {
    $protocol = 'http';
    if (isset($_SERVER['HTTPS']) && strtoupper($_SERVER['HTTPS']) === 'ON'){
        $protocol = 'https';
    }
    header('Location: ' . $protocol . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']));
    exit();
}

?>
    <header class="row">
        <div class="col-lg-12">
            <h2 class="page-header">
                <i class="fa fa-tags"></i> <?php echo $PMF_LANG['ad_entry_tags'] ?>
            </h2>
        </div>
    </header>

    <div class="row">
        <div class="col-lg-12">

<?php
if ($user->perm->checkRight($user->getUserId(), 'editbt')) {

    $tags = new PMF_Tags($faqConfig);

    if ('deletetag' == $action) {
        $id = PMF_Filter::filterInput(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($tags->deleteTag($id)) {
            echo '<p class="alert alert-success"><a href="#" class="close" data-dismiss="alert">×</a>';
            echo $PMF_LANG['ad_tag_delete_success'] . '</p>';
        } else {
            echo '<p class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">×</a>';
            echo $PMF_LANG['ad_tag_delete_error'];
            echo '<br />'.$PMF_LANG["ad_adus_dberr"].'<br />';
            echo $faqConfig->getDb()->error() . '</p>';
        }
    }

    $tagData = $tags->getAllTags();

    echo '<table class="table table-striped">';
    echo '<tbody>';

    foreach ($tagData as $key => $tag) {

        echo '<tr>';
        echo '<td>' . $tag . '</td>';
        echo '<td>edit</td>';

        printf(
            '<td><a class="btn btn-danger" onclick="return confirm(\'%s\'); return false;" href="%s%d">',
            $PMF_LANG['ad_user_del_3'],
            '?action=deletetag&amp;id=',
            $key
        );
        printf(
            '<span title="%s"><i class="fa fa-trash-o"></i></span></a></td>',
            $PMF_LANG['ad_entry_delete']
        );

        echo '<tr>';
    }

    echo '</tbody>';
    echo '</table>';

} else {
    echo $PMF_LANG["err_NotAuth"];
}
?>
        </div>
    </div>