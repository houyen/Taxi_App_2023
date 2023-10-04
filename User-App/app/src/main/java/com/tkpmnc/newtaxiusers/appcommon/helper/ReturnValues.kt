package com.tkpmnc.newtaxiusers.appcommon.helper

/**
 *  newtaxiusers
 * @subpackage helper
 * @category ReturnValues
 *  
 * 
 */

import com.google.android.gms.maps.model.LatLng

/* ************************************************************
 Return latitude and longitude Values for animate route in Main Activity
*************************************************************** */
class ReturnValues(
        /**
         * return latitude and longitude
         */
        val latLng: LatLng,
        /**
         * return country
         */
        val country: String)