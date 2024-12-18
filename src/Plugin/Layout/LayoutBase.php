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
      'full_width' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $configuration = $this->getConfiguration();

    // createa tab for the layout settings
    $form['layout_settings'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-general',
    ];

    // setup tabs for the layout settings
    $form['general'] = [
      '#type' => 'details',
      '#title' => $this->t('General'),
      '#group' => 'layout_settings',
      '#open' => TRUE,
    ];
    $form['decoration'] = [
      '#type' => 'details',
      '#title' => $this->t('Decoration'),
      '#group' => 'layout_settings',
    ];

    /**
     * General settings
     */
    $form['general']['section_padding'] = [
      '#type' => 'select',
      '#title' => $this->t('Section padding'),
      '#default_value' => $configuration['general']['section_padding'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
        "xl" => $this->t("Extra large"),
      ],
      '#description' => $this->t('The amount of space around the row, this will extend the background color'),
    ];
    $form['general']['extra_classes'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Extra classes'),
      '#default_value' => $configuration['general']['extra_classes'],
    ];

    /**
     * Decoration settings
     */
    $form['decoration']['full_width'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Full width'),
      '#default_value' => $configuration['decoration']['full_width'],
      '#description' => $this->t('Make the layout full bleed.'),
    ];
    $form['decoration']['background_color'] = [
      '#type' => 'select',
      '#title' => $this->t('Background color'),
      '#default_value' => $configuration['decoration']['background_color'],
      '#options' => [
        "nil" => $this->t("None"),
        "gray" => $this->t("Gray"),
        "charcoal" => $this->t("Charcoal"),
        "lime" => $this->t("Lime"),
        "green" => $this->t("Green"),
      ],
      '#description' => $this->t('The background color of the layout.'),
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
    $this->configuration['general']['extra_classes'] = (string) $form_state->getValue(['general', 'extra_classes']);
    $this->configuration['general']['section_padding'] = (string) $form_state->getValue(['general', 'section_padding']);
    $this->configuration['decoration']['background_color'] = (string) $form_state->getValue(['decoration', 'background_color']);
    $this->configuration['decoration']['full_width'] = (bool) $form_state->getValue(['decoration', 'full_width']);
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    // Ensure extra_classes is a string before using explode
    $extra_classes = is_string($this->configuration['general']['extra_classes']) ? $this->configuration['general']['extra_classes'] : '';
    $build['#attributes']['class'] = explode(' ', $extra_classes);

    // Set additional attributes safely
    $build['#attributes']['data-background-color'] = $this->configuration['decoration']['background_color'] ?? null;
    $build['#attributes']['data-section-padding'] = $this->configuration['general']['section_padding'] ?? 'md';

    $this->configuration['decoration']['full_width'] ? $build['#attributes']['data-full-width'] = TRUE : null;


    $build['#attributes']['class'][] = 'layout column-layout';
    $build['#attributes']['class'][] = 'column-layout--' . $build['#layout']->get('classname');

    return $build;
  }
}
