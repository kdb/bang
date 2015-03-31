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
 * Implements hook_preprocess_form_element().
 */
function bang_preprocess_form_element(&$vars) {
  $element = &$vars['element'];


  if (empty($element['#attributes']['class'])) {
    $element['#attributes']['class'] = array();
  }

  // Add class to form item if it has a label.
  if (!empty($element['#title'])) {
    $element['#attributes']['class'][] = 'form-item-has-label';
  }
}

/**
 * Implements hook_js_alter().
 */
function bang_js_alter(&$js) {
  unset($js['profiles/ding2/themes/ddbasic/scripts/ddbasic.topbar.menu.min.js']);
}

/**
 * Implements theme_form_element().
 *
 * This is basically copy/pasted from theme_form_element with the addition of
 * basing wrapper attributes on the #attributes value. This allows preprocess
 * functions to add classes to form elements.
 */
function bang_form_element($variables) {
  $element = &$variables['element'];

  // This function is invoked as theme wrapper, but the rendered form element
  // may not necessarily have been processed by form_builder().
  $element += array(
    '#title_display' => 'before',
  );

  // This is where changes have been introduced.
  // Base attributes on the #attributes value for the element and remember to
  // initialize the classes array.
  $attributes = $element['#attributes'];
  if (!isset($attributes['class'])) {
    $attributes['class'] = array();
  }

  // Add element #id for #type 'item'.
  if (isset($element['#markup']) && !empty($element['#id'])) {
    $attributes['id'] = $element['#id'];
  }
  // Add element's #type and #name as class to aid with JS/CSS selectors.
  // Add the base form-item class to the array.
  $attributes['class'][] = 'form-item';
  if (!empty($element['#type'])) {
    $attributes['class'][] = 'form-type-' . strtr($element['#type'], '_', '-');
  }
  if (!empty($element['#name'])) {
    $attributes['class'][] = 'form-item-' . strtr($element['#name'], array(' ' => '-', '_' => '-', '[' => '-', ']' => ''));
  }
  // Add a class for disabled elements to facilitate cross-browser styling.
  if (!empty($element['#attributes']['disabled'])) {
    $attributes['class'][] = 'form-disabled';
  }

  $output = '<div' . drupal_attributes($attributes) . '>' . "\n";

  // If #title is not set, we don't display any label or required marker.
  if (!isset($element['#title'])) {
    $element['#title_display'] = 'none';
  }
  $prefix = isset($element['#field_prefix']) ? '<span class="field-prefix">' . $element['#field_prefix'] . '</span> ' : '';
  $suffix = isset($element['#field_suffix']) ? ' <span class="field-suffix">' . $element['#field_suffix'] . '</span>' : '';

  switch ($element['#title_display']) {
    case 'before':
    case 'invisible':
      $output .= ' ' . theme('form_element_label', $variables);
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;

    case 'after':
      $output .= ' ' . $prefix . $element['#children'] . $suffix;
      $output .= ' ' . theme('form_element_label', $variables) . "\n";
      break;

    case 'none':
    case 'attribute':
      // Output no label and no required marker, only the children.
      $output .= ' ' . $prefix . $element['#children'] . $suffix . "\n";
      break;
  }

  if (!empty($element['#description'])) {
    $output .= '<div class="description">' . $element['#description'] . "</div>\n";
  }

  $output .= "</div>\n";

  return $output;
}

