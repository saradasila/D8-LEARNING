<?php

namespace Drupal\mymodule\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DefaultForm.
 *
 * @package Drupal\mymodule\Form
 */
class DefaultForm extends FormBase {

 /**
   * @var AccountInterface $account
   */
  protected $account;

  /**
   * Class constructor.
   */
  public function __construct(AccountInterface $account) {
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
      // Load the service required to construct this class.
      $container->get('current_user')
    );
  }





  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'default_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

   // Get current user data.
    $uid = $this->account->id();
    //print_r($uid);die;

    $form['candidate_name'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate Name:'),
      '#required' => TRUE,
    );
    $form['candidate_mail'] = array(
      '#type' => 'email',
      '#title' => t('Email ID:'),
      '#required' => TRUE,
    );
    $form['candidate_number'] = array (
      '#type' => 'tel',
      '#title' => t('Mobile no'),
    );
    $form['candidate_dob'] = array (
      '#type' => 'date',
      '#title' => t('DOB'),
      '#required' => TRUE,
    );
  $form['candidate_uid'] = array(
      '#type' => 'textfield',
      '#title' => t('Candidate UID:'),
      '#required' => TRUE,
      '#default_value' => $uid,
    );

    $form['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
    * {@inheritdoc}
    */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
        drupal_set_message('Form Saved Successfully');
    }

  }

}
