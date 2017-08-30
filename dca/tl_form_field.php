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
'{type_legend},type,name,label;{db_select_field_legend},db_select_datenbank,db_select_id,db_select_name;{fconfig_legend},mandatory;{expert_legend:hide},class;{template_legend:hide},customTpl;{submit_legend},addSubmit';


// Fields
$GLOBALS['TL_DCA'][$strName]['fields']['db_select_datenbank'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_datenbank'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllTables'),
	'eval'                    => array('chosen'=>true, 'submitOnChange' => true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_select_id'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_id'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA'][$strName]['fields']['db_select_name'] = array
(
    'label'                   => &$GLOBALS['TL_LANG'][$strName]['db_select_name'],
	'exclude'                 => true,
	'search'                  => true,
	'inputType'               => 'select',
	'options_callback'        => array('db_select_field', 'getAllFields'),
	'eval'                    => array('chosen'=>true),
	'sql'                     => "varchar(64) NOT NULL default ''"
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