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
                ->quantity()
                    ->any()
                    ->token(T_WHITESPACE, "\n")
                ->end()
                ->quantity()
                    ->exactly(1)
                    ->token(T_OPEN_TAG)
                ->end()
            ->end()
            ->build();

        return $sequence->matches($tokens, $tokenIndex);
    }

    private function isFollowedByTwoNewLines(array $tokens, $tokenIndex)
    {
        $sequence = SequenceBuilder::create()
            ->expect()
                ->quantity()
                    ->any()
                    ->token(T_DOC_COMMENT)
                ->end()
                ->quantity()
                    ->atLeast(2)
                    ->token(T_WHITESPACE, "\n")
                ->end()
            ->end()
            ->build();

        return $sequence->matches($tokens, $tokenIndex);
    }
}
