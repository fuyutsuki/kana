<?php

namespace Ree\kana\task;


use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Ree\kana\Translate;
use Ree\kana\TranslateException;

class TranslateTask extends AsyncTask
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $text;

	public function __construct(string $name, string $text)
	{
		$this->name = $name;
		$this->text = $text;
	}

	/**
	 * @inheritDoc
	 */
	public function onRun()
	{
		try
		{
			$en = Translate::request(str_replace(' ', '', $this->text), Translate::LANG_JA, Translate::LANG_EN);
			$result = Translate::request($en, Translate::LANG_EN, Translate::LANG_JA);
			if (mb_strlen($result) === 1551) {
				$result = '[Translate Bad Request] '.$this->text;
			}
		} catch (TranslateException $e) {
			$result = '[Translate Bad Request] '.$this->text;
		}
		$this->setResult($result);
	}

	/**
	 * @param Server $server
	 */
	public function onCompletion(Server $server)
	{
		$server->broadcastMessage($this->name . ' ' . $this->getResult() . TextFormat::GOLD. '   <' . $this->getResult() . '>');
		parent::onCompletion($server);
	}
}