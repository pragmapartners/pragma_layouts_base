<?php

namespace Drupal\pragma_layouts_base\Plugin\Layout;

use Drupal\Core\Form\FormStateInterface;
use Drupal\pragma_layouts_base\Plugin\Layout\LayoutBase;

/**
 * {@inheritdoc}
 */
class MultiColumnBase extends LayoutBase
{

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return parent::defaultConfiguration() + [
      'col_gap' => 'md',
      'row_gap' => 'md',
      'horizontal_alignment' => 'start',
      'bleed_left' => FALSE,
      'bleed_right' => FALSE,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state)
  {
    $form = parent::buildConfigurationForm($form, $form_state);
    $configuration = $this->getConfiguration();
    $form['general']['col_gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Column gap'),
      '#default_value' => $configuration['general']['col_gap'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
      ],
      '#description' => $this->t('The amount of space between columns.'),
    ];
    $form['general']['row_gap'] = [
      '#type' => 'select',
      '#title' => $this->t('Row gap'),
      '#default_value' => $configuration['general']['col_gap'],
      '#options' => [
        "nil" => $this->t("None"),
        "sm" => $this->t("Small"),
        "md" => $this->t("Medium"),
        "lg" => $this->t("Large"),
      ],
      '#description' => $this->t('The amount of space between rows.'),
    ];
    $form['decoration']['horizontal_alignment'] = [
      '#type' => 'select',
      '#title' => $this->t('Horizontal alignment'),
      '#default_value' => $configuration['decoration']['horizontal_alignment'],
      '#options' => [
        "start" => $this->t("Start"),
        "center" => $this->t("Center"),
        "end" => $this->t("End"),
      ],
      '#description' => $this->t('The horizontal alignment of the columns.'),
    ];
    $form['decoration']['bleed_left'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Bleed left'),
      '#default_value' => $configuration['decoration']['bleed_left'],
      '#description' => $this->t('Make the left column bleed to the edge.'),
    ];
    $form['decoration']['bleed_right'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Bleed right'),
      '#default_value' => $configuration['decoration']['bleed_right'],
      '#description' => $this->t('Make the right column bleed to the edge.'),
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
    parent::submitConfigurationForm($form, $form_state);
    $this->configuration['general']['col_gap'] = $form_state->getValue(['general', 'col_gap']);
    $this->configuration['general']['row_gap'] = $form_state->getValue(['general', 'row_gap']);
    $this->configuration['decoration']['horizontal_alignment'] = $form_state->getValue(['decoration', 'horizontal_alignment']);
    $this->configuration['decoration']['bleed_left'] = $form_state->getValue(['decoration', 'bleed_left']);
    $this->configuration['decoration']['bleed_right'] = $form_state->getValue(['decoration', 'bleed_right']);
  }

  /**
   * {@inheritdoc}
   */
  public function build(array $regions)
  {
    $build = parent::build($regions);

    $build['#attributes']['data-col-gap'] = $this->configuration['general']['col_gap'];
    $build['#attributes']['data-row-gap'] = $this->configuration['general']['row_gap'];
    $build['#attributes']['data-horizontal-alignment'] = $this->configuration['decoration']['horizontal_alignment'];
    $this->configuration['decoration']['bleed_left'] ? $build['#attributes']['data-bleed-left'] = TRUE : null;
    $this->configuration['decoration']['bleed_right'] ? $build['#attributes']['data-bleed-right'] = TRUE : null;

    return $build;
  }
}
