<?php

namespace AppBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class NeoRecordsRepository extends DocumentRepository
{
    public function getPotentiallyHazardous()
    {
		 $db = $this->createQueryBuilder()
		            ->field('isHazardous')->equals("1");

		$query = $db->getQuery();
		$users = $query->execute();
		return $users;
    }

    public function getFastestHazardous($hazardous){
    	if($hazardous == 'true'){
    		$hzval = "1";
    	}else{
			$hzval = "";
    	}
    	$lastPointContent = $this->createQueryBuilder('NeoRecords')
    							 ->field('isHazardous')->equals($hzval)
        						 ->sort('speed','desc')->limit(1)->getQuery()->getSingleResult();
        return $lastPointContent;
    }
    
}
?>