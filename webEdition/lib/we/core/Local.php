<?php
/**
 * webEdition SDK
 *
 * LICENSE_TEXT
 *
 * TODO insert license text
 *
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/licence     LICENCE_TYPE  TODO insert license type and url
 */

/**
 * Base class for localisation
 * 
 * @category   we
 * @package    we_core
 * @copyright  Copyright (c) 2008 living-e AG (http://www.living-e.com)
 * @license    http://www.living-e.de/license     LICENSE_TYPE  TODO insert license type and url
 */
class we_core_Local
{

	/**
	 * cache attribute
	 *
	 * @var array
	 */
	private static $_cache = array();

	/**
	 * lang attribute
	 *
	 * @var string
	 */
	private static $_lang = '';

	/**
	 * charset attribute
	 *
	 * @var string
	 */
	private static $_charset = '';

	/**
	 * translate attribute
	 *
	 * @var NULL
	 */
	public static $_translate = NULL;

	/**
	 * translationSources attribute
	 *
	 * @var array
	 */
	public static $_translationSources = array();

	/**
	 * return localisation string
	 * 
	 * @param string $lang
	 * @return string
	 */
	public static function weLangToLocale($lang)
	{
		$locales = array(

		'Deutsch' => 'de', 'English' => 'en', 'Dutch' => 'nl', 'Finnish' => 'fi', 'French' => 'fr', 'Polish' => 'pl', 'Russian' => 'ru', 'Spanish' => 'es');
		
		$lang = str_replace('_UTF-8', '', $lang);
		
		if (isset($locales[$lang])) {
			return $locales[$lang];
		}
		return $lang;
	}

	/**
	 * return language string
	 * 
	 * @param string $locale
	 * @return string
	 */
	public static function localeToWeLang($locale)
	{
		$langs = array(

		'de' => 'Deutsch', 'en' => 'English', 'nl' => 'Dutch', 'fi' => 'Finnish', 'fr' => 'French', 'pl' => 'Polish', 'ru' => 'Russian', 'es' => 'Spanish');
		
		$locale = substr($locale, 0, 2);
		
		if (isset($langs[$locale])) {
			$charset = self::getComputedUICharset();
			if ($charset == 'UTF-8') {
				return $langs[$locale] . '_UTF-8';
			}
			return $langs[$locale];
		}
		return $locale;
	}

	/**
	 * return localisation string
	 * 
	 * @return string
	 */
	public static function getLocale()
	{
		return self::weLangToLocale(self::getComputedUILang());
	}

	/**
	 * return language string
	 * 
	 * @return string
	 */
	public static function getComputedUILang()
	{
		// get from cache if there
		if (self::$_lang !== '') {
			return self::$_lang;
		}
		
		if (defined('WE_WEBUSER_LANGUAGE')) {
			self::$_lang = WE_WEBUSER_LANGUAGE;
		} else {
			if (!isset($_SESSION)) {
				Zend_Session::start();
			}
			
			if (isset($_SESSION['prefs']['Language']) && $_SESSION['prefs']['Language'] !== '') {
				if (is_dir($_SERVER['DOCUMENT_ROOT'] . '/webEdition/we/include/we_language/' . $_SESSION['prefs']['Language'])) {
					self::$_lang = $_SESSION['prefs']['Language'];
				} else if (defined('WE_LANGUAGE')) { //  bugfix #4229
					$_SESSION['prefs']['Language'] = WE_LANGUAGE;
					self::$_lang = WE_LANGUAGE;
				}
			
			} else {
				if (defined('WE_LANGUAGE')) {
					self::$_lang = WE_LANGUAGE;
				}
			}
		}
		if (self::$_lang === '') {
			self::$_lang = 'English_UTF-8';
		}
		return self::$_lang;
	}

	/**
	 * return charset
	 * 
	 * @return string
	 */
	public static function getComputedUICharset()
	{
		// get from cache if there
		if (self::$_charset !== '') {
			return self::$_charset;
		}
		$lang = self::getComputedUILang();
		@include ($GLOBALS['__WE_BASE_PATH__'] . '/we/include/we_language/' . $lang . '/charset/charset.inc.php');
		if (!isset($_language["charset"])) {
			//we_util_Log::errorlog('Error: No charset language file found, using UTF-8 now!');
			self::$_charset = 'UTF-8';
			return self::$_charset;
		}
		self::$_charset = $_language["charset"];
		unset($_language["charset"]);
		return self::$_charset;
	}

	/**
	 * add translation to application
	 * 
	 * @param string $file
	 * @param string $appName
	 * @return object
	 */
	public static function addTranslation($file, $appName = '')
	{
		$locale = self::getLocale();
		$path = ($appName === '') ? ($GLOBALS['__WE_BASE_PATH__'] . '/lang/' . $locale . '/' . $file) : ($GLOBALS['__WE_APP_PATH__'] . '/' . $appName . '/lang/' . $locale . '/' . $file);
		
		if (!in_array($path, self::$_translationSources)) {
			
			if (is_null(self::$_translate)) {
				self::$_translate = new we_core_Translate('tmx', $path, $locale);
				self::$_translate->setLocale($locale);
			} else {
				self::$_translate->addTranslation($path, $locale);
			}
			self::$_translationSources[] = $path;
		}
		return self::$_translate;
	}

}
