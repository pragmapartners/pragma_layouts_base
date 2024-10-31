<?php

namespace Drupal\pragma_layouts\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Layout\LayoutDefault;
use Drupal\Core\Plugin\PluginFormInterface;
use Drupal\media\Entity\Media;

/**
 * {@inheritdoc}
 */
class LayoutBase extends LayoutDefault implements PluginFormInterface
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'extra_classes' => '',
      'background_color' => 'nil',
      'background_image' => NULL,
      'section_padding' => 'md',
      'section_title' => '',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $configuration = $this->getConfiguration();
    // add a section title field
    $form['section_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Section title'),
      '#default_value' => $configuration['section_title'],
    ];
    $form['background_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Background color'),
      '#default_value' => $configuration['background_color'],
      '#options' => [
        "nil" => $this->t("None"),
        "gray" => $this->t("Gray"),
        "charcoal" => $this->t("Charcoal"),
        "lime" => $this->t("Lime"),
        "green" => $this->t("Green"),
      ],
      '#description' => $this->t('The background color of the layout.'),
    ];
    $form['background_image'] = [
      '#type' => 'media_library',
      '#allowed_bundles' => ['image'],
      '#title' => $this->t('Upload your image'),
      '#default_value' => $configuration['background_image'],
      '#description' => $this->t('Upload or select your profile image.'),
    ];
    $form['extra_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Extra classes'),
      '#default_value' => $configuration['extra_classes'],
    ];
    $form['section_padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Section padding'),
      '#default_value' => $configuration['section_padding'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
        "xl" => $this->t("Extra large"),
      ],
      '#description' => $this->t('The amount of space around the row, this will extend the background color'),
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    // any additional form validation that is required
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state)
  {
    $this->configuration['section_title'] = $form_state->getValue('section_title');
    $this->configuration['extra_classes'] = $form_state->getValue('extra_classes');
    $this->configuration['background_color'] = $form_state->getValue('background_color');
    $this->configuration['background_image'] = $form_state->getValue('background_image');
    $this->configuration['section_padding'] = $form_state->getValue('section_padding');
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    if ($this->configuration['background_image']) {
      $media = Media::load($this->configuration['background_image']);
      $build['media'] = [
        '#theme' => 'image_style',
        '#style_name' => 'large',
        '#uri' => $media->field_media_image->entity->getFileUri(),
      ];
    }
    if ($this->configuration['section_title']) {
      $build['section_title'] = [
        '#type' => 'markup',
        '#markup' => $this->configuration['section_title'],
      ];
    }
    $build['#attributes']['data-section-title'] = $this->configuration['section_title'] ? "TRUE" : "FALSE";
    $build['#attributes']['class'] = $this->configuration['extra_classes'];
    $build['#attributes']['data-background-color'] = $this->configuration['background_color'];
    $build['#attributes']['data-section-padding'] = $this->configuration['section_padding'];

    return $build;
  }
}
