<?php // no direct acces
defined( '_JEXEC' ) or die( 'Restricted access');


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




$configuration = $params->get('configuration', '');
if (!$configuration) {
  return;
}

// if config starts with { remove it.
$configuration = ltrim($configuration, '{');

// wrap config in curlys
$configuration = '{' . $configuration . '}';

// make it usable
/* $configuration = json_decode($configuration); */

echo '<script>var OA_zones = '.$configuration.'; </script>';


echo "<script src='//$serverURL/$deliveryPath/spcjs.php?$urlOptions'></script>";
