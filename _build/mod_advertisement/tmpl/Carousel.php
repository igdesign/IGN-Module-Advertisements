<?php // no direct acces
defined( '_JEXEC' ) or die( 'Restricted access');

// template
$template   = $params->get('template', 'Carousel');
$moduleclass_sfx = $params->get('moduleclass_sfx', $template);

$document = JFactory::getDocument();

// load external js
if ($params->get('use_js', true)) {
    $document->addScript('modules/mod_advertisement/media/js/carousel.js');
}

// load external css
if ($params->get('use_css', true)) {
    $document->addStyleSheet('modules/mod_advertisement/media/css/carousel.css');
}

/**
 * Config JSON Parsing
 */
// Confiuguration JSON
$configuration = $params->get('configuration', '');
if (!$configuration) {
  return;
}

// if config starts with { remove it.
$configuration = ltrim($configuration, '{');

// wrap config in curlys
$configuration = '{' . $configuration . '}';

// make it usable
$configuration = json_decode($configuration);



/**
 * Internal CSS for Rotator
 */
// Responsive code
$breakpoint = $params->get('breakpoint', 480);
$breakpoint_images = $params->get('breakpoint_images', array(480, 768));
$item_count = $params->get('count', 4);

$style = '
@media (min-width: '.$breakpoint.'px) {
  .'.$moduleclass_sfx.' .'.$moduleclass_sfx.'__container {
    transition: margin 0.3s;
    display: block;
    margin-left: 0px;
    width: '. 100 * $item_count . '% !important;
  }

  .'.$moduleclass_sfx.' .'.$moduleclass_sfx.'__item {
    float: left;
    margin: 0px;
    padding: 0px;
    width: ' . 100 / $item_count . '%;
  }
}';

$style_actions  = '@media (min-width: '.$breakpoint.'px) {'."\n";
$i = 0;
foreach($configuration as $index => $item) {

  $style_actions .= '#'.$moduleclass_sfx.'__item' . $index . ':checked ~ .'.$moduleclass_sfx.'__viewport .'.$moduleclass_sfx.'__container { margin-left: ' . ($i * 100 * -1) .'%; }'."\n";
  $i++;
}
$items = array();
foreach($configuration as $index => $item) {
  $item_index = '#' . $moduleclass_sfx . '__item' . $index . ':checked ~ .'.$moduleclass_sfx.'__nav .'.$moduleclass_sfx.'__nav-item[for='.$moduleclass_sfx.'__item' . $index.']';
  $items[] = $item_index;
}



$style_actions .= implode(','."\n", $items) . '{ text-decoration: underline; }';
$style_actions .= '}';

$document->addStyleDeclaration($style);
$document->addStyleDeclaration($style_actions);

/**
 * Setup
 */
$serverURL = $params->get('serverURL', '');
$serverURL = preg_replace('#^https?://#', '', rtrim($serverURL,'/'));

$deliveryPath = $params->get('deliveryPath', 'www/delivery');
$deliveryPath = trim($deliveryPath,'/');

$urlOptions = null;

$siteID = $params->get('siteID', 0);
if ($siteID) {
    $siteID = intval($siteID);
    $urlOptions['siteID'] = 'id='.$siteID;
}

$blockRepeatBanners = $params->get('blockRepeat', 0);
if ($blockRepeatBanners) {
    $blockRepeatBanners = intval($blockRepeatBanners);
    $urlOptions['blockRepeatBanners'] = 'block='.$blockRepeatBanners;
}

$blockCampaignRepeat = $params->get('blockCampaignRepeat', 0);
if ($blockCampaignRepeat) {
    $blockCampaignRepeat = intval($blockCampaignRepeat);
    $urlOptions['blockCampaign'] = 'blockCampaign='.$blockCampaignRepeat;
}

$target = $params->get('target', '_blank');
if ($target) {
    $urlOptions['target'] = 'target='.$target;
}

$urlOptions = implode('&amp;', $urlOptions);

$n = substr(md5(rand()),0,7);



?>

<div class="js-carousel" id="<?= $moduleclass_sfx ?>">

    <?php foreach($configuration as $index=>$item) : ?>
    <input type="radio" name="<?php echo trim($moduleclass_sfx); ?>" id="<?php echo $moduleclass_sfx; ?>__item<?php echo $index; ?>" class="<?php echo trim($moduleclass_sfx); ?>__radio-control" <?php if ($index == 0) : ?>checked<?php endif; ?> />
    <?php endforeach; ?>


    <div class="<?php echo $moduleclass_sfx; ?>__viewport">
        <div class="<?php echo $moduleclass_sfx; ?>__container">

            <?php
            foreach($configuration as $zone_name => $config) {
                // possible parameters
                $widths      = array();
                $zone_id     = null;
                $conditional = null;

                // min width specified
                if (isset($config->min_width)) $widths['min'] = 'document.documentElement.clientWidth >= '.$config->min_width;

                // max width specified
                if (isset($config->max_width)) $widths['max'] = 'document.documentElement.clientWidth <= '.$config->max_width;

                // zone id specified
                if (isset($config->zone_id)) $zone_id = $config->zone_id;

                // build conditionals
                if ($widths) $conditional = implode(' && ', $widths);

                $string = "OA_show('$zone_name')";

                if ($conditional) {
                    $string = "if ($conditional) { $string }";
                }
                ?>

                <div class="<?php echo $moduleclass_sfx; ?>__item">
                    <script>
                        <?= $string ?>
                    </script>
                    <noscript>
                      <a target='_blank' href='//<?php echo $serverURL; ?>/<?php echo $deliveryPath; ?>/ck.php?n=<?php echo $n; ?>'>
                        <img border='0' alt='' src='//<?php echo $serverURL; ?>/<?php echo $deliveryPath; ?>/avw.php?zoneid=<?php echo $configuration->zone_id; ?>&amp;n=<?php echo $n; ?>' />
                      </a>
                    </noscript>
                </div>


                <?php
            }
            ?>

        </div>
    </div>

    <nav class="<?php echo trim($moduleclass_sfx); ?>__nav">

            <li class="<?php echo trim($moduleclass_sfx); ?>__nav-previous">
                <button id="<?php echo trim($moduleclass_sfx); ?>__nav-previous" class="<?php echo trim($moduleclass_sfx); ?>__nav-previous    js-<?php echo trim($moduleclass_sfx); ?>-button-previous">
                    <span>Previous</span>
                </button>
            </li>
            <?php foreach($configuration as $index=>$item) : ?>
                <li class="<?php echo trim($moduleclass_sfx); ?>__nav-item">
                    <label for="<?php echo $moduleclass_sfx; ?>__item<?php echo $index; ?>" class="<?php echo trim($moduleclass_sfx); ?>__nav-item">
                        <?php echo $index + 1; ?>
                    </label>
                </li>
                <?php endforeach; ?>
                    <li class="<?php echo trim($moduleclass_sfx); ?>__nav-next">
                        <button id="<?php echo trim($moduleclass_sfx); ?>__nav-next" class="<?php echo trim($moduleclass_sfx); ?>__nav-next    js-<?php echo trim($moduleclass_sfx); ?>-button-next">
                            <span>Next </span>
                        </button>
                    </li>
        </ul>

    </nav>
</div>
<script>
  var responsiveSliderAds = new ResponsiveSliderAds({
       'element': document.getElementById('<?php echo trim($moduleclass_sfx); ?>'),
        'radios': document.getElementsByClassName('<?php echo trim($moduleclass_sfx); ?>__radio-control'),
    'nextButton': document.getElementById('<?php echo trim($moduleclass_sfx); ?>__nav-next'),
'previousButton': document.getElementById('<?php echo trim($moduleclass_sfx); ?>__nav-previous'),
      'interval': <?php echo $params->get('interval', 5) * 1000; ?>
  }).action('start');

  console.log(responsiveSliderAds);
</script>
