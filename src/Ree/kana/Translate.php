<?php

namespace Ree\kana;

class Translate
{

	/** @var string */
	public const LANG_JA = 'ja';
	/** @var string */
	public const LANG_EN = 'en';

	/** @var string[] */
	private $kana = [
		'bb' => 'っb',
		'cc' => 'っc',
		'dd' => 'っd',
		'ff' => 'っf',
		'gg' => 'っg',
		'hh' => 'っh',
		'jj' => 'っj',
		'kk' => 'っk',
		'll' => 'っl',
		'mm' => 'っm',
		'nn' => 'ん',
		'pp' => 'っp',
		'qq' => 'っq',
		'rr' => 'っr',
		'ss' => 'っs',
		'tt' => 'っt',
		'vv' => 'っv',
		'ww' => 'っw',
		'yy' => 'っy',
		'zz' => 'っz',
		'kya' => 'きゃ',
		'kyu' => 'きゅ',
		'kyo' => 'きょ',
		'sya' => 'しゃ',
		'syu' => 'しゅ',
		'syo' => 'しょ',
		'sha' => 'しゃ',
		'shu' => 'しゅ',
		'sho' => 'しょ',
		'cha' => 'ちゃ',
		'chu' => 'ちゅ',
		'cho' => 'ちょ',
		'tya' => 'ちゃ',
		'tyu' => 'ちゅ',
		'tyo' => 'ちょ',
		'nya' => 'にゃ',
		'nyu' => 'にゅ',
		'nyo' => 'にょ',
		'hya' => 'ひゃ',
		'hyu' => 'ひゅ',
		'hyo' => 'ひょ',
		'mya' => 'みゃ',
		'myu' => 'みゅ',
		'myo' => 'みょ',
		'rya' => 'りゃ',
		'ryu' => 'りゅ',
		'ryo' => 'りょ',
		'gya' => 'ぎゃ',
		'gyu' => 'ぎゅ',
		'gyo' => 'ぎょ',
		'zya' => 'じゃ',
		'zyu' => 'じゅ',
		'zyo' => 'じょ',
		'ja' => 'じゃ',
		'ju' => 'じゅ',
		'jo' => 'じょ',
		'wi' => 'うぃ',
		'we' => 'うぇ',
	];

	public static function execute(string $text, string $source, string $target): string
	{
		foreach($this->kana as $en => $ja){
			$text = str_replace($en, $ja, $text);
		}
		$text = rawurlencode($text);
		$ch = curl_init();
		curl_setopt(
			$ch,
			CURLOPT_URL,
			"https://script.google.com/macros/s/AKfycbweJFfBqKUs5gGNnkV2xwTZtZPptI6ebEhcCU2_JvOmHwM2TCk/exec?text={$text}&source={$source}&target={$target}"
		); //TODO: use https://www.google.co.jp/ime/cgiapi.html
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$result = curl_exec($ch);
		curl_close($ch);
		if($result === false){
			throw new TranslateException('cURL connection failed');
		}
		return $result;
	}
}