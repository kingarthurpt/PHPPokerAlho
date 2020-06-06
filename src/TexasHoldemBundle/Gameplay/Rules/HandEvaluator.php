<?php

namespace TexasHoldemBundle\Gameplay\Rules;

use TexasHoldemBundle\Gameplay\Cards\CardCollection;
use TexasHoldemBundle\Gameplay\Game\HandStrength;
use TexasHoldemBundle\Gameplay\Game\Player;
use TexasHoldemBundle\Gameplay\Game\Table;
use TexasHoldemBundle\Gameplay\Rules\HandRankings\RankingMediator;

class HandEvaluator
{
    // /**
    //  * Compare an array of HandStrengths and return the same array sorted by
    //  * the best HandStrengths.
    //  *
    //  * @param array $hands
    //  *
    //  * @return array The sorted array of HandStrengths
    //  */
    // public function compareHands(array $hands)
    // {
    //     usort($hands, [$this, 'compareTwoHands']);

    //     return $hands;
    // }

    /**
     * Gets the strength of a Player playing at a Table.
     *
     * @param Player $player
     * @param Table  $table
     *
     * @return HandStrength
     */
    public function getPlayerStrength(Player $player, Table $table): ?HandStrength
    {
        $cards = new CardCollection();
        $cards->mergeCards($player->getHand());
        $cards->mergeCards($table->getCommunityCards());

        return $this->getHandStrength($cards);
    }

    /**
     * Gets the Strength of just two cards.
     *
     * @return HandStrength|null
     */
    public function getStartingHandStrength(CardCollection $cards): ?HandStrength
    {
        if (2 != $cards->getSize()) {
            return null;
        }

        return $this->getStrength($cards);
    }

    /**
     * Gets the strength of a collection of cards.
     *
     * @param CardCollection $cards
     *
     * @return HandStrength|null
     */
    public function getHandStrength(CardCollection $cards): ?HandStrength
    {
        if ($cards->getSize() < 5 || $cards->getSize() > 7) {
            return null;
        }

        return $this->getStrength($cards);
    }

    private function getStrength(CardCollection $cards): HandStrength
    {
        $rankingMediator = new RankingMediator();
        $ranking = $rankingMediator->getRanking($cards);
        $rankCardValues = $rankingMediator->getRankCardsValues($cards, $ranking);
        $kickers = $rankingMediator->getKickers($cards, $ranking, $rankCardValues);

        return new HandStrength($ranking, $rankCardValues, $kickers);
    }

    /*
     * Compare two HandStrengths.
     *
     * @param HandStrength $first  The first HandStrength
     * @param HandStrength $second The second HandStrength
     *
     * @return int 1 if the second hand is stronger than the first,
     *             -1 if the first hand is stronger than the second,
     *             0 if both hands have the same strength
     *
     * @SuppressWarnings(PHPMD.UnusedPrivateMethod)
     */
    // private function compareTwoHands(HandStrength $first, HandStrength $second)
    // {
    //     // Compare HandRankings
    //     if ($first->getRanking() > $second->getRanking()) {
    //         return -1;
    //     } elseif ($first->getRanking() < $second->getRanking()) {
    //         return 1;
    //     }

    //     // Both HandStrength's have the same HandRanking.
    //     // Compare their ranking Card values
    //     $result = $this->compareCardValues(
    //         $first->getRankingCardValues(),
    //         $second->getRankingCardValues()
    //     );
    //     if (0 != $result) {
    //         return $result;
    //     }

    //     // Both ranking Card values are the same.
    //     // Compare their kicker Card values
    //     return $this->compareCardValues($first->getKickers(), $second->getKickers());
    // }

    /*
     * Compare two arrays of Card values.
     * Each array is sorted with a reverse order and contain the
     * values of each Card.
     *
     * @param array $firstKickers
     * @param array $secondKickers
     *
     * @return int
     */
    // private function compareCardValues(array $firstKickers, array $secondKickers)
    // {
    //     for ($i = 0; $i < count($firstKickers) || $i < count($secondKickers); ++$i) {
    //         if ($firstKickers[$i] > $secondKickers[$i]) {
    //             return -1;
    //         } elseif ($firstKickers[$i] < $secondKickers[$i]) {
    //             return 1;
    //         }
    //     }

    //     return 0;
    // }
}
