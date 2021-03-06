<?php

/**
 * webEdition SDK
 *
 * This source is part of the webEdition SDK. The webEdition SDK is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * The GNU Lesser General Public License can be found at
 * http://www.gnu.org/licenses/lgpl-3.0.html.
 * A copy is found in the textfile 
 * webEdition/licenses/webEditionSDK/License.txt
 *
 *
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */

/**
 * class for service error codes
 * 
 * @category   we
 * @package    we_service
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.gnu.org/licenses/lgpl-3.0.html  LGPL
 */
class we_service_ErrorCodes
{

	const kModelNotSetInSession = 1;

	const kModelTextEmpty = 2;

	const kModelFormDataNotSet = 3;

	const kModelIdNotSet = 4;

	const kModelIdsNotTheSame = 5;

	const kDBError = 6;

	const kModelNoPrimaryKeySet = 7;

	const kPathExists = 8;
}