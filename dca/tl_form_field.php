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
$GLOBALS['TL_DCA'][$strName]['palettes']['dbst_select_field'] = 
'{type_legend},type,name,label;{dbst_select_field_legend},dbst_select_table,dbst_select_id,dbst_select_name,dbst_sorting_field,dbst_sorting,dbst_conditions_select,dbst_select_empty;{fconfig_legend},mandatory;{expert_legend:hide},class;{template_legend:hide},customTpl;{submit_legend},addSubmit';

// Subpalette
$GLOBALS['TL_DCA'][$strName]['subpalettes']['dbst_select_empty'] = 'dbst_select_empty_value,dbst_select_empty_name';

$GLOBALS['TL_DCA'][$strName]['subpalettes']['dbst_conditions_select'] = 'dbst_conditions_start,dbst_conditions';

$GLOBALS['TL_DCA'][$strName]['palettes']['__selector__'][] = 'dbst_select_empty';  
$GLOBALS['TL_DCA'][$strName]['palettes']['__selector__'][] = 'dbst_conditions_select';  

// Fields
$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_table'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_select_table'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('dbst_select_field', 'getAllTables'),
	'eval'                    => array('chosen'=>true, 'submitOnChange' => true, 'tl_class'=>'w100'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_id'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_select_id'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('dbst_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_name'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_select_name'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('dbst_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_sorting_field'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_sorting_field'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('dbst_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_sorting'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_sorting'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options'         	      => array('asc', 'desc'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w50'),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_conditions_select'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['dbst_conditions_select'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_conditions_start'] = array
(
	'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_conditions_start'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options'         	      => array('WHERE', 'WHERE NOT'),
	'eval'                    => array('chosen'=>true, 'tl_class'=>'w100 clr'),
	'sql'                     => "varchar(64) NOT NULL default ''"

);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_conditions'] = array
(
	'label'                   => &$GLOBALS['TL_LANG'][$strName]['dbst_conditions'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'ConditionsList',
	'options'         	      => array('AND', 'OR', 'AND NOT'),
	'eval'                    => array('allowHtml'=>true,),
	'sql'                     => "blob NULL"
);

$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_empty'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['dbst_select_empty'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'eval'                    => array('submitOnChange'=>true, 'tl_class'=>'w50 clr'),
	'sql'                     => "char(1) NOT NULL default ''"
);
		
$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_empty_value'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['dbst_select_empty_value'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50 clr'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);

	
$GLOBALS['TL_DCA'][$strName]['fields']['dbst_select_empty_name'] = array
(
	'label'                   =>  &$GLOBALS['TL_LANG'][$strName]['dbst_select_empty_name'],
	'exclude'                 => true,
	'inputType'               => 'text',
	'eval'                    => array('mandatory'=>false, 'maxlength'=>255, 'tl_class'=>'w50'),
	'sql'                     => "varchar(255) NOT NULL default ''"
);


class dbst_select_field extends Backend
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
	
	$table = $dc->activeRecord->dbst_select_table;
	if (!$table) {
		$table = 'tl_article';
		}
	return $this->Database->getFieldNames($table);
}
	
}