<?php

namespace Hackathon\PlayerIA;

use Hackathon\Game\Result;

/**
 * Class ChristaupherPlayer
 * @package Hackathon\PlayerIA
 * @author christaupher
 */
class ChristaupherPlayer extends Player
{
    protected $mySide;
    protected $opponentSide;
    protected $result;
    protected $opponent_choices = array();
	protected $opponent_scores = array();
	protected $my_choices = array();
    protected $my_scores = array();

    // this is my starting choices I use more foe than friends
    private $start_choices = array(
		'friend', 'friend', 'friend', 'friend',
		'friend', 'friend', 'foe',  'foe', 'foe', 'foe'
    );
    
    // function to compute the average between my choices and his choices
    private function calculate_average($choice)
	{
		$total_score = 0;
		$n = 1;
		foreach ($this->my_choices as $i => $my_choice)
			if ($my_choice === $choice)
			{
				$total_score += $this->my_scores[$i];
				$n++;
			}
		return $total_score / $n;
	}


    public function getChoice()
    {

        // part of the dream team, we will help each other
        $dream_team = array('PacoTheGreat', 'Felixdupriez', 'Shiinsekai', 'Ghope', 'Etienneelg', 'Benli06', 'Galtar95');

        $oppName = $this->result->getStatsFor($this->opponentSide)['name'];
                if (in_array($oppName, $dream_team))
                    return parent::friendChoice();


        // setting the variables i will need
        
        $opponent_choices = $this->result->getChoicesFor($this->opponentSide);
        $opponent_scores = $this->result->getScoresFor($this->opponentSide);
        $my_choices = $this->result->getChoicesFor($this->mySide);
        $my_scores = $this->result->getScoresFor($this->mySide);


        // compute the average and if the score of friend is higher choose friend
        if (isset($this->start_choices[count($my_choices)]))
            return $this->start_choices[count($my_choices)];

        $friend_average = $this->calculate_average('friend');
        $foe_average = $this->calculate_average('foe');
        return $friend_average > $foe_average ? 'friend' : 'foe';


 
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Choice           ?    $this->result->getLastChoiceFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Choice ?    $this->result->getLastChoiceFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide) -- if 0 (first round)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide) -- if 0 (first round)
        // -------------------------------------    -----------------------------------------------------
        // How to get all the Choices          ?    $this->result->getChoicesFor($this->mySide)
        // How to get the opponent Last Choice ?    $this->result->getChoicesFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get my Last Score            ?    $this->result->getLastScoreFor($this->mySide)
        // How to get the opponent Last Score  ?    $this->result->getLastScoreFor($this->opponentSide)
        // -------------------------------------    -----------------------------------------------------
        // How to get the stats                ?    $this->result->getStats()
        // How to get the stats for me         ?    $this->result->getStatsFor($this->mySide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // How to get the stats for the oppo   ?    $this->result->getStatsFor($this->opponentSide)
        //          array('name' => value, 'score' => value, 'friend' => value, 'foe' => value
        // -------------------------------------    -----------------------------------------------------
        // How to get the number of round      ?    $this->result->getNbRound()
        // -------------------------------------    -----------------------------------------------------
        // How can i display the result of each round ? $this->prettyDisplay()
        // -------------------------------------    -----------------------------------------------------
        //return parent::friendChoice();
    }
 
};
