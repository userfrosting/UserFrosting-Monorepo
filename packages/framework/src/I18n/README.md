# I18n module for UserFrosting 4

The I18n module handles translation tasks for UserFrosting.

The translator uses a Dictionary, which is itself tied to a Locale. The basic structure of the system can be represented this way :

```
    |------------|
    |   Locale   |
    |------------|
          |
          V
    |------------|     |---------|     |-------------|
    | Dictionary | <-- | Locator | <-- | Definitions |
    |------------|     |---------|     |-------------|
          |
          V
    |------------|
    | Translator |
    |------------|               
```

The **Locale** knows all there is to know about the locale itself. The name of the locale, the authors, the plural rules, etc.

The **Dictionary** is tied to a specific locale. It's purpose is to return a data matrix composed of keys shared between all locales (called _message keys_) and the translated string (called _localized messages_). The system uses a `KEY` and `VALUE` system, which can be stored in standard PHP files.

The **translator** use the data from the Dictionary to perform the actual translation, aka finding the proper key and replacing the placeholder with the specified values.  

<hr />

Table of Contents
=================

   * [Documentation](#documentation)
      * [Basic usage](#basic-usage)
         * [Step 1 - Set up language file(s).](#step-1---set-up-language-files)
         * [Step 2 - Set up the Locale:](#step-2---set-up-the-locale)
         * [Step 3 - Set up UniformResourceLocator and the Dictionary:](#step-3---set-up-uniformresourcelocator-and-the-dictionary)
         * [Step 4 - Initialize a Translator object:](#step-4---initialize-a-translator-object)
         * [Step 5 - Do a translation!](#step-5---do-a-translation)
         * [Wrap up](#wrap-up)
      * [Locale configuration file](#locale-configuration-file)
         * [Config values](#config-values)
            * [name](#name)
            * [regional](#regional)
            * [authors](#authors)
            * [plural_rule](#plural_rule)
            * [parents](#parents)
      * [Pluralization](#pluralization)
         * [Plural value with placeholders](#plural-value-with-placeholders)
         * [Multiple plural in a string](#multiple-plural-in-a-string)
         * [Numbers are rules, not limits !](#numbers-are-rules-not-limits-)
         * [One last thing about pluralization...](#one-last-thing-about-pluralization)
      * [Sub keys](#sub-keys)
      * [Handles](#handles)
         * [@TRANSLATION](#translation)
         * [@PLURAL](#plural)
         * [The &amp; placeholder](#the--placeholder)
      * [Example of a complex translation](#example-of-a-complex-translation)
         * [Language file](#language-file)
         * [Translate function](#translate-function)
         * [Result](#result)
      * [Style Guide](STYLE-GUIDE.md)
      * [Testing](RUNNING_TESTS.md)
      * [API docs](docs/api.md)

# Documentation

## Basic usage

### Step 1 - Set up language file(s).

A language file returns an array mapping _message keys_ to _localized messages_. Messages may optionally have placeholders. For example:


**locale/en_US/main.php**
```
return array(
    //LANGUAGE_KEY                 => Localized message

	"ACCOUNT_SPECIFY_USERNAME"     => "Please enter your user name.",
	"ACCOUNT_SPECIFY_DISPLAY_NAME" => "Please enter your display name.",
	"ACCOUNT_USER_CHAR_LIMIT"      => "Your user name must be between {{min}} and {{max}} characters in length."
);
```

**locale/es_ES/main.php**
```
return array(
    //MESSAGE_KEY                  => Localized message

    "ACCOUNT_SPECIFY_USERNAME"     => "Introduce tu nombre de usuario.",
	"ACCOUNT_SPECIFY_DISPLAY_NAME" => "Introduce tu nombre público.",
	"ACCOUNT_USER_CHAR_LIMIT"      => "Tu nombre de usuario debe estar entre {{min}} y {{max}} caracteres de longitud."
);
```

### Step 2 - Set up the Locale:

The `Locale` class will load all [configuration value](#locale-configuration-file) for the specified locale. All you need to do is specify the locale identifier as a string :

```
$locale = new Locale('en_US');
```

This will load all the English (`en_US`) locale config. When passed to the Dictionary, this will load all the English definitions.

### Step 3 - Set up UniformResourceLocator and the Dictionary:

The `Dictionary` will load all definitions for the specified locale. To achieve this, the dictionary will build a list of the files located in the locale identifier directory (eg. `en_US`) for the specified locator path. The [UniformResourceLocator](../UniformResourceLocator) will be used to get the file list.

First, you'll need to setup the Locator. See the [UniformResourceLocator documentation](../UniformResourceLocator) for more information on this.
```
// Set up a locator class
$locator = new UniformResourceLocator(__DIR__);
$locator->registerStream('locale');
$locator->registerLocation('core');

// Register the `__DIR__/core/locale/` path
```

With the locator and the locale, we can now create the Dictionary instance.

```
$dictionary = new Dictionary($locale, $this->locator);
```

### Step 4 - Initialize a `Translator` object:

The translator can now be initiated with the Dictionary. The Locale will be inherited from the Dictionary.

```
// Create the Translator object
$translator = new Translator($dictionary);
```

### Step 5 - Do a translation!

```
echo $translator->translate("ACCOUNT_USER_CHAR_LIMIT", [
    "min" => 4,
    "max" => 200
]);

// Returns "Tu nombre de usuario debe estar entre 4 y 200 caracteres de longitud."
```

### Wrap up

```
$locator = new UniformResourceLocator(__DIR__);
$locator->addPath('locale', '', 'locale');

$locale = new Locale('en_US');
$dictionary = new Dictionary($locale, $locator);
$translator = new Translator($dictionary);

echo $translator->translate("ACCOUNT_USER_CHAR_LIMIT", [
    "min" => 4,
    "max" => 200
]);
```

## Locale configuration file

Each locale have it's own configuration file. Theses options are required to be saved in a `locale.yaml` file, located in the locale folder, accessible accessible using the `locale://en_US/locale.yaml` URI.

The configuration file can contain multiple options. For example :

```
name: French Canadian
regional: Français Canadien
authors:
  - Foo Bar
  - Bar Foo
plural_rule: 2
parents:
  - fr_FR
```

### Config values

#### `name`

The name of the locale. Should be the English version of the name.

#### `regional`

The localized name of the locale. For example, for the French locale, the name of the locale in French.

#### `authors`

A list of authors for the locale.

#### `plural_rule`

The plural rule number associated with the locale. See [Pluralization](#Pluralization) for more details.

#### `parents`

A list of parents locales for this locale. Each locale data will be loaded on top of the parents one, including all dictionary definitions.

For example, if the `fr_CA` locale has `fr_FR` as parent, all config and all keys not found in the `CA` translation will fallback to the `FR` one. If the `fr_FR` locale has `en_US` as parent itself, all keys not found in `CA` and `FR` will fallback to the English keys.

It is recommended all locale have at least `en_US` as a top parent, so undefined keys in your locale will fallback to the English version.

## Pluralization

The plural system allow for easy pluralization of strings. This whole system is based on [Mozilla plural rules](https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals). For a given language, there is a grammatical rule on how to change words depending on the number qualifying the word. Different languages can have different rules. For example, in English you say `no cars` (note the plural `cars`) while in French you say `Aucune voiture` (note the singular `voiture`).

The rule associated with a particular language ([see link above](https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals)) is defined in the [locale configuration metadata](#locale-configuration-file). So for the `english` locale, you should find `plural_rule: 1` and in the `french` file `"plural_rule: 2`.

Strings with plural forms are defined as sub arrays with the rules as the key. The right plural form is determined by the plural value passed as the second parameter of the `translate` function :
```
"HUNGRY_CATS" => [
	0 => "hungry cats",
	1 => "hungry cat",
	2 => "hungry cats",
]

echo $translator->translate("HUNGRY_CATS", 0); // Return "hungry cats"
echo $translator->translate("HUNGRY_CATS", 1); // Return "hungry cat"
echo $translator->translate("HUNGRY_CATS", 2); // Return "hungry cats"
echo $translator->translate("HUNGRY_CATS", 5); // Return "hungry cats"
```

The plural value used to select the right form is defined by default in the `plural` placeholder. This means that `$translator->translate("HUNGRY_CATS", 5)` is equivalent to `$translator->translate("HUNGRY_CATS", ['plural' => 5])`. The `plural` placeholder can also be used in the string definition. Note that in this case, it is recommended to use the `X_` prefix to indicate that the plural will be displayed :

```
"X_HUNGRY_CATS" => [
	0 => "No hungry cats",
	1 => "{{plural}} hungry cat",
	2 => "{{plural}} hungry cats",
]

echo $translator->translate("X_HUNGRY_CATS", 0); // Return "No hungry cats"
echo $translator->translate("X_HUNGRY_CATS", 1); // Return "1 hungry cat"
echo $translator->translate("X_HUNGRY_CATS", 2); // Return "2 hungry cats"
echo $translator->translate("X_HUNGRY_CATS", 5); // Return "5 hungry cats"
echo $translator->translate("X_HUNGRY_CATS", ['plural': 5]); // Return "5 hungry cats" (equivalent to the previous one)
```

In this example, you can see that `0` is used as a special rules to display `No hungry cats` instead of `0 hungry cats` to create more user friendly strings. Note that the `plural` placeholder can be overwritten using [handles](#plural).

When the first argument of the `translate` function points to a plural key in the language definition files and the second parameter is omitted, the plural value will be `1` by default unless a `@TRANSLATION` key is defined (See [Handles](#handles)). In the previous example, `$translator->translate("X_HUNGRY_CATS", 1)` is equivalent to `$translator->translate("X_HUNGRY_CATS")`.

### Plural value with placeholders
If you have more than one placeholder, you must then pass the plural value in the placeholders (no shortcut possible).

```
"X_EMOTION_CATS" => [
 0 => "No {{emotion}} cats",
 1 => "One {{emotion}} cat",
 2 => "{{plural}} {{emotion}} cats",
]

echo $translator->translate("X_EMOTION_CATS", ['plural': 2, 'emotion': 'hungry']); // Return "2 hungry cats"
echo $translator->translate("X_EMOTION_CATS", ['plural': 5, 'emotion': 'angry']); // Return "5 angry cats"
```

### Multiple plural in a string
If a localized string contain more than more plural, for example `1 guest and 4 friends currently online`, you can apply the plural rule to both `guest` and `friends` by nesting the `ONLINE_GUEST` and `ONLINE_FRIEND` keys into `ONLINE_USERS`:
```
"ONLINE_GUEST" => [
	0 => "0 guests",
	1 => "1 guest",
	2 => "{{plural}} guests"
],

"ONLINE_FRIEND" => [
	0 => "0 friends",
	1 => "1 friend",
	2 => "{{plural}} friends"
],

"ONLINE_USERS" => "{{guest}} and {{friend}} currently online",

[...]

$online_guest => $translator->translate("ONLINE_GUEST", 1);
$online_friend => $translator->translate("ONLINE_FRIEND", 4);
echo $translator->translate("ONLINE_USERS", ["guest" => $online_guest, "friend" => $online_friend]); // Returns "1 guest and 4 friends currently online"
```

Note that nested translations can be used when faced with long sentence using multiples sub strings or plural form, but those should be avoided when possible. Shorter or multiple sentences should be preferred instead. Specials [handles](#handles) can also be useful in those cases.

### Numbers are rules, not limits !
**REALLY IMPORTANT** : The **number** defined in the language files **IS NOT** related to the plural value, but to [the plural rule](https://developer.mozilla.org/en-US/docs/Mozilla/Localization/Localization_and_Plurals). **So this is completely WRONG** :

```
"X_HUNGRY_CATS" => [
	0 => "No hungry cats",
	1 => "One hungry cat",
	2 => "{{plural}} hungry cats",
	5 => "A lot of hungry cats"
]

echo $translator->translate("X_HUNGRY_CATS", 2); // Return "2 hungry cats"
echo $translator->translate("X_HUNGRY_CATS", 5); // Return "5 hungry cats", NOT "A lot of hungry cats"!
```

### One last thing about pluralization...
In some cases, it could be faster and easier to directly access the plural value. For example, when the string will *always* be plural. Consider the following example :
```
"COLOR" => [
  0 => "colors",
  1 => "color",
  2 => "colors"
],
"COLORS" => "Colors",
```
In this example, `$translator->translate("COLOR", 2);` and `$translator->translate("COLORS");` will return the same value. This is true for English, but not necessarily for all languages. While languages without any form of plural definitions will define something like `"COLOR" => "Color"` and `"COLORS" => "Color"`, some will have even more complicated rules. That's why it's always best to avoid keys like `COLORS` if you plan to translate to more than one language. This is also true with the `0` value that can be different across different language, but can also be handle differently depending of the message you want to display (Ex.: `No colors` instead of `0 colors`).


## Sub keys
Sub keys can be defined in language files for easier navigation of lists or to distinguish two items with common keys. For example:

```
return [
  "COLOR" => [
    "BLACK" => "black",
    "RED" => "red",
    "WHITE" => "white"
  ]
];
```
Sub keys can be accessed using _dot syntax_. So `$translator->translate('COLOR.BLACK')` will return `black`. Sub keys are also useful when multiple *master keys* share the same sub keys:

```
return [
	"METHOD_A" => [
		"TITLE" => "Scénario A",
		"DESCRIPTION" => "..."
	],
	"METHOD_B" => [
		"TITLE" => "Scénario B",
		"DESCRIPTION" => "..."
	]
];

$method = Method->get(); // return $method = "METHOD_A";
echo $translator->translate("$method.TITLE"); // Print "Scénario A"
```

Of courses, sub keys and plural rules can live together inside the same master key :
```
"COLOR" => [
    //Substrings
    "BLACK" => "black",
    "RED" => "red",
    "WHITE" => "white",

    //Plurals
    1 => "color",
    2 => "colors"
]
```

## Handles
Some special handles can be defined in the languages files to modify the default behavior of the translator. These handle uses the `@` prefix.

### `@TRANSLATION`
If you want to give a value for the top level key, you can use the `@TRANSLATION` (handle)[#handles] which will create an alias `TOP_KEY` and point it to `TOP_KEY.@TRANSLATION`:
```
return [
    "ACCOUNT" => [
        "@TRANSLATION" => "Account",
        "ALT" => "Profile"
    ]
];


$translator->translate('ACCOUNT') //Return "Account"
$translator->translate('ACCOUNT.@TRANSLATION') //Return "Account"
$translator->translate('ACCOUNT.ALT'); //Return "Profile"
```

N.B.: When `@TRANSLATION` is used with plural rules, omitting the second argument of the `translate` function will change the result. `1` will not be used as a plural value to determine which rule we chose. The `@TRANSLATION` value will be returned instead. For example:

```
"X_HUNGRY_CATS" => [
    "@TRANSLATION => "Hungry cats",
	0 => "No hungry cats",
	1 => "{{plural}} hungry cat",
	2 => "{{plural}} hungry cats",
]
```
With `@TRANSLATION` define above, `$translator->translate("X_HUNGRY_CATS");` will return `Hungry cats`. Remove the `@TRANSLATION` handle and the same `$translator->translate("X_HUNGRY_CATS");` will now return `1 hungry cat`.


### `@PLURAL`
The default `plural` default placeholder can be overwritten by the `@PLURAL` handle in the language files. This may be useful if you pass an existing array to the translate function.

```
"NB_HUNGRY_CATS" => [
    "@PLURAL" => "nb",
	0 => "No hungry cats",
	1 => "One hungry cat",
	2 => "{{nb}} hungry cats",
]

echo $translator->translate("NB_HUNGRY_CATS", 2); // Return "2 hungry cats"
echo $translator->translate("NB_HUNGRY_CATS", ['nb': 5]); // Return "5 hungry cats"
```

### The `&` placeholder
When a placeholder name starts with the `&` character in translation files or the value of a placeholder starts with this same `&` character, it tells the translator to directly replace the placeholder with the message mapped by that message key (if found). Note that this is CASE SENSITIVE and, as with the other handles, all placeholders defined in the main translation function are passed to all child translations. This is useful when you don't want to translate the same word over and over again in the same language file or with complex translations with plural values. Be careful when using this with plurals as the plural value is passed to all child translation and can cause conflict (See [Example of a complex translation](#example-of-a-complex-translation)).

Example:
```
"MY_CATS" => [
    1 => "my cat",
    2 => "my {{plural}} cats"
];
"I_LOVE_MY_CATS" => "I love {{&MY_CATS}}";

$translator->translate('I_LOVE_MY_CATS', 3); //Return "I love my 3 cats"
```
In this example, `{{&MY_CATS}}` gets replaced with the `MY_CATS` and since there's 3 cats, the n° 2 rule is selected. So the string becomes `I love my {{plural}} cats` which then becomes `I love my 3 cats`.


N.B.: Since this is the last thing handled by the translator, this behavior can be overwritten by the function call:
```
$translator->translate('I_LOVE_MY_CATS', ["plural" => 3, "&MY_CATS" => "my 3 dogs"); //Return "I love my 3 dogs"
```

Since the other placeholders, including the plural value(s) are also be passed to the sub translation, it can be useful for languages like french where the adjectives can also be "pluralizable". Consider this sentence : `I have 3 white catS`. In french, we would say `J'ai 3 chatS blancS`. Notice the `S` on the color `blanc`? One developer could be tempted to do this in an English context :

```
$colorString = $translator->translate('COLOR.WHITE');
echo $translator->translate('MY_CATS', ["plural" => 3, "color" => $colorString);
```

While this would work in english because the color isn't "pluralizable", it won't in french. We'll end up with `J'ai 3 chatS blanc` (No `S` on the color). What we need is the php code to call the translation and passing the color key as a placeholder using the `&` prefix : `$translator->translate('MY_CATS', ["plural" => 3, "color" => "&COLOR.WHITE"]);`. The languages files for both languages in this case would be:

_English_
```
"COLOR" => [
    "RED" => "red",
    "WHITE" => "white",
    [...]
];

"MY_CATS" => [
    0 => "I have no cats",
    1 => "I have a {{color}} cat",
    2 => "I have {{plural}} {{color}} cats"
];
```

_French_
```
"COLOR" => [
    "RED" => [
        1 => "rouge",
        2 => "rouges"
    "WHITE" => [
        1 => "blanc",
        2 =. "blancs"
    ].
    [...]
];

"MY_CATS" => [
    0 => "I have no cats",
    1 => "I have a {{color}} cat",
    2 => "I have {{plural}} {{color}} cats"
];
```

Since the placeholders (`["plural" => 3, "color" => "&COLOR.WHITE"]`) will be passed to the translate function when the `COLOR.WHITE` key is translated, the correct plural form will be returned for the color in french, giving us `J'ai 3 chatS blancS`. Even without any plural value, this is still shorter to use that defining both translate function inside the php code :

```
$translator->translate('MY_CATS', ["color" => "&COLOR.WHITE"]);
```
Vs.
```
$colorString = $translator->translate('COLOR.WHITE');
echo $translator->translate('MY_CATS', ["color" => $colorString);
```

Finally, if the sub translated key is missing in the translation file, we simply end up with the placeholder not being translated (which is something you may want in certain context) : `I have 3 COLOR.WHITE cats`.

## Example of a complex translation

### Language file
```
return [
    "COMPLEX_STRING" => "There's {{&X_CHILD}} and {{&X_ADULT}} in the {{color}} {{&CAR.FULL_MODEL}}",
    "X_CHILD" => [
        "@PLURAL" => "nb_child",
    	0 => "no children",
    	1 => "a child",
    	2 => "{{plural}} children",
    ],
    "X_ADULT" => [
        "@PLURAL" => "nb_adult",
    	0 => "no adults",
    	1 => "an adult",
    	2 => "{{nb_adult}} adults",
    ],
    "CAR" => [
        "FULL_MODEL" => "{{make}} {{model}} {{year}}"
    ],
    "COLOR" => [
        "BLACK" => "black",
        "RED" => "red",
        "WHITE" => "white"
    ]
];
```

### Translate function

```
$carMake = "Honda";
echo $translator->translate("COMPLEX_STRING", [
    "nb_child" => 1,
    "nb_adult" => 0,
    "color" => "&COLOR.WHITE",
    "make" => $carMake,
    "model" => "Civic",
    "year" => 1993
]);
```

### Result
```
There's a child and no adults in the white Honda Civic 1993
```

## [API docs](docs/api.md)

To build docs :

```
vendor/bin/phpdoc-md generate src/I18n/ > src/I18n/docs/README.md
```
