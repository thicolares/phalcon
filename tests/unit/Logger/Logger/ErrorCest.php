<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalcon.io>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Phalcon\Tests\Unit\Logger\Logger;

use Phalcon\Tests\Fixtures\Traits\LoggerTrait;
use UnitTester;

class ErrorCest
{
    use LoggerTrait;

    /**
     * Tests Phalcon\Logger :: error()
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalcon.io>
     * @since  2020-09-09
     */
    public function loggerError(UnitTester $I)
    {
        $I->wantToTest('Logger - error()');
        $this->runLoggerFile($I, 'error');
    }
}
