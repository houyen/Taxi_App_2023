package com.tkpmnc.newtaxidriver.home.interfaces

/**
 *  newtaxidriver
 * @subpackage interfaces
 * @category YourTripsListener
 *  
 *
 */

import android.content.res.Resources

import com.tkpmnc.newtaxidriver.trips.tripsdetails.YourTrips


/*****************************************************************
 * YourTripsListener
 */

interface YourTripsListener {

    val res: Resources

    val instance: YourTrips
}
