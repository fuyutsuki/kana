<?php

declare(strict_types=1);

namespace Ree\kana;

use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Exception;

/**
 * Class TranslateTask
 * @package Ree\kana
 */
class TranslateTask extends AsyncTask {

    /**
     * @see https://www.google.co.jp/ime/cgiapi.html
     */
    private const API_ENDPOINT = "https://www.google.com/transliterate?langpair=ja-Hira|ja&text=" . self::PARAMETER_KEY;

    private const PARAMETER_KEY = "%param%";

	/** @var string */
	private $playerName;
	/** @var string */
	private $colorizedMessage;
	/** @var array */
    private $tokenizedMessage;
    /** @var bool */
    private $isOperator;

	public function __construct(string $playerName, string $message, bool $isOperator) {
		$this->playerName = "<{$playerName}>";
		$this->colorizedMessage = TextFormat::colorize($message);
        $this->tokenizedMessage = TextFormat::tokenize($this->colorizedMessage);
        $this->isOperator = $isOperator;
	}

	public function onRun() {
		$ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $this->convertToParameter(HepburnRomaji::convertToHiragana($this->markedEscapeText())),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
        ]);
        $json = curl_exec($ch);
        $errorNo = curl_errno($ch);
        if ($errorNo) {
            $error = curl_error($ch);
            throw new Exception($error);
        }
        curl_close($ch);
		$this->setResult(json_decode($json, true));
	}

	private function convertToParameter(string $param): string {
	    $param = rawurlencode(str_replace(" ", ",", $param));
	    return str_replace(self::PARAMETER_KEY, $param, self::API_ENDPOINT);
    }

    private function startWithEscape(string $text): bool {
	    return strpos($text, TextFormat::ESCAPE) === 0;
    }

    private function markedEscapeText(): string {
	    $result = "";
        if ($this->startWithEscape($this->colorizedMessage)) {
            foreach ($this->tokenizedMessage as $key => $text) {
                if ($key % 2 !== 0) $result .= " & {$text}";
            }
        }else {
            foreach ($this->tokenizedMessage as $key => $text) {
                if ($key % 2 === 0) {
                    if ($key !== 0) {
                        $result .= " & {$text}";
                    }else {
                        $result .= $text;
                    }
                }
            }
        }
        return $result;
    }

	public function onCompletion(Server $server) {
	    $result = $this->getResult();
	    if (!empty($result)) {
            $text = "";
            foreach ($result as $key => $phrase) {
                $text .= $phrase[0] === "&" ? $this->tokenizedMessage[$key] : $phrase[1][0];
            }
            if (!$this->isOperator) {
                $text = TextFormat::clean($text);
            }
            $server->broadcastMessage("{$this->playerName} {$text}" . TextFormat::GRAY . " (" . TextFormat::clean($this->colorizedMessage) . ")");
        }
	}
}