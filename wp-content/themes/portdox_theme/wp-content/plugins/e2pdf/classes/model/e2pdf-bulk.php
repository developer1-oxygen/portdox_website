<?php

/**
 * E2pdf Bulk Model
 * 
 * @copyright  Copyright 2017 https://e2pdf.com
 * @license    GPLv3
 * @version    1
 * @link       https://e2pdf.com
 * @since      0.00.01
 */
if (!defined('ABSPATH')) {
    die('Access denied.');
}

class Model_E2pdf_Bulk extends Model_E2pdf_Model {

    private $table;
    private $bulk = array();

    function __construct() {
        global $wpdb;
        parent::__construct();
        $this->table = $wpdb->prefix . 'e2pdf_bulks';
        $this->key = hash('sha256', md5(NONCE_KEY));
    }

    public function load($bulk_id) {
        global $wpdb;

        $bulk = false;
        if ($this->helper->get('cache')) {
            $bulk = wp_cache_get($bulk_id, 'e2pdf_bulks');
        }

        if ($bulk === false) {
            $this->helper->clear_cache();
            $bulk = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->get_table()}` WHERE ID = %d", $bulk_id), ARRAY_A);
            if ($this->helper->get('cache')) {
                wp_cache_set($bulk_id, $bulk, 'e2pdf_bulks');
            }
        }

        if ($bulk) {
            $this->bulk = $bulk;
            $template = new Model_E2pdf_Template();
            if ($this->get('template_id') && $template->load($this->get('template_id'), false)) {
                $this->set('template', $template);
            }
            $this->set('options', unserialize($bulk['options']));
            $this->set('datasets', unserialize($bulk['datasets']));
            return true;
        }
        return false;
    }

    /**
     * Load Entry by UID
     * 
     * @param int $uid - ID of template
     */
    public function load_by_uid($uid = false) {
        global $wpdb;
        $bulk = false;
        if ($this->helper->get('cache')) {
            $bulk = wp_cache_get($uid, 'e2pdf_bulks_uids');
        }
        if ($bulk === false) {
            $this->helper->clear_cache();
            $bulk = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->get_table()}` WHERE uid = %s", $uid), ARRAY_A);
            if ($this->helper->get('cache')) {
                wp_cache_set($uid, $bulk, 'e2pdf_bulks_uids');
            }
        }

        if ($bulk) {
            $this->bulk = $bulk;
            $this->set('options', unserialize($bulk['options']));
            $this->set('datasets', unserialize($bulk['datasets']));
            return true;
        }
        return false;
    }

    public function get($key) {
        if (isset($this->bulk[$key])) {
            return $this->bulk[$key];
        } else {
            switch ($key) {
                case 'uid':
                    $value = md5(md5(time()) . md5($this->key));
                    break;
                case 'status':
                    $value = 'pending';
                    break;
                case 'count':
                case 'total':
                    $value = '0';
                    break;
                case 'options':
                    $value = array();
                    break;
                default:
                    $value = '';
                    break;
            }
            return $value;
        }
    }

    public function set($key, $value) {
        $this->bulk[$key] = $value;
        return true;
    }

    public function bulk() {
        return $this->bulk;
    }

    public function pre_save() {
        $bulk = array(
            'uid' => $this->get('uid'),
            'template_id' => $this->get('template_id'),
            'count' => $this->get('count'),
            'total' => $this->get('total'),
            'dataset' => $this->get('dataset'),
            'datasets' => serialize($this->get('datasets')),
            'options' => serialize($this->get('options')),
            'status' => $this->get('status'),
        );

        if (!$this->get('ID')) {
            $bulk['created_at'] = current_time('mysql', 1);
        }

        return $bulk;
    }

    public function save() {
        global $wpdb;
        $bulk = $this->pre_save();

        $show_errors = false;
        if ($wpdb->show_errors) {
            $wpdb->show_errors(false);
            $show_errors = true;
        }

        if ($this->get('ID')) {
            $where = array(
                'ID' => $this->get('ID')
            );
            $success = $wpdb->update($this->get_table(), $bulk, $where);
            if ($success === false) {
                $this->helper->init_db($wpdb->prefix);
                $wpdb->update($this->get_table(), $bulk, $where);
            }
        } else {
            $success = $wpdb->insert($this->get_table(), $bulk);
            if ($success === false) {
                $this->helper->init_db($wpdb->prefix);
                $wpdb->insert($this->get_table(), $bulk);
            }
            $this->set('ID', $wpdb->insert_id);
        }

        if ($show_errors) {
            $wpdb->show_errors();
        }

        if ($this->helper->get('cache') && $this->get('ID')) {
            wp_cache_delete($this->get('ID'), 'e2pdf_bulks');
            wp_cache_delete($this->get('uid'), 'e2pdf_bulks_uids');
        }

        return $this->get('ID');
    }

    public function get_table() {
        return $this->table;
    }

    public function get_active_bulk() {
        global $wpdb;

        $bulk = $wpdb->get_row($wpdb->prepare("SELECT * FROM `{$this->get_table()}` WHERE status = %s OR status = %s ORDER BY ID ASC", 'pending', 'busy'), ARRAY_A);
        if ($bulk) {
            $this->load($bulk['ID']);
            return true;
        }
        return false;
    }

    public function get_active_status() {
        global $wpdb;
        $status = $wpdb->get_var($wpdb->prepare("SELECT status FROM `{$this->get_table()}` WHERE ID = %d", $this->get('ID')));
        return $status;
    }

    public function process() {

        if ($this->get('ID') && $this->get('status') != 'busy' && $this->get_active_status() !== 'stop') {

            $this->set('status', 'busy');
            $this->save();

            $template_id = $this->get('template_id');

            $datasets = $this->get('datasets');
            $dataset = array_shift($datasets);

            $pdf_dir = $this->helper->get('bulk_dir') . $this->get('uid') . "/";
            if (!file_exists($pdf_dir)) {
                $this->helper->create_dir($pdf_dir, false, true, true);
            }

            if ($template_id && $dataset) {
                $model_e2pdf_shortcode = new Model_E2pdf_Shortcode();
                $atts = array(
                    'id' => $template_id,
                    'dataset' => $dataset,
                    'user_id' => 0,
                    'create_index' => 'false',
                    'create_htaccess' => 'false',
                    'overwrite' => 'false',
                    'dir' => $pdf_dir,
                    'apply' => 'true'
                );
                if ($this->get('options')) {
                    foreach ($this->get('options') as $key => $value) {
                        $atts[$key] = $value;
                    }
                }
                $model_e2pdf_shortcode->e2pdf_save($atts);
            }

            $this->set('datasets', $datasets);
            $this->set('count', $this->get('count') + 1);
            if (empty($datasets)) {
                $zip_path = $this->helper->get('bulk_dir') . $this->get('uid') . ".zip";
                $zip = new ZipArchive;
                if ($zip->open($zip_path, ZipArchive::CREATE) === TRUE) {
                    $dir = opendir($pdf_dir);
                    while ($file = readdir($dir)) {
                        if (is_file($pdf_dir . $file) && $file !== 'index.php' && $file !== '.htaccess') {
                            $zip->addFile($pdf_dir . $file, $file);
                        }
                    }
                    $zip->close();
                }
                $this->helper->delete_dir($pdf_dir);
                $this->set('status', 'completed');
            } else {
                if ($this->get_active_status() == 'stop') {
                    $this->set('status', 'stop');
                } else {
                    $this->set('status', 'pending');
                }
            }
            $this->save();
        }
    }

    /**
     * Delete loaded entry
     */
    public function delete() {
        global $wpdb;
        if ($this->get('ID')) {

            $where = array(
                'ID' => $this->get('ID')
            );
            $wpdb->delete($this->get_table(), $where);

            if ($this->helper->get('cache') && $this->get('ID')) {
                wp_cache_delete($this->get('ID'), 'e2pdf_bulks');
                wp_cache_delete($this->get('uid'), 'e2pdf_bulks_uids');
            }

            $pdf_dir = $this->helper->get('bulk_dir') . $this->get('uid') . "/";
            if (file_exists($pdf_dir)) {
                $this->helper->delete_dir($pdf_dir);
            }

            $zip_path = $this->helper->get('bulk_dir') . $this->get('uid') . ".zip";
            if (file_exists($zip_path)) {
                unlink($zip_path);
            }
        }
    }

}
