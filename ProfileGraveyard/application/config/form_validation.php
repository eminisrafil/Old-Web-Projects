<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

		$config = array(
			'obit' => array(
				array(
					'field' => 'obit_text',
					'label' => 'Obituary',
					'rules' => 'min_length[25]|required'
				),
				array(
					'field' => 'category',
					'label' => 'Category',
					'rules' => 'is_natural_no_zero|required'
				),
				array(
					'field' => 'birthy',
					'label' => 'Profile Creation Year',
					'rules' => 'is_natural_no_zero|exact_length[4]|required'
				),
				array(
					'field' => 'deathy',
					'label' => 'Profile Deletion Year',
					'rules' => 'is_natural_no_zero|exact_length[4]|callback_proAgePositive[birthy]|required'
				)
			),
			'comment' => array(

				array(
					'field' => 'comment_text',
					'label' => 'Comment',
					'rules' => 'min_length[3]|required'
				)
			)
		);
?>