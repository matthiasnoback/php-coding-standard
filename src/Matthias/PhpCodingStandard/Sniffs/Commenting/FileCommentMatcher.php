<?php

namespace Matthias\PhpCodingStandard\Sniffs\Commenting;

use Matthias\Codesniffer\MatcherInterface;
use Matthias\Codesniffer\Sequence\SequenceBuilder;

class FileCommentMatcher implements MatcherInterface
{
    public function matches(array $tokens, $tokenIndex)
    {
        if (!$this->isAtBeginningOfDocument($tokens, $tokenIndex)) {
            return false;
        }

        if (!$this->isFollowedByTwoNewLines($tokens, $tokenIndex)) {
            return false;
        }

        return true;
    }

    private function isAtBeginningOfDocument(array $tokens, $tokenIndex)
    {
        $sequence = SequenceBuilder::create()
            ->lookingBackward()
            ->expect()
            ->any()
            ->token(T_WHITESPACE, "\n")
            ->then()
            ->exactly(1)
            ->token(T_OPEN_TAG)
            ->build();

        return $sequence->matches($tokens, $tokenIndex);
    }

    private function isFollowedByTwoNewLines(array $tokens, $tokenIndex)
    {
        $sequence = SequenceBuilder::create()
            ->expect()
            ->any()
            ->token(T_DOC_COMMENT)
            ->then()
            ->atLeast(2)
            ->tokens(T_WHITESPACE, "\n")
            ->build();

        return $sequence->matches($tokens, $tokenIndex);
    }
}
