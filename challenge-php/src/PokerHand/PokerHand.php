<?php

namespace PokerHand;

class PokerHand
{
    public function __construct($hand)
    {
        $this->hand = $hand;
    }

    public function getRank()
    {
        // TODO: Implement poker hand ranking
    
        $hand_array = explode(" ", $this->hand);
        $card_hand = [];

        // Input Validation Variables
        $valid_suits = ['h', 'c', 's', 'd'];
        $valid_cards = ['A', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $invalid_cards = [];

        // Validation - Check Length
        if (count($hand_array) != 5) {
            return "Incorrect number of cards in hand.";
        }

        // Loop to format card data
        foreach($hand_array as $array_item) {
            $card = substr($array_item, 0, -1);  
            $suit = substr($array_item, -1);
            
            // Validation - Check Suits
            // if( !in_array($suit, $valid_suits, true) ) {

            // }

            // Validation - Check Cards
            // if ( !in_array($card, $valid_cards, true) ) {

            // }

            // Convert Special Cards to Numbers
            switch ($card) {
                case "A":
                    $card = "14";
                    break;
                case "K":
                    $card = "13";
                    break;
                case "Q":
                    $card = "12";
                    break;
                case "J":
                    $card = "11";
                    break;
            }
              
            $card_hand[] = (object) [
                'card' => (int)$card,
                'suit' => $suit,
            ];
        }

        //print_r($card_hand);
        
        $isRoyal = false;
        $isFlush = false;
        $isSequential = false;

        // Determines if Flush
        if (count(array_unique(array_column($card_hand, 'suit'))) == 1) {
            $isFlush = true;
        }

        // Determines if Sequential
        $sequencedCards = array_column($card_hand, 'card');
        sort($sequencedCards);

        // Detect a Royal Flush, then detect if A is low card
        if ($sequencedCards == [10, 11, 12, 13, 14]) {
            $isRoyal = true;
            $isSequential = true;
        } else if ($sequencedCards == [2, 3, 4, 5, 14]) {
            $isSequential = true;
        } else {
            $isSequential = true;
            for ($i = 1; $i < count($sequencedCards); $i++) {
                if ($sequencedCards[$i] !== $sequencedCards[$i - 1] + 1) {
                    $isSequential = false;
                    break;
                }
            }
        }

        // Determines Pairs
        $card_counts = array_values(array_count_values(array_column($card_hand, 'card')));
        sort($card_counts);

        // Returns Hand
        if ($isRoyal && $isFlush) {
            return "Royal Flush";
        } else if ($isFlush && $isSequential) {
            return "Straight Flush";
        }else if ($card_counts === [1, 4]) {
            return "Four of a Kind";
        } else if ($card_counts === [2, 3]) {
            return "Full House";
        } else if ($isFlush) {
            return "Flush";
        } else if ($isSequential) {
            return "Straight";
        } else if ($card_counts === [1, 1, 3]) {
            return "Three of a Kind";
        } else if ($card_counts === [1, 2, 2]) {
            return "Two Pair";
        } else if ($card_counts === [1, 1, 1, 2]) {
            return "One Pair";
        } else {
            return "High Card";
        }
    }
}