<?php
namespace VATEUD;
require( "DataObject.php" );

class DataHandler{
    
    function __construct(){}
    
    function getData( $url ){
        
        $result = array();
        $file_name = str_replace( "/", "_", explode( "vateud.net/", strtolower( $url ) )[ 1 ] );
        
        if( file_exists( dirname(__FILE__) . "/cache/$file_name" ) and time() - filemtime( dirname(__FILE__) . "/cache/$file_name" ) < 1800 ){
            
            $data = json_decode( file_get_contents( dirname(__FILE__) . "/cache/$file_name" ), true );
            
        }else{
            
            $data = @file_get_contents( $url );
            if( $data === false ){
                
                if( file_exists( dirname(__FILE__) . "/cache/$file_name" ) ){
                    
                    $data = json_decode( file_get_contents( dirname(__FILE__) . "/cache/$file_name" ), true );
                    
                }else{ 
                
                    return array();
                
                }
                
            }else{
                
                file_put_contents( dirname(__FILE__) . "/cache/$file_name", $data );
                $data = json_decode( $data, true );
                
            }
            
        }
        
        foreach( $data as $object ){
            
            array_push( $result, new DataObject( $object ) );
            
        }
        
        return $result;
        
    }
    
    function searchFor( $functionName, $searchRegex, $searchField ){

        if( !method_exists( $this, $functionName ) ){ 
            throw new Exception( "Invalid Function Provided!" );
            return array();
        }
        
        return array_filter( $this->{$functionName}(), function( $dataObject ) use ( $searchRegex, $searchField ) {

            return isset( $dataObject->{$searchField} ) ? preg_match( $searchRegex, $dataObject->{$searchField} ) : false;
            
        } );
        
    }
    
    function getStaffMembers( $vacc=Null ){
        
       return $vacc == null ? $this->getData( "http://api.vateud.net/staff_members.json" ) : $this->getData( "http://api.vateud.net/staff_members/vacc/$vacc.json" );

    }
    
    function getATCFrequencies( $vacc=Null ){
        
       return $vacc == null ? $this->getData( "http://api.vateud.net/frequencies.json" ) : $this->getData( "http://api.vateud.net/frequencies/$vacc.json" );
        
    }
    
    function getEvents( $vacc=Null ){
        
       return $vacc == null ? array_reverse( $this->getData( "http://api.vateud.net/events.json" ) ) : array_reverse( $this->getData( "http://api.vateud.net/events/vacc/$vacc.json" ) );
        
    }
    
    function getMembers( $vacc=Null ){
    
        return $vacc == null ? $this->getData( "http://api.vateud.net/members.json" ) : $this->getData( "http://api.vateud.net/members/$vacc.json" );

    }
    
    function getvACCs(){
        
        return $this->getData( "http://api.vateud.net/subdivisions.json" );
        
    }
    
    function getAirports( $countryCode=null ){
        
        return $countryCode == null ? $this->getData( "http://api.vateud.net/airports.json" ) : $this->getData( "http://api.vateud.net/airports/country/$countryCode.json" );

    }
    
    function getNOTAMs( $icao=null ){
        
        return isset( $icao ) ? $this->getData( "http://api.vateud.net/notams/$icao.json" ) : array();
        
    }
    
}
