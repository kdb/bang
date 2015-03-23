<?php

/**
 * @file
 * Template.php for bang theme.
 */

/**
 * Implements template_preprocess_html().
 */
function bang_preprocess_html(&$vars) {

  // TypeKit.
  drupal_add_js('//use.typekit.net/qqr6kuv.js', array('type' => 'external'));
  $data = 'try{Typekit.load();}catch (e){}';
  drupal_add_js($data, array('type' => 'inline'));
}


/**
 * Implements theme_menu_link().
 *
 * Add specific markup for top-bar menu exposed as menu_block_4.
 */
function bang_menu_link__menu_tabs_menu($vars) {
  // Run classes array through our custom stripper.
  $vars['element']['#attributes']['class'] = ddbasic_remove_default_link_classes($vars['element']['#attributes']['class']);

  // Check if the class array is empty.
  if (empty($vars['element']['#attributes']['class'])) {
    unset($vars['element']['#attributes']['class']);
  }

  $element = $vars['element'];

  $sub_menu = '';

  if ($element['#below']) {
    $sub_menu = drupal_render($element['#below']);
  }

  // Add default class to a tag.
  $element['#localized_options']['attributes']['class'] = array(
    'menu-item',
  );

  // Make sure text string is treated as html by l function.
  $element['#localized_options']['html'] = TRUE;

  $element['#localized_options']['attributes']['class'][] = 'js-topbar-link';
  $title_prefix = '';

  // Add some icons to our top-bar menu. We use system paths to check against.
  switch ($element['#href']) {
    case 'search':
      $title_prefix = '<i class="icon-search"></i>';
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-search';
      $element['#attributes']['class'][] = 'topbar-link-search';
      $element['#title'] = '';
      break;

    case 'node':
      // Special placeholder for mobile user menu. Fall through to next case.
      $element['#localized_options']['attributes']['class'][] = 'default-override';

    case 'user':
      // If a user is logged in we change the menu item title.
      if (user_is_logged_in()) {
        $element['#title'] = t('My Account');
        $element['#attributes']['class'][] = 'topbar-link-user-account';
        $element['#localized_options']['attributes']['class'][] = 'topbar-link-user-account';
      }
      else {
        $element['#attributes']['class'][] = 'topbar-link-user';
        $element['#localized_options']['attributes']['class'][] = 'topbar-link-user';
      }
      break;

    case 'user/logout':
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-signout';
      $element['#attributes']['class'][] = 'topbar-link-signout';

      // For some unknown issue translation fails for this title.
      $element['#title'] = t($element['#title']);
      break;

    default:
      $element['#localized_options']['attributes']['class'][] = 'topbar-link-menu';
      $element['#attributes']['class'][] = 'topbar-link-menu';
      break;
  }

  $output = l($title_prefix . '<span>' . $element['#title'] . '</span>', $element['#href'], $element['#localized_options']);
  return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>\n";
}

/**
 * Implements hook_preprocess_field().
 */
function bang_preprocess_field(&$vars) {
  $element = $vars['element'];
  if ($element['#field_name'] == 'field_ding_eresource_access') {
    // Remove the clearfix class from ding_eresource_access field.
    // It messes with our floating of the logo.
    $clearfix_index = array_search('clearfix', $vars['classes_array']);
    if ($clearfix_index !== FALSE) {
      unset($vars['classes_array'][$clearfix_index]);
    }
  }
}

/**
 * Implements hook_js_alter().
 */
function bang_js_alter(&$js) {
  unset($js['profiles/ding2/themes/ddbasic/scripts/ddbasic.topbar.menu.min.js']);
}
