<?php

namespace Ree\kana;

class Translate
{

	/** @var string */
	public const LANG_JA = 'ja';
	/** @var string */
	public const LANG_EN = 'en';

	public static function request(string $text, string $source, string $target): string
	{
		$text = rawurlencode($text);
		$ch = curl_init();
		curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://script.google.com/macros/s/AKfycbweJFfBqKUs5gGNnkV2xwTZtZPptI6ebEhcCU2_JvOmHwM2TCk/exec?text={$text}&source={$source}&target={$target}"
		);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result === false){
			throw new TranslateException('cURL connection failed');
		}
		var_dump($result);
		return $result;
	}
}