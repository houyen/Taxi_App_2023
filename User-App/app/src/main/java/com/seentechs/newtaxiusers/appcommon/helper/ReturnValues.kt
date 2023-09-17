package com.seentechs.newtaxiusers.appcommon.helper

/**
 * @package com.seentechs.newtaxiusers
 * @subpackage helper
 * @category ReturnValues
 * @author Seen Technologies
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