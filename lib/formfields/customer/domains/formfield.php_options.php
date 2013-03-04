<?php

// READ THIS BEFORE CHANGING/ADDING STUFF HERE
// The field name must begin with php_ to separate this field from
// the other (non php) values. The label of the field must be
// exactly the name of the setting. The array behind select_var must
// be an array with all valid options. The first option is the default
// option.



//TODO: fsock_open


return array(
	'domain_add' => array(
		'sections' => array(
			'section_b' => array(
                'title' => $lng['admin']['phpsettings']['title'],
                'image' => 'icons/phpsettings.png',
				'fields' => array(
					'php_memory_limit' => array(
						'label' => 'memory_limit',
						'type' => 'select',
						'select_var' => array('64', '128', '256')
					),
					'php_allow_url_fopen' => array(
						'label' => 'allow_url_fopen',
						'type' => 'select',
						'select_var' => array('on', 'off')
					),
					'php_suhosin_session_encrypt' => array(
						'label' => 'suhosin.session.encrypt',
						'type' => 'select',
						'select_var' => array('on', 'off')
                    ),

                    // PHP Extensions (see customer_domains)
                    'zend_extension_ioncube_loader' => array(
                        'label' => 'IonCube Loader',
                        'type' => 'select',
                        'select_var' => array('disabled', 'enabled')
                    )
				)
			)
		)
	)
);
