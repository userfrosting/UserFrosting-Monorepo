## Table of contents

- [Table of contents](#table-of-contents)
  - [Interface: \UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)
  - [Class: \UserFrosting\I18n\Dictionary](#class-userfrostingi18ndictionary)
  - [Interface: \UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)
  - [Class: \UserFrosting\I18n\Translator](#class-userfrostingi18ntranslator)
  - [Class: \UserFrosting\I18n\Locale](#class-userfrostingi18nlocale)
  - [Class: \UserFrosting\I18n\Compare](#class-userfrostingi18ncompare)
  - [Class: \UserFrosting\I18n\PluralRules\Rule0](#class-userfrostingi18npluralrulesrule0)
  - [Class: \UserFrosting\I18n\PluralRules\Rule1](#class-userfrostingi18npluralrulesrule1)
  - [Class: \UserFrosting\I18n\PluralRules\Rule3](#class-userfrostingi18npluralrulesrule3)
  - [Class: \UserFrosting\I18n\PluralRules\Rule2](#class-userfrostingi18npluralrulesrule2)
  - [Class: \UserFrosting\I18n\PluralRules\Rule6](#class-userfrostingi18npluralrulesrule6)
  - [Class: \UserFrosting\I18n\PluralRules\Rule7](#class-userfrostingi18npluralrulesrule7)
  - [Class: \UserFrosting\I18n\PluralRules\Rule5](#class-userfrostingi18npluralrulesrule5)
  - [Class: \UserFrosting\I18n\PluralRules\Rule4](#class-userfrostingi18npluralrulesrule4)
  - [Class: \UserFrosting\I18n\PluralRules\Rule14](#class-userfrostingi18npluralrulesrule14)
  - [Interface: \UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)
  - [Class: \UserFrosting\I18n\PluralRules\Rule15](#class-userfrostingi18npluralrulesrule15)
  - [Class: \UserFrosting\I18n\PluralRules\Rule12](#class-userfrostingi18npluralrulesrule12)
  - [Class: \UserFrosting\I18n\PluralRules\Rule13](#class-userfrostingi18npluralrulesrule13)
  - [Class: \UserFrosting\I18n\PluralRules\Rule11](#class-userfrostingi18npluralrulesrule11)
  - [Class: \UserFrosting\I18n\PluralRules\Rule10](#class-userfrostingi18npluralrulesrule10)
  - [Class: \UserFrosting\I18n\PluralRules\Rule9](#class-userfrostingi18npluralrulesrule9)
  - [Class: \UserFrosting\I18n\PluralRules\Rule8](#class-userfrostingi18npluralrulesrule8)

<hr />

### Interface: \UserFrosting\I18n\LocaleInterface

> Locale interface.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getAuthors()</strong> : <em>string[] The list of authors</em><br /><em>Returns the list of authors of the locale.</em> |
| public | <strong>getConfig()</strong> : <em>\UserFrosting\I18n\(array/\UserFrosting\I18n\string)[]</em><br /><em>Return the raw configuration data.</em> |
| public | <strong>getConfigFile()</strong> : <em>string</em><br /><em>Returns defined configuration file.</em> |
| public | <strong>getDependentLocales()</strong> : <em>[\UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)[]</em><br /><em>Return an array of parent locales.</em> |
| public | <strong>getDependentLocalesIdentifier()</strong> : <em>string[]</em><br /><em>Return a list of parent locale identifier (eg. [fr_FR, en_US]).</em> |
| public | <strong>getIdentifier()</strong> : <em>string</em><br /><em>Returns the locale identifier.</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Return the name of the locale, in English form.</em> |
| public | <strong>getPluralRule()</strong> : <em>int</em><br /><em>Return the number representing the plural rule to use for this locale.</em> |
| public | <strong>getRegionalName()</strong> : <em>string</em><br /><em>Return the localized version of the locale name.</em> |

<hr />

### Class: \UserFrosting\I18n\Dictionary

> Locale Dictionary. Load all locale all "Key => translation" data matrix

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)</em> <strong>$locale</strong>, <em>\UserFrosting\UniformResourceLocator\ResourceLocatorInterface</em> <strong>$locator</strong>, <em>\UserFrosting\Support\Repository\Loader\FileRepositoryLoader</em> <strong>$fileLoader=null</strong>)</strong> : <em>void</em> |
| public | <strong>getDictionary()</strong> : <em>mixed</em> |
| public | <strong>getFileLoader()</strong> : <em>\UserFrosting\Support\Repository\Loader\FileRepositoryLoader</em><br /><em>Return the file repository loader used to load.</em> |
| public | <strong>getFlattenDictionary()</strong> : <em>mixed</em> |
| public | <strong>getLocale()</strong> : <em>mixed</em> |
| public | <strong>setUri(</strong><em>\string</em> <strong>$uri</strong>)</strong> : <em>void</em><br /><em>Set the locator base URI (default 'locale://').</em> |
| protected | <strong>filterDictionaryFiles(</strong><em>\UserFrosting\UniformResourceLocator\ResourceInterface[]</em> <strong>$files</strong>)</strong> : <em>string[]</em><br /><em>Remove config files from locator results and convert ResourceInterface to path/string.</em> |
| protected | <strong>getFiles()</strong> : <em>\UserFrosting\UniformResourceLocator\ResourceInterface[]</em><br /><em>List all files for a given locale using the locator.</em> |
| protected | <strong>loadDictionary()</strong> : <em>\UserFrosting\I18n\(string/array)[] The locale dictionary</em><br /><em>Load the dictionary from file.</em> |

*This class extends \UserFrosting\Support\Repository\Repository*

*This class implements \Illuminate\Contracts\Config\Repository, \ArrayAccess, [\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)*

<hr />

### Interface: \UserFrosting\I18n\DictionaryInterface

> Locale Dictionary. Used to return all "Key => translation" data matrix Extend the Config repository to have acess to all the standard `has`, `get`, etc. public methods on the dictionnay array

| Visibility | Function |
|:-----------|:---------|
| public | <strong>getDictionary()</strong> : <em>\UserFrosting\I18n\(string/array)[] The locale dictionary</em><br /><em>Returns all loaded locale Key => Translation data dictionary.</em> |
| public | <strong>getFlattenDictionary()</strong> : <em>string[]</em><br /><em>Return the dictionnary as a flatten array, using dot notation.</em> |
| public | <strong>getLocale()</strong> : <em>[\UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)</em><br /><em>Return the associate locale.</em> |

*This class implements \Illuminate\Contracts\Config\Repository*

<hr />

### Class: \UserFrosting\I18n\Translator

> Translator Class. Translate message ids to a message in a specified language.

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$dictionary</strong>)</strong> : <em>void</em><br /><em>Create the translator.</em> |
| public | <strong>getDictionary()</strong> : <em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em><br /><em>Returned the associated dictionary.</em> |
| public | <strong>getLocale()</strong> : <em>[\UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)</em><br /><em>Returns the associated locale for the specified dictionary.</em> |
| public | <strong>getPluralForm(</strong><em>int/float</em> <strong>$number</strong>, <em>bool/int/bool</em> <strong>$forceRule=false</strong>)</strong> : <em>int The plural-case we need to use for the number plural-rule combination</em><br /><em>Determine which plural form we should use. For some languages this is not as simple as for English.</em> |
| public | <strong>translate(</strong><em>\string</em> <strong>$messageKey</strong>, <em>array/mixed[]/int</em> <strong>$placeholders=array()</strong>)</strong> : <em>string The translated message.</em><br /><em>Translate the given message id into the currently configured language, substituting any placeholders that appear in the translated string. Return the $messageKey if not match is found</em> |
| protected | <strong>getMessageFromKey(</strong><em>\string</em> <strong>$messageKey</strong>, <em>mixed[]/int</em> <strong>$placeholders</strong>)</strong> : <em>string The message string</em><br /><em>Get the message from key. Go throught all registered language keys avaiable and find the correct one to use, using the placeholders to select the correct plural form.</em> |
| protected | <strong>getPluralKey(</strong><em>mixed[]</em> <strong>$messageArray</strong>)</strong> : <em>string</em><br /><em>Return the plural key from a translation array. If no plural key is defined in the `@PLURAL` instruction of the message array, we fallback to the default one.</em> |
| protected | <strong>getPluralMessageKey(</strong><em>mixed[]</em> <strong>$messageArray</strong>, <em>\int</em> <strong>$pluralValue</strong>)</strong> : <em>int/null Returns which key from $messageArray to use</em><br /><em>Return the correct plural message form to use. When multiple plural form are available for a message, this method will return the correct oen to use based on the numeric value.</em> |
| protected | <strong>getPluralValue(</strong><em>mixed[]/int</em> <strong>$placeholders</strong>, <em>\string</em> <strong>$pluralKey</strong>)</strong> : <em>int/null The number, null if not found</em><br /><em>Return the plural value, aka the nummber to display, from the placeholder values.</em> |
| protected | <strong>parsePlaceHolders(</strong><em>\string</em> <strong>$message</strong>, <em>mixed[]/int</em> <strong>$placeholders</strong>)</strong> : <em>string The message with replaced placeholders</em><br /><em>Parse Placeholder. Replace placeholders in the message with their values from the passed argument.</em> |

<hr />

### Class: \UserFrosting\I18n\Locale

> Locale Class. Act as a container for a Locale data loaded from filesystem data

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>\string</em> <strong>$identifier</strong>, <em>\string</em> <strong>$configFile=null</strong>)</strong> : <em>void</em><br /><em>Create locale class.</em> |
| public | <strong>getAuthors()</strong> : <em>string[] The list of authors</em><br /><em>Returns the list of authors of the locale.</em> |
| public | <strong>getConfig()</strong> : <em>string[]</em><br /><em>Return the raw configuration data.</em> |
| public | <strong>getConfigFile()</strong> : <em>string</em><br /><em>Returns defined configuration file.</em> |
| public | <strong>getDependentLocales()</strong> : <em>[\UserFrosting\I18n\Locale](#class-userfrostingi18nlocale)[]</em><br /><em>Return an array of parent locales.</em> |
| public | <strong>getDependentLocalesIdentifier()</strong> : <em>string[]</em><br /><em>Return a list of parent locale identifier (eg. [fr_FR, en_US]).</em> |
| public | <strong>getIdentifier()</strong> : <em>string</em><br /><em>Returns the locale identifier.</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Return the name of the locale, in English form.</em> |
| public | <strong>getPluralRule()</strong> : <em>int</em><br /><em>Return the number representing the plural rule to use for this locale.</em> |
| public | <strong>getRegionalName()</strong> : <em>string</em><br /><em>Return the localized version of the locale name.</em> |
| protected | <strong>loadConfig()</strong> : <em>mixed</em><br /><em>Loads the config into the class property.</em> |

*This class implements [\UserFrosting\I18n\LocaleInterface](#interface-userfrostingi18nlocaleinterface)*

<hr />

### Class: \UserFrosting\I18n\Compare

> Helper class to compare two dictionaries. Can be used to determine which keys/values are missing from a dictionary (right) compared to a base directory (left).

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>dictionaries(</strong><em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$leftDictionary</strong>, <em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$rightDictionary</strong>, <em>\bool</em> <strong>$undot=false</strong>)</strong> : <em>string[]</em><br /><em>Compares keys and values from left dictionary against right dictionary and returns the difference.</em> |
| public static | <strong>dictionariesEmptyValues(</strong><em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$dictionary</strong>)</strong> : <em>string[] List of keys</em><br /><em>Returns all keys for which the value is empty. Can be used to find all keys that needs to be translated in the dictionary.</em> |
| public static | <strong>dictionariesKeys(</strong><em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$leftDictionary</strong>, <em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$rightDictionary</strong>)</strong> : <em>string[] List of keys</em><br /><em>Compares keys from left dictionary against right dictionary. Returns a list of keys present in the left dictory, but not found in the right one. Can be used to sync both dictionary content.</em> |
| public static | <strong>dictionariesValues(</strong><em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$leftDictionary</strong>, <em>[\UserFrosting\I18n\DictionaryInterface](#interface-userfrostingi18ndictionaryinterface)</em> <strong>$rightDictionary</strong>, <em>\bool</em> <strong>$undot=false</strong>)</strong> : <em>string[]</em><br /><em>Compares values from left dictionary against right dictionary to find same values. Returns a list of values which are the same in both dictionaries. Can be used to find all values in the right directory that might not have been translated compared to the left one. For example, when comparing french and english dictionaries, this can be used to return all English values present in the French dictionary.</em> |
| protected static | <strong>undot(</strong><em>mixed[]</em> <strong>$array</strong>)</strong> : <em>mixed[]</em><br /><em>Transfer dot notation associative array back into multidimentional associative array.</em> |

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule0

> Families: Asian (Chinese, Japanese, Korean, Vietnamese), Persian, Turkic/Altaic (Turkish), Thai, Lao 1 - everything: 0, 1, 2, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule1

> Families: Germanic (Danish, Dutch, English, Faroese, Frisian, German, Norwegian, Swedish), Finno-Ugric (Estonian, Finnish, Hungarian), Language isolate (Basque), Latin/Greek (Greek), Semitic (Hebrew), Romanic (Italian, Portuguese, Spanish, Catalan) 1 - 1 2 - everything else: 0, 2, 3, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule3

> Families: Baltic (Latvian) 1 - 0 2 - ends in 1, not 11: 1, 21, ... 101, 121, ... 3 - everything else: 2, 3, ... 10, 11, 12, ... 20, 22, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule2

> Families: Romanic (French, Brazilian Portuguese) 1 - 0, 1 2 - everything else: 2, 3, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule6

> Families: Baltic (Lithuanian) 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ... 2 - ends in 0 or ends in 10-20: 0, 10, 11, 12, ... 19, 20, 30, 40, ... 3 - everything else: 2, 3, ... 8, 9, 22, 23, ... 29, 32, 33, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule7

> Families: Slavic (Croatian, Serbian, Russian, Ukrainian) 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, ... 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ... 3 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 25, 26, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule5

> Families: Romanic (Romanian) 1 - 1 2 - is 0 or ends in 01-19: 0, 2, 3, ... 19, 101, 102, ... 119, 201, ... 3 - everything else: 20, 21, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule4

> Families: Celtic (Scottish Gaelic) 1 - is 1 or 11: 1, 11 2 - is 2 or 12: 2, 12 3 - others between 3 and 19: 3, 4, ... 10, 13, ... 18, 19 4 - everything else: 0, 20, 21, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule14

> Families: Slavic (Macedonian) 1 - ends in 1: 1, 11, 21, ... 2 - ends in 2: 2, 12, 22, ... 3 - everything else: 0, 3, 4, ... 10, 13, 14, ... 20, 23, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Interface: \UserFrosting\I18n\PluralRules\RuleInterface

> Interface for Rule Definition. The plural rules are based on a list published by the Mozilla Developer Network & code from phpBB Group

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>int</em> <strong>$number</strong>)</strong> : <em>int The rule</em><br /><em>Return the rule to apply.</em> |

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule15

> Families: Icelandic 1 - ends in 1, not 11: 1, 21, 31, ... 101, 121, 131, ... 2 - everything else: 0, 2, 3, ... 10, 11, 12, ... 20, 22, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule12

> Families: Semitic (Arabic). 1 - 1 2 - 2 3 - ends in 03-10: 3, 4, ... 10, 103, 104, ... 110, 203, 204, ... 4 - ends in 11-99: 11, ... 99, 111, 112, ... 5 - everything else: 100, 101, 102, 200, 201, 202, ... 6 - 0

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule13

> Families: Semitic (Maltese) 1 - 1 2 - is 0 or ends in 01-10: 0, 2, 3, ... 9, 10, 101, 102, ... 3 - ends in 11-19: 11, 12, ... 18, 19, 111, 112, ... 4 - everything else: 20, 21, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule11

> Families: Celtic (Irish Gaeilge) 1 - 1 2 - 2 3 - is 3-6: 3, 4, 5, 6 4 - is 7-10: 7, 8, 9, 10 5 - everything else: 0, 11, 12, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule10

> Families: Slavic (Slovenian, Sorbian) 1 - ends in 01: 1, 101, 201, ... 2 - ends in 02: 2, 102, 202, ... 3 - ends in 03-04: 3, 4, 103, 104, 203, 204, ... 4 - everything else: 0, 5, 6, 7, 8, 9, 10, 11, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule9

> Families: Slavic (Polish) 1 - 1 2 - ends in 2-4, not 12-14: 2, 3, 4, 22, 23, 24, 32, ... 104, 122, ... 3 - everything else: 0, 5, 6, ... 11, 12, 13, 14, 15, ... 20, 21, 25, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

<hr />

### Class: \UserFrosting\I18n\PluralRules\Rule8

> Families: Slavic (Slovak, Czech) 1 - 1 2 - 2, 3, 4 3 - everything else: 0, 5, 6, 7, ...

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>selectPluralForm(</strong><em>mixed</em> <strong>$number</strong>)</strong> : <em>mixed</em> |

*This class implements [\UserFrosting\I18n\PluralRules\RuleInterface](#interface-userfrostingi18npluralrulesruleinterface)*

