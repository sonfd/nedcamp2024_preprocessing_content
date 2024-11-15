<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\Context\EntityContextDefinition;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provide a Related Articles block.
 */
#[Block(
  id: "mymodule_related_articles",
  admin_label: new TranslatableMarkup("Related Articles"),
  context_definitions: [
    'node' => new EntityContextDefinition(
      data_type: 'entity:node',
      label: new TranslatableMarkup('Node from context'),
      required: FALSE
    ),
  ]
)]
class RelatedArticles extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->getContextValue('node');

    if (!$node->hasField('field_related_articles') || $node->field_related_articles->isEmpty()) {
      return [
        '#type' => 'view',
        '#name' => 'related_articles',
        '#display_id' => 'latest_3',
      ];
    }

    return [];
  }

}
