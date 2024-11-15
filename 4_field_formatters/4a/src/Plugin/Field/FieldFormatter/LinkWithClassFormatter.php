<?php

namespace Drupal\mymodule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\link\LinkItemInterface;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;

/**
 * Plugin implementation of the 'mymodule_link_with_class' formatter.
 *
 * Adds a configured class to links.
 */
#[FieldFormatter(
  id: 'mymodule_link_with_class',
  label: new TranslatableMarkup('Link with Class'),
  field_types: [
    'link',
  ],
)]
class LinkWithClassFormatter extends LinkFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'class' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);

    $elements['class'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Add classes to links'),
      '#default_value' => $this->getSetting('class'),
      '#description' => $this->t('Enter a space separated list of classes.'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    $class = $this->getSetting('class');
    if (!empty($class)) {
      $summary[] = $this->t('Add class="@class"', [
        '@class' => $class,
      ]);
    }

    return $summary;
  }

  /**
   * Add configured classes to the URL.
   *
   * {@inheritdoc}
   */
  protected function buildUrl(LinkItemInterface $item) {
    $url = parent::buildUrl($item);
    $class_string = $this->getSetting('class');

    if (empty($class_string)) {
      return $url;
    }

    // Create an options array with our classes.
    $options = [];
    $options['attributes']['class'] = explode(' ', $class_string);

    // Merge our new options array with the URL's existing options.
    $url->mergeOptions($options);

    return $url;
  }

}
