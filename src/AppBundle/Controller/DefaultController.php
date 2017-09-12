<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use FOS\RestBundle\Request\ParamFetcher;
use AppBundle\Document\NeoRecords;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use \DateTime;


class DefaultController extends FOSRestController
{

    /* Hello world api
     * @return json response
     */
    public function indexAction(){
        $output = array( 'hello' => 'world!');
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);
    }

    /* Create records from neo gov api
     * @return json response with success message
     */
    public function addRNeoDataAction() {
        $key = "AIzaSyD56d9egQtt7R2ILKvSKAPcxeHiYKzJt6g"; // nasa gov api key
        //get data from api
        $jsonObj = file_get_contents("https://api.nasa.gov/neo/rest/v1/feed?start_date=2017-08-30&end_date=2017-09-03&api_key=Gz05VKbzdZ3P0yHmW2e6n71FiSBMVCjDyVCeZ2pI");
        $json = json_decode($jsonObj);
        if($json->element_count > 0){
            $neoarr = $json->near_earth_objects;
            //fetch data from api result
            foreach ($neoarr as $key => $value) {
                foreach ( $value as $key1 => $data ) {
                    $date       = $data->close_approach_data[0]->close_approach_date;
                    $reference  = $data->neo_reference_id; 
                    $name       = $data->name; 
                    $speed      = $data->close_approach_data[0]->relative_velocity->kilometers_per_hour;
                    $hazardous  = $data->is_potentially_hazardous_asteroid;
                    $mongoDate = new \MongoDate(strtotime( date($date)));

                    //insert data in to neorecords 
                    $neo = new NeoRecords();
                    $neo->setDate($mongoDate);
                    $neo->setReference($reference);
                    $neo->setName($name);
                    $neo->setSpeed($speed);
                    $neo->setIsHazardous($hazardous);
                    $dm = $this->get('doctrine_mongodb')->getManager();
                    $dm->persist($neo);
                    $dm->flush();
                }
            }
            $msg = 'NEO records created successfully';
        }else{
            $msg = 'No records found';
        }
        //return response
        $output = array(
            'data' => '',
            'message' => $msg,
            'status' => 'success',
            'statusCode' => '200'
        );
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);
    }

    /* For get Hazardous Data
     * @return json response with potential hazardous
     */
    public function getHazardousDataAction() {
        $neoObjHaz = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:NeoRecords')->getPotentiallyHazardous();
        $resultArr = array();
        if(count($neoObjHaz) > 0){
            foreach ($neoObjHaz as $key => $value) {
                $resultArr[$key]['date']        = $value->getDate();
                $resultArr[$key]['reference']   = $value->getReference();
                $resultArr[$key]['name']        = $value->getName();
                $resultArr[$key]['speed']       = $value->getSpeed();
                $resultArr[$key]['isHazardous'] = $value->getIsHazardous();
            }
            $msg = count($neoObjHaz).' records found';

        }else{
            $msg = 'No records found';
        }
        $output = array(
            'data' => $resultArr,
            'message' => $msg,
            'status' => 'success',
            'statusCode' => '200'
        );
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);
    }

    /* For get fastest hazardous
     * @return json response with fastest hazardous
     * @input hazardous(true/false)
     */
    public function getFastestHazardousDataAction(request $request) {
        $hazardous = $request->get('hazardous');
        $neoFastHazObj = $this->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:NeoRecords')->getFastestHazardous($hazardous);
        $fastHazArr = '';
        if(is_object(($neoFastHazObj))){
            $fastHazArr['date']        = $neoFastHazObj->getDate();
            $fastHazArr['reference']   = $neoFastHazObj->getReference();
            $fastHazArr['name']        = $neoFastHazObj->getName();
            $fastHazArr['speed']       = $neoFastHazObj->getSpeed();
            $fastHazArr['isHazardous'] = $neoFastHazObj->getIsHazardous();
            $msg = 'Fasted ateroid data';
        }else{
            $msg = 'No records found';
        }
        $output = array(
            'data' => $fastHazArr,
            'message' => $msg,
            'status' => 'success',
            'statusCode' => '200'
        );
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);
    }


    /* For get bes month neo
     * @return json response with best month
     * @input hazardous(true/false)
     */
    public function getNeoBestMonthDataAction(request $request){
        $hazardous = $request->get('hazardous');
        if($hazardous == 'true'){
            $hzval = "1";
        }else{
            $hzval = "";
        }
        $monthArray = array();
        $expr = new \Solution\MongoAggregation\Pipeline\Operators\Expr;
        $resultm = $this->get('doctrine_mongodb.odm.default_aggregation_query')
        ->getCollection('AppBundle:NeoRecords')->createAggregateQuery()
        ->match(['isHazardous' => $hzval])
        ->group(['_id' => ['month' => $expr->month('$date')], 'count' => $expr->sum(1)])
        ->sort(['count' => -1])
        ->limit(1)
        ->getQuery()->aggregate()->toArray();

        if(is_array($resultm)){
			$monthArray = $resultm[0];
        }
        $output = array(
            'data' => $monthArray,
            'message' => 'Month with most ateroids',
            'status' => 'success',
            'statusCode' => '200'
        );
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);   
    }

    /* For get bes year neo
     * @return json response with best year
     * @input hazardous(true/false)
     */
    public function getNeoBestYearDataAction(request $request){
        $hazardous = $request->get('hazardous');
        if($hazardous == 'true'){
            $hzval = "1";
        }else{
            $hzval = "";
        }
        $yearArray = array();
        $expr = new \Solution\MongoAggregation\Pipeline\Operators\Expr;
        $resulty = $this->get('doctrine_mongodb.odm.default_aggregation_query')
        ->getCollection('AppBundle:NeoRecords')->createAggregateQuery()
        ->match(['isHazardous' => $hzval])
        ->group(['_id' => ['year' => $expr->year('$date')], 'count' => $expr->sum(1)])
        ->sort(['count' => -1])
        ->limit(1)
        ->getQuery()->aggregate()->toArray();        

        if(is_array($resulty)){
			$yearArray = $resulty[0];
        }
        $output = array(
            'data' => $yearArray,
            'message' => 'Year with most ateroids',
            'status' => 'success',
            'statusCode' => '200'
        );
        $serializedEntity = $this->container->get('serializer')->serialize($output, 'json');
        return new Response($serializedEntity);   
    }
}


 