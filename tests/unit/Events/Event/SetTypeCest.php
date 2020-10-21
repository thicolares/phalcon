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

namespace Phalcon\Tests\Unit\Events\Event;

use Phalcon\Events\Event;
use UnitTester;

/**
 * Class SetTypeCest
 *
 * @package Phalcon\Tests\Unit\Events\Event
 */
class SetTypeCest
{
    /**
     * Tests Phalcon\Events\Event :: setType()
     *
     * @param UnitTester $I
     *
     * @author Sid Roberts <https://github.com/SidRoberts>
     * @since  2020-09-09
     */
    public function eventsEventSetType(UnitTester $I)
    {
        $I->wantToTest('Events\Event - setType()');

        $event = new Event('some-type:beforeSome', $this, []);

        $newType = 'some-type:afterSome';

        $event->setType($newType);

        $expected = $newType;
        $actual   = $event->getType();
        $I->assertEquals($expected, $actual);
    }
}
