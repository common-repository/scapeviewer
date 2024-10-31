<?php
/** @var $this WO_Plugin_Admin */
?>
<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-post"><br></div>
    <h2>ScapeViewer� for WordPress</h2>

    <p>ScapeViewer for WordPress enables easy embedded linking in WordPress to scapes built using the
        Whitepoint framework. The necessary script that is required to open ScapeViewer is automatically added by the
        plugin so there is no messy scripting or knowledge of coding required.
	<br /><br />
        After making a selection for each of the sections below, a shortcode will be generated which you can copy and
        paste into WordPress postings.
<br /><br />
You will need the Scape ID of a scape built using the Whitepoint framework. For Whitepoint authors, scape IDs can be located in the Whitepoint Authoring Panel on the "Personal Scapes" or "Team
        Scapes" pages.</p>

    <form action="" method="get">
        <fieldset class="images">
            <h3>Choose an Image For Your Scape Link</h3>
            <? foreach ($this->wo_plugin->images as $index => $image) : ?>
            <label>
                <input type="radio" name="image" value="<?=$index?>">
                <img
                    src="<?=$this->wo_plugin->generate_image_url($image['filename'])?>"
                    alt="<?= $image['alt'] ?>"
                    width="<?= $image['width'] ?>"
                    height="<?= $image['height'] ?>"
                    />
            </label>
            <? endforeach; ?>
        </fieldset>

        <fieldset>
            <h3>Set Alignment With Surrounding Text</h3>
            <label>
                <input type="radio" name="align" value="left">
                Left
            </label>
            <label>
                <input type="radio" name="align" value="right">
                Right
            </label>
            <label>
                <input type="radio" name="align" value="none">
                Do not set in shortcode
            </label>
        </fieldset>

        <fieldset>
            <h3>Enter Your Scape ID</h3>
            <input type="text" name="scape_id" id="scape_id">
            <p>For Whitepoint authors, scape IDs can be located in the Whitepoint Authoring Panel on the "Personal Scapes" or "Team Scapes" pages.</p>
        </fieldset>

        <fieldset>
            <label><input type="checkbox" name="agreement" id="agreement"> Your shortcode will provide a link to a
                Whitepoint scape, which is an external link. WordPress requires your permission to do this. Please check
                the box to accept. You will then see your shortcode.</label>
        </fieldset>

        <fieldset id="shortcode-panel" style="display: none">
            <h3>Your Shortcode is Ready</h3>
            <input type="text" id="shortcode">
        </fieldset>
    </form>

</div>