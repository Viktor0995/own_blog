<?php

namespace Drupal\blog_custom\Plugin\paragraphs\behavior;

use Drupal\Core\Entity\Display\EntityViewDisplayInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\paragraphs\Annotation\ParagraphsBehavior;
use Drupal\paragraphs\Entity\Paragraph;
use Drupal\paragraphs\Entity\ParagraphsType;
use Drupal\paragraphs\ParagraphInterface;
use Drupal\paragraphs\ParagraphsBehaviorBase;

/**
 * @ParagraphsBehavior(
 *   id = "gallery_behavior",
 *   label = @Translation("Gallery setting"),
 *   description = @Translation("Settings for gallery paragraphs type."),
 *   weight = 0,
 * )
 */

class GalleryBehavior extends ParagraphsBehaviorBase {
  /**
   * {@inheritdoc}
   */
  public static function isApplicable(ParagraphsType $paragraphs_type) {
    return $paragraphs_type->id() == 'gallery';
  }

  /**
   * {@inheritdoc}
   */
  public function view(array &$build, Paragraph $paragraph, EntityViewDisplayInterface $display, $view_mode) {
    $images_per_row = $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 2);
    $bem_block =  'images-per-row-' . $images_per_row;
    $build['#attributes']['class'][] = $bem_block;
  }

  /**
   * {@inheritdoc}
   */
  public function buildBehaviorForm(ParagraphInterface $paragraph, array &$form, FormStateInterface $form_state) {
      $form['items_per_row'] = [
        '#type' => 'select',
        '#title' => $this->t('Number of images per row'),
        '#options' => [
          '2' => $this->formatPlural(2, '1 photo per row', '@count photos per row'),
          '3' => $this->formatPlural(3, '1 photo per row', '@count photos per row'),
          '4' => $this->formatPlural(4, '1 photo per row', '@count photos per row'),
        ],
        '#default_value' => $paragraph->getBehaviorSetting($this->getPluginId(), 'items_per_row', 2),
      ];

    return $form;
  }
}
