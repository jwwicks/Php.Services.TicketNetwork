<?php 
/**
 * @file ticketnetwork_category.class.php
 * @package  TicketNetwork
 *
 * @license    see LICENSE.txt
 * @author jwwicks <jwwicks-at-gmail-dot-com>
 */

if(!class_exists('TicketNetworkBase')){
	require_once('ticketnetwork.class.php');
}

/**
 * @class TNCategory
 * @brief TicketNetwork Category
 * 
 * @since    0.0.1
 */
class TNCategory extends TicketNetworkBase{
	public function __construct($options=false){
		self::_defaults();
		if($options){
			self::config($options);
		}
	}
	
	
	public function get($params=false){
	
		$this->_request['method'] = 'GetCategoriesMasterList';
		
		if($params){
			$this->set($params);
			
			if(!array_key_exists('parentCategoryID', $params) && !array_key_exists('childCategoryID', $params)){
				$this->_request['method'] = 'GetCategories';
			} else {
				$this->_request['method'] = 'GetSublevelCategories';
			}
		}
		
		return $this;
	}
	
	/**
	 * Parse the results from TicketNetwork
	 * @return string|unknown
	 */
	public function parse(){
		$this->_data = array();
	
		try{
			parent::parse();
	
			if(!empty($this->_response)){
				if($this->_request['method'] == 'GetCategoriesMasterList'){
					if(is_array($this->_response->GetCategoriesMasterListResult->Category)){
						foreach($this->_response->GetCategoriesMasterListResult->Category as $category){
							$this->_data[] = $category;
						}
					}else{
						$this->_data = null;
					}
				}else if($this->_request['method'] == 'GetCategories'){
					if(is_array($this->_response->GetCategoriesResult->Category)){
						foreach($this->_response->GetCategoriesResult->Category as $category){
							$this->_data[] = $category;
						}
					}else{
						$this->_data = null;
					}
				}else{
					if(is_array($this->_response->GetSublevelCategoriesResult->Category)){
						foreach($this->_response->GetSublevelCategoriesResult->Category as $category){
							$this->_data[] = $category;
						}
					}else{
						$this->_data = null;
					}
				}
			}
	
		}catch(TNException $e){
		}
	
		return $this;
	}
	
	protected function _defaults(){
		parent::_defaults();
		
		$this->_map = array(
			'categories' => array(
				'parentCategoryID' => array(
					'sports' => SPORTS,
					'sport' => SPORTS,
					'concerts' => CONCERTS,
					'concert' => CONCERTS,
					'theatre' => THEATER,
					'theater' => THEATER,
					'other' => OTHER,
				),
				'childCategoryID' => array(
					'jazz' => JAZZ_AND_BLUES,
					'blues' => JAZZ_AND_BLUES,
					'alternative' => ALTERNATIVE,
					'country' => COUNTRY_AND_FOLK,
					'folk' => COUNTRY_AND_FOLK,
					'comedy' => COMEDY,
					'tennis' =>	TENNIS,
					'off-broadway' => OFF_BROADWAY,
					'las-vegas-shows' => LAS_VEGAS_SHOWS,
					'las-vegas-show' => LAS_VEGAS_SHOWS,
					'las-vegas' => LAS_VEGAS,
					'rap' => RAP_AND_HIP_HOP,
					'hip-hop' => RAP_AND_HIP_HOP,
				    'rap-hip-hop' => RAP_AND_HIP_HOP,
					'musicals' => MUSICALS_AND_PLAYS,
					'musical' => MUSICALS_AND_PLAYS,
					'plays' => MUSICALS_AND_PLAYS,
					'play' => MUSICALS_AND_PLAYS,
					'musical-play' => MUSICALS_AND_PLAYS,
					'wrestling' => WRESTLING,
					'christian' => CHRISTIAN_RELIGIOUS,
					'religious' => CHRISTIAN_RELIGIOUS,
					'rythm-blues' => RYTHM_AND_BLUES_AND_SOUL,
					'soul' => RYTHM_AND_BLUES_AND_SOUL,
				    'rnb-soul' => RYTHM_AND_BLUES_AND_SOUL,
					'bluegrass' => BLUEGRASS,
					'volleyball' => VOLLEYBALL,
					'new-age' => NEW_AGE_AND_SPIRITUAL,
					'spiritual' => NEW_AGE_AND_SPIRITUAL,
					'classical' => CLASSICAL,
					'boxing' => BOXING,
					'skating' => SKATING,
					'rodeo' => RODEO,
					'childrens-shows' => CHILDREN_AND_FAMILY_SHOWS,
					'childrens-show' => CHILDREN_AND_FAMILY_SHOWS,
					'family-shows' => CHILDREN_AND_FAMILY_SHOWS,
					'family-show' => CHILDREN_AND_FAMILY_SHOWS,
					'world' => WORLD,
					'fairs' => FAIRS_AND_FESTIVALS,
					'festivals' => FAIRS_AND_FESTIVALS,
					'circus' => CIRCUS,
					'ballet' => BALLET,
					'hard-rock' => HARD_ROCK_AND_METAL,
					'metal' => HARD_ROCK_AND_METAL,
					'pop' => POP_AND_ROCK,
					'rock' => POP_AND_ROCK,
					'baseball' => BASEBALL,
					'football' => FOOTBALL,
					'basketball' => BASKETBALL,
					'golf' => GOLF,
					'hockey' => HOCKEY,
					'racing' => RACING,
					'broadway' => BROADWAY,
					'soccer' => SOCCER,
					'magic-shows' => MAGIC_SHOWS,
					'magic-show' => MAGIC_SHOWS,
					'latin' => LATIN,
					'opera' => OPERA,
					'lacrosse' => LACROSSE,
					'rugby' => RUGBY,
				),
				'grandchildCategoryID' => array(
					'mlb' => MLB_PRO_GRANDCHILD,
					'ncaa-football' => COLLEGE_GRANDCHILD,
					'ncaa-baseball' => COLLEGE_GRANDCHILD,
					'ncaa-basketball' => COLLEGE_GRANDCHILD,
					'pga' => PGA_PRO_GRANDCHILD,
				    'professional-pga' => PGA_PRO_GRANDCHILD,
					'nhl' => NHL_PRO_GRANDCHILD,
				    'professional-nhl' => NHL_PRO_GRANDCHILD,
					'racing' => AUTO_GRANDCHILD,
					'nascar' => AUTO_GRANDCHILD,
					'motorcycle' => MOTORCYCLE_GRANDCHILD,
					'mls' => MLS_PRO_GRANDCHILD,
					'uspta' => USPTA_PRO_GRANDCHILD,
					'wwe' => WWE_PRO_GRANDCHILD,
					'triple-a' => MINORS_AAA_GRANDCHILD,
					'world-cup' => WORLD_CUP_GRANDCHILD,
					'nba' => NBA_PRO_GRANDCHILD,
				    'professional-nba' => NBA_PRO_GRANDCHILD,
					'wnba' => WNBA_PRO_GRANDCHILD,
					'nfl' => NFL_PRO_GRANDCHILD,
					'figure-skating' => ICE_FIGURE_SKATING_GRANDCHILD,
					'ice-shows' => ICE_SHOW_GRANDCHILD,
					'ice-show' => ICE_SHOW_GRANDCHILD,
					'horse-shows' => HORSE_GRANDCHILD,
					'horse-show' => HORSE_GRANDCHILD,
					'cfl' => CFL_GRANDCHILD,
					'frontier-league' => FRONTIER_LEAGUE_GRANDCHILD,
					'nll' => NLL_GRANDCHILD,
					'ihl' => IHL_GRANDCHILD,
					'ahl' => AHL_GRANDCHILD,
					'echl' => ECHL_GRANDCHILD,
				)
			),
		);
	
		$this->_request = array(
			'method' => 'GetCategoriesMasterList',
			'parameters' => array()
		);
	}
}
