<?php

namespace Matthias\Codesniffer\Tests\Sequence;

use Matthias\Codesniffer\Sequence\ForwardSequence;
use Matthias\Codesniffer\Tests\Sequence\Expectation\Spy;
use Matthias\Codesniffer\TokenBuilder;

class ForwardSequenceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider tokensProvider
     */
    public function it_walks_forward_over_an_array_of_tokens($tokens, $tokenIndex, $expectedTokens)
    {
        $forwardSequence = new ForwardSequence();
        $expectationSpy = new Spy();
        $forwardSequence->addExpectation($expectationSpy);

        $forwardSequence->matches($tokens, $tokenIndex);

        $this->assertEquals($expectedTokens, $expectationSpy->getTokens());
    }

    public function tokensProvider()
    {
        $tokens = array(
            TokenBuilder::create('T_OPEN_TAG')->build(),
            TokenBuilder::create('T_WHITESPACE')->build(),
            TokenBuilder::create('T_NAMESPACE')->build(),
        );

        return array(
            // start with index 0, expect tokens starting at index 1
            array(
                $tokens,
                0,
                array($tokens[1], $tokens[2])
            ),
            // start with index 1, expect tokens starting at index 2
            array(
                $tokens,
                1,
                array($tokens[2])
            ),
            // start with index 2, expect no tokens
            array(
                $tokens,
                2,
                array()
            ),
        );
    }
}
