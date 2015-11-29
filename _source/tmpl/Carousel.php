<?php // no direct acces
defined( '_JEXEC' ) or die( 'Restricted access');

$interval = $params->get('interval', 15);

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

?>
<div class="advertisement  advertisement--repsonsive">

  <script>
<?php


// for each config
foreach($configuration as $zone_name=>$config) {

  // possible parameters
  $widths      = array();
  $zone_id     = null;
  $conditional = null;

  // min width specified
  if (isset($config->min_width)) {
    $widths['min'] = 'document.documentElement.clientWidth >= '.$config->min_width;
  }

  // max width specified
  if (isset($config->max_width)) {
    $widths['max'] = 'document.documentElement.clientWidth <= '.$config->max_width;
  }

  // zone id specified
  if (isset($config->zone_id)) {
    $zone_id = $config->zone_id;
  }

  // build conditionals
  if ($widths) {
    $conditional = implode(' && ', $widths);
  }



  if ($conditional) {
    echo 'if ('.$conditional.') { ';
  }

  echo 'OA_show("'.$zone_name.'")';

  if ($conditional) {
    echo ' } ';
  }

}

?>
  </script>
  <noscript>
    <a target='_blank' href='//<?php echo $serverURL; ?>/<?php echo $deliveryPath; ?>/ck.php?n=<?php echo $n; ?>'>
      <img border='0' alt='' src='//<?php echo $serverURL; ?>/<?php echo $deliveryPath; ?>/avw.php?zoneid=<?php echo $configuration->zone_id; ?>&amp;n=<?php echo $n; ?>' />
    </a>
  </noscript>
</div>

