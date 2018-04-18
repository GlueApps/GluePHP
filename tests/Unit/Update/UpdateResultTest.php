<?php

namespace GlueApps\GluePHP\Tests\Unit\Update;

use PHPUnit\Framework\TestCase;
use GlueApps\GluePHP\Update\UpdateResult;
use GlueApps\GluePHP\Update\UpdateInterface;

/**
 * @author Andy Daniel Navarro Taño <andaniel05@gmail.com>
 */
class UpdateResultTest extends TestCase
{
    public function getUpdateResult(string $id = 'result1')
    {
        $update = $this->createMock(UpdateInterface::class);

        $result = new UpdateResult($update, $id);

        return $result;
    }

    public function testGetId_ReturnTheIdArgument()
    {
        $updateId = uniqid();
        $result = $this->getUpdateResult($updateId);

        $this->assertEquals($updateId, $result->getId());
    }

    public function testGetUpdate_ReturnTheUpdateArgument()
    {
        $update = $this->createMock(UpdateInterface::class);

        $result = new UpdateResult($update, 'result1');

        $this->assertSame($update, $result->getUpdate());
    }

    public function testGetErrors_ReturnAnEmptyArrayByDefault()
    {
        $result = $this->getUpdateResult();

        $this->assertEquals([], $result->getErrors());
    }

    public function testGetErrors_ReturnAllInsertedErrors()
    {
        $result = $this->getUpdateResult();

        $result->addError('error1', 'message1');
        $result->addError('error2', 'message2');
        $errors = $result->getErrors();

        $this->assertEquals('message1', $errors['error1']);
        $this->assertEquals('message2', $errors['error2']);
    }
}
