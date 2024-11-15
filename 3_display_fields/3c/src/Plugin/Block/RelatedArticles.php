<?php

namespace Drupal\mymodule\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Provide a Related Articles block.
 */
#[Block(
  id: "mymodule_related_articles",
  admin_label: new TranslatableMarkup("Related Articles"),
)]
class RelatedArticles extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'view',
      '#name' => 'related_articles',
      '#display_id' => 'latest_3',
    ];
  }

}
