<?php

declare(strict_types=1);

namespace Ree\kana;

/**
 * Class HepburnRomaji
 * @package Ree\kana
 */
class HepburnRomaji {

    /**
     * @see https://www.seikatubunka.metro.tokyo.lg.jp/passport/documents/0000000485.html
     */
    private const SPELLING_TABLE = [
        'a'  => 'あ', 'i'  =>  'い', 'u'  =>  'う', 'e'  => 'え', 'o' =>  'お',
        'ka' => 'か', 'ki' =>  'き', 'ku' =>  'く', 'ke' => 'け', 'ko' => 'こ',
        'sa' => 'さ', 'shi' => 'し', 'su' =>  'す', 'se' => 'せ', 'so' => 'そ',
        'ta' => 'た', 'chi' => 'ち', 'tsu' => 'つ', 'te' => 'て', 'to' => 'と',
        'na' => 'な', 'ni' =>  'に', 'nu' =>  'ぬ', 'ne' => 'ね', 'no' => 'の',
        'ha' => 'は', 'hi' =>  'ひ', 'fu' =>  'ふ', 'he' => 'へ', 'ho' => 'ほ',
        'ma' => 'ま', 'mi' =>  'み', 'mu' =>  'む', 'me' => 'め', 'mo' => 'も',
        'ya' => 'や',               'yu' =>  'ゆ',               'yo' => 'よ',
        'ra' => 'ら', 'ri' =>  'り', 'ru' =>  'る', 're' => 'れ', 'ro' => 'ろ',
        'wa' => 'わ',               'wo' =>  'を',               'nn' => 'ん',

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

        'ga' => 'が',
        'gi' => 'ぎ',
        'gu' => 'ぐ',
        'ge' => 'げ',
        'go' => 'ご',
        'za' => 'ざ',
        'zi' => 'じ',
        'zu' => 'ず',
        'ze' => 'ぜ',
        'zo' => 'ぞ',
        'da' => 'だ',
        'di' => 'ぢ',
        'du' => 'づ',
        'de' => 'で',
        'do' => 'ど',
        'ba' => 'ば',
        'bi' => 'び',
        'bu' => 'ぶ',
        'be' => 'べ',
        'bo' => 'ぼ',

        'si' => 'し',
        'ci' => 'し',
        'ti' => 'ち',
        'tu' => 'つ',
        'hu' => 'ふ',
        'n' => 'ん',

        'bb' => 'っｂ',
        'cc' => 'っc',
        'dd' => 'っd',
        'ff' => 'っf',
        'gg' => 'っg',
        'hh' => 'っh',
        'jj' => 'っj',
        'kk' => 'っk',
        'll' => 'っl',
        'mm' => 'っm',
        'pp' => 'っp',
        'qq' => 'っq',
        'rr' => 'っr',
        'ss' => 'っs',
        'tt' => 'っt',
        'vv' => 'っv',
        'ww' => 'っw',
        'yy' => 'っy',
        'zz' => 'っz',
    ];

    public static function convertToHiragana(string $text): string {
        return strtr($text, self::SPELLING_TABLE);
    }

}