<?php

namespace Vendelev\Service\ExampleTest;

use Vendelev\Service\Example\Service\Division;

/**
 * @coversDefaultClass Vendelev\Service\Example\Service\Division
 */
class DivisionTest extends AbstractTest
{
    /**
     * @test
     * @covers ::getDivisionChanges
     */
    public function getDivisionChanges()
    {
        fwrite(STDOUT, "\n". __METHOD__);

        $result = (new Division())
                    ->getDivisionChanges(
                        ['test1' => ['t1' => 't1'], 'test2' => ['t2' => 't2'], 'test3' => ['t3' => 't3']],
                        ['test1' => ['t1' => 't2'], 'test3' => ['t3' => 't3']]
                    );
        $this->assertEquals(['updateDivs' => [['t1' => 't1']], 'insertDivs' => [['t2' => 't2']]], $result);
    }
}
