<?php

namespace Drupal\mymodule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of 'mymodule_entity_ref_with_fallback_view' formatter.
 *
 * Render the referenced entities, or the configured view if empty.
 */
#[FieldFormatter(
  id: 'mymodule_entity_ref_with_fallback_view',
  label: new TranslatableMarkup('Rendered Entity with Fallback View'),
  description: new TranslatableMarkup('Render the referenced entities, or the configured view if empty.'),
  field_types: [
    'entity_reference',
  ],
)]
class EntityRefWithFallbackView extends EntityReferenceEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'view_name' => '',
      'view_display' => '',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form = parent::settingsForm($form, $form_state);

    $form['view_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Fallback view name'),
      '#default_value' => $this->getSetting('view_name'),
      '#description' => $this->t('The machine name of the view to use.'),
      '#required' => TRUE,
    ];

    $form['view_display'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Fallback view display'),
      '#default_value' => $this->getSetting('view_display'),
      '#description' => $this->t('The machine name of the view display to use.'),
      '#required' => TRUE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = parent::settingsSummary();

    $summary[] = $this->t('Fallback view name: @view_name', [
      '@view_name' => $this->getSetting('view_name'),
    ]);

    $summary[] = $this->t('Fallback view display: @view_display', [
      '@view_display' => $this->getSetting('view_display'),
    ]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    if (!empty($elements)) {
      return $elements;
    }

    return $this->getFallbackView();
  }

  /**
   * Get the fallback view render array.
   *
   * @return array
   *   A render array for the fallback view.
   */
  protected function getFallbackView() {
    $view_name = $this->getSetting('view_name');
    $view_display = $this->getSetting('view_display');

    if (empty($view_name) || empty($view_display)) {
      return [];
    }

    return [
      '#type' => 'view',
      '#name' => $view_name,
      '#display_id' => $view_display,
    ];
  }

}
