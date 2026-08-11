class PokerHand {
  constructor(hand) {
    this.hand = hand;
  }

  getRank() {
    // Implement poker hand ranking

    // Formatting string of cards into an array
    const hand_array = this.hand.split(" ");

    // Array of objects that will hold the card and suit
    const card_hand = [];

    // Input Validation Variables
    const valid_suits = ['h', 'c', 's', 'd'];
    const valid_cards = ['A', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K'];
    const duplicate_card_check = [];

    // Validation - Check Length
    if (hand_array.length != 5) {
      return "Incorrect number of cards in hand.";
    }

    // Loop to format card data
    for (const array_item of hand_array) {
        let card = array_item.slice(0, -1);
        let suit = array_item.slice(-1);

        // Validation - Check Suits
        if (!valid_suits.includes(suit)) {
            return "Invalid suit detected in hand.";
        }

        // Validation - Check Cards
        if (!valid_cards.includes(card)) {
            return "Invalid card detected in hand.";
        }

        // Validation - Duplicate Cards
        if (duplicate_card_check.includes(array_item)) {
            return "Duplicate card detected in hand.";
        }
        duplicate_card_check.push(array_item);

        // Convert Special Cards to Numbers
        switch (card) {
            case "A":
                card = "14";
                break;
            case "K":
                card = "13";
                break;
            case "Q":
                card = "12";
                break;
            case "J":
                card = "11";
                break;
        }

        card_hand.push({
            card: parseInt(card),
            suit: suit,
        });
    }
    
    // Variables for various hand conditions
    let is_royal = false;
    let is_flush = false;
    let is_sequential = false;
    
    // Determines if Flush
    if (card_hand.every(c => c.suit === card_hand[0].suit)) {
        is_flush = true;
    }

    // Variable used for determining pairs
    const card_values = card_hand.map(card => card.card);

    // Variable used for sequence
    const sequenced_cards = [...card_values].sort((a, b) => a - b);
    
    // Creates array for pairs of of-a-kind comparison
    const counts = {};
    for (const value of card_values) {
        counts[value] = (counts[value] || 0) + 1;
    }

    const card_counts = Object.values(counts);
    card_counts.sort((a, b) => a - b);

    // Determines if Sequential, with edge cases (Royal Flush and Ace as low card)
    if (JSON.stringify(sequenced_cards) === JSON.stringify([2, 3, 4, 5, 14])) {
        is_sequential = true;
    } else {
        is_sequential = true;
        for (let i = 1; i < sequenced_cards.length; i++) {
            if (sequenced_cards[i] !== sequenced_cards[i - 1] + 1) {
                is_sequential = false;
                break;
            }
        }
    }
    
    is_royal = is_sequential && sequenced_cards[0] === 10;

    // Returns Hand
    if (is_royal && is_flush) {
        return "Royal Flush";
    } else if (is_flush && is_sequential) {
        return "Straight Flush";
    }else if (JSON.stringify(card_counts) === JSON.stringify([1, 4])) {
        return "Four of a Kind";
    } else if (JSON.stringify(card_counts) === JSON.stringify([2, 3])) {
        return "Full House";
    } else if (is_flush) {
        return "Flush";
    } else if (is_sequential) {
        return "Straight";
    } else if (JSON.stringify(card_counts) === JSON.stringify([1, 1, 3])) {
        return "Three of a Kind";
    } else if (JSON.stringify(card_counts) === JSON.stringify([1, 2, 2])) {
        return "Two Pair";
    } else if (JSON.stringify(card_counts) === JSON.stringify([1, 1, 1, 2])) {
        return "One Pair";
    } else {
        return "High Card";
    }

  }
}

module.exports = PokerHand;
