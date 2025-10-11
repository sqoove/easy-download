<?php
if((isset($_GET['output'])) && ($_GET['output'] === 'updated'))
{
    $notice = array('success', __('Your link have been successfully added.', 'easy-download'));
}
elseif((isset($_GET['output'])) && ($_GET['output'] === 'deleted'))
{
    $notice = array('success', __('Your link have been successfully deleted.', 'easy-download'));
}
?>
<div class="wrap">
    <section class="wpbnd-wrapper">
        <div class="wpbnd-container">
            <div class="wpbnd-tabs">
                <?php echo $this->return_plugin_header(); ?>
                <main class="tabs-main">
                    <?php echo $this->return_tabs_menu('tab3'); ?>
                    <section class="tab-section">
                        <?php if(isset($notice)) { ?>
                        <div class="wpbnd-notice <?php echo esc_attr($notice[0]); ?>">
                            <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                            <span><?php echo esc_attr($notice[1]); ?></span>
                        </div>
                        <?php } ?>
                        <div class="wpbnd-datatables">
                            <table id="links-table" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo _e('Link', 'easy-download'); ?></th>
                                        <th><?php echo _e('UUID', 'easy-download'); ?></th>
                                        <th><?php echo _e('Click', 'easy-download'); ?></th>
                                        <th><?php echo _e('Operate', 'easy-download'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $links = unserialize($opts);
                                    foreach($links as $key => $val)
                                    {
                                        $uuid = esc_sql($key);
                                        $sql = "SELECT SUM(`count`) as `count` FROM `".$wpdb->prefix."downloads` WHERE `uuid` = '".$uuid."'";
                                        $res = $wpdb->get_results($sql);
                                        if(empty($res))
                                        {
                                            $count = '0';
                                        }
                                        else
                                        {
                                            $count = $res[0]->count;
                                        }

                                        $table = '<tr>';
                                        $table.= '<td class="wpbnd-txt-l">'.$val.'</td>';
                                        $table.= '<td class="wpbnd-txt-c">'.$key.'</td>';
                                        $table.= '<td class="wpbnd-txt-c">'.$count.'</td>';
                                        $table.= '<td class="wpbnd-txt-c">';

                                        $table.= '<form method="POST">';
                                        $table.= '<input type="hidden" name="edw-delete-links" value="true" />';
                                        $table.= wp_nonce_field('edw-referer-form', 'edw-referer-delete');
                                        $table.= '<input type="hidden" name="_easy_download_links[uuid]" value="'.$key.'" />';
                                        $table.= '<button type="submit" class="button button-danger">'.__('Remove', 'easy-download').'</button>';
                                        $table.= '</form>';

                                        $table.= '</td>';
                                        $table.= '</tr>';
                                        echo $table;
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><?php echo _e('Link', 'easy-download'); ?></th>
                                        <th><?php echo _e('UUID', 'easy-download'); ?></th>
                                        <th><?php echo _e('Click', 'easy-download'); ?></th>
                                        <th><?php echo _e('Operate', 'easy-download'); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </section>
                </main>
            </div>
        </div>
    </section>
</div>