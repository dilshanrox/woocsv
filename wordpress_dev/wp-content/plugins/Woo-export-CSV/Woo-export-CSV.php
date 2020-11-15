<?php
/*
Plugin Name: WooCommerce Export CSV / Excel or PDF
Description: This plugin is developed by Dilshan
Author: Dilshan Chandrasekara
Version: 1.0
Author URI: https://www.fiverr.com/dilshanrox
Text Domain: dilshan
 */


add_action('admin_menu', 'export_csv_menu');
add_action('admin_enqueue_scripts', 'package_css');
add_action('admin_enqueue_scripts', 'package_js');

//hook to add a new button to order page called Custom Export to CSV/Excel/PDF
add_action('manage_posts_extra_tablenav', 'admin_custom_export_button', 20, 1);
function admin_custom_export_button()
{
    if (isset($_GET['post_type']) == 'shop_order') {
?>
        <div class="alignleft actions custom">
            <a href="admin.php?page=export_csv_menu" style="height:32px;" class="button-primary">
                <?php
                echo __('Custom Export to CSV/Excel/PDF', 'woocommerce');
                ?>
            </a>
        </div>
    <?php
    }
}

//hook to add a new button to order page called Get CSV
add_action('manage_posts_extra_tablenav', 'admin_qucik_export_button', 20, 1);
function admin_qucik_export_button()
{
    if (isset($_GET['post_type']) == 'shop_order') {
    ?>
        <a href="edit.php?post_type=shop_order&export_post=csv" style="height:32px;" class="button-primary">
            <?php
            echo __('Export CSV', 'woocommerce');
            ?>
        </a>
    <?php
    }
}

add_action('init', 'quick_csv_export');

function quick_csv_export()
{
    if (isset($_GET['export_post']) == 'csv') {

        //csv generator function
        function outputCsv($fileName, $assocDataArray)
        {
            ob_clean();
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Cache-Control: private', false);
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment;filename=' . $fileName);
            if (isset($assocDataArray['0'])) {
                $fp = fopen('php://output', 'w');
                fputcsv($fp, array_keys($assocDataArray['0']));
                foreach ($assocDataArray as $values) {
                    fputcsv($fp, $values);
                }
                fclose($fp);
            }
            ob_flush();
        }

        //getting data
        $args = array(
            'limit' => -1,
        );
        $orders = wc_get_orders($args);
        $data = array();

        foreach ($orders as $id_key => $order) {
            $order_meta = get_post_custom($order->get_id());
            $user_full_name = $order_meta['_billing_first_name'][0] . " " . $order_meta['_billing_last_name'][0];
            $currency_format = '$' . $order->get_total();
            array_push($data, array(
                "Order placed date" => $order->get_date_created(),
                "Order Number" => $order->get_id(),
                "Name of customer" => $user_full_name,
                "Order status" => $order->get_status(),
                "Order total" => $currency_format
            ));
        }
        outputCsv('myorderlist.csv', $data);
        exit;
    }
}

function export_csv_menu()
{
    add_menu_page('Export Orders', 'Export Orders', 'manage_woocommerce', 'export_csv_menu', 'export_csv_dashboard', '', 200);
}

function package_css()
{

    if (isset($_GET['page']) == 'export_csv_menu') {
        // list of styles used
        wp_enqueue_style('bootstrapStyle', plugins_url('/assets/css/bootstrap.min.css', __FILE__), '', '', false);
        wp_enqueue_style('bootstrapDataTableStyle', plugins_url('/assets/css/dataTables.bootstrap.min.css', __FILE__), '', '', false);
        wp_enqueue_style('dataTableButtonStyle', plugins_url('/assets/css/buttons.dataTables.min.css', __FILE__), '', '', false);
    }
}

function package_js()
{

    if (isset($_GET['page']) == 'export_csv_menu') {
        // list of scripts used
        wp_register_script('bootstrapJS', plugins_url() . '/Woo-export-CSV/assets/js/dataTables.bootstrap.min.js');
        wp_enqueue_script('bootstrapJS');

        wp_register_script('jqueryJS', plugins_url() . '/Woo-export-CSV/assets/js/jquery-3.5.1.js');
        wp_enqueue_script('jqueryJS');

        wp_register_script('dataTableJS', plugins_url() . '/Woo-export-CSV/assets/js/jquery.dataTables.min.js');
        wp_enqueue_script('dataTableJS');

        wp_register_script('dataTableJSButtons', plugins_url() . '/Woo-export-CSV/assets/js/dataTables.buttons.min.js');
        wp_enqueue_script('dataTableJSButtons');

        wp_register_script('dataTableJSHTML5', plugins_url() . '/Woo-export-CSV/assets/js/buttons.html5.min.js');
        wp_enqueue_script('dataTableJSHTML5');

        wp_register_script('dataTableJSZIP', plugins_url() . '/Woo-export-CSV/assets/js/jszip.min.js');
        wp_enqueue_script('dataTableJSZIP');

        wp_register_script('dataTableJSPDF', plugins_url() . '/Woo-export-CSV/assets/js/pdfmake.min.js');
        wp_enqueue_script('dataTableJSPDF');

        wp_register_script('dataTableJSVFS', plugins_url() . '/Woo-export-CSV/assets/js/vfs_fonts.js');
        wp_enqueue_script('dataTableJSVFS');

        wp_register_script('customJS', plugins_url() . '/Woo-export-CSV/assets/js/custom.js');
        wp_enqueue_script('customJS');
    }
}

function export_csv_dashboard()
{
    //showing the results if woocommerce is active
    if (class_exists('woocommerce')) {

        $args = array(
            'limit' => -1,
        );
        $orders = wc_get_orders($args);
        $data = "";

        foreach ($orders as $id_key => $order) {

            $order_meta = get_post_custom($order->get_id());
            $data .= "<tr>
            <td>" . $order->get_date_created() . "</td>
            <td>" . $order->get_id() . "</td>
            <td>" . $order_meta['_billing_first_name'][0] . " " . $order_meta['_billing_last_name'][0] . "</td>
            <td>" . $order->get_status() . "</td>
            <td>" . $order->get_total() . "</td>";
        }

    ?>

        <div class="container">
            <!-- Example row of columns -->
            <div class="row">
                <div class="col-md-12">

                    <h2>WooCommerce Order Export </h2>
                    <p>Export your cutormers orders to CSV,PDF or Excel in a one place</p>

                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <th>Order placed date</th>
                            <th>Order Number</th>
                            <th>Name of customer </th>
                            <th>Order status </th>
                            <th>Order total ($)</th>
                        </thead>
                        <tbody>
                            <?php echo $data; ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>

<?php
    } else {
        echo '<div class="error notice">
        <p>It\'s required to install and enable WooCommerce plugin to get this feature!</p>
        </div>';
    }
}

?>