<?php

namespace PokerHand;

class PokerHand
{
    private string $hand;

    public function __construct($hand)
    {
        $this->hand = $hand;
    }

    public function getRank()
    {
        // TODO: Implement poker hand ranking
    
        // Format string of cards into an array
        $hand_array = explode(" ", $this->hand);

        // Array that will hold the cart and suit
        $card_hand = [];

        // Input Validation Variables
        $valid_suits = ['h', 'c', 's', 'd'];
        $valid_cards = ['A', '1', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
        $duplicate_card_check = [];

        // Validation - Check Length
        if (count($hand_array) != 5) {
            return "Incorrect number of cards in hand.";
        }

        // Loop to format card data
        foreach($hand_array as $array_item) {
            $card = substr($array_item, 0, -1);  
            $suit = substr($array_item, -1);
            
            // Validation - Check Suits
            if( !in_array($suit, $valid_suits, true) ) {
                return "Invalid suit detected in hand.";
            }

            // Validation - Check Cards
            if ( !in_array($card, $valid_cards, true) ) {
                return "Invalid card detected in hand.";
            }

            // Validation - Duplicate Cards
            if ( in_array($array_item, $duplicate_card_check, true) ) {
                return "Duplicate card detected in hand.";
            }
            $duplicate_card_check[] = $array_item;

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
        
        // Variables for various hand conditions
        $is_royal = false;
        $is_flush = false;
        $is_sequential = false;

        // Determines if Flush
        if (count(array_unique(array_column($card_hand, 'suit'))) == 1) {
            $is_flush = true;
        }

        // Determines if Sequential
        $sequenced_cards = array_column($card_hand, 'card');
        sort($sequenced_cards);

        // Checks for sequence, with edge cases (Royal Flush and Ace as low card)
        if ($sequenced_cards == [10, 11, 12, 13, 14]) {
            $is_royal = true;
            $is_sequential = true;
        } else if ($sequenced_cards == [2, 3, 4, 5, 14]) {
            $is_sequential = true;
        } else {
            $is_sequential = true;
            for ($i = 1; $i < count($sequenced_cards); $i++) {
                if ($sequenced_cards[$i] !== $sequenced_cards[$i - 1] + 1) {
                    $is_sequential = false;
                    break;
                }
            }
        }

        // Determines Pairs
        $card_counts = array_values(array_count_values(array_column($card_hand, 'card')));
        sort($card_counts);

        // Returns Hand
        if ($is_royal && $is_flush) {
            return "Royal Flush";
        } else if ($is_flush && $is_sequential) {
            return "Straight Flush";
        }else if ($card_counts === [1, 4]) {
            return "Four of a Kind";
        } else if ($card_counts === [2, 3]) {
            return "Full House";
        } else if ($is_flush) {
            return "Flush";
        } else if ($is_sequential) {
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