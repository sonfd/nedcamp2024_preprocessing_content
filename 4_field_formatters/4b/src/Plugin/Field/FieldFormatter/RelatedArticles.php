<?php

namespace Drupal\mymodule\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Attribute\FieldFormatter;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Plugin implementation of the 'mymodule_related_articles' formatter.
 *
 * Render the referenced entities, or the Related Articles view if empty.
 */
#[FieldFormatter(
  id: 'mymodule_related_articles',
  label: new TranslatableMarkup('Related Articles'),
  description: new TranslatableMarkup('Render the referenced entities, or the Related Articles view if empty.'),
  field_types: [
    'entity_reference',
  ],
)]
class RelatedArticles extends EntityReferenceEntityFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = parent::viewElements($items, $langcode);

    if (!empty($elements)) {
      return $elements;
    }

    return $elements['default'] = [
      '#type' => 'view',
      '#name' => 'related_articles',
      '#display_id' => 'latest_3',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function isApplicable(FieldDefinitionInterface $field_definition) {
    // This formatter is only available for the field_related_articles field.
    $field_name = $field_definition->getName();

    return $field_name == 'field_related_articles';
  }

}
