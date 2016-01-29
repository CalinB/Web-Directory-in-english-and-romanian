<?php 

return array(

	/*
	|--------------------------------------------------------------------------
	| Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| The following language lines contain the default error messages used
	| by the validator class. Some of the rules contain multiple versions,
	| such as the size (max, min, between) rules. These versions are used
	| for different input types such as strings and files.
	|
	| These language lines may be easily changed to provide custom error
	| messages in your application. Error messages for custom validation
	| rules may also be added to this file.
	|
	*/

	"accepted"       => "Câmpul :attribute trebuie sa fie acceptat.",
	"active_url"     => "Câmpul :attribute nu este un URL valid.",
	"after"          => "Câmpul :attribute trebuie sa fie o data dupa :date.",
	"alpha"          => "Câmpul :attribute poate contine numai litere.",
	"alpha_dash"     => "Câmpul :attribute poate contine numai litere, numere si liniute.",
	"alpha_num"      => "Câmpul :attribute poate contine numai litere si numere.",
	"array"          => "Câmpul :attribute trebuie sa aiba elemente selectate.",
	"before"         => "Câmpul :attribute trebuie sa fie o data inainte de :date.",
	"between"        => array(
		"numeric" => "Câmpul :attribute trebuie sa fie intre :min si :max.",
		"file"    => "Câmpul :attribute trebuie sa fie intre :min si :max kilobytes.",
		"string"  => "Câmpul :attribute trebuie sa fie intre :min si :max caractere.",
	),
	"confirmed"      => "Confirmarea :attribute nu se potriveste.",
	"count"          => "Câmpul :attribute trebuie sa aiba exact :count elemente selectate.",
	"countbetween"   => "Câmpul :attribute trebuie sa aiba intre :min si :max elemente selectate.",
	"countmax"       => "Câmpul :attribute trebuie sa aiba mai putin de :max elemente selectate.",
	"countmin"       => "Câmpul :attribute trebuie sa aiba cel putin :min elemente selectate.",
	"date_format"	 => "Câmpul :attribute trebuie sa fie intr-un format valid.",
	"different"      => "Campurile :attribute si :other trebuie sa fie diferite.",
	"email"          => "Formatul campului :attribute este invalid.",
	"exists"         => "Acest :attribute nu este înregistrat.",
	"image"          => "Câmpul :attribute trebuie sa fie o imagine.",
	"in"             => "Câmpul :attribute selectat este invalid.",
	"integer"        => "Câmpul :attribute trebuie sa fie un numar intreg.",
	"ip"             => "Câmpul :attribute trebuie sa fie o adresa IP valida.",
	"match"          => "Formatul campului :attribute este invalid.",
	"max"            => array(
		"numeric" => "Câmpul :attribute trebuie sa fie mai mic de :max.",
		"file"    => "Câmpul :attribute trebuie sa fie mai mic de :max kilobytes.",
		"string"  => "Câmpul :attribute trebuie sa fie mai mic de :max caractere.",
	),
	"mimes"          => "Câmpul :attribute trebuie sa fie un fisier de tipul: :values.",
	"min"            => array(
		"numeric" => "Câmpul :attribute trebuie sa fie cel putin :min.",
		"file"    => "Câmpul :attribute trebuie sa aiba cel putin :min kilobytes.",
		"string"  => "Câmpul :attribute trebuie sa aiba cel putin :min caractere.",
	),
	"not_in"         => "Câmpul :attribute selectat este invalid.",
	"numeric"        => "Câmpul :attribute trebuie sa fie un numar.",
	"regex"          => "Câmpul :attribute nu are format valid.",
	"required"       => "Câmpul :attribute este obligatoriu.",
    "required_with"  => "Câmpul :attribute este obligatoriu cu :field",
	"same"           => "Câmpul :attribute si :other trebuie sa fie identice.",
	"size"           => array(
		"numeric" => "Câmpul :attribute trebuie sa fie :size.",
		"file"    => "Câmpul :attribute trebuie sa aiba :size kilobyte.",
		"string"  => "Câmpul :attribute trebuie sa aiba :size caractere.",
	),
	"unique"         => "Acest :attribute a fost deja folosit. Dacă nu este vizibil înseamnă că aşteaptă aprobarea",
	"url"            => "Câmpul :attribute nu este intr-un format valid.",
	"recaptcha"		 => "Câmpul :attribute nu este corect.",

	/*
	|--------------------------------------------------------------------------
	| Custom Validation Language Lines
	|--------------------------------------------------------------------------
	|
	| Here you may specify custom validation messages for attributes using the
	| convention "attribute_rule" to name the lines. This helps keep your
	| custom validation clean and tidy.
	|
	| So, say you want to use a custom validation message when validating that
	| the "email" attribute is unique. Just add "email_unique" to this array
	| with your custom message. The Validator will handle the rest!
	|
	*/

	'custom' => array(),

	/*
	|--------------------------------------------------------------------------
	| Validation Attributes
	|--------------------------------------------------------------------------
	|
	| The following language lines are used to swap attribute place-holders
	| with something more reader friendly such as "E-Mail Address" instead
	| of "email". Your users will thank you.
	|
	| The Validator class will automatically search this array of lines it
	| is attempting to replace the :attribute place-holder in messages.
	| It's pretty slick. We think you'll like it.
	|
	*/

	'attributes' => array(),

);
