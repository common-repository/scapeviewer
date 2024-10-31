<?php
/*
Plugin Name: ScapeViewer&trade; for WordPress by Whitepoint
Description: ScapeViewer &trade; helps link tours, slideshows, and photo galleries built using Whitepoint &trade;
Author: Whitepoint, Inc.
Version: 1.0
Author URI: http://www.whitepoint.mobi
*/

new WO_Plugin();
class WO_Plugin
{
    var $images = array(
        1 => array(
            'filename' => 'WordPress-Whitepoint-Tour.png',
            'width' => 350,
            'height' => 110,
            'alt' => 'Take the Whitepoint Tour'
        ),
        2 => array(
            'filename' => 'WordPress-Whitepoint-Image-Gallery.png',
            'width' => 350,
            'height' => 110,
            'alt' => 'View the Whitepoint Image Gallery'
        ),
        3 => array(
            'filename' => 'WordPress-Whitepoint-Slideshow.png',
            'width' => 350,
            'height' => 110,
            'alt' => 'View the Whitepoint Slideshow'
        )
    );

    /** @var bool Flag which shows was Javascript code embedded or not */
    //Impossible to use wp_script_enqueue() in shortcode processor, so we need to use trick to avoid double JS code embedding
    var $js_code_embedded = false;

    function __construct()
    {
        //WO_Plugin_Admin will attach a method to 'admin_menu' action. But 'admin_menu' will be called before 'admin_init'.
        //So we need to call WO_Plugin_Admin script at 'admin_menu' instead of 'admin_init'
        add_action('admin_menu', array(&$this, 'load_admin_class'));

        add_shortcode('wpscape', array(&$this, 'expand_shortcode'));
    }

    function load_admin_class()
    {
        require dirname(__FILE__) . '/admin.php';
    }

    /**
     * @param $params array User parameters from the shortcode
     *
     * @return string
     */
    function expand_shortcode($params)
    {
        ob_start();

        $this->echo_js_code();
        $image_tag = $this->render_image_tag($params);
        $this->echo_scape_viewer($params, $image_tag);

        return ob_get_clean();
    }

    /**
     * @param bool $dont_embed_twice If TRUE, method will echo JS code only on the first call
     */
    protected function echo_js_code($dont_embed_twice = true)
    {
        if ($dont_embed_twice and $this->js_code_embedded) {
            return;
        }

        $this->js_code_embedded = true;
        echo <<<HTML
<script type="text/javascript">
    function wpWPScapeViewer(scrape_id) {
        window.open(
            "http://webview.whitepoint.mobi/scapes/scape_viewer/" + scrape_id.toString(),
            '_blank',
            'width=1000, height=675, resizable=no, scrollbars=no, location=no, menubar=no, status=no, toolbar=no');
    }
</script>
HTML;
        return;
    }

    /**
     * @param $params array User parameters from the shortcode
     *
     * @return string
     */
    protected function render_image_tag($params)
    {
        if (!isset($params['image']) || !isset($this->images[$params['image']])) {
            return '';
        }

        $image_params = $this->images[$params['image']];

        $link = $this->generate_image_url($image_params['filename']);
        $width = $image_params['width'];
        $height = $image_params['height'];
        $alt = $image_params['alt'];

        return "<img src=\"$link\" width=\"{$width}px\" height=\"{$height}px\" alt=\"$alt\"/>";
    }

    /**
     * @param $params array User parameters from the shortcode
     * @param $image_tag string Img HTML code from render_image_tag() method
     */
    protected function echo_scape_viewer($params, $image_tag)
    {
        if (!isset($params['scapeid']) || !$params['scapeid']) {
            return;
        }

        $scape_id = $params['scapeid'];

        $align_code = '';
        if (isset($params['align'])) {
            $align = $params['align'];
            $align_code = "style=\"float: $align\"";
        }

        echo <<<HTML
<div class="WPScapeViewer{$scape_id}" $align_code>
    <a href="#" onclick="wpWPScapeViewer($scape_id); return false;">
        $image_tag
    </a>
</div>
HTML;
    }

    function generate_image_url($filename)
    {
        return plugin_dir_url(__FILE__) . '/images/' . $filename;
    }
}
