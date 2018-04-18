<?php

namespace GlueApps\GluePHP\Request;

use GlueApps\GluePHP\Update\UpdateInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
interface RequestInterface
{
    public function getAppToken(): string;

    public function getStatus(): ?string;

    public function getServerUpdates(): array;

    public function addServerUpdate(UpdateInterface $update): void;

    public function getEventName(): string;

    public function getEventData(): array;
}
