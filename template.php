<?php


/**
 * Implements template_preprocess_html().
 */
function bang_preprocess_html(&$vars) {

  // TypeKit.
  /*drupal_add_js('//use.typekit.net/qqr6kuv.js');
  $data = 'try{Typekit.load();}catch (e){}';
  drupal_add_js($data, array('type' => 'inline'));*/


  drupal_add_js('http://fast.fonts.net/jsapi/9b1cfb60-2d2f-4073-9fd4-43df10260641.js');
}
