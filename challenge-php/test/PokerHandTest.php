<?php
namespace PokerHand;

use PHPUnit\Framework\TestCase;

class PokerHandTest extends TestCase
{
    /**
     * @test
     */
    public function itCanRankARoyalFlush()
    {
        $hand = new PokerHand('As Ks Qs Js 10s');
        $this->assertEquals('Royal Flush', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAPair()
    {
        $hand = new PokerHand('Ah As 10c 7d 6s');
        $this->assertEquals('One Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankTwoPair()
    {
        $hand = new PokerHand('Kh Kc 3s 3h 2d');
        $this->assertEquals('Two Pair', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanRankAStraightFlush()
    {
        $hand = new PokerHand('Kh Qh 6h 2h 9h');
        $this->assertEquals('Flush', $hand->getRank());
    }


    /**
     * @test
     */
    public function itCanRankAStraight()
    {
        $hand = new PokerHand('4h 5c 6d 7s 8h');
        $this->assertEquals('Straight', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanDetectDuplicates()
    {
        $hand = new PokerHand('Kh Qh Qh 2h 9h');
        $this->assertEquals('Duplicate card detected in hand.', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanDetectFakeSuits()
    {
        $hand = new PokerHand('Kh 7h 3h 2t 9h');
        $this->assertEquals('Invalid suit detected in hand.', $hand->getRank());
    }

    /**
     * @test
     */
    public function itCanDetectFakeCards()
    {
        $hand = new PokerHand('Kh 55h 3h 2d 9h');
        $this->assertEquals('Invalid card detected in hand.', $hand->getRank());
    }
    // TODO: More tests go here
}