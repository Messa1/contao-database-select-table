<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2017 Matthias Gmeiner
 *
 * @license LGPL-3.0+
 */
 
$strName = 'tl_form_field';

// Palette
$GLOBALS['TL_DCA'][$strName]['palettes']['db_select_field'] = 
'{type_legend},type,name,label;{db_select_field_legend},db_select_datenbank,db_select_id,db_select_name,db_sorting_field,db_sorting,db_conditions_select,db_select_empty;{fconfig_legend},mandatory;{expert_legend:hide},class;{template_legend:hide},customTpl;{submit_legend},addSubmit';

// Subpalette
$GLOBALS['TL_DCA'][$strName]['subpalettes']['db_select_empty'] = 'db_select_empty_value,db_select_empty_name';

$GLOBALS['TL_DCA'][$strName]['subpalettes']['db_conditions_select'] = 'db_conditions_start,db_conditions';

$GLOBALS['TL_DCA'][$strName]['palettes']['__selector__'][] = 'db_select_empty';  
$GLOBALS['TL_DCA'][$strName]['palettes']['__selector__'][] = 'db_conditions_select';  

// Fields
$GLOBALS['TL_DCA'][$strName]['fields']['db_select_datenbank'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_datenbank'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllTables'),
	'eval'                    => array('chosen'=>true, 'submitOnChange' => true, 'tl_class'=>'w100'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_select_id'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_id'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_select_name'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_name'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_sorting_field'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_sorting_field'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_sorting'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_sorting'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options'         	      => array('asc', 'desc'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_conditions_select'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['db_conditions_select'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_conditions_start'] = array
(
	'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_conditions_start'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options'         	      => array('WHERE', 'WHERE NOT'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w100 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"

);

$GLOBALS['TL_DCA'][$strName]['fields']['db_conditions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_conditions'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'ConditionsList',
	'options'         	      => array('AND', 'OR', 'AND NOT'),
	'eval'                    => array('allowHtml'=>true,),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_select_empty'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['db_select_empty'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA'][$strName]['fields']['db_select_empty_value'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['db_select_empty_value'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

	
$GLOBALS['TL_DCA'][$strName]['fields']['db_select_empty_name'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['db_select_empty_name'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);


class db_select_field extends Backend
{

/**
 * Get all tables and return them as array
 *
 * @return array
 */
public function getAllTables()
{
	return $this->Database->listTables();
}

public function getAllFields(DataContainer $dc)
{
	
	$table = $dc->activeRecord->db_select_datenbank;
	if (!$table) {
		$table = 'tl_article';
		}
	return $this->Database->getFieldNames($table);
}
	
}