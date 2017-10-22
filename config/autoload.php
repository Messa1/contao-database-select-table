<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2017 Leo Feyer
 *
 * @license LGPL-3.0+
 */


/**
 * Register the namespaces
 */
ClassLoader::addNamespaces(array
(
	'MatthiasGmeiner',
));


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Forms
	'MatthiasGmeiner\FormDBSelectMenu' => 'system/modules/database-select-table/forms/FormDBSelectMenu.php',

	// Widgets
	'MatthiasGmeiner\ConditionsList'   => 'system/modules/database-select-table/widgets/ConditionsList.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_dbst_select' => 'system/modules/database-select-table/templates',
));
