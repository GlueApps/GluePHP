<?php

namespace GlueApps\GluePHP\Response;

use GlueApps\GluePHP\AbstractApp;
use GlueApps\GluePHP\Action\AbstractAction;
use GlueApps\GluePHP\Update\UpdateResultInterface;
use GlueApps\GluePHP\Update\UpdateInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface ResponseInterface
{
    public function getApp(): AbstractApp;

    public function getCode(): int;

    public function getUpdateResults(): array;

    public function addUpdateResult(UpdateResultInterface $result): void;

    public function getActions(): array;

    public function addAction(AbstractAction $action): void;

    public function toJSON(): string;

    public function canSendActions(): bool;

    public function setSendActions(bool $sendActions): void;
}
